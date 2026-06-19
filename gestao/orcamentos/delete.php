<?php
require_once "../../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: " . BASEURL . "paginas/login.php");
    exit;
}

$allowed_rules = ['admin', 'dono'];
if (!isset($_SESSION['usuario_rule']) || !in_array($_SESSION['usuario_rule'], $allowed_rules)) {
    header("Location: " . BASEURL . "index.php?erro=acesso_negado");
    exit;
}

if (isset($_GET['id'])) {
    $database = open_database();
    try {
        $stmt = $database->prepare("DELETE FROM orcamentos WHERE id = :id");
        $stmt->execute([':id' => (int)$_GET['id']]);
    } catch(PDOException $e) {}
    close_database($database);
}
header("Location: index.php");
exit;
?>
