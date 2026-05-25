<?php
require_once "../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();
include(HEADER_TEMPLATE);
?>

<div class="container py-5 fade-in">
    <!-- Header Dúvidas -->
    <div class="row mb-5 text-center">
        <div class="col-12">
            <h2 class="display-5 fw-bold section-title mb-4">Dúvidas Frequentes</h2>
            <p class="lead text-muted mx-auto" style="max-width: 800px;">
                Reunimos aqui as perguntas mais comuns dos nossos clientes. Se a sua dúvida não estiver listada, entre em contato conosco pelo WhatsApp ou pela página de Suporte.
            </p>
        </div>
    </div>

    <!-- Accordion FAQ -->
    <div class="row justify-content-center slide-up delay-1">
        <div class="col-lg-9">
            <div class="accordion" id="faqAccordion">

                <!-- Pergunta 1 -->
                <div class="accordion-item faq-item">
                    <h3 class="accordion-header" id="faq1-head">
                        <button class="accordion-button faq-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                            <i class="fa-solid fa-circle-question me-2 faq-icon"></i>
                            Quais tipos de móveis a Marcenaria Nanias produz?
                        </button>
                    </h3>
                    <div id="faq1" class="accordion-collapse collapse show" aria-labelledby="faq1-head" data-bs-parent="#faqAccordion">
                        <div class="accordion-body faq-body">
                            Trabalhamos com móveis planejados sob medida para todos os ambientes: cozinhas, dormitórios, salas de estar, banheiros, home offices, áreas gourmet, closets e muito mais. Cada projeto é desenvolvido de acordo com as necessidades e o espaço do cliente.
                        </div>
                    </div>
                </div>

                <!-- Pergunta 2 -->
                <div class="accordion-item faq-item">
                    <h3 class="accordion-header" id="faq2-head">
                        <button class="accordion-button collapsed faq-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                            <i class="fa-solid fa-circle-question me-2 faq-icon"></i>
                            Quais materiais são utilizados na fabricação?
                        </button>
                    </h3>
                    <div id="faq2" class="accordion-collapse collapse" aria-labelledby="faq2-head" data-bs-parent="#faqAccordion">
                        <div class="accordion-body faq-body">
                            Utilizamos MDF de alta densidade, MDF Ultra resistente à umidade (para cozinhas e banheiros), laminados melamínicos, laca fosca e brilhante, além de ferragens premium com corrediças telescópicas, dobradiças com amortecimento e puxadores em alumínio. Todos os materiais são de fornecedores certificados.
                        </div>
                    </div>
                </div>

                <!-- Pergunta 3 -->
                <div class="accordion-item faq-item">
                    <h3 class="accordion-header" id="faq3-head">
                        <button class="accordion-button collapsed faq-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                            <i class="fa-solid fa-circle-question me-2 faq-icon"></i>
                            Como funciona o processo de orçamento?
                        </button>
                    </h3>
                    <div id="faq3" class="accordion-collapse collapse" aria-labelledby="faq3-head" data-bs-parent="#faqAccordion">
                        <div class="accordion-body faq-body">
                            O processo é simples: você entra em contato conosco pelo WhatsApp ou pelo formulário na página de Suporte, informando o que precisa. Agendamos uma visita técnica gratuita para tirar medidas e entender suas necessidades. Em seguida, enviamos o projeto detalhado com o orçamento, tudo sem compromisso.
                        </div>
                    </div>
                </div>

                <!-- Pergunta 4 -->
                <div class="accordion-item faq-item">
                    <h3 class="accordion-header" id="faq4-head">
                        <button class="accordion-button collapsed faq-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                            <i class="fa-solid fa-circle-question me-2 faq-icon"></i>
                            Qual é o prazo médio de entrega?
                        </button>
                    </h3>
                    <div id="faq4" class="accordion-collapse collapse" aria-labelledby="faq4-head" data-bs-parent="#faqAccordion">
                        <div class="accordion-body faq-body">
                            O prazo varia conforme a complexidade e o tamanho do projeto. Em média, projetos menores (como painéis e gabinetes) levam de 15 a 20 dias úteis, enquanto projetos maiores (como cozinhas completas e dormitórios) podem levar de 30 a 45 dias úteis. O prazo exato é informado junto ao orçamento.
                        </div>
                    </div>
                </div>

                <!-- Pergunta 5 -->
                <div class="accordion-item faq-item">
                    <h3 class="accordion-header" id="faq5-head">
                        <button class="accordion-button collapsed faq-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq5" aria-expanded="false" aria-controls="faq5">
                            <i class="fa-solid fa-circle-question me-2 faq-icon"></i>
                            A Marcenaria Nanias oferece garantia?
                        </button>
                    </h3>
                    <div id="faq5" class="accordion-collapse collapse" aria-labelledby="faq5-head" data-bs-parent="#faqAccordion">
                        <div class="accordion-body faq-body">
                            Sim! Todos os nossos móveis possuem garantia contra defeitos de fabricação. A garantia cobre problemas como empenamento de chapas, descolamento de bordas e falhas nas ferragens, desde que o móvel seja utilizado de acordo com as recomendações de uso e manutenção que fornecemos na entrega.
                        </div>
                    </div>
                </div>

                <!-- Pergunta 6 -->
                <div class="accordion-item faq-item">
                    <h3 class="accordion-header" id="faq6-head">
                        <button class="accordion-button collapsed faq-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq6" aria-expanded="false" aria-controls="faq6">
                            <i class="fa-solid fa-circle-question me-2 faq-icon"></i>
                            Vocês atendem em quais regiões?
                        </button>
                    </h3>
                    <div id="faq6" class="accordion-collapse collapse" aria-labelledby="faq6-head" data-bs-parent="#faqAccordion">
                        <div class="accordion-body faq-body">
                            Atendemos em toda a região metropolitana. Para localidades mais distantes, consulte a disponibilidade e o valor do frete diretamente pelo nosso WhatsApp. Fazemos questão de atender com a mesma qualidade independente da localização.
                        </div>
                    </div>
                </div>

                <!-- Pergunta 7 -->
                <div class="accordion-item faq-item">
                    <h3 class="accordion-header" id="faq7-head">
                        <button class="accordion-button collapsed faq-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq7" aria-expanded="false" aria-controls="faq7">
                            <i class="fa-solid fa-circle-question me-2 faq-icon"></i>
                            Quais formas de pagamento são aceitas?
                        </button>
                    </h3>
                    <div id="faq7" class="accordion-collapse collapse" aria-labelledby="faq7-head" data-bs-parent="#faqAccordion">
                        <div class="accordion-body faq-body">
                            Aceitamos pagamento via PIX, transferência bancária e dinheiro. As condições de pagamento podem ser combinadas diretamente com a equipe, com possibilidade de parcelamento conforme o valor do projeto. Consulte as condições ao solicitar seu orçamento.
                        </div>
                    </div>
                </div>

                <!-- Pergunta 8 -->
                <div class="accordion-item faq-item">
                    <h3 class="accordion-header" id="faq8-head">
                        <button class="accordion-button collapsed faq-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq8" aria-expanded="false" aria-controls="faq8">
                            <i class="fa-solid fa-circle-question me-2 faq-icon"></i>
                            A montagem está inclusa no preço?
                        </button>
                    </h3>
                    <div id="faq8" class="accordion-collapse collapse" aria-labelledby="faq8-head" data-bs-parent="#faqAccordion">
                        <div class="accordion-body faq-body">
                            Sim! O valor do orçamento já inclui a entrega e a montagem completa no local. Nossa equipe de montadores profissionais cuida de toda a instalação, garantindo que o móvel fique perfeito e alinhado. Não há custos adicionais surpresa.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="row mt-5 slide-up delay-2">
        <div class="col-12 text-center">
            <div class="cta-section py-5" style="border-radius: 16px;">
                <h3 class="fw-bold text-white mb-3">Não encontrou sua dúvida?</h3>
                <p class="text-white-50 mb-4 lead">Fale diretamente com nossa equipe. Estamos prontos para ajudar!</p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="<?php echo BASEURL; ?>paginas/suporte.php" class="btn btn-nanias-light btn-lg px-5 py-3 rounded-pill">
                        <i class="fa-solid fa-envelope me-2"></i>Enviar Mensagem
                    </a>
                    <a href="https://wa.me/seunumerodewhatsapp" class="btn btn-nanias-light btn-lg px-5 py-3 rounded-pill" target="_blank">
                        <i class="fa-brands fa-whatsapp me-2"></i>WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* FAQ Accordion Custom Styles */
