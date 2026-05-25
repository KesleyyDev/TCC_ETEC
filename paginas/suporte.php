<?php
require_once "../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();
include(HEADER_TEMPLATE);

// Exemplo de inclusão de função conforme solicitado pelo usuário
require_once ABSPATH . "inc/functions.php";
// gerar_csv_contatos(); // Esta função seria chamada aqui no painel administrativo, por enquanto apenas referenciada.
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
                    <div>
                        <h6 class="mb-0 text-white-50">WhatsApp / Telefone</h6>
                        <p class="mb-0 fw-bold">(11) 99999-9999</p>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box-small me-3">
                        <i class="fa-solid fa-envelope fa-xl"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-white-50">E-mail</h6>
                        <p class="mb-0 fw-bold">contato@marcenariananias.com.br</p>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-5">
                    <div class="icon-box-small me-3">
                        <i class="fa-solid fa-location-dot fa-xl"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-white-50">Endereço</h6>
                        <p class="mb-0 fw-bold">Rua da Marcenaria, 123 - São Paulo, SP</p>
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
                <form action="#" method="post">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nome" class="form-label text-muted">Nome Completo</label>
                            <input type="text" class="form-control custom-input" id="nome" placeholder="Seu nome" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label text-muted">E-mail</label>
                            <input type="email" class="form-control custom-input" id="email" placeholder="seu@email.com" required>
                        </div>
                        <div class="col-12">
                            <label for="assunto" class="form-label text-muted">Assunto</label>
                            <select class="form-select custom-input" id="assunto" required>
                                <option value="" selected disabled>Escolha um assunto...</option>
                                <option value="orcamento">Solicitar Orçamento</option>
                                <option value="duvida">Dúvida Técnica</option>
                                <option value="elogio">Elogio / Sugestão</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="mensagem" class="form-label text-muted">Mensagem</label>
                            <textarea class="form-control custom-input" id="mensagem" rows="5" placeholder="Como podemos ajudar?" required></textarea>
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