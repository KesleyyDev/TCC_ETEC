<?php
require_once "../config.php";
require_once DBAPI;
require_once ABSPATH . "inc/auth.php";

$allowed_rules = ['admin', 'dono', 'funcionario'];
require_roles($allowed_rules);

$database = open_database();
$kpis = [
    'orcamentos_novos' => 0,
    'projetos_andamento' => 0,
    'clientes_total' => 0,
    'produtos_ativos' => 0
];

if ($database) {
    try {
        $stmt = $database->query("SELECT COUNT(id) FROM orcamentos WHERE status = 'novo'");
        if ($stmt) $kpis['orcamentos_novos'] = (int)$stmt->fetchColumn();

        $stmt = $database->query("SELECT COUNT(id) FROM projetos_cliente WHERE status != 'concluido'");
        if ($stmt) $kpis['projetos_andamento'] = (int)$stmt->fetchColumn();

        $stmt = $database->query("SELECT COUNT(id) FROM usuarios WHERE rule = 'cliente'");
        if ($stmt) $kpis['clientes_total'] = (int)$stmt->fetchColumn();

        $stmt = $database->query("SELECT COUNT(id) FROM produtos WHERE ativo = 1");
        if ($stmt) $kpis['produtos_ativos'] = (int)$stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log('Dashboard query error: ' . $e->getMessage());
    }
}
close_database($database);

include(HEADER_TEMPLATE);
?>

    <div class="row mt-5 fade-in">
        <div class="col-md-12">
            <h2 style="color: var(--logo-escuro); font-weight: 600;">
                <i class="fa-solid fa-boxes-stacked me-2"></i> Gestão do Sistema
            </h2>
            <hr style="border-color: var(--verde-claro); border-width: 2px;">
        </div>
    </div>

    <!-- Seção de KPIs (Dashboard Analítico) -->
    <div class="row mb-5 slide-up">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #1A4645, #266b69); color: white;">
                <div class="card-body text-center py-4">
                    <h1 class="display-5 fw-bold mb-0"><?php echo $kpis['orcamentos_novos']; ?></h1>
                    <p class="mb-0 mt-2">Orçamentos Novos</p>
                    <a href="orcamentos/index.php" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #266b69, #1A4645); color: white;">
                <div class="card-body text-center py-4">
                    <h1 class="display-5 fw-bold mb-0"><?php echo $kpis['projetos_andamento']; ?></h1>
                    <p class="mb-0 mt-2">Projetos em Andamento</p>
                    <a href="projetos/index.php" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 dashboard-kpi-light dashboard-kpi-clients" style="background: linear-gradient(135deg, #F8CCB5, #e0b098);">
                <div class="card-body text-center py-4">
                    <h1 class="display-5 fw-bold mb-0"><?php echo $kpis['clientes_total']; ?></h1>
                    <p class="mb-0 mt-2 fw-bold">Clientes Cadastrados</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 dashboard-kpi-light dashboard-kpi-products" style="background: linear-gradient(135deg, #EBECE8, #dcdedd);">
                <div class="card-body text-center py-4">
                    <h1 class="display-5 fw-bold mb-0"><?php echo $kpis['produtos_ativos']; ?></h1>
                    <p class="mb-0 mt-2 fw-bold">Produtos Ativos</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 mb-5 slide-up delay-1">
        <?php if (in_array($_SESSION['usuario_rule'], ['admin', 'dono'])): ?>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 border-0" style="background-color: #ffffff; border-radius: 10px;">
                <div class="card-body text-center py-5">
                    <i class="fa-solid fa-users fa-3x mb-3" style="color: var(--botao-escuro);"></i>
                    <h5 class="card-title" style="color: var(--header-escuro);">Usuários</h5>
                    <p class="card-text text-muted mb-4">Gerencie os usuários do sistema.</p>
                    <a href="usuarios/index.php" class="btn px-4" style="background-color: var(--botao-escuro); color: #ffffff; font-weight: 500;">
                        <i class="fa-solid fa-list me-1"></i> Ver Lista
                    </a>
                    <a href="usuarios/add.php" class="btn px-4" style="background-color: var(--logo-escuro); color: #ffffff; font-weight: 500;">
                        <i class="fa-solid fa-plus me-1"></i> Adicionar
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 border-0" style="background-color: #ffffff; border-radius: 10px;">
                <div class="card-body text-center py-5">
                    <i class="fa-solid fa-couch fa-3x mb-3" style="color: var(--logo-claro);"></i>
                    <h5 class="card-title" style="color: var(--header-escuro);">Produtos</h5>
                    <p class="card-text text-muted mb-4">Gerencie os produtos do catálogo (Móveis).</p>
                    <a href="produtos/index.php" class="btn px-4" style="background-color: var(--verde-oliva); color: #ffffff; font-weight: 500;">
                        <i class="fa-solid fa-list me-1"></i> Ver Lista
                    </a>
                    <a href="produtos/add.php" class="btn px-4" style="background-color: var(--logo-escuro); color: #ffffff; font-weight: 500;">
                        <i class="fa-solid fa-plus me-1"></i> Adicionar
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 border-0" style="background-color: #ffffff; border-radius: 10px;">
                <div class="card-body text-center py-5">
                    <i class="fa-solid fa-cubes fa-3x mb-3" style="color: var(--verde-claro);"></i>
                    <h5 class="card-title" style="color: var(--header-escuro);">Materiais</h5>
                    <p class="card-text text-muted mb-4">Gerencie os materiais disponíveis.</p>
                    <a href="materiais/index.php" class="btn px-4" style="background-color: var(--header-escuro); color: #ffffff; font-weight: 500;">
                        <i class="fa-solid fa-list me-1"></i> Ver Lista
                    </a>
                    <a href="materiais/add.php" class="btn px-4" style="background-color: var(--logo-escuro); color: #ffffff; font-weight: 500;">
                        <i class="fa-solid fa-plus me-1"></i> Adicionar
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php 
include(FOOTER_TEMPLATE);
?>
