<?php
require_once "../config.php";
require_once DBAPI;
require_once ABSPATH . "inc/functions.php";
require_once ABSPATH . "inc/auth.php";
require_roles(['admin', 'dono']);

$database = open_database();
if (!$database) {
    http_response_code(503);
    exit('Serviço indisponível.');
}

gerar_csv_contatos($database);
?>
