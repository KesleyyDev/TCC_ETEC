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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto = $_POST['produto'];
    $upload_dir = ABSPATH . 'img/produtos/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

    // Upload da imagem principal
    if (isset($_FILES['imagem_principal']) && $_FILES['imagem_principal']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['imagem_principal']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('prod_') . '.' . $ext;
        if (move_uploaded_file($_FILES['imagem_principal']['tmp_name'], $upload_dir . $filename)) {
            $produto['imagem_url'] = 'img/produtos/' . $filename;
        }
    } else {
        $produto['imagem_url'] = ''; // ou uma imagem default
    }

    // Salvar produto e pegar o ID
    try {
        $colunas = array_keys($produto);
        $valores = array_values($produto);
        $placeholders = implode(', ', array_fill(0, count($valores), '?'));
        $sql = "INSERT INTO produtos (" . implode(', ', $colunas) . ") VALUES (" . $placeholders . ")";
        $stmt = $database->prepare($sql);
        $stmt->execute($valores);
        $produto_id = $database->lastInsertId();

        // Upload das imagens da galeria
        if (isset($_FILES['galeria'])) {
            $total = count($_FILES['galeria']['name']);
            for ($i = 0; $i < $total; $i++) {
                if ($_FILES['galeria']['error'][$i] === UPLOAD_ERR_OK) {
                    $ext = pathinfo($_FILES['galeria']['name'][$i], PATHINFO_EXTENSION);
                    $filename = uniqid('gal_') . '_' . $i . '.' . $ext;
                    if (move_uploaded_file($_FILES['galeria']['tmp_name'][$i], $upload_dir . $filename)) {
                        $gal_url = 'img/produtos/' . $filename;
                        $database->prepare("INSERT INTO imagens_produto (produto_id, imagem_url) VALUES (?, ?)")
                                 ->execute([$produto_id, $gal_url]);
                    }
                }
            }
        }
    } catch (PDOException $e) {}

    close_database($database);
    header('Location: index.php');
    exit;
}

close_database($database);
include(HEADER_TEMPLATE);
?>
<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">Novo Produto (Móvel)</h2>
        </div>
    </div>
    <form action="add.php" method="POST" enctype="multipart/form-data" class="shadow-sm rounded-4 bg-white p-4">
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label for="titulo" class="fw-bold">Título <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="produto[titulo]" required>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="categoria_id" class="fw-bold">Categoria <span class="text-danger">*</span></label>
                <select class="form-control" name="produto[categoria_id]" required>
                    <option value="">Selecione...</option>
                    <?php foreach($categorias as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nome']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-12 mb-3">
                <label for="descricao" class="fw-bold">Descrição <span class="text-danger">*</span></label>
                <textarea class="form-control" name="produto[descricao]" rows="3" required></textarea>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="imagem_principal" class="fw-bold">Imagem Principal (Capa)</label>
                <input type="file" class="form-control" name="imagem_principal" accept="image/*">
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="galeria" class="fw-bold">Galeria (Múltiplas Imagens)</label>
                <input type="file" class="form-control" name="galeria[]" accept="image/*" multiple>
                <small class="text-muted">Selecione várias fotos segurando CTRL/CMD.</small>
            </div>
            <div class="form-group col-md-3 mb-3">
                <label for="destaque" class="fw-bold">Destaque na Home?</label>
                <select class="form-control" name="produto[destaque]">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
            </div>
            <div class="form-group col-md-3 mb-3">
                <label for="ativo" class="fw-bold">Status</label>
                <select class="form-control" name="produto[ativo]">
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                </select>
            </div>
        </div>
        <div id="actions" class="row mt-4">
            <div class="col-md-12">
                <button type="submit" class="btn btn-nanias px-4 rounded-pill">Salvar Produto</button>
                <a href="index.php" class="btn btn-outline-secondary rounded-pill ms-2">Cancelar</a>
            </div>
        </div>
    </form>
</div>
<?php include(FOOTER_TEMPLATE); ?>
