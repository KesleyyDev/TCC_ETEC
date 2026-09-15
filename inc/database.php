<?php

/** Abre uma conexão PDO sem expor detalhes do banco ao visitante. */
function open_database(): ?PDO
{
    try {
        return new PDO(DB_DSN, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
    } catch (PDOException $e) {
        error_log('Database connection error: ' . $e->getMessage());
        return null;
    }
}

function close_database(?PDO &$conn): void
{
    $conn = null;
}

/** Evita que nomes de tabela/coluna vindos de fora sejam inseridos no SQL. */
function safe_identifier(string $identifier): string
{
    if (!preg_match('/\A[A-Za-z_][A-Za-z0-9_]*\z/', $identifier)) {
        throw new InvalidArgumentException('Identificador de banco inválido.');
    }

    return $identifier;
}

function safe_table(string $table): string
{
    $allowedTables = [
        'usuarios',
        'categorias',
        'produtos',
        'mensagens_contato',
        'orcamentos',
        'projetos_cliente',
        'imagens_produto'
    ];

    if (!in_array($table, $allowedTables, true)) {
        throw new InvalidArgumentException('Tabela não permitida.');
    }

    return safe_identifier($table);
}

/** Mantém somente os campos explicitamente permitidos pelo chamador. */
function only_allowed_fields(array $data, array $allowedFields): array
{
    return array_intersect_key($data, array_flip($allowedFields));
}

function find(?string $table = null, ?int $id = null): ?array
{
    if ($table === null) {
        return null;
    }

    try {
        $table = safe_table($table);
    } catch (InvalidArgumentException $e) {
        error_log($e->getMessage());
        return null;
    }

    $database = open_database();
    if ($database === null) {
        return null;
    }

    try {
        if ($id !== null) {
            $stmt = $database->prepare("SELECT * FROM {$table} WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch() ?: null;
        }

        $stmt = $database->query("SELECT * FROM {$table}");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('Database read error: ' . $e->getMessage());
        return null;
    } finally {
        close_database($database);
    }
}

function find_all(string $table): ?array
{
    return find($table);
}

function save(?string $table = null, ?array $data = null): bool
{
    if ($table === null || empty($data)) {
        return false;
    }

    try {
        $table = safe_table($table);
        $columns = array_map('safe_identifier', array_keys($data));
    } catch (InvalidArgumentException $e) {
        error_log($e->getMessage());
        return false;
    }

    $database = open_database();
    if ($database === null) {
        return false;
    }

    $placeholders = [];
    foreach ($columns as $column) {
        $placeholders[] = ':' . $column;
    }

    $sql = "INSERT INTO {$table} (" . implode(', ', $columns) .
        ') VALUES (' . implode(', ', $placeholders) . ')';

    try {
        $stmt = $database->prepare($sql);
        $stmt->execute($data);
        $_SESSION['message'] = 'Registro cadastrado com sucesso.';
        $_SESSION['type'] = 'success';
        return true;
    } catch (PDOException $e) {
        error_log('Database insert error: ' . $e->getMessage());
        $_SESSION['message'] = 'Não foi possível realizar a operação.';
        $_SESSION['type'] = 'danger';
        return false;
    } finally {
        close_database($database);
    }
}

function update(?string $table = null, int $id = 0, ?array $data = null): bool
{
    if ($table === null || $id <= 0 || empty($data)) {
        return false;
    }

    try {
        $table = safe_table($table);
        $columns = array_map('safe_identifier', array_keys($data));
    } catch (InvalidArgumentException $e) {
        error_log($e->getMessage());
        return false;
    }

    $database = open_database();
    if ($database === null) {
        return false;
    }

    $items = [];
    foreach ($columns as $column) {
        $items[] = "{$column} = :{$column}";
    }

    $sql = "UPDATE {$table} SET " . implode(', ', $items) . ' WHERE id = :id';

    try {
        $data['id'] = $id;
        $stmt = $database->prepare($sql);
        $stmt->execute($data);
        $_SESSION['message'] = 'Registro atualizado com sucesso.';
        $_SESSION['type'] = 'success';
        return true;
    } catch (PDOException $e) {
        error_log('Database update error: ' . $e->getMessage());
        $_SESSION['message'] = 'Não foi possível realizar a operação.';
        $_SESSION['type'] = 'danger';
        return false;
    } finally {
        close_database($database);
    }
}

function remove(?string $table = null, ?int $id = null): bool
{
    if ($table === null || $id === null || $id <= 0) {
        return false;
    }

    try {
        $table = safe_table($table);
    } catch (InvalidArgumentException $e) {
        error_log($e->getMessage());
        return false;
    }

    $database = open_database();
    if ($database === null) {
        return false;
    }

    try {
        $stmt = $database->prepare("DELETE FROM {$table} WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $_SESSION['message'] = 'Registro removido com sucesso.';
        $_SESSION['type'] = 'success';
        return true;
    } catch (PDOException $e) {
        error_log('Database delete error: ' . $e->getMessage());
        $_SESSION['message'] = 'Não foi possível realizar a operação.';
        $_SESSION['type'] = 'danger';
        return false;
    } finally {
        close_database($database);
    }
}
