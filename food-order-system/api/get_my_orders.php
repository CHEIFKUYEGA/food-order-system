<?php
header("Content-Type: application/json");
require_once '../includes/db_connection.php';

$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

if ($user_id > 0) {
    $sql = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC";
    $result = $conn->query($sql);
    $orders = [];

    while($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    echo json_encode(["success" => true, "data" => $orders]);
} else {
    echo json_encode(["success" => false, "message" => "User ID haitambuliki!"]);
}
?>