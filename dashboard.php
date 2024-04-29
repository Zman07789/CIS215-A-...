<?php
session_start();

if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    header('Location: login.html');
    exit;
}

echo "Welcome to the dashboard!";
?>
