<?php
/** Caminho absoluto para a pasta do sistema. */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . DIRECTORY_SEPARATOR);
}

/** Caminho no servidor para o sistema. */
if (!defined('BASEURL')) {
    define('BASEURL', '/TCC/');
}

/** Configuração do banco. Em produção, informe os valores por variáveis de ambiente. */
if (!defined('DB_NAME')) {
    define('DB_NAME', getenv('TCC_DB_NAME') ?: 'marcenaria_nanias');
}
if (!defined('DB_HOST')) {
    define('DB_HOST', getenv('TCC_DB_HOST') ?: 'localhost');
}
if (!defined('DB_USER')) {
    define('DB_USER', getenv('TCC_DB_USER') ?: 'root');
}
if (!defined('DB_PASS')) {
    $dbPassword = getenv('TCC_DB_PASS');
    define('DB_PASS', $dbPassword === false ? '' : $dbPassword);
}

if (!defined('DB_DSN')) {
    define('DB_DSN', 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4');
}

if (!defined('DBAPI')) {
    define('DBAPI', ABSPATH . 'inc/database.php');
}

/** Caminhos dos templates de header e footer. */
if (!defined('HEADER_TEMPLATE')) {
    define('HEADER_TEMPLATE', ABSPATH . 'inc/header.php');
}
if (!defined('FOOTER_TEMPLATE')) {
    define('FOOTER_TEMPLATE', ABSPATH . 'inc/footer.php');
}

/** Verifica se um caminho de imagem local existe antes de renderizá-lo. */
if (!function_exists('local_image_exists')) {
    function local_image_exists(?string $path): bool
    {
        $path = trim((string)$path);
        if ($path === '' ||
            !preg_match('#\Aimg/[A-Za-z0-9/_\-.]+\.(?:jpe?g|png|gif|webp)\z#i', $path)) {
            return false;
        }

        return is_file(ABSPATH . str_replace('/', DIRECTORY_SEPARATOR, $path));
    }
}

/** Inicia a sessão com proteção contra fixation, acesso via JavaScript e CSRF. */
if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.use_strict_mode', '1');

    $cookiePath = parse_url(BASEURL, PHP_URL_PATH) ?: '/';
    $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => $cookiePath,
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}
?>
