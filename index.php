<?php
session_start();

if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    header('Location: login.html');
    exit;
} else {
    header('Location: purchase_order_system.php');
    exit;
}
?>
