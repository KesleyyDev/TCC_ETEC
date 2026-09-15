<?php
require_once "../../config.php";
require_once DBAPI;
require_once ABSPATH . "inc/auth.php";
require_roles(['admin', 'dono']);

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $input = is_array($_POST['usuario'] ?? null) ? $_POST['usuario'] : [];
    $usuario = only_allowed_fields($input, ['nome', 'email', 'senha', 'rule']);
    $usuario['nome'] = trim((string)($usuario['nome'] ?? ''));
    $usuario['email'] = trim((string)($usuario['email'] ?? ''));
    $usuario['senha'] = (string)($usuario['senha'] ?? '');
    $usuario['rule'] = (string)($usuario['rule'] ?? 'cliente');

    if ($usuario['nome'] === '' || mb_strlen($usuario['nome']) > 100) {
        $erro = 'Informe um nome válido.';
    } elseif (!filter_var($usuario['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($usuario['email']) > 100) {
        $erro = 'Informe um e-mail válido.';
    } elseif (mb_strlen($usuario['senha']) < 6) {
        $erro = 'A senha deve ter no mínimo 6 caracteres.';
    } elseif (!in_array($usuario['rule'], ['admin', 'dono', 'funcionario', 'cliente'], true)) {
        $erro = 'Permissão inválida.';
    } else {
        $database = open_database();
        try {
            if (!$database) {
                throw new RuntimeException('Banco indisponível.');
            }
            $stmt = $database->prepare(
                'INSERT INTO usuarios (nome, email, senha, rule) VALUES (:nome, :email, :senha, :rule)'
            );
            $usuario['senha'] = password_hash($usuario['senha'], PASSWORD_DEFAULT);
            $stmt->execute($usuario);
            $_SESSION['message'] = 'Usuário cadastrado com sucesso.';
            $_SESSION['type'] = 'success';
            close_database($database);
            header('Location: index.php');
            exit;
        } catch (Throwable $e) {
            error_log('User insert error: ' . $e->getMessage());
            $erro = 'Não foi possível cadastrar o usuário. Verifique se o e-mail já está em uso.';
            close_database($database);
        }
    }
}

include(HEADER_TEMPLATE);
?>
<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">Novo Usuário</h2>
        </div>
    </div>
    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>
    <form action="add.php" method="POST" class="shadow-sm rounded-4 bg-white p-4">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label for="name">Nome / Razão Social</label>
                <input type="text" class="form-control" name="usuario[nome]" required>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="campo2">E-mail</label>
                <input type="email" class="form-control" name="usuario[email]" required>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="campo3">Senha</label>
                <input type="password" class="form-control" name="usuario[senha]" required>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="campo4">Permissão</label>
                <select class="form-control" name="usuario[rule]">
                    <option value="cliente">Cliente</option>
                    <option value="funcionario">Funcionário</option>
                    <option value="admin">Administrador</option>
                    <option value="dono">Dono</option>
                </select>
            </div>
        </div>
        <div id="actions" class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-nanias">Salvar</button>
                <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </div>
    </form>
</div>
<?php include(FOOTER_TEMPLATE); ?>
