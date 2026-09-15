<?php
require_once "../../config.php";
require_once DBAPI;
require_once ABSPATH . "inc/auth.php";
require_roles(['admin', 'dono', 'funcionario']);


if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $produto = find('produtos', $id);
    if (!$produto) {
        header('Location: index.php');
        exit;
    }
    
    // Fetch category name
    $database = open_database();
    $cat_nome = 'Desconhecida';
    if ($produto && isset($produto['categoria_id']) && $database) {
        try {
            $stmt = $database->prepare("SELECT nome FROM categorias WHERE id = :id");
            $stmt->execute([':id' => $produto['categoria_id']]);
            $cat = $stmt->fetch();
            if ($cat) $cat_nome = $cat['nome'];
        } catch (PDOException $e) {
            error_log('Category query error: ' . $e->getMessage());
        }
    }
    close_database($database);
} else {
    header('Location: index.php');
    exit;
}

include(HEADER_TEMPLATE);
?>
<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">Visualizar Material</h2>
            <a href="index.php" class="btn btn-outline-nanias rounded-pill">
                <i class="fa-solid fa-arrow-left me-1"></i> Voltar
            </a>
        </div>
        <hr style="border-color: var(--verde-claro); border-width: 2px;">
    </div>

    <div class="card shadow-sm border-0 rounded-4 p-4">
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <?php if(!empty($produto['imagem_url']) && local_image_exists($produto['imagem_url'])): ?>
                    <img src="<?php echo BASEURL . htmlspecialchars($produto['imagem_url'], ENT_QUOTES, 'UTF-8'); ?>" alt="" style="max-width: 100%; border-radius: 8px;">
                <?php else: ?>
                    <div class="rounded-3" style="width: 100%; height: 200px; background-color: var(--fundo-creme); display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-image fa-4x" style="color: var(--logo-claro);"></i>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <h6 class="text-muted mb-1">Título</h6>
                        <p class="fw-bold fs-4 mb-0"><?php echo htmlspecialchars($produto['titulo']); ?></p>
                    </div>
                    <div class="col-md-12 mb-3">
                        <h6 class="text-muted mb-1">Descrição</h6>
                        <p class="mb-0"><?php echo nl2br(htmlspecialchars($produto['descricao'])); ?></p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h6 class="text-muted mb-1">Categoria</h6>
                        <p class="mb-0"><span class="badge" style="background-color: var(--verde-claro); color: var(--header-escuro);"><?php echo htmlspecialchars($cat_nome); ?></span></p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h6 class="text-muted mb-1">Destaque</h6>
                        <p class="mb-0"><?php echo $produto['destaque'] ? 'Sim' : 'Não'; ?></p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h6 class="text-muted mb-1">Status</h6>
                        <p class="mb-0"><?php echo $produto['ativo'] ? 'Ativo' : 'Inativo'; ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-12">
                <a href="edit.php?id=<?php echo $produto['id']; ?>" class="btn btn-primary">Editar</a>
                <?php if (in_array($_SESSION['usuario_rule'], ['admin', 'dono'], true)): ?>
                <form action="delete.php" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo (int)$produto['id']; ?>">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include(FOOTER_TEMPLATE); ?>
