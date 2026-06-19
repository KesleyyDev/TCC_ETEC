<?php
require_once "../../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ' . BASEURL . 'paginas/login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    if (!empty($usuario['senha'])) {
        $usuario['senha'] = password_hash($usuario['senha'], PASSWORD_DEFAULT);
    }
    save('usuarios', $usuario);
    header('Location: index.php');
    exit;
}

include(HEADER_TEMPLATE);
?>
<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">Novo Usuário</h2>
        </div>
    </div>
    <form action="add.php" method="POST" class="shadow-sm rounded-4 bg-white p-4">
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
