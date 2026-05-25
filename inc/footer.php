</main>

<!-- Botão Flutuante WhatsApp -->
<a href="https://wa.me/seunumerodewhatsapp" id="whatsapp-fab" target="_blank" aria-label="Fale conosco pelo WhatsApp" title="WhatsApp">
    <i class="fa-brands fa-whatsapp"></i>
</a>

<!-- Widget de Acessibilidade Flutuante -->
<button id="accessibility-fab" aria-label="Abrir menu de acessibilidade" title="Acessibilidade">
    <i class="fa-solid fa-universal-access"></i>
</button>

<div id="accessibility-panel" role="dialog" aria-label="Opções de Acessibilidade">
    <div class="acc-panel-header">
        <h6><i class="fa-solid fa-universal-access me-2"></i>Acessibilidade</h6>
        <button class="acc-panel-close" id="acc-close-btn" aria-label="Fechar painel de acessibilidade">&times;</button>
    </div>
    <div class="acc-panel-body">
        <!-- Tamanho da Fonte -->
        <div class="acc-option-group">
            <div class="acc-option-group-title">Tamanho da Fonte</div>
            <div class="acc-slider-wrapper">
                <label for="acc-font-slider"><i class="fa-solid fa-text-height me-1"></i> Ajustar tamanho</label>
                <input type="range" id="acc-font-slider" class="acc-slider" min="80" max="150" value="100" step="5">
                <div class="acc-slider-value" id="acc-font-value">100%</div>
            </div>
        </div>

        <!-- Visão -->
        <div class="acc-option-group">
            <div class="acc-option-group-title">Visão</div>
            <button class="acc-option" id="acc-contrast" aria-pressed="false">
                <i class="fa-solid fa-circle-half-stroke"></i>
                <span>Alto Contraste</span>
            </button>
            <button class="acc-option" id="acc-grayscale" aria-pressed="false">
                <i class="fa-solid fa-droplet-slash"></i>
                <span>Escala de Cinza</span>
            </button>
            <button class="acc-option" id="acc-links" aria-pressed="false">
                <i class="fa-solid fa-link"></i>
                <span>Destacar Links</span>
            </button>
        </div>

        <!-- Navegação -->
        <div class="acc-option-group">
            <div class="acc-option-group-title">Navegação</div>
            <button class="acc-option" id="acc-cursor" aria-pressed="false">
                <i class="fa-solid fa-arrow-pointer"></i>
                <span>Cursor Grande</span>
            </button>
            <button class="acc-option" id="acc-reading" aria-pressed="false">
                <i class="fa-solid fa-bars-staggered"></i>
                <span>Guia de Leitura</span>
            </button>
            <button class="acc-option" id="acc-dyslexia" aria-pressed="false">
                <i class="fa-solid fa-font"></i>
                <span>Fonte para Dislexia</span>
            </button>
        </div>

        <!-- Reset -->
        <button class="acc-reset-btn" id="acc-reset">
            <i class="fa-solid fa-rotate-left me-1"></i> Restaurar Padrão
        </button>
    </div>
</div>

<!-- Guia de Leitura (barra que segue o mouse) -->
<div class="acc-reading-line" id="acc-reading-line">
    <div class="acc-reading-line-bar" id="acc-reading-bar"></div>
</div>

    <footer class="mt-auto py-4" style="background-color: var(--header-escuro); color: var(--fundo-creme); margin-top: 80px !important; box-shadow: 0 -4px 6px rgba(0,0,0,0.1);">
        <div class="container text-center">
            <?php $data = new DateTime("now", new DateTimeZone("America/Sao_Paulo")); ?>
            
            <p class="mb-1 fw-bold" style="color: #fff; letter-spacing: 1px;">
                Marcenaria Nanias
            </p>
            
            <p class="mb-0" style="font-size: 0.95rem;">
                &copy; 2025–<?php echo $data->format("Y"); ?> | Desenvolvido por <span style="color: #faba89; font-weight: 600;">Equipe Dipas</span>
            </p>
        </div>
    </footer>

    <script src="<?php echo BASEURL; ?>js/awesome/all.min.js"></script>
    <script src="<?php echo BASEURL; ?>js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASEURL; ?>js/main.js?v=<?php echo time(); ?>"></script>
</body>
</html>