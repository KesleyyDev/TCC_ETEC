<?php
require_once "../../config.php";
require_once DBAPI;
require_once ABSPATH . "inc/auth.php";
require_roles(['admin', 'dono', 'funcionario']);

$database = open_database();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$projeto = $id > 0 ? find('projetos_cliente', $id) : null;
if (!$projeto) {
    close_database($database);
    header('Location: index.php');
    exit;
}

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $titulo = trim((string)($_POST['titulo'] ?? ''));
    $descricao = trim((string)($_POST['descricao'] ?? ''));
    $status = (string)($_POST['status'] ?? '');
    $allowedStatuses = ['analise', 'fabricacao', 'transporte', 'montagem', 'concluido'];

    if ($titulo === '' || mb_strlen($titulo) > 100 || !in_array($status, $allowedStatuses, true)) {
        $erro = 'Preencha os dados do projeto corretamente.';
    } elseif (!update('projetos_cliente', $id, [
        'titulo' => $titulo,
        'descricao' => $descricao,
        'status' => $status
    ])) {
        $erro = 'Não foi possível atualizar o projeto.';
    } else {
        close_database($database);
        header('Location: index.php');
        exit;
    }
}

$cliente = find('usuarios', $projeto['cliente_id']);
close_database($database);

include(HEADER_TEMPLATE);
?>

<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">Editar Projeto #<?php echo $projeto['id']; ?></h2>
            <a href="index.php" class="btn btn-outline-nanias rounded-pill">Voltar</a>
        </div>
        <hr style="border-color: var(--verde-claro); border-width: 2px;">
    </div>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <form action="edit.php?id=<?php echo (int)$projeto['id']; ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Cliente</label>
                        <input type="text" class="form-control bg-light border-0" value="<?php echo htmlspecialchars($cliente['nome'] . ' (' . $cliente['email'] . ')'); ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Título do Projeto <span class="text-danger">*</span></label>
                        <input type="text" name="titulo" class="form-control bg-light border-0" value="<?php echo htmlspecialchars($projeto['titulo']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descrição / Medidas</label>
                        <textarea name="descricao" class="form-control bg-light border-0" rows="4"><?php echo htmlspecialchars($projeto['descricao']); ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Status Atual</label>
                        <select name="status" class="form-select bg-light border-0">
                            <option value="analise" <?php if($projeto['status']=='analise') echo 'selected'; ?>>Em Análise de Medidas</option>
                            <option value="fabricacao" <?php if($projeto['status']=='fabricacao') echo 'selected'; ?>>Em Fabricação</option>
                            <option value="transporte" <?php if($projeto['status']=='transporte') echo 'selected'; ?>>Em Transporte</option>
                            <option value="montagem" <?php if($projeto['status']=='montagem') echo 'selected'; ?>>Em Montagem Local</option>
                            <option value="concluido" <?php if($projeto['status']=='concluido') echo 'selected'; ?>>Concluído</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-nanias w-100 rounded-pill">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include(FOOTER_TEMPLATE); ?>
