<?php
session_start();

if (!isset($_SESSION["username"]) || !isset($_SESSION["role"])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION["role"];

if ($role === "Patient") {
    header("Location: ../dashboard/patdash.php");
    exit();
} elseif ($role === "Doctor") {
    header("Location: ../dashboard/docdash.php");
    exit();
} elseif ($role === "Pharmacist") {
    header("Location: ../dashboard/pharmdash.php");
    exit();
} elseif ($role === "Admin") {
    header("Location: ../dashboard/admindash.php");
    exit();
} else {
    echo "Unknown role: $role";
}

$username = $_SESSION["username"];
$role = $_SESSION["role"];
?>
