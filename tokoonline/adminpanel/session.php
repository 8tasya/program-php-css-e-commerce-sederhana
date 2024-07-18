<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
    header('Location: login.php');
    exit(); // Tambahkan exit untuk menghentikan eksekusi skrip setelah header redirect
}
?>
