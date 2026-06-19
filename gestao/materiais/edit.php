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
    $stmt = $database->query("SELECT id, nome FROM categorias WHERE tipo = 'materiais'");
    if($stmt) $categorias = $stmt->fetchAll();
} catch (PDOException $e) {}
close_database($database);

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto = $_POST['produto'];
    update('produtos', $id, $produto);
    header('Location: index.php');
    exit;
  } else {
    $produto = find('produtos', $id);
  }
} else {
  header('Location: index.php');
  exit;
}

include(HEADER_TEMPLATE);
?>
<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">Editar Material</h2>
        </div>
    </div>
    <form action="edit.php?id=<?php echo $produto['id']; ?>" method="POST" class="shadow-sm rounded-4 bg-white p-4">
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label for="titulo">Título</label>
                <input type="text" class="form-control" name="produto[titulo]" value="<?php echo htmlspecialchars($produto['titulo']); ?>" required>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="categoria_id">Categoria</label>
                <select class="form-control" name="produto[categoria_id]" required>
                    <option value="">Selecione...</option>
                    <?php foreach($categorias as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php if($produto['categoria_id'] == $cat['id']) echo 'selected'; ?>><?php echo htmlspecialchars($cat['nome']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-12 mb-3">
                <label for="descricao">Descrição</label>
                <textarea class="form-control" name="produto[descricao]" rows="3" required><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="imagem_url">URL da Imagem</label>
                <input type="text" class="form-control" name="produto[imagem_url]" value="<?php echo htmlspecialchars($produto['imagem_url']); ?>">
            </div>
            <div class="form-group col-md-3 mb-3">
                <label for="destaque">Destaque na Home?</label>
                <select class="form-control" name="produto[destaque]">
                    <option value="0" <?php if($produto['destaque'] == 0) echo 'selected'; ?>>Não</option>
                    <option value="1" <?php if($produto['destaque'] == 1) echo 'selected'; ?>>Sim</option>
                </select>
            </div>
            <div class="form-group col-md-3 mb-3">
                <label for="ativo">Status</label>
                <select class="form-control" name="produto[ativo]">
                    <option value="1" <?php if($produto['ativo'] == 1) echo 'selected'; ?>>Ativo</option>
                    <option value="0" <?php if($produto['ativo'] == 0) echo 'selected'; ?>>Inativo</option>
                </select>
            </div>
        </div>
        <div id="actions" class="row mt-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-nanias">Atualizar</button>
                <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </div>
    </form>
</div>
<?php include(FOOTER_TEMPLATE); ?>
