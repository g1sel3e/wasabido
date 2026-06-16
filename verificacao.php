<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// verifica se cliente está logado
if (!isset($_SESSION['cod'])) {
    header("Location: /wasabido/login.php");
    exit();
}