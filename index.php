<?php
require_once "config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();
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
            <div class="d-flex justify-content-center gap-3">
                <a href="<?php echo BASEURL; ?>paginas/catalogomoveis.php" class="btn btn-nanias btn-lg px-5 py-3 rounded-pill">
                    <i class="fa-solid fa-book-open me-2"></i>Ver Catálogo
                </a>
                <a href="https://wa.me/seunumerodewhatsapp" class="btn btn-outline-nanias btn-lg px-5 py-3 rounded-pill" target="_blank">
                    <i class="fa-brands fa-whatsapp me-2"></i>Orçamento via WhatsApp
                </a>
            </div>
        </div>
    </div>

    <div class="container py-5 slide-up">
        <div class="row text-center mb-5 mt-4">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold mb-3 section-title">Por que escolher a Marcenaria Nanias?</h2>
                <p class="text-muted">Nossa prioridade é a sua satisfação. Trabalhamos com materiais de alta qualidade para garantir durabilidade e beleza.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm feature-card">
                    <div class="card-body text-center p-5">
                        <div class="icon-box mb-4 mx-auto">
                            <i class="fa-solid fa-ruler-combined fa-2x"></i>
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
                            <i class="fa-solid fa-leaf fa-2x"></i>
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
                            <i class="fa-solid fa-truck-fast fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Entrega no Prazo</h4>
                        <p class="text-muted mb-0">Compromisso com o cronograma. Seu projeto entregue e montado na data combinada.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cta-section text-center py-5 mt-5 fade-in">
        <div class="container py-4">
            <h2 class="fw-bold mb-3 text-white">Pronto para realizar seu projeto?</h2>
            <p class="mb-4 text-white-50 lead">Fale conosco e agende uma visita técnica para orçamento sem compromisso.</p>
            <a href="https://wa.me/seunumerodewhatsapp" class="btn btn-nanias-light btn-lg px-5 py-3 rounded-pill" target="_blank">
                <i class="fa-brands fa-whatsapp me-2"></i>Falar com Especialista
            </a>
        </div>
    </div>
</div>

<?php 
include(FOOTER_TEMPLATE);
?>