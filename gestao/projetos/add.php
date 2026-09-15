<?php
require_once "../../config.php";
require_once DBAPI;
require_once ABSPATH . "inc/auth.php";
require_roles(['admin', 'dono', 'funcionario']);

$database = open_database();
$clientes = [];
try {
    if (!$database) {
        throw new RuntimeException('Banco indisponível.');
    }
    $stmt = $database->query("SELECT id, nome, email FROM usuarios WHERE rule = 'cliente' ORDER BY nome ASC");
    if ($stmt) $clientes = $stmt->fetchAll();
} catch (Throwable $e) {
    error_log('Client list error: ' . $e->getMessage());
}

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $clienteId = (int)($_POST['cliente_id'] ?? 0);
    $titulo = trim((string)($_POST['titulo'] ?? ''));
    $descricao = trim((string)($_POST['descricao'] ?? ''));
    $status = (string)($_POST['status'] ?? 'analise');
    $allowedStatuses = ['analise', 'fabricacao', 'transporte', 'montagem', 'concluido'];

    try {
        if (!$database) {
            throw new RuntimeException('Banco indisponível.');
        }
        if ($clienteId <= 0 || $titulo === '' || mb_strlen($titulo) > 100 ||
            !in_array($status, $allowedStatuses, true)) {
            throw new InvalidArgumentException('Preencha os dados do projeto corretamente.');
        }

        $clientStmt = $database->prepare(
            "SELECT id FROM usuarios WHERE id = :id AND rule = 'cliente'"
        );
        $clientStmt->execute([':id' => $clienteId]);
        if (!$clientStmt->fetch()) {
            throw new InvalidArgumentException('Cliente inválido.');
        }

        $saved = save('projetos_cliente', [
            'cliente_id' => $clienteId,
            'titulo' => $titulo,
            'descricao' => $descricao,
            'status' => $status
        ]);
        if (!$saved) {
            throw new RuntimeException('Não foi possível salvar o projeto.');
        }

        close_database($database);
        header('Location: index.php');
        exit;
    } catch (Throwable $e) {
        error_log('Project insert error: ' . $e->getMessage());
        $erro = $e instanceof InvalidArgumentException
            ? $e->getMessage()
            : 'Não foi possível cadastrar o projeto.';
    }
}
close_database($database);

include(HEADER_TEMPLATE);
?>

<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">Novo Projeto</h2>
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
                <form action="add.php" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Cliente <span class="text-danger">*</span></label>
                        <select name="cliente_id" class="form-select bg-light border-0" required>
                            <option value="">Selecione o Cliente...</option>
                            <?php foreach($clientes as $cli): ?>
                                <option value="<?php echo $cli['id']; ?>"><?php echo htmlspecialchars($cli['nome']) . ' (' . htmlspecialchars($cli['email']) . ')'; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Título do Projeto <span class="text-danger">*</span></label>
                        <input type="text" name="titulo" class="form-control bg-light border-0" required placeholder="Ex: Cozinha Completa - Apto 42">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descrição / Medidas</label>
                        <textarea name="descricao" class="form-control bg-light border-0" rows="4"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Status Inicial</label>
                        <select name="status" class="form-select bg-light border-0">
                            <option value="analise">Em Análise de Medidas</option>
                            <option value="fabricacao">Em Fabricação</option>
                            <option value="transporte">Em Transporte</option>
                            <option value="montagem">Em Montagem Local</option>
                            <option value="concluido">Concluído</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-nanias w-100 rounded-pill">Criar Projeto</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include(FOOTER_TEMPLATE); ?>
