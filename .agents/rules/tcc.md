---
trigger: always_on
---

PROJETO: Site institucional e catálogo para a Marcenaria Nanias.
OBJETIVO: Exibir catálogo de móveis e direcionar clientes para pedidos via WhatsApp. (Futuramente: pedidos via forms/email).
STACK: HTML5, CSS3, JS, PHP, MySQL.

INSTRUÇÕES ESTRITAS DE DESENVOLVIMENTO:
1. DESIGN MANTIDO: Use EXCLUSIVAMENTE as variáveis CSS (root) definidas em `/css/style.css`. Não invente novas cores.
2. ASSETS LOCAIS: É PROIBIDO o uso de CDNs externos. Utilize apenas as classes do Bootstrap e ícones do FontAwesome presentes na estrutura local (`/css/bootstrap/`, `/css/awesome/`).
3. INCLUDES: O layout deve utilizar sempre `inc/header.php` e `inc/footer.php`. 
4. LÓGICA PHP: Antes de adicionar funções pesadas no header, verifique se elas já existem ou devem ser alocadas em `inc/functions.php` e chamadas após o include do header.

ESTRUTURA DO PROJETO:
/TCC
├── /css
│   ├── /awesome
│   ├── /bootstrap
│   └── style.css
├── /fonts
│   └── Todas as fontes estão aqui.
├── /inc
│   ├── database.php    (Conexão e Queries)
│   ├── footer.php      (Template global)
│   ├── functions.php   (Lógica Global)
│   └── header.php      (Template global)
├── /js
│   ├── /awesome
│   ├── /bootstrap
│   └── main.js
├── catalogo.php
├── config.php          (Configurações de Ambiente)
├── gestao.php
├── index.php
└── login.php