<?php
session_start();

if ($_POST['username'] === 'admin' && $_POST['password'] === 'password') {
    $_SESSION['authenticated'] = true;
    header('Location: dashboard.php');
    exit;
} else {
    echo "Invalid username or password";
}
?>
