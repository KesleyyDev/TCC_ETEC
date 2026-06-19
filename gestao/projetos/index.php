<?php
require_once "../../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: " . BASEURL . "paginas/login.php");
    exit;
}

$allowed_rules = ['admin', 'dono', 'funcionario'];
if (!isset($_SESSION['usuario_rule']) || !in_array($_SESSION['usuario_rule'], $allowed_rules)) {
    header("Location: " . BASEURL . "index.php?erro=acesso_negado");
    exit;
}

$database = open_database();
$projetos = [];
try {
    $sql = "SELECT p.*, u.nome as cliente_nome FROM projetos_cliente p INNER JOIN usuarios u ON p.cliente_id = u.id ORDER BY p.atualizado_em DESC";
    $result = $database->query($sql);
    if ($result) {
        $projetos = $result->fetchAll();
    }
} catch (PDOException $e) {}
close_database($database);

include(HEADER_TEMPLATE);
?>

<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">
                <i class="fa-solid fa-folder-open me-2"></i> Projetos dos Clientes
            </h2>
            <div>
                <a href="add.php" class="btn btn-nanias rounded-pill me-2">
                    <i class="fa-solid fa-plus me-1"></i> Novo Projeto
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
            <div class="table-responsive shadow-sm rounded-4 bg-white p-4">
                <table class="table table-hover align-middle">
                    <thead class="table-light text-muted">
                        <tr>
                            <th>ID</th>
                            <th>Projeto</th>
                            <th>Cliente</th>
                            <th>Status</th>
                            <th>Última Atualização</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($projetos) : ?>
                    <?php foreach ($projetos as $proj) : ?>
                        <tr>
                            <td><?php echo $proj['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($proj['titulo']); ?></strong></td>
                            <td><?php echo htmlspecialchars($proj['cliente_nome']); ?></td>
                            <td>
                                <span class="badge" style="background-color: var(--verde-claro); color: var(--header-escuro);"><?php echo ucfirst(str_replace('_', ' ', $proj['status'])); ?></span>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($proj['atualizado_em'])); ?></td>
                            <td class="text-end">
                                <a href="edit.php?id=<?php echo $proj['id']; ?>" class="btn btn-sm btn-outline-primary" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                <?php if(in_array($_SESSION['usuario_rule'], ['admin', 'dono'])): ?>
                                <a href="delete.php?id=<?php echo $proj['id']; ?>" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Excluir projeto?');"><i class="fa-solid fa-trash"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Nenhum projeto cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include(FOOTER_TEMPLATE); ?>
