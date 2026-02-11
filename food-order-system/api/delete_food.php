<?php
require_once '../includes/db_connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // 1. Tafuta jina la Primary Key (Column ya kwanza yenye ufunguo)
    $res = $conn->query("SHOW KEYS FROM menu_items WHERE Key_name = 'PRIMARY'");
    $key_info = $res->fetch_assoc();
    $primaryKey = $key_info['Column_name']; 

    // 2. Jaribu kufuta
    $sql = "DELETE FROM menu_items WHERE $primaryKey = $id";
    $conn->query($sql);

    // 3. Angalia kama kweli kuna kitu kimefutwa kwenye database
    if ($conn->affected_rows > 0) {
        // Imefanikiwa!
        header("Location: ../admin_dashboard.php?status=deleted");
    } else {
        // Haikufuta chochote! (Labda ID haipo au jina la column limekataa)
        die("Database haijafuta kitu. Sababu inaweza kuwa ID $id haikupatikana kwenye column ya $primaryKey. <br><a href='../admin_dashboard.php'>Rudi Dashboard</a>");
    }
} else {
    die("Hakuna ID iliyopokelewa!");
}
$conn->close();
?>