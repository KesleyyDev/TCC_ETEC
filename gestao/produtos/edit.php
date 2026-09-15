<?php
require_once "../../config.php";
require_once DBAPI;
require_once ABSPATH . "inc/auth.php";
require_once ABSPATH . "inc/uploads.php";
require_roles(['admin', 'dono', 'funcionario']);

$database = open_database();
$categorias = [];
if ($database) {
try {
    $stmt = $database->query("SELECT id, nome FROM categorias WHERE tipo = 'moveis'");
    if($stmt) $categorias = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log('Category query error: ' . $e->getMessage());
}
} else {
    error_log('Category query skipped: database unavailable.');
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$produto = find('produtos', $id);
if (!$produto) {
    close_database($database);
    header('Location: index.php');
    exit;
}

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $input = is_array($_POST['produto'] ?? null) ? $_POST['produto'] : [];
    $titulo = trim((string)($input['titulo'] ?? ''));
    $descricao = trim((string)($input['descricao'] ?? ''));
    $categoriaId = (int)($input['categoria_id'] ?? 0);
    $destaque = (int)($input['destaque'] ?? 0);
    $ativo = (int)($input['ativo'] ?? 1);

    if ($titulo === '' || mb_strlen($titulo) > 100 || $descricao === '') {
        $erro = 'Preencha um título e uma descrição válidos.';
    } elseif (!in_array($destaque, [0, 1], true) || !in_array($ativo, [0, 1], true)) {
        $erro = 'Status do produto inválido.';
    } elseif ($categoriaId <= 0) {
        $erro = 'Selecione uma categoria válida.';
    }

    $uploadedFiles = [];
    try {
        if ($erro !== '') {
            throw new InvalidArgumentException($erro);
        }
        if (!$database) {
            throw new RuntimeException('Banco indisponível.');
        }

        $categoryStmt = $database->prepare(
            "SELECT id FROM categorias WHERE id = :id AND tipo = 'moveis'"
        );
        $categoryStmt->execute([':id' => $categoriaId]);
        if (!$categoryStmt->fetch()) {
            throw new InvalidArgumentException('Categoria de móvel inválida.');
        }

        $mainImage = store_image_upload($_FILES['imagem_principal'] ?? null, 'prod_');
        if ($mainImage !== null) {
            $uploadedFiles[] = $mainImage;
        } else {
            $mainImage = $produto['imagem_url'];
        }
        $galleryImages = store_multiple_image_uploads($_FILES['galeria'] ?? null, 'gal_');
        $uploadedFiles = array_merge($uploadedFiles, $galleryImages);

        $database->beginTransaction();
        $stmt = $database->prepare(
            'UPDATE produtos SET titulo = :titulo, descricao = :descricao, imagem_url = :imagem_url, '
            . 'categoria_id = :categoria_id, destaque = :destaque, ativo = :ativo WHERE id = :id'
        );
        $stmt->execute([
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':imagem_url' => $mainImage,
            ':categoria_id' => $categoriaId,
            ':destaque' => $destaque,
            ':ativo' => $ativo,
            ':id' => $id
        ]);

        if ($galleryImages) {
            $galleryStmt = $database->prepare(
                'INSERT INTO imagens_produto (produto_id, imagem_url) VALUES (:produto_id, :imagem_url)'
            );
            foreach ($galleryImages as $galleryImage) {
                $galleryStmt->execute([
                    ':produto_id' => $id,
                    ':imagem_url' => $galleryImage
                ]);
            }
        }

        $database->commit();
        $_SESSION['message'] = 'Produto atualizado com sucesso.';
        $_SESSION['type'] = 'success';
        close_database($database);
        header('Location: index.php');
        exit;
    } catch (Throwable $e) {
        if ($database && $database->inTransaction()) {
            $database->rollBack();
        }
        foreach ($uploadedFiles as $uploadedFile) {
            $absoluteFile = ABSPATH . str_replace('/', DIRECTORY_SEPARATOR, $uploadedFile);
            if (is_file($absoluteFile)) {
                unlink($absoluteFile);
            }
        }
        error_log('Product update error: ' . $e->getMessage());
        if ($erro === '') {
            $erro = $e instanceof InvalidArgumentException
                ? $e->getMessage()
                : 'Não foi possível atualizar o produto.';
        }
    }
}

