<?php
require_once "../../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ' . BASEURL . 'paginas/login.php');
    exit;
}


if (isset($_GET['id'])) {
    remove('usuarios', $_GET['id']);
}
header('Location: index.php');
exit;
?>
