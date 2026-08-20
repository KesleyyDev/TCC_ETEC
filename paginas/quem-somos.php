<?php
require_once "../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();
include(HEADER_TEMPLATE);
?>

<div class="container py-5 fade-in">
    <!-- Header Quem Somos -->
    <div class="row mb-5 text-center">
        <div class="col-12">
            <h2 class="display-5 fw-bold section-title mb-4">Quem Somos</h2>
            <p class="lead text-muted mx-auto" style="max-width: 800px;">
                Conheça a história, a missão e os valores da Marcenaria Nanias. Tradição familiar aliada à tecnologia e design de ponta.
            </p>
        </div>
    </div>

    <!-- Seção História (Imagem + Texto) -->
    <div class="row align-items-center mb-5 slide-up delay-1">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="about-image-wrapper p-4 bg-white rounded-4 shadow-sm text-center" style="border: 2px dashed var(--logo-claro);">
                <i class="fa-solid fa-tree fa-10x" style="color: var(--verde-oliva); opacity: 0.8;"></i>
            </div>
        </div>
        <div class="col-lg-6">
            <h3 class="fw-bold mb-3" style="color: var(--botao-escuro);">Nossa História</h3>
            <p class="text-muted" style="line-height: 1.8;">
                Fundada com a paixão pela arte de trabalhar com a madeira, a Marcenaria Nanias começou como um pequeno negócio familiar. Ao longo dos anos, aperfeiçoamos nossas técnicas, investimos em tecnologia de ponta e expandimos nossa capacidade produtiva sem perder a essência do trabalho artesanal e o cuidado com cada detalhe.
            </p>
            <p class="text-muted" style="line-height: 1.8;">
                Hoje, somos referência na produção de móveis planejados, transformando os sonhos de nossos clientes em ambientes práticos, aconchegantes e sofisticados.
            </p>
        </div>
    </div>

    <!-- Timeline de Evolução -->
    <div class="row mb-5 slide-up delay-2">
        <div class="col-12 text-center mb-4">
            <h3 class="fw-bold section-title">Nossa Trajetória</h3>
        </div>
        <div class="col-lg-8 mx-auto">
            <div class="timeline">
                <div class="timeline-item timeline-animate">
                    <h5>O Início</h5>
                    <p>A Marcenaria Nas nasceu de um sonho familiar: transformar madeira em arte funcional. Com poucas ferramentas, mas muita dedicação, começamos a atender os primeiros clientes da vizinhança, criando peças sob encomenda na garagem de casa.</p>
                </div>
                <div class="timeline-item timeline-animate">
                    <h5>Crescimento e Estruturação</h5>
                    <p>Com o aumento da demanda, investimos em equipamentos profissionais — serra esquadrejadeira, coladeira de borda e ferramentas de precisão — e montamos nosso primeiro ateliê dedicado, com espaço para projetos maiores e mais complexos.</p>
                </div>
                <div class="timeline-item timeline-animate">
                    <h5>Especialização em Planejados</h5>
                    <p>Nos especializamos em móveis planejados, passando a trabalhar com MDF de alta densidade, laminados melamínicos e ferragens de alta performance. Cada projeto começou a ser desenvolvido com desenho técnico detalhado, garantindo aproveitamento máximo do espaço e acabamento impecável.</p>
                </div>
                <div class="timeline-item timeline-animate">
                    <h5>Presença Digital</h5>
                    <p>Ampliamos nosso alcance criando nossa presença online para que mais clientes conheçam nossos projetos, solicitem orçamentos com facilidade e acompanhem a evolução de seus pedidos de forma prática e transparente.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Números da Marcenaria -->
    <div class="row g-4 mb-5 slide-up">
        <div class="col-12 text-center mb-3">
            <h3 class="fw-bold section-title">Nossos Números</h3>
            <p class="text-muted mt-4">Resultados que refletem nosso compromisso com a qualidade.</p>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-number"><span class="counter" data-target="200">0</span>+</div>
                <div class="stat-label">Projetos Entregues</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-number"><span class="counter" data-target="150">0</span>+</div>
                <div class="stat-label">Clientes Satisfeitos</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-number"><span class="counter" data-target="5">0</span>+</div>
                <div class="stat-label">Anos de Experiência</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-number"><span class="counter" data-target="98">0</span>%</div>
                <div class="stat-label">Taxa de Aprovação</div>
            </div>
        </div>
    </div>

    <!-- Valores em Cards (Missão, Visão, Valores) -->
    <div class="row g-4 mt-4 slide-up delay-2">
        <div class="col-md-4">
            <div class="card h-100 border-0 bg-white shadow-sm feature-card about-card">
                <div class="card-body text-center p-5">
                    <div class="icon-box mb-4 mx-auto">
                        <i class="fa-solid fa-bullseye fa-2x" style="color: var(--logo-claro);"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Missão</h4>
                <p class="text-muted mb-0">Entregar soluções em marcenaria que aliem qualidade, conforto e design exclusivo para cada cliente, transformando espaços em ambientes funcionais e acolhedores.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 bg-white shadow-sm feature-card about-card">
                <div class="card-body text-center p-5">
                    <div class="icon-box mb-4 mx-auto">
                        <i class="fa-regular fa-eye fa-2x" style="color: var(--logo-claro);"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Visão</h4>
                <p class="text-muted mb-0">Ser reconhecida como a melhor marcenaria da região pela excelência no atendimento, pontualidade na entrega e qualidade inquestionável dos nossos produtos.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 bg-white shadow-sm feature-card about-card">
                <div class="card-body text-center p-5">
                    <div class="icon-box mb-4 mx-auto">
                        <i class="fa-solid fa-handshake fa-2x" style="color: var(--logo-claro);"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Valores</h4>
                <p class="text-muted mb-0">Comprometimento com a qualidade, transparência em cada etapa do projeto, respeito aos prazos combinados e valorização genuína das relações humanas.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Nosso Processo de Trabalho -->
    <div class="row mt-5 pt-4 slide-up">
        <div class="col-12 text-center mb-4">
            <h3 class="fw-bold section-title">Como Trabalhamos</h3>
            <p class="text-muted mt-4">Do primeiro contato à montagem final, cada etapa é pensada para garantir sua satisfação.</p>
        </div>
    </div>
    <div class="row align-items-start mb-5 slide-up">
        <div class="col-12 col-sm-6 col-lg">
            <div class="process-step">
                <div class="process-icon">
                    <i class="fa-solid fa-comments fa-2x" style="color: var(--logo-escuro);"></i>
                </div>
                <h6 class="fw-bold">1. Contato</h6>
                <p class="text-muted small mb-0">Você entra em contato pelo WhatsApp ou formulário e nos conta o que precisa.</p>
            </div>
        </div>
        <div class="col-auto d-none d-lg-flex process-arrow">
            <i class="fa-solid fa-chevron-right"></i>
        </div>
        <div class="col-12 col-sm-6 col-lg">
            <div class="process-step">
                <div class="process-icon">
                    <i class="fa-solid fa-pencil-ruler fa-2x" style="color: var(--logo-escuro);"></i>
                </div>
                <h6 class="fw-bold">2. Projeto</h6>
                <p class="text-muted small mb-0">Desenvolvemos o projeto com medidas precisas e acabamentos sob medida.</p>
            </div>
        </div>
        <div class="col-auto d-none d-lg-flex process-arrow">
            <i class="fa-solid fa-chevron-right"></i>
        </div>
        <div class="col-12 col-sm-6 col-lg">
            <div class="process-step">
                <div class="process-icon">
                    <i class="fa-solid fa-hammer fa-2x" style="color: var(--logo-escuro);"></i>
                </div>
                <h6 class="fw-bold">3. Produção</h6>
                <p class="text-muted small mb-0">Fabricamos cada peça com materiais de primeira e acabamento impecável.</p>
            </div>
        </div>
        <div class="col-auto d-none d-lg-flex process-arrow">
            <i class="fa-solid fa-chevron-right"></i>
        </div>
        <div class="col-12 col-sm-6 col-lg">
            <div class="process-step">
                <div class="process-icon">
                    <i class="fa-solid fa-truck fa-2x" style="color: var(--logo-escuro);"></i>
                </div>
                <h6 class="fw-bold">4. Entrega</h6>
                <p class="text-muted small mb-0">Entregamos e montamos no local combinado, dentro do prazo estipulado.</p>
            </div>
        </div>
    </div>

    <!-- Nossos Diferenciais -->
    <div class="row mt-4 slide-up">
        <div class="col-12 text-center mb-4">
            <h3 class="fw-bold section-title">Nossos Diferenciais</h3>
            <p class="text-muted mt-4">O que nos diferencia das demais marcenarias da região.</p>
        </div>
    </div>
    <div class="row g-4 mb-5 slide-up">
        <div class="col-md-6 col-lg-3">
            <div class="diff-card shadow-sm h-100">
                <i class="fa-solid fa-medal fa-2x mb-3" style="color: var(--logo-escuro);"></i>
                <h6 class="fw-bold">Garantia de Qualidade</h6>
                <p class="text-muted small mb-0">Todos os nossos projetos possuem garantia contra defeitos de fabricação, assegurando sua tranquilidade.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="diff-card shadow-sm h-100">
                <i class="fa-solid fa-screwdriver-wrench fa-2x mb-3" style="color: var(--logo-escuro);"></i>
                <h6 class="fw-bold">Ferragens Premium</h6>
                <p class="text-muted small mb-0">Utilizamos ferragens de marcas reconhecidas no mercado, como corrediças telescópicas e dobradiças com amortecimento.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="diff-card shadow-sm h-100">
                <i class="fa-solid fa-palette fa-2x mb-3" style="color: var(--logo-escuro);"></i>
                <h6 class="fw-bold">Acabamento Personalizado</h6>
                <p class="text-muted small mb-0">Oferecemos diversas opções de acabamento: laca, laminado melamínico, MDF amadeirado e pintura sob medida.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="diff-card shadow-sm h-100">
                <i class="fa-solid fa-headset fa-2x mb-3" style="color: var(--logo-escuro);"></i>
                <h6 class="fw-bold">Atendimento Humanizado</h6>
                <p class="text-muted small mb-0">Cada cliente é atendido de forma individual, com atenção aos detalhes e acompanhamento constante do projeto.</p>
            </div>
        </div>
    </div>

    <!-- Depoimentos de Clientes -->
    <div class="row mt-4 slide-up">
        <div class="col-12 text-center mb-4">
            <h3 class="fw-bold section-title">O Que Nossos Clientes Dizem</h3>
            <p class="text-muted mt-4">A satisfação de quem confiou na Marcenaria Nanias.</p>
        </div>
    </div>
    <div class="row g-4 mb-5 slide-up">
        <div class="col-md-4">
            <div class="testimonial-card shadow-sm h-100">
                <p class="testimonial-quote">"Minha cozinha ficou exatamente como eu sonhei. O acabamento é perfeito, cada detalhe foi pensado com muito cuidado. Recomendo de olhos fechados!"</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">MC</div>
                    <div>
                        <div class="testimonial-name">Maria C.</div>
                        <div class="testimonial-role">Cozinha Planejada</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="testimonial-card shadow-sm h-100">
                <p class="testimonial-quote">"Profissionalismo do início ao fim. Cumpriram o prazo, o material é de primeira qualidade e o preço foi justo. O guarda-roupa ficou incrível!"</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">RS</div>
                    <div>
                        <div class="testimonial-name">Roberto S.</div>
                        <div class="testimonial-role">Dormitório Master</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="testimonial-card shadow-sm h-100">
                <p class="testimonial-quote">"Já é o terceiro projeto que faço com a Nanias. Escritório, sala e agora a área gourmet. Qualidade sempre impecável e atendimento nota 10!"</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">AF</div>
                    <div>
                        <div class="testimonial-name">Ana F.</div>
                        <div class="testimonial-role">Área Gourmet</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA para contato -->
    <div class="cta-section text-center py-5 mt-4 fade-in" style="border-radius: 16px;">
        <div class="container py-3">
            <h3 class="fw-bold mb-3 text-white">Quer saber mais sobre nosso trabalho?</h3>
            <p class="mb-4 text-white-50 lead">Entre em contato conosco e agende uma visita para conhecer de perto a qualidade Nanias.</p>
            <div class="d-flex justify-content-center flex-column flex-sm-row gap-3 flex-wrap">
                <a href="<?php echo BASEURL; ?>paginas/suporte.php" class="btn btn-nanias-light btn-lg px-5 py-3 rounded-pill">
                    <i class="fa-solid fa-envelope me-2"></i>Falar Conosco
                </a>
                <a href="https://wa.me/seunumerodewhatsapp" class="btn btn-nanias-light btn-lg px-5 py-3 rounded-pill" target="_blank">
                    <i class="fa-brands fa-whatsapp me-2"></i>WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Timeline Scroll Animation */
