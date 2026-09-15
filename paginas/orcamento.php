<?php
require_once "../config.php";
require_once DBAPI;
require_once ABSPATH . "inc/auth.php";

$database = open_database();
$produto_id = isset($_GET['produto']) ? (int)$_GET['produto'] : null;
$produto_selecionado = null;

if ($produto_id && $database) {
    try {
        $stmt = $database->prepare("SELECT id, titulo, imagem_url FROM produtos WHERE id = :id AND ativo = 1");
        $stmt->execute([':id' => $produto_id]);
        $produto_selecionado = $stmt->fetch();
    } catch (PDOException $e) {
        error_log('Selected product query error: ' . $e->getMessage());
    }
}

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $nome = trim((string)($_POST['nome'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $telefone = trim((string)($_POST['telefone'] ?? ''));
    $mensagem = trim((string)($_POST['mensagem'] ?? ''));
    $postProdutoId = (int)($_POST['produto_id'] ?? 0);

    if ($nome === '' || mb_strlen($nome) > 100 || $telefone === '' || mb_strlen($telefone) > 30 ||
        $mensagem === '') {
        $erro = 'Preencha todos os campos obrigatórios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 100) {
        $erro = 'Informe um e-mail válido.';
    } elseif ($postProdutoId > 0) {
        if (!$database) {
            $erro = 'Não foi possível validar o produto.';
        } else {
            try {
                $productStmt = $database->prepare(
                    'SELECT id FROM produtos WHERE id = :id AND ativo = 1'
                );
                $productStmt->execute([':id' => $postProdutoId]);
                if (!$productStmt->fetch()) {
                    $erro = 'Produto inválido.';
                }
            } catch (PDOException $e) {
                error_log('Product validation error: ' . $e->getMessage());
                $erro = 'Não foi possível validar o produto.';
            }
        }
    }

    if ($erro === '') {
        $saved = save('orcamentos', [
            'cliente_nome' => $nome,
            'cliente_email' => $email,
            'telefone' => $telefone,
            'mensagem' => $mensagem,
            'produto_id' => $postProdutoId > 0 ? $postProdutoId : null
        ]);
        if ($saved) {
            unset($_SESSION['message'], $_SESSION['type']);
            $_SESSION['msg_sucesso'] = 'Orçamento solicitado com sucesso! Nossa equipe entrará em contato em breve.';
            close_database($database);
            header('Location: ' . BASEURL . 'paginas/orcamento.php');
            exit;
        }
        $erro = 'Não foi possível enviar a solicitação. Tente novamente mais tarde.';
    }
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
                    <i class="fa-solid fa-circle-check me-2"></i> <?php echo htmlspecialchars($_SESSION['msg_sucesso'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['msg_sucesso']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (!empty($erro)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5">
                    <form action="orcamento.php" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php if($produto_selecionado): ?>
                            <input type="hidden" name="produto_id" value="<?php echo (int)$produto_selecionado['id']; ?>">
                            <div class="alert alert-info d-flex align-items-center mb-4">
                                <?php if(!empty($produto_selecionado['imagem_url']) && local_image_exists($produto_selecionado['imagem_url'])): ?>
                                    <img src="<?php echo BASEURL . htmlspecialchars($produto_selecionado['imagem_url'], ENT_QUOTES, 'UTF-8'); ?>" alt="" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;" class="me-3">
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
                                <input type="text" class="form-control form-control-lg bg-light border-0" id="nome" name="nome" maxlength="100" value="<?php echo htmlspecialchars($_POST['nome'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">E-mail <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-lg bg-light border-0" id="email" name="email" maxlength="100" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label fw-bold">Telefone / WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg bg-light border-0" id="telefone" name="telefone" maxlength="30" value="<?php echo htmlspecialchars($_POST['telefone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label for="mensagem" class="form-label fw-bold">Detalhes do Projeto <span class="text-danger">*</span></label>
                                <textarea class="form-control form-control-lg bg-light border-0" id="mensagem" name="mensagem" rows="5" placeholder="Descreva as medidas, ambiente ou detalhes adicionais..." required><?php echo htmlspecialchars($_POST['mensagem'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
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
