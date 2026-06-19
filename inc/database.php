<?php

function open_database() {
    try {
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection error: " . $e->getMessage();
        return null;
    }
}

function close_database(&$conn) {
    $conn = null;
}

function find($table = null, $id = null) {
    $database = open_database();
    $found = null;
    try {
        if ($id) {
            $stmt = $database->prepare("SELECT * FROM " . $table . " WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $found = $stmt->fetch();
        } else {
            $stmt = $database->query("SELECT * FROM " . $table);
            $found = $stmt->fetchAll();
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
    return $found;
}

function find_all($table) {
    return find($table);
}

function save($table = null, $data = null) {
    $database = open_database();
    $columns = implode(", ", array_keys($data));
    $placeholders = ":" . implode(", :", array_keys($data));
    $sql = "INSERT INTO " . $table . " ($columns) VALUES ($placeholders)";
    try {
        $stmt = $database->prepare($sql);
        $stmt->execute($data);
        $_SESSION['message'] = 'Registro cadastrado com sucesso.';
        $_SESSION['type'] = 'success';
    } catch (PDOException $e) { 
        $_SESSION['message'] = 'Não foi possível realizar a operação. Erro: ' . $e->getMessage();
        $_SESSION['type'] = 'danger';
    } 
    close_database($database);
}

function update($table = null, $id = 0, $data = null) {
    $database = open_database();
    $items = "";
    foreach ($data as $key => $value) {
        $items .= "$key = :$key, ";
    }
    $items = rtrim($items, ', ');
    $sql  = "UPDATE " . $table . " SET $items WHERE id = :id";
    try {
        $stmt = $database->prepare($sql);
        $data['id'] = $id;
        $stmt->execute($data);
        $_SESSION['message'] = 'Registro atualizado com sucesso.';
        $_SESSION['type'] = 'success';
    } catch (PDOException $e) { 
        $_SESSION['message'] = 'Não foi possível realizar a operação. Erro: ' . $e->getMessage();
        $_SESSION['type'] = 'danger';
    } 
    close_database($database);
}

function remove($table = null, $id = null) {
    $database = open_database();
    try {
        if ($id) {
            $stmt = $database->prepare("DELETE FROM " . $table . " WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $_SESSION['message'] = "Registro removido com sucesso.";
            $_SESSION['type'] = 'success';
        }
    } catch (PDOException $e) { 
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
}
?>
