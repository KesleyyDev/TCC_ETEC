<?php
/** Inicia a sessão para que o login e o CRUD funcionem **/
if (!session_id()) {
    session_start();
}

/** O nome do banco de dados*/
const DB_NAME = "";

/** nome do host do MySQL */
const DB_HOST = "localhost";

/** Usuário do banco de dados MySQL */
const DB_USER = "";

/** Senha do banco de dados MySQL */
const DB_PASS = "";

/** String de conexão do PDO */
const DB_DSN = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";

/** caminho absoluto para a pasta do sistema **/
if (!defined('ABSPATH'))
    define('ABSPATH', dirname(__FILE__) . '/');

/** caminho no server para o sistema **/
if (!defined('BASEURL'))
    define('BASEURL', '/TCC/');

/** caminho do arquivo de banco de dados **/
if (!defined('DBAPI'))
    define('DBAPI', ABSPATH . 'inc/database.php');

/** caminhos dos templates de header e footer **/
const HEADER_TEMPLATE = ABSPATH . 'inc/header.php';
const FOOTER_TEMPLATE = ABSPATH . 'inc/footer.php';
?>