.timeline-animate {
    opacity: 0;
    transform: translateX(-40px);
    transition: opacity 0.7s cubic-bezier(0.4, 0, 0.2, 1), transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
}
.timeline-animate.visible {
    opacity: 1;
    transform: translateX(0);
}
.timeline-animate:nth-child(1) { transition-delay: 0s; }
.timeline-animate:nth-child(2) { transition-delay: 0.15s; }
.timeline-animate:nth-child(3) { transition-delay: 0.3s; }
.timeline-animate:nth-child(4) { transition-delay: 0.45s; }

.about-card {
    border-radius: 12px;
    transition: transform 0.3s ease;
    border-bottom: 4px solid transparent !important;
}
.about-card:hover {
    transform: translateY(-5px);
    border-bottom: 4px solid var(--logo-medio) !important;
}
.about-image-wrapper {
    transition: all 0.3s ease;
}
.about-image-wrapper:hover {
    background-color: var(--fundo-creme) !important;
    border-color: var(--logo-escuro) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var timelineItems = document.querySelectorAll('.timeline-animate');
    if (!timelineItems.length) return;

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.2,
        rootMargin: '0px 0px -50px 0px'
    });

    timelineItems.forEach(function (item) {
        observer.observe(item);
    });

    // Animação dos números
    var counters = document.querySelectorAll('.counter');
    var countersStarted = false;

    if (counters.length > 0) {
        var counterObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting && !countersStarted) {
                    countersStarted = true;
                    counters.forEach(function(counter) {
                        var target = +counter.getAttribute('data-target');
                        var duration = 2000;
                        var step = target / (duration / 16);
                        var current = 0;
                        
                        var updateCounter = function() {
                            current += step;
                            if (current < target) {
                                counter.innerText = Math.ceil(current);
                                requestAnimationFrame(updateCounter);
                            } else {
                                counter.innerText = target;
                            }
                        };
                        updateCounter();
                    });
                }
            });
        }, { threshold: 0.5 });

        if (counters[0]) {
            counterObserver.observe(counters[0]);
        }
    }
});
</script>

<?php 
include(FOOTER_TEMPLATE);
?>
