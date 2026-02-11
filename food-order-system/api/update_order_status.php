<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

require_once '../includes/db_connection.php';

// Pokea data inayotumwa kutoka kwenye JavaScript
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['order_id'])) {
    $order_id = (int)$data['order_id'];

    // Badilisha hali ya oda kuwa Completed
    $sql = "UPDATE orders SET order_status = 'Completed' WHERE order_id = $order_id";

    if ($conn->query($sql)) {
        echo json_encode([
            "success" => true, 
            "message" => "Oda #" . $order_id . " imekamilishwa kikamilifu!"
        ]);
    } else {
        echo json_encode([
            "success" => false, 
            "message" => "Imeshindwa kubadilisha hali: " . $conn->error
        ]);
    }
} else {
    echo json_encode([
        "success" => false, 
        "message" => "Order ID haijapokelewa."
    ]);
}
?>