<?php
require_once "../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();
include(HEADER_TEMPLATE);
?>

<div class="container py-5 fade-in">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h2 class="display-5 fw-bold section-title mb-4">Nosso Catálogo</h2>
            <p class="lead text-muted max-w-700 mx-auto">Explore nossos projetos de marcenaria sob medida. Cada peça é cuidadosamente planejada para aliar estética, funcionalidade e durabilidade ao seu ambiente.</p>
        </div>
    </div>

    <!-- Filtros do Catálogo (UI/UX) -->
    <div class="row mb-5 slide-up delay-1">
        <div class="col-12 d-flex justify-content-center flex-wrap gap-2">
            <button class="btn btn-nanias px-4 rounded-pill">Todos</button>
            <button class="btn btn-outline-nanias px-4 rounded-pill">Cozinhas</button>
            <button class="btn btn-outline-nanias px-4 rounded-pill">Dormitórios</button>
            <button class="btn btn-outline-nanias px-4 rounded-pill">Salas</button>
            <button class="btn btn-outline-nanias px-4 rounded-pill">Banheiros</button>
        </div>
    </div>

    <!-- Grid de Produtos -->
    <div class="row g-4 slide-up delay-2">
        <!-- Produto 1 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="product-img-wrapper" style="background-color: var(--fundo-creme); height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 12px 12px 0 0;">
                    <i class="fa-solid fa-kitchen-set fa-5x" style="color: var(--logo-claro);"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-2 text-dark">Cozinha Planejada Premium</h5>
                    <p class="text-muted mb-4 small">MDF Ultra com acabamento em laca fosca e puxadores em perfil de alumínio champagne.</p>
                    <div class="mt-auto">
                        <a href="https://wa.me/seunumerodewhatsapp?text=Olá, tenho interesse na Cozinha Planejada Premium" class="btn btn-outline-nanias w-100 rounded-pill" target="_blank">
                            <i class="fa-brands fa-whatsapp me-2"></i>Solicitar Orçamento
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produto 2 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="product-img-wrapper" style="background-color: #e8dbb4; height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 12px 12px 0 0;">
                    <i class="fa-solid fa-bed fa-5x" style="color: var(--logo-medio);"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-2 text-dark">Dormitório Casal Master</h5>
                    <p class="text-muted mb-4 small">Guarda-roupa com portas de correr em espelho bronze e painel ripado iluminado.</p>
                    <div class="mt-auto">
                        <a href="https://wa.me/seunumerodewhatsapp?text=Olá, tenho interesse no Dormitório Casal Master" class="btn btn-outline-nanias w-100 rounded-pill" target="_blank">
                            <i class="fa-brands fa-whatsapp me-2"></i>Solicitar Orçamento
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produto 3 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="product-img-wrapper" style="background-color: var(--fundo-creme); height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 12px 12px 0 0;">
                    <i class="fa-solid fa-tv fa-5x" style="color: var(--logo-claro);"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-2 text-dark">Home Theater Clean</h5>
                    <p class="text-muted mb-4 small">Painel em MDF amadeirado com rack suspenso em laca branca e fita LED embutida.</p>
                    <div class="mt-auto">
                        <a href="https://wa.me/seunumerodewhatsapp?text=Olá, tenho interesse no Home Theater Clean" class="btn btn-outline-nanias w-100 rounded-pill" target="_blank">
                            <i class="fa-brands fa-whatsapp me-2"></i>Solicitar Orçamento
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produto 4 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="product-img-wrapper" style="background-color: #e8dbb4; height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 12px 12px 0 0;">
                    <i class="fa-solid fa-bath fa-5x" style="color: var(--logo-medio);"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-2 text-dark">Gabinete de Banheiro Luxo</h5>
                    <p class="text-muted mb-4 small">MDF resistente à umidade, gavetões com corrediças ocultas e sistema fecho-toque.</p>
                    <div class="mt-auto">
                        <a href="https://wa.me/seunumerodewhatsapp?text=Olá, tenho interesse no Gabinete de Banheiro Luxo" class="btn btn-outline-nanias w-100 rounded-pill" target="_blank">
                            <i class="fa-brands fa-whatsapp me-2"></i>Solicitar Orçamento
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produto 5 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="product-img-wrapper" style="background-color: var(--fundo-creme); height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 12px 12px 0 0;">
                    <i class="fa-solid fa-couch fa-5x" style="color: var(--logo-claro);"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-2 text-dark">Painel Divisor de Ambientes</h5>
                    <p class="text-muted mb-4 small">Estrutura ripada vazada em freijó, ideal para integrar sala de jantar e estar com elegância.</p>
                    <div class="mt-auto">
                        <a href="https://wa.me/seunumerodewhatsapp?text=Olá, tenho interesse no Painel Divisor de Ambientes" class="btn btn-outline-nanias w-100 rounded-pill" target="_blank">
                            <i class="fa-brands fa-whatsapp me-2"></i>Solicitar Orçamento
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produto 6 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="product-img-wrapper" style="background-color: #e8dbb4; height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 12px 12px 0 0;">
                    <i class="fa-solid fa-briefcase fa-5x" style="color: var(--logo-medio);"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-2 text-dark">Escritório Home Office</h5>
                    <p class="text-muted mb-4 small">Mesa em L com gaveteiro volante e nichos suspensos para organização eficiente.</p>
                    <div class="mt-auto">
                        <a href="https://wa.me/seunumerodewhatsapp?text=Olá, tenho interesse no Escritório Home Office" class="btn btn-outline-nanias w-100 rounded-pill" target="_blank">
                            <i class="fa-brands fa-whatsapp me-2"></i>Solicitar Orçamento
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px;
}
.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}
.product-img-wrapper {
    position: relative;
    transition: background-color 0.3s ease;
}
.product-card:hover .product-img-wrapper {
    background-color: var(--verde-claro) !important;
}
.product-card:hover .product-img-wrapper i {
    color: var(--header-escuro) !important;
}
.max-w-700 {
    max-width: 700px;
}
</style>

<?php 
include(FOOTER_TEMPLATE);
?>