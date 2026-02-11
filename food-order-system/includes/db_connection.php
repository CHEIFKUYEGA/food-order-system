<?php
// Unganisha na database yako halisi
$conn = new mysqli("localhost", "root", "", "food_ordering_db");

// Angalia kama muunganisho umefeli
if ($conn->connect_error) {
    header('Content-Type: application/json');
    die(json_encode([
        "success" => false, 
        "message" => "Database 'food_ordering_db' haijaunganishwa: " . $conn->connect_error
    ]));
}
?>