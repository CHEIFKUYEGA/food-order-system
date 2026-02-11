<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
require_once '../includes/db_connection.php';
require_once '../includes/admin_check.php';

// Unaweza kuongeza JOIN ili kupata jina la mteja badala ya ID tu
$sql = "SELECT * FROM orders ORDER BY created_at DESC";
$result = $conn->query($sql);

$orders = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    echo json_encode(["success" => true, "data" => $orders]);
} else {
    echo json_encode(["success" => false, "message" => "Hakuna oda zilizopatikana."]);
}
?>