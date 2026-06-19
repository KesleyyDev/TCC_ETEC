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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $id = (int)$_GET['id'];
    $status = $_POST['status'];
    try {
        $stmt = $database->prepare("UPDATE orcamentos SET status = :status WHERE id = :id");
        $stmt->execute([':status' => $status, ':id' => $id]);
    } catch(PDOException $e) {}
    header("Location: view.php?id=$id");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$orcamento = null;
if ($id) {
    try {
        $sql = "SELECT o.*, p.titulo as produto_titulo, p.imagem_url as produto_imagem FROM orcamentos o LEFT JOIN produtos p ON o.produto_id = p.id WHERE o.id = :id";
        $stmt = $database->prepare($sql);
        $stmt->execute([':id' => $id]);
        $orcamento = $stmt->fetch();
    } catch(PDOException $e) {}
}
close_database($database);

if (!$orcamento) {
    header("Location: index.php");
    exit;
}

include(HEADER_TEMPLATE);
?>

<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">Detalhes do Orçamento #<?php echo $orcamento['id']; ?></h2>
            <a href="index.php" class="btn btn-outline-nanias rounded-pill">
                <i class="fa-solid fa-arrow-left me-1"></i> Voltar
            </a>
        </div>
        <hr style="border-color: var(--verde-claro); border-width: 2px;">
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4 p-4 mb-4">
                <h5 class="fw-bold mb-4">Informações do Cliente</h5>
                <p><strong>Nome:</strong> <?php echo htmlspecialchars($orcamento['cliente_nome']); ?></p>
                <p><strong>E-mail:</strong> <?php echo htmlspecialchars($orcamento['cliente_email']); ?></p>
                <p><strong>Telefone/WhatsApp:</strong> <a href="https://wa.me/55<?php echo preg_replace('/[^0-9]/', '', $orcamento['telefone']); ?>" target="_blank" class="text-decoration-none text-success"><i class="fa-brands fa-whatsapp me-1"></i> <?php echo htmlspecialchars($orcamento['telefone']); ?></a></p>
                <p><strong>Data:</strong> <?php echo date('d/m/Y H:i', strtotime($orcamento['data_envio'])); ?></p>
                
                <h5 class="fw-bold mt-4 mb-3">Mensagem / Detalhes</h5>
                <div class="p-3 bg-light rounded border">
                    <?php echo nl2br(htmlspecialchars($orcamento['mensagem'])); ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 p-4 mb-4">
                <h5 class="fw-bold mb-3">Status de Atendimento</h5>
                <form action="view.php?id=<?php echo $orcamento['id']; ?>" method="POST">
                    <select name="status" class="form-select mb-3" onchange="this.form.submit()">
                        <option value="novo" <?php if($orcamento['status'] == 'novo') echo 'selected'; ?>>Novo</option>
                        <option value="em atendimento" <?php if($orcamento['status'] == 'em atendimento') echo 'selected'; ?>>Em Atendimento</option>
                        <option value="fechado" <?php if($orcamento['status'] == 'fechado') echo 'selected'; ?>>Fechado</option>
                    </select>
                </form>
            </div>

            <?php if($orcamento['produto_id']): ?>
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <h5 class="fw-bold mb-3">Produto Relacionado</h5>
                <?php if($orcamento['produto_imagem']): ?>
                    <img src="<?php echo BASEURL . $orcamento['produto_imagem']; ?>" class="img-fluid rounded mb-2">
                <?php endif; ?>
                <p class="mb-0 fw-bold text-center"><?php echo htmlspecialchars($orcamento['produto_titulo']); ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include(FOOTER_TEMPLATE); ?>
