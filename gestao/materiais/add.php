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
    $stmt = $database->query("SELECT id, nome FROM categorias WHERE tipo = 'materiais'");
    if($stmt) $categorias = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log('Category query error: ' . $e->getMessage());
}
} else {
    error_log('Category query skipped: database unavailable.');
}
close_database($database);

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $input = is_array($_POST['produto'] ?? null) ? $_POST['produto'] : [];
    $titulo = trim((string)($input['titulo'] ?? ''));
    $descricao = trim((string)($input['descricao'] ?? ''));
    $categoriaId = (int)($input['categoria_id'] ?? 0);
    $destaque = (int)($input['destaque'] ?? 0);
    $ativo = (int)($input['ativo'] ?? 1);

    try {
        $imagemUrl = normalize_image_path($input['imagem_url'] ?? null);
        if ($titulo === '' || mb_strlen($titulo) > 100 || $descricao === '') {
            throw new InvalidArgumentException('Preencha um título e uma descrição válidos.');
        }
        if ($categoriaId <= 0 || !in_array($destaque, [0, 1], true) || !in_array($ativo, [0, 1], true)) {
            throw new InvalidArgumentException('Informe valores válidos para categoria e status.');
        }

        $database = open_database();
        if (!$database) {
            throw new RuntimeException('Banco indisponível.');
        }
        $categoryStmt = $database->prepare(
            "SELECT id FROM categorias WHERE id = :id AND tipo = 'materiais'"
        );
        $categoryStmt->execute([':id' => $categoriaId]);
        if (!$categoryStmt->fetch()) {
            throw new InvalidArgumentException('Categoria de material inválida.');
        }

        $stmt = $database->prepare(
            'INSERT INTO produtos (titulo, descricao, imagem_url, categoria_id, destaque, ativo) '
            . 'VALUES (:titulo, :descricao, :imagem_url, :categoria_id, :destaque, :ativo)'
        );
        $stmt->execute([
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':imagem_url' => $imagemUrl,
            ':categoria_id' => $categoriaId,
            ':destaque' => $destaque,
            ':ativo' => $ativo
        ]);
        close_database($database);
        $_SESSION['message'] = 'Material cadastrado com sucesso.';
        $_SESSION['type'] = 'success';
        header('Location: index.php');
        exit;
    } catch (Throwable $e) {
        error_log('Material insert error: ' . $e->getMessage());
        $erro = $e instanceof InvalidArgumentException
            ? $e->getMessage()
            : 'Não foi possível cadastrar o material.';
        if (isset($database) && $database instanceof PDO) {
            close_database($database);
        }
    }
}

include(HEADER_TEMPLATE);
?>
<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">Novo Material</h2>
        </div>
    </div>
    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>
    <form action="add.php" method="POST" class="shadow-sm rounded-4 bg-white p-4">
        <?php echo csrf_field(); ?>
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
