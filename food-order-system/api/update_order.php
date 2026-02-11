<?php
// api/update_order.php
require_once '../includes/db_connection.php';
session_start();

// Hakikisha ni Admin pekee anafanya hivi
if ($_SESSION['role'] !== 'admin') {
    die("Huna ruhusa!");
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    $sql = "UPDATE orders SET status = '$status' WHERE id = $id";
    
    if ($conn->query($sql)) {
        header("Location: ../admin_dashboard.php?msg=Oda imesasishwa");
    } else {
        echo "Kosa: " . $conn->error;
    }
}
?>