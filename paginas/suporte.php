<?php
require_once "../config.php";
require_once DBAPI;
require_once ABSPATH . "inc/auth.php";

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $nome = trim((string)($_POST['nome'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $assunto = (string)($_POST['assunto'] ?? '');
    $mensagem = trim((string)($_POST['mensagem'] ?? ''));
    $allowedSubjects = ['orcamento', 'duvida', 'elogio'];

    if ($nome === '' || mb_strlen($nome) > 100 || $mensagem === '') {
        $erro = 'Preencha seu nome e sua mensagem.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 100) {
        $erro = 'Informe um e-mail válido.';
    } elseif (!in_array($assunto, $allowedSubjects, true)) {
        $erro = 'Selecione um assunto válido.';
    } else {
        $saved = save('mensagens_contato', [
            'nome' => $nome,
            'email' => $email,
            'assunto' => $assunto,
            'mensagem' => $mensagem
        ]);
        if ($saved) {
            unset($_SESSION['message'], $_SESSION['type']);
            $_SESSION['msg_sucesso'] = 'Mensagem enviada com sucesso! Retornaremos em breve.';
            header('Location: ' . BASEURL . 'paginas/suporte.php');
            exit;
        }
        $erro = 'Não foi possível enviar a mensagem. Tente novamente mais tarde.';
    }
}

include(HEADER_TEMPLATE);
?>

<div class="container py-5 fade-in">
    <div class="row mb-5 text-center">
        <div class="col-12">
            <h2 class="display-5 fw-bold section-title mb-4">Suporte & Contato</h2>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                Precisa de ajuda, quer solicitar um orçamento ou tem alguma dúvida? Preencha o formulário abaixo ou fale conosco diretamente pelo WhatsApp.
            </p>
        </div>
    </div>

    <div class="row g-5 align-items-center slide-up delay-1">
        <!-- Informações de Contato -->
        <div class="col-lg-5">
            <div class="p-5 rounded-4 shadow-sm h-100" style="background-color: var(--header-escuro); color: var(--fundo-creme);">
                <h3 class="fw-bold mb-4 text-white">Fale Conosco</h3>
                
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box-small me-3">
                        <i class="fa-brands fa-whatsapp fa-xl"></i>
                    </div>
                    <div style="min-width: 0; flex: 1;">
                        <h6 class="mb-0 text-white-50">WhatsApp / Telefone</h6>
                        <p class="mb-0 fw-bold text-break">(11) 99999-9999</p>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box-small me-3">
                        <i class="fa-solid fa-envelope fa-xl"></i>
                    </div>
                    <div style="min-width: 0; flex: 1;">
                        <h6 class="mb-0 text-white-50">E-mail</h6>
                        <p class="mb-0 fw-bold text-break">contato@marcenariananias.com.br</p>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-5">
                    <div class="icon-box-small me-3">
                        <i class="fa-solid fa-location-dot fa-xl"></i>
                    </div>
                    <div style="min-width: 0; flex: 1;">
                        <h6 class="mb-0 text-white-50">Endereço</h6>
                        <p class="mb-0 fw-bold text-break">Rua da Marcenaria, 123 - São Paulo, SP</p>
                    </div>
                </div>

                <hr class="border-light opacity-25 mb-4">
                
                <h6 class="text-white mb-3">Redes Sociais</h6>
                <div class="d-flex gap-3">
                    <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fa-brands fa-facebook-f"></i></a>
                </div>
            </div>
        </div>

        <!-- Formulário de Contato -->
        <div class="col-lg-7">
            <div class="bg-white p-5 rounded-4 shadow-sm form-wrapper">
                <h4 class="fw-bold mb-4" style="color: var(--botao-escuro);">Envie uma Mensagem</h4>
                <?php if (!empty($_SESSION['msg_sucesso'])): ?>
                    <div class="alert alert-success">
                        <?php echo htmlspecialchars($_SESSION['msg_sucesso'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['msg_sucesso']); ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($erro)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>
                <form action="<?php echo BASEURL; ?>paginas/suporte.php" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nome" class="form-label text-muted">Nome Completo</label>
                            <input type="text" class="form-control custom-input" id="nome" name="nome" maxlength="100" placeholder="Seu nome" value="<?php echo htmlspecialchars($_POST['nome'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label text-muted">E-mail</label>
                            <input type="email" class="form-control custom-input" id="email" name="email" maxlength="100" placeholder="seu@email.com" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="col-12">
                            <label for="assunto" class="form-label text-muted">Assunto</label>
                            <select class="form-select custom-input" id="assunto" name="assunto" required>
                                <option value="" selected disabled>Escolha um assunto...</option>
                                <option value="orcamento" <?php echo (($_POST['assunto'] ?? '') === 'orcamento') ? 'selected' : ''; ?>>Solicitar Orçamento</option>
                                <option value="duvida" <?php echo (($_POST['assunto'] ?? '') === 'duvida') ? 'selected' : ''; ?>>Dúvida Técnica</option>
                                <option value="elogio" <?php echo (($_POST['assunto'] ?? '') === 'elogio') ? 'selected' : ''; ?>>Elogio / Sugestão</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="mensagem" class="form-label text-muted">Mensagem</label>
                            <textarea class="form-control custom-input" id="mensagem" name="mensagem" rows="5" placeholder="Como podemos ajudar?" required><?php echo htmlspecialchars($_POST['mensagem'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-nanias btn-lg w-100 rounded-pill">
                                <i class="fa-solid fa-paper-plane me-2"></i>Enviar Mensagem
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.icon-box-small {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--verde-claro);
    flex-shrink: 0;
}
.social-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    flex-shrink: 0;
}
.social-icon:hover {
    background-color: var(--logo-claro);
    color: white;
    transform: translateY(-3px);
}
.custom-input {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}
.custom-input:focus {
    background-color: #fff;
    border-color: var(--logo-claro);
    box-shadow: 0 0 0 0.25rem rgba(166, 138, 100, 0.25);
}
.form-wrapper {
    border: 1px solid rgba(0,0,0,0.05);
}
</style>

<?php 
include(FOOTER_TEMPLATE);
?>
