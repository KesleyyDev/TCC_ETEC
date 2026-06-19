<?php
require_once "../config.php";
require_once DBAPI;
require_once ABSPATH . "inc/functions.php";

if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ' . BASEURL . 'paginas/login.php');
    exit;
}


// Chama a função que vai processar e gerar o CSV
// Para isso funcionar, setamos exportar_csv no GET
$_GET['exportar_csv'] = 1;
gerar_csv_contatos();

// Se a função por algum motivo não der exit, podemos redirecionar ou mostrar mensagem
header("Location: gestao.php");
exit;
?>
