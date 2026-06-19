<?php
require_once "../../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: " . BASEURL . "paginas/login.php");
    exit;
}
$allowed_rules = ['admin', 'dono', 'funcionario'];
if (!isset($_SESSION['usuario_rule']) || !in_array($_SESSION['usuario_rule'], $allowed_rules)) {
    header("Location: " . BASEURL . "index.php?erro=acesso_negado");
    exit;
}

$database = open_database();
$clientes = [];
try {
    $stmt = $database->query("SELECT id, nome, email FROM usuarios WHERE rule = 'cliente' ORDER BY nome ASC");
    if($stmt) $clientes = $stmt->fetchAll();
} catch (PDOException $e) {}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projeto = [
        'cliente_id' => $_POST['cliente_id'],
        'titulo' => $_POST['titulo'],
        'descricao' => $_POST['descricao'],
        'status' => $_POST['status']
    ];
    save('projetos_cliente', $projeto);
    close_database($database);
    header("Location: index.php");
    exit;
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

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <form action="add.php" method="POST">
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
