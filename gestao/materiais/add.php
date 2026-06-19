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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto = $_POST['produto'];
    save('produtos', $produto);
    header('Location: index.php');
    exit;
}

include(HEADER_TEMPLATE);
?>
<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">Novo Material</h2>
        </div>
    </div>
    <form action="add.php" method="POST" class="shadow-sm rounded-4 bg-white p-4">
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label for="titulo">Título</label>
                <input type="text" class="form-control" name="produto[titulo]" required>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="categoria_id">Categoria</label>
                <select class="form-control" name="produto[categoria_id]" required>
                    <option value="">Selecione...</option>
                    <?php foreach($categorias as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nome']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-12 mb-3">
                <label for="descricao">Descrição</label>
                <textarea class="form-control" name="produto[descricao]" rows="3" required></textarea>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="imagem_url">URL da Imagem</label>
                <input type="text" class="form-control" name="produto[imagem_url]" placeholder="ex: img/produtos/material.jpg">
            </div>
            <div class="form-group col-md-3 mb-3">
                <label for="destaque">Destaque na Home?</label>
                <select class="form-control" name="produto[destaque]">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
            </div>
            <div class="form-group col-md-3 mb-3">
                <label for="ativo">Status</label>
                <select class="form-control" name="produto[ativo]">
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                </select>
            </div>
        </div>
        <div id="actions" class="row mt-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-nanias">Salvar</button>
                <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </div>
    </form>
</div>
<?php include(FOOTER_TEMPLATE); ?>
