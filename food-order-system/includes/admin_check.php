<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Kama si admin, mrudishe login
    header("Location: login.html");
    exit();
}
?>