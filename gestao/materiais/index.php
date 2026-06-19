<?php
require_once "../../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ' . BASEURL . 'paginas/login.php');
    exit;
}

include(HEADER_TEMPLATE);

$database = open_database();
$sql = "SELECT p.*, c.nome as categoria_nome FROM produtos p JOIN categorias c ON p.categoria_id = c.id WHERE c.tipo = 'materiais'";
$produtos = [];
try {
    $result = $database->query($sql);
    if ($result) {
        $produtos = $result->fetchAll();
    }
} catch (PDOException $e) {
    $_SESSION['message'] = $e->getMessage();
    $_SESSION['type'] = 'danger';
}
close_database($database);
?>
<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">
                <i class="fa-solid fa-cubes me-2"></i> Gerenciar Materiais
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
                            <th>Imagem</th>
                            <th>Título</th>
                            <th>Categoria</th>
                            <th>Destaque</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($produtos) : ?>
                    <?php foreach ($produtos as $produto) : ?>
                        <tr>
                            <td class="fw-bold text-muted">#<?php echo $produto['id']; ?></td>
                            <td>
                                <?php if($produto['imagem_url']): ?>
                                    <img src="<?php echo BASEURL . $produto['imagem_url']; ?>" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                <?php else: ?>
                                    <div class="rounded-3" style="width: 50px; height: 50px; background-color: var(--fundo-creme); display: flex; align-items: center; justify-content: center;">
                                        <i class="fa-solid fa-image" style="color: var(--logo-claro);"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($produto['titulo']); ?></td>
                            <td><span class="badge" style="background-color: var(--verde-claro); color: var(--header-escuro);"><?php echo htmlspecialchars($produto['categoria_nome']); ?></span></td>
                            <td><?php echo $produto['destaque'] ? 'Sim' : 'Não'; ?></td>
                            <td><?php echo $produto['ativo'] ? 'Ativo' : 'Inativo'; ?></td>
                            <td class="text-end">
                                <a href="view.php?id=<?php echo $produto['id']; ?>" class="btn btn-sm btn-outline-success" title="Visualizar"><i class="fa-solid fa-eye"></i></a>
                                <a href="edit.php?id=<?php echo $produto['id']; ?>" class="btn btn-sm btn-outline-primary" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                <a href="delete.php?id=<?php echo $produto['id']; ?>" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir o material?');"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center">Nenhum registro encontrado.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include(FOOTER_TEMPLATE); ?>
