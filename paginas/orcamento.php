<?php
require_once "../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();

$database = open_database();
$produto_id = isset($_GET['produto']) ? (int)$_GET['produto'] : null;
$produto_selecionado = null;

if ($produto_id) {
    try {
        $stmt = $database->prepare("SELECT id, titulo, imagem_url FROM produtos WHERE id = :id");
        $stmt->execute([':id' => $produto_id]);
        $produto_selecionado = $stmt->fetch();
    } catch (PDOException $e) {}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orcamento = [
        'cliente_nome' => $_POST['nome'],
        'cliente_email' => $_POST['email'],
        'telefone' => $_POST['telefone'],
        'mensagem' => $_POST['mensagem'],
        'produto_id' => !empty($_POST['produto_id']) ? $_POST['produto_id'] : null
    ];
    
    save('orcamentos', $orcamento);
    $_SESSION['msg_sucesso'] = "Orçamento solicitado com sucesso! Nossa equipe entrará em contato em breve.";
    header("Location: " . BASEURL . "paginas/orcamento.php");
    exit;
}
close_database($database);

include(HEADER_TEMPLATE);
?>

<div class="container py-5 fade-in">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="display-6 fw-bold section-title mb-4 text-center">Solicitar Orçamento</h2>
            <p class="text-center text-muted mb-5">Preencha os dados abaixo e retornaremos com uma estimativa para o seu projeto.</p>
            
            <?php if(isset($_SESSION['msg_sucesso'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> <?php echo $_SESSION['msg_sucesso']; unset($_SESSION['msg_sucesso']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5">
                    <form action="orcamento.php" method="POST">
                        <?php if($produto_selecionado): ?>
                            <input type="hidden" name="produto_id" value="<?php echo $produto_selecionado['id']; ?>">
                            <div class="alert alert-info d-flex align-items-center mb-4">
                                <?php if($produto_selecionado['imagem_url']): ?>
                                    <img src="<?php echo BASEURL . $produto_selecionado['imagem_url']; ?>" alt="" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;" class="me-3">
                                <?php else: ?>
                                    <div class="rounded-3 me-3" style="width: 60px; height: 60px; background-color: var(--fundo-creme); display: flex; align-items: center; justify-content: center;">
                                        <i class="fa-solid fa-couch" style="color: var(--logo-claro);"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <h6 class="mb-1 fw-bold">Produto de Interesse:</h6>
                                    <p class="mb-0 text-dark"><?php echo htmlspecialchars($produto_selecionado['titulo']); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-md-12 mb-3">
                                <label for="nome" class="form-label fw-bold">Nome Completo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg bg-light border-0" id="nome" name="nome" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">E-mail <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-lg bg-light border-0" id="email" name="email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label fw-bold">Telefone / WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg bg-light border-0" id="telefone" name="telefone" required>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label for="mensagem" class="form-label fw-bold">Detalhes do Projeto <span class="text-danger">*</span></label>
                                <textarea class="form-control form-control-lg bg-light border-0" id="mensagem" name="mensagem" rows="5" placeholder="Descreva as medidas, ambiente ou detalhes adicionais..." required></textarea>
                            </div>
                            <div class="col-12 d-grid">
                                <button type="submit" class="btn btn-nanias btn-lg rounded-pill">
                                    <i class="fa-solid fa-paper-plane me-2"></i> Enviar Solicitação
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(FOOTER_TEMPLATE); ?>