// Buscar imagens da galeria atual
$galeria = [];
try {
    $stmt = $database->prepare("SELECT * FROM imagens_produto WHERE produto_id = ?");
    $stmt->execute([$id]);
    $galeria = $stmt->fetchAll();
} catch(PDOException $e) {
    error_log('Gallery query error: ' . $e->getMessage());
}

close_database($database);
include(HEADER_TEMPLATE);
?>
<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">Editar Produto #<?php echo $produto['id']; ?></h2>
        </div>
    </div>
    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>
    <form action="edit.php?id=<?php echo $produto['id']; ?>" method="POST" enctype="multipart/form-data" class="shadow-sm rounded-4 bg-white p-4">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label for="titulo" class="fw-bold">Título <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="produto[titulo]" value="<?php echo htmlspecialchars($produto['titulo']); ?>" required>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="categoria_id" class="fw-bold">Categoria <span class="text-danger">*</span></label>
                <select class="form-control" name="produto[categoria_id]" required>
                    <option value="">Selecione...</option>
                    <?php foreach($categorias as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php if($produto['categoria_id'] == $cat['id']) echo 'selected'; ?>><?php echo htmlspecialchars($cat['nome']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-12 mb-3">
                <label for="descricao" class="fw-bold">Descrição <span class="text-danger">*</span></label>
                <textarea class="form-control" name="produto[descricao]" rows="3" required><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="imagem_principal" class="fw-bold">Alterar Imagem Principal (Capa)</label>
                <input type="file" class="form-control" name="imagem_principal" accept="image/*">
                <?php if(!empty($produto['imagem_url']) && local_image_exists($produto['imagem_url'])): ?>
                    <div class="mt-2">
                    <img src="<?php echo BASEURL . htmlspecialchars($produto['imagem_url'], ENT_QUOTES, 'UTF-8'); ?>" alt="Atual" style="height: 60px; border-radius: 8px;">
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="galeria" class="fw-bold">Adicionar à Galeria (Múltiplas Imagens)</label>
                <input type="file" class="form-control" name="galeria[]" accept="image/*" multiple>
                <?php if($galeria): ?>
                    <div class="mt-2 d-flex flex-wrap gap-2">
                        <?php foreach($galeria as $img): ?>
                            <?php if (local_image_exists($img['imagem_url'])): ?>
                                <img src="<?php echo BASEURL . htmlspecialchars($img['imagem_url'], ENT_QUOTES, 'UTF-8'); ?>" style="height: 60px; border-radius: 8px;">
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group col-md-3 mb-3">
                <label for="destaque" class="fw-bold">Destaque na Home?</label>
                <select class="form-control" name="produto[destaque]">
                    <option value="0" <?php if($produto['destaque'] == '0') echo 'selected'; ?>>Não</option>
                    <option value="1" <?php if($produto['destaque'] == '1') echo 'selected'; ?>>Sim</option>
                </select>
            </div>
            <div class="form-group col-md-3 mb-3">
                <label for="ativo" class="fw-bold">Status</label>
                <select class="form-control" name="produto[ativo]">
                    <option value="1" <?php if($produto['ativo'] == '1') echo 'selected'; ?>>Ativo</option>
                    <option value="0" <?php if($produto['ativo'] == '0') echo 'selected'; ?>>Inativo</option>
                </select>
            </div>
        </div>
        <div id="actions" class="row mt-4">
            <div class="col-md-12">
                <button type="submit" class="btn btn-nanias px-4 rounded-pill">Salvar Alterações</button>
                <a href="index.php" class="btn btn-outline-secondary rounded-pill ms-2">Cancelar</a>
            </div>
        </div>
    </form>
</div>
<?php include(FOOTER_TEMPLATE); ?>
