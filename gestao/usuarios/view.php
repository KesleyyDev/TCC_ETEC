<?php
require_once "../../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ' . BASEURL . 'paginas/login.php');
    exit;
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $usuario = find('usuarios', $id);
} else {
    header('Location: index.php');
    exit;
}

include(HEADER_TEMPLATE);
?>
<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">Visualizar Usuário</h2>
            <a href="index.php" class="btn btn-outline-nanias rounded-pill">
                <i class="fa-solid fa-arrow-left me-1"></i> Voltar
            </a>
        </div>
        <hr style="border-color: var(--verde-claro); border-width: 2px;">
    </div>

    <div class="card shadow-sm border-0 rounded-4 p-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <h6 class="text-muted mb-1">ID</h6>
                <p class="fw-bold fs-5 mb-0">#<?php echo $usuario['id']; ?></p>
            </div>
            <div class="col-md-6 mb-3">
                <h6 class="text-muted mb-1">Nome / Razão Social</h6>
                <p class="fw-bold fs-5 mb-0"><?php echo htmlspecialchars($usuario['nome']); ?></p>
            </div>
            <div class="col-md-6 mb-3">
                <h6 class="text-muted mb-1">E-mail</h6>
                <p class="fw-bold fs-5 mb-0"><?php echo htmlspecialchars($usuario['email']); ?></p>
            </div>
            <div class="col-md-6 mb-3">
                <h6 class="text-muted mb-1">Permissão</h6>
                <p class="mb-0"><span class="badge" style="background-color: var(--verde-claro); color: var(--header-escuro);"><?php echo htmlspecialchars($usuario['rule']); ?></span></p>
            </div>
            <div class="col-md-6 mb-3">
                <h6 class="text-muted mb-1">Criado em</h6>
                <p class="mb-0"><?php echo date('d/m/Y H:i:s', strtotime($usuario['criado_em'])); ?></p>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-12">
                <a href="edit.php?id=<?php echo $usuario['id']; ?>" class="btn btn-primary">Editar</a>
                <a href="delete.php?id=<?php echo $usuario['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
            </div>
        </div>
    </div>
</div>
<?php include(FOOTER_TEMPLATE); ?>
