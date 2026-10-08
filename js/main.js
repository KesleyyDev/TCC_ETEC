/**
 * main.js — Marcenaria Nanias
 * Widget de Acessibilidade + funções globais
 */

document.addEventListener('DOMContentLoaded', function () {

    // =============================================
    // WIDGET DE ACESSIBILIDADE
    // =============================================

    const fab = document.getElementById('accessibility-fab');
    const panel = document.getElementById('accessibility-panel');
    const closeBtn = document.getElementById('acc-close-btn');
    const resetBtn = document.getElementById('acc-reset');
    const fontSlider = document.getElementById('acc-font-slider');
    const fontValue = document.getElementById('acc-font-value');
    const readingBar = document.getElementById('acc-reading-bar');

    // Opções de toggle (id do botão -> classe CSS no body)
    const toggleOptions = {
        'acc-contrast':  'acc-high-contrast',
        'acc-grayscale': 'acc-grayscale',
        'acc-links':     'acc-highlight-links',
        'acc-cursor':    'acc-big-cursor',
        'acc-reading':   'acc-reading-guide',
        'acc-dyslexia':  'acc-dyslexia-font'
    };

    // --- Carregar preferências salvas ---
    function loadPreferences() {
        try {
            const saved = JSON.parse(localStorage.getItem('nanias_accessibility') || '{}');

            // Tamanho da fonte
            if (saved.fontSize) {
                document.documentElement.style.fontSize = saved.fontSize + '%';
                if (fontSlider) fontSlider.value = saved.fontSize;
                if (fontValue) fontValue.textContent = saved.fontSize + '%';
            }

            // Toggles
            if (saved.toggles) {
                Object.keys(saved.toggles).forEach(function (btnId) {
                    if (saved.toggles[btnId]) {
                        const cssClass = toggleOptions[btnId];
                        if (cssClass) document.body.classList.add(cssClass);
                        const btn = document.getElementById(btnId);
                        if (btn) {
                            btn.classList.add('active');
                            btn.setAttribute('aria-pressed', 'true');
                        }
                    }
                });
            }
        } catch (e) {
            // Ignora erros de parse
        }
    }

    // --- Salvar preferências ---
    function savePreferences() {
        var data = {
            fontSize: fontSlider ? parseInt(fontSlider.value) : 100,
            toggles: {}
        };
        Object.keys(toggleOptions).forEach(function (btnId) {
            var btn = document.getElementById(btnId);
            data.toggles[btnId] = btn ? btn.classList.contains('active') : false;
        });
        try {
            localStorage.setItem('nanias_accessibility', JSON.stringify(data));
        } catch (e) {
            // Ignora erros de storage
        }
    }

    // --- Abrir / Fechar painel ---
    if (fab) {
        fab.addEventListener('click', function () {
            var isOpen = panel.classList.contains('open');
            if (isOpen) {
                panel.classList.remove('open');
                fab.setAttribute('aria-expanded', 'false');
            } else {
                panel.classList.add('open');
                fab.setAttribute('aria-expanded', 'true');
            }
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            panel.classList.remove('open');
            fab.setAttribute('aria-expanded', 'false');
        });
    }

    // Fechar ao clicar fora
    document.addEventListener('click', function (e) {
        if (panel && fab && !panel.contains(e.target) && !fab.contains(e.target)) {
            panel.classList.remove('open');
            fab.setAttribute('aria-expanded', 'false');
        }
    });

    // Fechar com ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && panel && panel.classList.contains('open')) {
            panel.classList.remove('open');
            fab.setAttribute('aria-expanded', 'false');
            fab.focus();
        }
    });

    // --- Slider de Tamanho de Fonte ---
    if (fontSlider) {
        fontSlider.addEventListener('input', function () {
            var val = this.value;
            document.documentElement.style.fontSize = val + '%';
            if (fontValue) fontValue.textContent = val + '%';
            savePreferences();
        });
    }

    // --- Botões de Toggle ---
    Object.keys(toggleOptions).forEach(function (btnId) {
        var btn = document.getElementById(btnId);
        if (btn) {
            btn.addEventListener('click', function () {
                var cssClass = toggleOptions[btnId];
                var isActive = this.classList.contains('active');

                if (isActive) {
                    this.classList.remove('active');
                    this.setAttribute('aria-pressed', 'false');
                    document.body.classList.remove(cssClass);
                } else {
                    this.classList.add('active');
                    this.setAttribute('aria-pressed', 'true');
                    document.body.classList.add(cssClass);
                }

                savePreferences();
            });
        }
    });

    // --- Guia de Leitura (barra segue o mouse) ---
    document.addEventListener('mousemove', function (e) {
        if (readingBar && document.body.classList.contains('acc-reading-guide')) {
            readingBar.style.top = (e.clientY - 6) + 'px';
        }
    });

    // --- Botão Reset ---
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            // Resetar fonte
            document.documentElement.style.fontSize = '';
            if (fontSlider) fontSlider.value = 100;
            if (fontValue) fontValue.textContent = '100%';

            // Remover todas as classes de acessibilidade
            Object.keys(toggleOptions).forEach(function (btnId) {
                var cssClass = toggleOptions[btnId];
                document.body.classList.remove(cssClass);
                var btn = document.getElementById(btnId);
                if (btn) {
                    btn.classList.remove('active');
                    btn.setAttribute('aria-pressed', 'false');
                }
            });

            // Limpar localStorage
            try {
                localStorage.removeItem('nanias_accessibility');
            } catch (e) {}
        });
    }

    // Carregar preferências ao iniciar
    loadPreferences();

    // =============================================
    // DARK MODE TOGGLE
    // =============================================

    var darkToggle = document.getElementById('darkmode-toggle');

    function setDarkMode(enabled) {
        var bannerLogo = document.querySelector('.banner-logo');
        if (enabled) {
            document.body.classList.add('dark-mode');
            if (bannerLogo && bannerLogo.src.includes('teste.png')) {
                bannerLogo.src = bannerLogo.src.replace('teste.png', 'logobranco.png');
            }
        } else {
            document.body.classList.remove('dark-mode');
            if (bannerLogo && bannerLogo.src.includes('logobranco.png')) {
                bannerLogo.src = bannerLogo.src.replace('logobranco.png', 'teste.png');
            }
        }
        try {
            localStorage.setItem('nanias_darkmode', enabled ? 'on' : 'off');
        } catch (e) {}
    }

    // Carregar preferência salva
    (function () {
        try {
            var saved = localStorage.getItem('nanias_darkmode');
            if (saved === 'on') {
                setDarkMode(true);
            }
        } catch (e) {}
    })();

    // Click toggle
    if (darkToggle) {
        darkToggle.addEventListener('click', function () {
            darkToggle.classList.add('animating');
            setTimeout(function () {
                darkToggle.classList.remove('animating');
            }, 700);
            
            var isDark = document.body.classList.contains('dark-mode');
            setDarkMode(!isDark);
        });
    }

    // =============================================
    // SCROLL REVEAL (a animação fica no style.css)
    // =============================================

    var revealSelector = 'h1, h2, h3, p, img, form, .card, .testimonial-card, .hero-section, .accordion-item, .alert';

    if ('IntersectionObserver' in window) {
        var revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                // Revela com 30% visível (ou 30% da tela, para elementos muito altos)
                var visibleEnough = entry.intersectionRatio >= 0.3 ||
                    entry.intersectionRect.height >= window.innerHeight * 0.3;
                if (visibleEnough) {
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: [0, 0.05, 0.1, 0.2, 0.3] });

        document.querySelectorAll('main ' + revealSelector.split(', ').join(', main ')).forEach(function (el) {
            // Anima só o elemento mais externo, nunca um dentro do outro
            if (el.parentElement && el.parentElement.closest(revealSelector)) return;
            el.classList.add('scroll-reveal');
            revealObserver.observe(el);
        });
    }

});
