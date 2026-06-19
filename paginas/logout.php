<?php
require_once "../config.php";

if (!isset($_SESSION)) session_start();
session_unset();
session_destroy();

header("Location: " . BASEURL . "index.php");
exit;
?>
