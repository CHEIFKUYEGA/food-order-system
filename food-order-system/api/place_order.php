<?php
session_start();
header("Content-Type: application/json");
require_once '../includes/db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Tafadhali ingia kwanza."]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Get JSON data
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['items']) || !isset($data['total']) || empty($data['items'])) {
    echo json_encode(["success" => false, "message" => "Data ya oda si sahihi."]);
    exit;
}

$items = $data['items'];
$total = $data['total'];

// Start transaction
$conn->begin_transaction();

try {
    // Insert order header
    $order_sql = "INSERT INTO orders (user_id, total) VALUES (?, ?)";
    $order_stmt = $conn->prepare($order_sql);
    $order_stmt->bind_param("id", $user_id, $total);
    $order_stmt->execute();
    $order_id = $conn->insert_id;

    // Insert order items
    $item_sql = "INSERT INTO order_items (order_id, food_id, qty, price) VALUES (?, ?, ?, ?)";
    $item_stmt = $conn->prepare($item_sql);

    foreach ($items as $item) {
        $item_stmt->bind_param("iiid", $order_id, $item['id'], $item['qty'], $item['price']);
        $item_stmt->execute();
    }

    // Commit transaction
    $conn->commit();

    echo json_encode(["success" => true, "message" => "Oda yako imetumwa!", "order_id" => $order_id]);

} catch (Exception $e) {
    // Rollback on error
    $conn->rollback();
    echo json_encode(["success" => false, "message" => "Kosa katika kutuma oda: " . $e->getMessage()]);
}
?>