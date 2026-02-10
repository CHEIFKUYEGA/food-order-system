<?php
session_start();
require_once 'includes/db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Oda Zangu | FoodieExpress</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        .status { padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: bold; }
        .Inasubiri { background: #f1c40f; color: white; }
        .Imekubaliwa { background: #2ecc71; color: white; }
        .Imekataliwa { background: #e74c3c; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Oda Zangu</h2>
        <a href="index.php">Rudi Kwenye Menu</a>
        <table>
            <tr>
                <th>Chakula</th>
                <th>Bei</th>
                <th>Hali (Status)</th>
                <th>Tarehe</th>
            </tr>
            <?php
            $res = $conn->query("SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY id DESC");
            if ($res->num_rows > 0) {
                while($row = $res->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['food_name']}</td>
                        <td>TSh ".number_format($row['price'])."</td>
                        <td><span class='status {$row['status']}'>{$row['status']}</span></td>
                        <td>".date('d/m/Y H:i', strtotime($row['order_date']))."</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4' style='text-align:center;'>Hujafanya oda bado.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>