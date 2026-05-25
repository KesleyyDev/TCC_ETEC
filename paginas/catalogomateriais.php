<?php
require_once "../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();
include(HEADER_TEMPLATE);
?>

<div class="container py-5 fade-in">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h2 class="display-5 fw-bold section-title mb-4">Catálogo de Materiais</h2>
            <p class="lead text-muted max-w-700 mx-auto">Conheça os materiais que utilizamos em nossos projetos. Cada tipo de madeira e acabamento é selecionado com rigor para garantir durabilidade, beleza e funcionalidade ao seu ambiente.</p>
        </div>
    </div>

    <!-- Filtros do Catálogo (UI/UX) -->
    <div class="row mb-5 slide-up delay-1">
        <div class="col-12 d-flex justify-content-center flex-wrap gap-2">
            <button class="btn btn-nanias px-4 rounded-pill">Todos</button>
            <button class="btn btn-outline-nanias px-4 rounded-pill">MDF</button>
            <button class="btn btn-outline-nanias px-4 rounded-pill">MDP</button>
            <button class="btn btn-outline-nanias px-4 rounded-pill">Compensados</button>
            <button class="btn btn-outline-nanias px-4 rounded-pill">Madeira Maciça</button>
        </div>
    </div>

    <!-- Grid de Materiais -->
    <div class="row g-4 slide-up delay-2">
        <!-- Material 1 - MDF -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="product-img-wrapper" style="background-color: var(--fundo-creme); height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 12px 12px 0 0;">
                    <i class="fa-solid fa-layer-group fa-5x" style="color: var(--logo-claro);"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-2 text-dark">MDF (Medium Density Fiberboard)</h5>
                    <p class="text-muted mb-4 small">Placa de fibra de média densidade, ideal para móveis planejados. Superfície uniforme que permite acabamentos em laca, pintura e revestimentos melamínicos de alta qualidade.</p>
                    <div class="mt-auto">
                        <a href="https://wa.me/seunumerodewhatsapp?text=Olá, tenho interesse em saber mais sobre o material MDF" class="btn btn-outline-nanias w-100 rounded-pill" target="_blank">
                            <i class="fa-brands fa-whatsapp me-2"></i>Solicitar Informações
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Material 2 - MDP -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="product-img-wrapper" style="background-color: #e8dbb4; height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 12px 12px 0 0;">
                    <i class="fa-solid fa-cubes fa-5x" style="color: var(--logo-medio);"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-2 text-dark">MDP (Medium Density Particleboard)</h5>
                    <p class="text-muted mb-4 small">Placa de partículas de média densidade, amplamente utilizada em móveis residenciais. Excelente custo-benefício com boa resistência estrutural para prateleiras e corpos de armário.</p>
                    <div class="mt-auto">
                        <a href="https://wa.me/seunumerodewhatsapp?text=Olá, tenho interesse em saber mais sobre o material MDP" class="btn btn-outline-nanias w-100 rounded-pill" target="_blank">
                            <i class="fa-brands fa-whatsapp me-2"></i>Solicitar Informações
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Material 3 - Compensado -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="product-img-wrapper" style="background-color: var(--fundo-creme); height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 12px 12px 0 0;">
                    <i class="fa-solid fa-layer-group fa-5x fa-flip-horizontal" style="color: var(--logo-claro);"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-2 text-dark">Compensado Naval</h5>
                    <p class="text-muted mb-4 small">Formado por múltiplas camadas de madeira prensada com resinas especiais. Alta resistência à umidade, perfeito para áreas externas, banheiros e cozinhas que exigem maior durabilidade.</p>
                    <div class="mt-auto">
                        <a href="https://wa.me/seunumerodewhatsapp?text=Olá, tenho interesse em saber mais sobre o material Compensado Naval" class="btn btn-outline-nanias w-100 rounded-pill" target="_blank">
                            <i class="fa-brands fa-whatsapp me-2"></i>Solicitar Informações
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Material 4 - Madeira Maciça -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="product-img-wrapper" style="background-color: #e8dbb4; height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 12px 12px 0 0;">
                    <i class="fa-solid fa-tree fa-5x" style="color: var(--logo-medio);"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-2 text-dark">Madeira Maciça (Freijó / Pinus)</h5>
                    <p class="text-muted mb-4 small">Madeira nobre de reflorestamento, com veios naturais e toque aconchegante. Ideal para peças decorativas, ripados, painéis e móveis rústicos que valorizam a beleza natural da madeira.</p>
                    <div class="mt-auto">
                        <a href="https://wa.me/seunumerodewhatsapp?text=Olá, tenho interesse em saber mais sobre Madeira Maciça" class="btn btn-outline-nanias w-100 rounded-pill" target="_blank">
                            <i class="fa-brands fa-whatsapp me-2"></i>Solicitar Informações
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Material 5 - Laminado Melamínico -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="product-img-wrapper" style="background-color: var(--fundo-creme); height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 12px 12px 0 0;">
                    <i class="fa-solid fa-swatchbook fa-5x" style="color: var(--logo-claro);"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-2 text-dark">Laminado Melamínico</h5>
                    <p class="text-muted mb-4 small">Revestimento de alta resistência aplicado sobre placas de MDF e MDP. Disponível em centenas de cores, texturas e acabamentos — desde madeirados naturais até tons lisos contemporâneos.</p>
                    <div class="mt-auto">
                        <a href="https://wa.me/seunumerodewhatsapp?text=Olá, tenho interesse em saber mais sobre Laminado Melamínico" class="btn btn-outline-nanias w-100 rounded-pill" target="_blank">
                            <i class="fa-brands fa-whatsapp me-2"></i>Solicitar Informações
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Material 6 - Laca / Acabamento -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="product-img-wrapper" style="background-color: #e8dbb4; height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 12px 12px 0 0;">
                    <i class="fa-solid fa-fill-drip fa-5x" style="color: var(--logo-medio);"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-2 text-dark">Acabamento em Laca</h5>
                    <p class="text-muted mb-4 small">Pintura especial em laca brilho ou fosca aplicada sobre MDF. Proporciona superfície lisa e sofisticada com alta durabilidade. Disponível em qualquer cor do catálogo RAL ou NCS.</p>
                    <div class="mt-auto">
                        <a href="https://wa.me/seunumerodewhatsapp?text=Olá, tenho interesse em saber mais sobre Acabamento em Laca" class="btn btn-outline-nanias w-100 rounded-pill" target="_blank">
                            <i class="fa-brands fa-whatsapp me-2"></i>Solicitar Informações
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