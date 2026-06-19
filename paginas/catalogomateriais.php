<?php
require_once "../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();

$database = open_database();
$produtos = [];
$categorias = [];
if ($database) {
    $stmt_cat = $database->query("SELECT * FROM categorias WHERE tipo = 'materiais' ORDER BY nome ASC");
    if ($stmt_cat) $categorias = $stmt_cat->fetchAll();

    $stmt_prod = $database->query("SELECT p.*, c.nome as categoria_nome FROM produtos p JOIN categorias c ON p.categoria_id = c.id WHERE c.tipo = 'materiais' AND p.ativo = 1 ORDER BY p.id DESC");
    if ($stmt_prod) $produtos = $stmt_prod->fetchAll();
    
    close_database($database);
}

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
        <div class="col-12 d-flex justify-content-center flex-wrap gap-2" id="filter-buttons">
            <button class="btn btn-nanias px-4 rounded-pill filter-btn" data-filter="all">Todos</button>
            <?php foreach($categorias as $cat): ?>
                <button class="btn btn-outline-nanias px-4 rounded-pill filter-btn" data-filter="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nome']); ?></button>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Grid de Materiais -->
    <div class="row g-4 slide-up delay-2" id="product-grid">
        <?php if($produtos): foreach($produtos as $prod): ?>
        <div class="col-md-6 col-lg-4 product-item" data-category="<?php echo $prod['categoria_id']; ?>">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="product-img-wrapper" style="background-color: var(--fundo-creme); height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 12px 12px 0 0;">
                    <?php if(!empty($prod['imagem_url'])): ?>
                        <img src="<?php echo BASEURL . htmlspecialchars($prod['imagem_url']); ?>" alt="<?php echo htmlspecialchars($prod['titulo']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    <?php else: ?>
                        <i class="fa-solid fa-layer-group fa-5x" style="color: var(--logo-claro);"></i>
                    <?php endif; ?>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-2 text-dark"><?php echo htmlspecialchars($prod['titulo']); ?></h5>
                    <div class="mb-3">
                        <span class="badge" style="background-color: var(--verde-claro); color: var(--header-escuro);"><?php echo htmlspecialchars($prod['categoria_nome']); ?></span>
                    </div>
                    <p class="text-muted mb-4 small"><?php echo nl2br(htmlspecialchars($prod['descricao'])); ?></p>
                    <div class="mt-auto">
                        <a href="<?php echo BASEURL; ?>paginas/orcamento.php?produto=<?php echo $prod['id']; ?>" class="btn btn-outline-nanias w-100 rounded-pill">
                            <i class="fa-solid fa-file-invoice-dollar me-2"></i>Solicitar Informações
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; else: ?>
            <div class="col-12 text-center">
                <p class="text-muted">Nenhum material cadastrado no momento.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const productItems = document.querySelectorAll('.product-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active button classes
            filterBtns.forEach(b => {
                b.classList.remove('btn-nanias');
                b.classList.add('btn-outline-nanias');
            });
            this.classList.remove('btn-outline-nanias');
            this.classList.add('btn-nanias');

            const filterValue = this.getAttribute('data-filter');

            productItems.forEach(item => {
                if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>

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