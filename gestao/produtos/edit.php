<?php
require_once "../../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ' . BASEURL . 'paginas/login.php');
    exit;
}

$database = open_database();
$categorias = [];
try {
    $stmt = $database->query("SELECT id, nome FROM categorias WHERE tipo = 'moveis'");
    if($stmt) $categorias = $stmt->fetchAll();
} catch (PDOException $e) {}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$produto = find('produtos', $id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_update = $_POST['produto'];
    $upload_dir = ABSPATH . 'img/produtos/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

    // Upload da imagem principal (se houver)
    if (isset($_FILES['imagem_principal']) && $_FILES['imagem_principal']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['imagem_principal']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('prod_') . '.' . $ext;
        if (move_uploaded_file($_FILES['imagem_principal']['tmp_name'], $upload_dir . $filename)) {
            $produto_update['imagem_url'] = 'img/produtos/' . $filename;
        }
    } else {
        $produto_update['imagem_url'] = $produto['imagem_url']; // Mantém a existente
    }

    try {
        update('produtos', $id, $produto_update);

        // Upload das imagens da galeria (adiciona novas)
        if (isset($_FILES['galeria'])) {
            $total = count($_FILES['galeria']['name']);
            for ($i = 0; $i < $total; $i++) {
                if ($_FILES['galeria']['error'][$i] === UPLOAD_ERR_OK) {
                    $ext = pathinfo($_FILES['galeria']['name'][$i], PATHINFO_EXTENSION);
                    $filename = uniqid('gal_') . '_' . $i . '.' . $ext;
                    if (move_uploaded_file($_FILES['galeria']['tmp_name'][$i], $upload_dir . $filename)) {
                        $gal_url = 'img/produtos/' . $filename;
                        $database->prepare("INSERT INTO imagens_produto (produto_id, imagem_url) VALUES (?, ?)")
                                 ->execute([$id, $gal_url]);
                    }
                }
            }
        }
    } catch (PDOException $e) {}

    close_database($database);
    header('Location: index.php');
    exit;
}

// Buscar imagens da galeria atual
$galeria = [];
try {
    $stmt = $database->prepare("SELECT * FROM imagens_produto WHERE produto_id = ?");
    $stmt->execute([$id]);
    $galeria = $stmt->fetchAll();
} catch(PDOException $e) {}

close_database($database);
include(HEADER_TEMPLATE);
?>
<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">Editar Produto #<?php echo $produto['id']; ?></h2>
        </div>
    </div>
    <form action="edit.php?id=<?php echo $produto['id']; ?>" method="POST" enctype="multipart/form-data" class="shadow-sm rounded-4 bg-white p-4">
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
                <?php if($produto['imagem_url']): ?>
                    <div class="mt-2">
                        <img src="<?php echo BASEURL . $produto['imagem_url']; ?>" alt="Atual" style="height: 60px; border-radius: 8px;">
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="galeria" class="fw-bold">Adicionar à Galeria (Múltiplas Imagens)</label>
                <input type="file" class="form-control" name="galeria[]" accept="image/*" multiple>
                <?php if($galeria): ?>
                    <div class="mt-2 d-flex flex-wrap gap-2">
                        <?php foreach($galeria as $img): ?>
                            <img src="<?php echo BASEURL . $img['imagem_url']; ?>" style="height: 60px; border-radius: 8px;">
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
