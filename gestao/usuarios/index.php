<?php
require_once "../../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ' . BASEURL . 'paginas/login.php');
    exit;
}

include(HEADER_TEMPLATE);

$usuarios = find_all('usuarios');
?>
<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">
                <i class="fa-solid fa-users me-2"></i> Gerenciar Usuários
            </h2>
            <div>
                <a href="add.php" class="btn btn-nanias rounded-pill me-2">
                    <i class="fa-solid fa-plus me-1"></i> Novo
                </a>
                <a href="../gestao.php" class="btn btn-outline-nanias rounded-pill">
                    <i class="fa-solid fa-arrow-left me-1"></i> Voltar
                </a>
            </div>
        </div>
        <hr style="border-color: var(--verde-claro); border-width: 2px;">
    </div>

    <div class="row">
        <div class="col-12">
            <?php if (isset($_SESSION['message'])) : ?>
                <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
                    <?php echo $_SESSION['message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['message']); unset($_SESSION['type']); ?>
            <?php endif; ?>

            <div class="table-responsive shadow-sm rounded-4 bg-white p-4">
                <table class="table table-hover align-middle">
                    <thead class="table-light text-muted">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Permissão</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($usuarios) : ?>
                    <?php foreach ($usuarios as $usuario) : ?>
                        <tr>
                            <td class="fw-bold text-muted">#<?php echo $usuario['id']; ?></td>
                            <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td><span class="badge" style="background-color: var(--verde-claro); color: var(--header-escuro);"><?php echo htmlspecialchars($usuario['rule']); ?></span></td>
                            <td class="text-end">
                                <a href="view.php?id=<?php echo $usuario['id']; ?>" class="btn btn-sm btn-outline-success" title="Visualizar"><i class="fa-solid fa-eye"></i></a>
                                <a href="edit.php?id=<?php echo $usuario['id']; ?>" class="btn btn-sm btn-outline-primary" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                <a href="delete.php?id=<?php echo $usuario['id']; ?>" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir o usuário?');"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">Nenhum registro encontrado.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include(FOOTER_TEMPLATE); ?>
