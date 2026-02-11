<?php
require_once '../includes/db_connection.php';

$sql = "SELECT * FROM menu_items ORDER BY id DESC";
$result = $conn->query($sql);

$menu = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $menu[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($menu);
?>