.faq-item {
    border: none !important;
    margin-bottom: 12px;
    border-radius: 12px !important;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.faq-button {
    background-color: #ffffff !important;
    color: #222 !important;
    font-weight: 600;
    font-size: 1rem;
    padding: 18px 24px;
    border: none;
    box-shadow: none !important;
}

.faq-button:not(.collapsed) {
    background-color: var(--header-escuro) !important;
    color: var(--fundo-creme) !important;
}

.faq-button:not(.collapsed) .faq-icon {
    color: var(--verde-claro) !important;
}

.faq-button::after {
    filter: none;
}

.faq-button:not(.collapsed)::after {
    filter: brightness(10);
}

.faq-icon {
    color: var(--logo-medio);
    font-size: 1.1rem;
}

.faq-body {
    background-color: #ffffff;
    color: #555;
    line-height: 1.8;
    padding: 20px 24px;
    border-top: 2px solid var(--verde-claro);
}

/* Dark mode FAQ */
body.dark-mode .faq-button {
    background-color: #2a2a2a !important;
    color: #e0d6c2 !important;
}

body.dark-mode .faq-button:not(.collapsed) {
    background-color: var(--header-escuro) !important;
    color: #e0d6c2 !important;
}

body.dark-mode .faq-body {
    background-color: #2a2a2a;
    color: #b0a890;
}

body.dark-mode .faq-item {
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}
</style>

<?php
include(FOOTER_TEMPLATE);
?>
