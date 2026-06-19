<?php
require_once "../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: " . BASEURL . "paginas/login.php");
    exit;
}

if ($_SESSION['usuario_rule'] !== 'cliente') {
    // Se for admin/dono/funcionario, vai para a gestão
    header("Location: " . BASEURL . "gestao/gestao.php");
    exit;
}

$database = open_database();
$projetos = [];
try {
    $stmt = $database->prepare("SELECT * FROM projetos_cliente WHERE cliente_id = :cliente_id ORDER BY atualizado_em DESC");
    $stmt->execute([':cliente_id' => $_SESSION['usuario_id']]);
    $projetos = $stmt->fetchAll();
} catch (PDOException $e) {}
close_database($database);

include(HEADER_TEMPLATE);

function getStatusProgress($status) {
    switch($status) {
        case 'analise': return 20;
        case 'fabricacao': return 50;
        case 'transporte': return 75;
        case 'montagem': return 90;
        case 'concluido': return 100;
        default: return 0;
    }
}
function getStatusLabel($status) {
    switch($status) {
        case 'analise': return 'Em Análise de Medidas';
        case 'fabricacao': return 'Em Fabricação';
        case 'transporte': return 'Em Transporte';
        case 'montagem': return 'Em Montagem Local';
        case 'concluido': return 'Concluído';
        default: return 'Desconhecido';
    }
}
?>

<div class="container py-5 fade-in">
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="display-6 fw-bold section-title mb-2">Área do Cliente</h2>
            <p class="text-muted">Bem-vindo(a), <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>! Acompanhe o andamento dos seus projetos abaixo.</p>
        </div>
    </div>

    <div class="row g-4">
        <?php if ($projetos): ?>
            <?php foreach ($projetos as $proj): 
                $progress = getStatusProgress($proj['status']);
                $label = getStatusLabel($proj['status']);
            ?>
            <div class="col-md-6 col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0 text-dark"><?php echo htmlspecialchars($proj['titulo']); ?></h5>
                            <span class="badge" style="background-color: var(--verde-claro); color: var(--header-escuro);"><?php echo $label; ?></span>
                        </div>
                        <p class="text-muted small mb-4"><?php echo nl2br(htmlspecialchars($proj['descricao'])); ?></p>
                        
                        <div class="progress mb-2" style="height: 10px; border-radius: 10px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="background-color: var(--logo-escuro); width: <?php echo $progress; ?>%;" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mt-2">
                            <span>Análise</span>
                            <span>Fabricação</span>
                            <span>Transporte</span>
                            <span>Montagem</span>
                            <span>Concluído</span>
                        </div>
                        <hr class="my-3 text-muted">
                        <small class="text-muted"><i class="fa-solid fa-clock me-1"></i> Última atualização: <?php echo date('d/m/Y H:i', strtotime($proj['atualizado_em'])); ?></small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fa-solid fa-folder-open fa-4x mb-3" style="color: var(--fundo-creme);"></i>
                <h4 class="text-muted">Nenhum projeto em andamento</h4>
                <p class="text-muted">Seu projeto aparecerá aqui assim que for iniciado pela nossa equipe.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include(FOOTER_TEMPLATE); ?>
