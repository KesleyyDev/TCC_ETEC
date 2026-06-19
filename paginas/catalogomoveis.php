<?php
require_once "../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();

$database = open_database();
$produtos = [];
$categorias = [];
$categoria_filtro = isset($_GET['cat']) ? (int)$_GET['cat'] : null;

if ($database) {
    try {
        $stmt_cat = $database->query("SELECT * FROM categorias WHERE tipo = 'moveis' ORDER BY nome ASC");
        if ($stmt_cat) $categorias = $stmt_cat->fetchAll();

        $sql = "SELECT p.*, c.nome as categoria_nome FROM produtos p LEFT JOIN categorias c ON p.categoria_id = c.id WHERE p.ativo = 1 AND c.tipo = 'moveis'";
        if ($categoria_filtro) {
            $sql .= " AND p.categoria_id = :categoria_id";
        }
        $sql .= " ORDER BY p.id DESC";

        $stmt = $database->prepare($sql);
        if ($categoria_filtro) {
            $stmt->execute([':categoria_id' => $categoria_filtro]);
        } else {
            $stmt->execute();
        }
        $produtos = $stmt->fetchAll();

        // Buscar imagens da galeria para todos os produtos
        $galerias = [];
        $stmt_img = $database->query("SELECT produto_id, imagem_url FROM imagens_produto");
        if($stmt_img) {
            $imagens = $stmt_img->fetchAll();
            foreach($imagens as $img) {
                $galerias[$img['produto_id']][] = $img['imagem_url'];
            }
        }
    } catch (PDOException $e) {
        die("Erro ao buscar dados: " . $e->getMessage());
    }
    close_database($database);
}

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
        <div class="col-12 d-flex justify-content-center flex-wrap gap-2" id="filter-buttons">
            <a href="catalogo.php" class="btn <?php echo !$categoria_filtro ? 'btn-nanias' : 'btn-outline-nanias'; ?> px-4 rounded-pill">Todos</a>
            <?php foreach($categorias as $cat): ?>
                <a href="catalogo.php?cat=<?php echo $cat['id']; ?>" class="btn <?php echo ($categoria_filtro == $cat['id']) ? 'btn-nanias' : 'btn-outline-nanias'; ?> px-4 rounded-pill"><?php echo htmlspecialchars($cat['nome']); ?></a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Grid de Produtos -->
    <div class="row g-4 slide-up delay-2" id="product-grid">
        <?php if($produtos): foreach($produtos as $prod): 
            $imagens_carrossel = [];
            if (!empty($prod['imagem_url'])) $imagens_carrossel[] = $prod['imagem_url'];
            if (isset($galerias[$prod['id']])) {
                $imagens_carrossel = array_merge($imagens_carrossel, $galerias[$prod['id']]);
            }
            $carrossel_id = "carousel_prod_" . $prod['id'];
        ?>
        <div class="col-md-6 col-lg-4 product-item" data-category="<?php echo $prod['categoria_id']; ?>">
            <div class="card h-100 border-0 shadow-sm product-card">
                <div class="product-img-wrapper" style="background-color: var(--fundo-creme); height: 250px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 12px 12px 0 0;">
                    <?php if(count($imagens_carrossel) > 1): ?>
                        <div id="<?php echo $carrossel_id; ?>" class="carousel slide" data-bs-ride="carousel" style="width: 100%; height: 100%;">
                            <div class="carousel-inner" style="height: 100%;">
                                <?php foreach($imagens_carrossel as $index => $img_url): ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>" style="height: 100%;">
                                    <img src="<?php echo BASEURL . htmlspecialchars($img_url); ?>" class="d-block w-100" style="height: 100%; object-fit: cover;" alt="<?php echo htmlspecialchars($prod['titulo']); ?>">
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $carrossel_id; ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $carrossel_id; ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        </div>
                    <?php elseif(!empty($prod['imagem_url'])): ?>
                        <img src="<?php echo BASEURL . htmlspecialchars($prod['imagem_url']); ?>" alt="<?php echo htmlspecialchars($prod['titulo']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    <?php else: ?>
                        <i class="fa-solid fa-couch fa-5x" style="color: var(--logo-claro);"></i>
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
                            <i class="fa-solid fa-file-invoice-dollar me-2"></i>Solicitar Orçamento
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; else: ?>
            <div class="col-12 text-center">
                <p class="text-muted">Nenhum móvel cadastrado no momento.</p>
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