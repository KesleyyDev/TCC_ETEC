<?php
require_once "config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();

$database = open_database();
$destaques = [];
if ($database) {
    try {
        $stmt = $database->query("SELECT p.*, c.nome as categoria_nome FROM produtos p LEFT JOIN categorias c ON p.categoria_id = c.id WHERE p.ativo = 1 AND p.destaque = 1 AND c.tipo = 'moveis' ORDER BY p.id DESC LIMIT 6");
        if ($stmt) $destaques = $stmt->fetchAll();
    } catch(PDOException $e) {}
    close_database($database);
}

include(HEADER_TEMPLATE);
?>
</div>
<div class="main-banner fade-in">
    <div class="container h-100 d-flex align-items-center">
        <div class="banner-logo-wrapper">
            <img src="<?php echo BASEURL; ?>img/teste.png" alt="Logo Marcenaria Nanias" class="img-fluid banner-logo">
        </div>
    </div>
</div>
<div class="container">
    <div class="hero-section text-center fade-in">
        <div class="hero-content">
            <h1 class="display-3 fw-bold mb-4">Móveis Planejados com Excelência</h1>
            <p class="lead mb-5">Transformamos seu espaço com marcenaria sob medida, unindo design moderno e a tradição do trabalho bem feito.</p>
            <div class="d-flex justify-content-center flex-column flex-sm-row gap-3">
                <a href="<?php echo BASEURL; ?>paginas/catalogomoveis.php" class="btn btn-nanias btn-lg px-5 py-3 rounded-pill">
                    <i class="fa-solid fa-book-open me-2"></i>Ver Catálogo
                </a>
                <a href="<?php echo BASEURL; ?>paginas/orcamento.php" class="btn btn-outline-nanias btn-lg px-5 py-3 rounded-pill">
                    <i class="fa-solid fa-file-invoice-dollar me-2"></i>Solicitar Orçamento
                </a>
            </div>
        </div>
    </div>

    <div class="container py-5 slide-up home-features">
        <div class="row text-center mb-5 mt-4">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold mb-3 section-title">Por que escolher a Marcenaria Nanias?</h2>
                <p class="text-muted home-features-description">Nossa prioridade é a sua satisfação. Trabalhamos com materiais de alta qualidade para garantir durabilidade e beleza.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm feature-card">
                    <div class="card-body text-center p-5">
                        <div class="icon-box mb-4 mx-auto">
                            <i class="fa-solid fa-ruler-combined fa-2x" style="color: var(--logo-claro);"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Sob Medida</h4>
                        <p class="text-muted mb-0">Projetos 100% personalizados para aproveitar cada centímetro do seu ambiente.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm feature-card">
                    <div class="card-body text-center p-5">
                        <div class="icon-box mb-4 mx-auto">
                            <i class="fa-solid fa-leaf fa-2x" style="color: var(--logo-claro);"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Materiais Premium</h4>
                        <p class="text-muted mb-0">Utilizamos MDF e madeiras de fornecedores certificados e de altíssima durabilidade.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm feature-card">
                    <div class="card-body text-center p-5">
                        <div class="icon-box mb-4 mx-auto">
                            <i class="fa-solid fa-truck-fast fa-2x" style="color: var(--logo-claro);"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Entrega no Prazo</h4>
                        <p class="text-muted mb-0">Compromisso com o cronograma. Seu projeto entregue e montado na data combinada.</p>
                    </div>
                </div>
        </div>
    </div>

    <!-- Vitrine de Destaques -->
    <?php if(!empty($destaques)): ?>
    <div class="container py-5 slide-up mt-4">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold section-title mb-3">Projetos em Destaque</h2>
                <p class="text-muted">Conheça alguns dos nossos trabalhos mais recentes e inspire-se.</p>
            </div>
        </div>
        <div class="row g-4">
            <?php foreach($destaques as $prod): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm product-card" style="border-radius: 12px; transition: transform 0.3s;">
                    <div style="height: 250px; overflow: hidden; border-radius: 12px 12px 0 0;">
                        <?php if($prod['imagem_url']): ?>
                            <img src="<?php echo BASEURL . htmlspecialchars($prod['imagem_url']); ?>" alt="<?php echo htmlspecialchars($prod['titulo']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: var(--fundo-creme);">
                                <i class="fa-solid fa-couch fa-3x" style="color: var(--logo-claro);"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="fw-bold text-dark mb-2"><?php echo htmlspecialchars($prod['titulo']); ?></h5>
                        <div class="mb-3">
                            <span class="badge" style="background-color: var(--verde-claro); color: var(--header-escuro);"><?php echo htmlspecialchars($prod['categoria_nome']); ?></span>
                        </div>
                        <div class="mt-auto pt-3">
                            <a href="<?php echo BASEURL; ?>paginas/orcamento.php?produto=<?php echo $prod['id']; ?>" class="btn btn-outline-nanias w-100 rounded-pill">
                                Orçamento deste móvel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="<?php echo BASEURL; ?>paginas/catalogomoveis.php" class="btn btn-nanias px-5 py-2 rounded-pill">Ver Catálogo Completo</a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Depoimentos de Clientes -->
    <div class="container slide-up mt-5 home-testimonials">
        <div class="row mt-5 py-5" style="background-color: var(--fundo-creme); border-radius: 20px;">
            <div class="col-12 text-center mb-4">
                <h3 class="fw-bold section-title">O Que Nossos Clientes Dizem</h3>
                <p class="text-muted mt-2 home-testimonials-description">A satisfação de quem confiou na Marcenaria Nanias.</p>
            </div>
            <div class="col-12 px-4">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="testimonial-card shadow-sm h-100 bg-white" style="border-radius: 12px; padding: 2rem;">
                            <p class="text-muted fst-italic">"Minha cozinha ficou exatamente como eu sonhei. O acabamento é perfeito, cada detalhe foi pensado com muito cuidado. Recomendo de olhos fechados!"</p>
                            <div class="d-flex align-items-center mt-4">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; font-weight: bold;">MC</div>
                                <div>
                                    <div class="fw-bold text-dark">Maria C.</div>
                                    <div class="small text-muted">Cozinha Planejada</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial-card shadow-sm h-100 bg-white" style="border-radius: 12px; padding: 2rem;">
                            <p class="text-muted fst-italic">"Profissionalismo do início ao fim. Cumpriram o prazo, o material é de primeira qualidade e o preço foi justo. O guarda-roupa ficou incrível!"</p>
                            <div class="d-flex align-items-center mt-4">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; font-weight: bold;">RS</div>
                                <div>
                                    <div class="fw-bold text-dark">Roberto S.</div>
                                    <div class="small text-muted">Dormitório Master</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial-card shadow-sm h-100 bg-white" style="border-radius: 12px; padding: 2rem;">
                            <p class="text-muted fst-italic">"Já é o terceiro projeto que faço com a Nanias. Escritório, sala e agora a área gourmet. Qualidade sempre impecável e atendimento nota 10!"</p>
                            <div class="d-flex align-items-center mt-4">
                                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; font-weight: bold;">AF</div>
                                <div>
                                    <div class="fw-bold text-dark">Ana F.</div>
                                    <div class="small text-muted">Área Gourmet</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="container py-4 home-cta">
            <h2 class="fw-bold mb-3">Pronto para realizar seu projeto?</h2>
            <p class="mb-4 lead">Fale conosco e agende uma visita técnica para orçamento sem compromisso.</p>
            <a href="<?php echo BASEURL; ?>paginas/orcamento.php" class="btn btn-nanias-light btn-lg px-5 py-3 rounded-pill">
                <i class="fa-solid fa-file-invoice-dollar me-2"></i>Solicitar Orçamento
            </a>
        </div>
    </div>
</div>

<?php 
include(FOOTER_TEMPLATE);
?>
