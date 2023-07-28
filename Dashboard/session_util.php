<?php
session_start();

if (!isset($_SESSION["username"]) || !isset($_SESSION["role"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];
$role = $_SESSION["role"];
?>