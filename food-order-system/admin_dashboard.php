<?php
session_start();
require_once 'includes/db_connection.php';

// Hakikisha ni Admin pekee anayeweza kuona ukurasa huu
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// 1. LOGIC YA KUFUTA CHAKULA (MPYA)
if (isset($_GET['delete_id'])) {
    $id_to_delete = $conn->real_escape_string($_GET['delete_id']);
    
    // Kwanza tunapata jina la picha ili tuifute kwenye folder la assets
    $getImage = $conn->query("SELECT image_url FROM menu_items WHERE id = '$id_to_delete'");
    if($imgData = $getImage->fetch_assoc()) {
        $path = "assets/images/" . $imgData['image_url'];
        if(file_exists($path)) { unlink($path); } // Futa picha yenyewe
    }

    $conn->query("DELETE FROM menu_items WHERE id = '$id_to_delete'");
    header("Location: admin_dashboard.php?deleted=1");
    exit();
}

// 2. TAKWIMU ZA HARAKA
$total_orders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
$pending_orders = $conn->query("SELECT COUNT(*) as count FROM orders WHERE status='Inasubiri'")->fetch_assoc()['count'];
$total_revenue = $conn->query("SELECT SUM(price) as total FROM orders WHERE status='Imekubaliwa'")->fetch_assoc()['total'];

// 3. LOGIC YA KUONGEZA CHAKULA
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_food'])) {
    $name = $conn->real_escape_string($_POST['food_name']);
    $price = $conn->real_escape_string($_POST['price']);
    $image_name = time() . "_" . $_FILES['food_image']['name'];
    
    if (move_uploaded_file($_FILES['food_image']['tmp_name'], "assets/images/" . $image_name)) {
        $conn->query("INSERT INTO menu_items (food_name, price, image_url) VALUES ('$name', '$price', '$image_name')");
        header("Location: admin_dashboard.php?success=1");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel | FoodieExpress</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #27ae60; --dark: #2c3e50; --light: #ecf0f1; --danger: #e74c3c; --warning: #f1c40f; }
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; margin: 0; display: flex; }
        
        .sidebar { width: 260px; background: var(--dark); height: 100vh; color: white; padding: 25px; position: fixed; box-sizing: border-box; }
        .sidebar h2 { color: var(--primary); font-size: 22px; margin-bottom: 30px; }
        .sidebar a { display: block; color: #bdc3c7; text-decoration: none; padding: 12px 0; border-bottom: 1px solid #34495e; transition: 0.3s; }
        .sidebar a:hover { color: white; padding-left: 10px; }
        .sidebar i { margin-right: 10px; width: 20px; }

        .main-content { margin-left: 260px; padding: 30px; width: calc(100% - 260px); box-sizing: border-box; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; align-items: center; }
        .stat-card i { font-size: 40px; color: var(--primary); margin-right: 15px; opacity: 0.3; }
        .stat-card h3 { margin: 0; font-size: 14px; color: #7f8c8d; }
        .stat-card p { margin: 5px 0 0; font-size: 20px; font-weight: bold; color: var(--dark); }

        .card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .card h3 { margin-top: 0; border-bottom: 2px solid #f1f1f1; padding-bottom: 10px; margin-bottom: 20px; display: flex; align-items: center; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th { background: #f8f9fa; padding: 15px; text-align: left; color: #7f8c8d; font-size: 13px; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #f1f1f1; font-size: 14px; }
        
        .status-badge { padding: 6px 12px; border-radius: 50px; font-size: 11px; font-weight: bold; }
        .Inasubiri { background: #fff3cd; color: #856404; }
        .Imekubaliwa { background: #d4edda; color: #155724; }
        .Imekataliwa { background: #f8d7da; color: #721c24; }

        .btn-action { padding: 8px 15px; border-radius: 6px; text-decoration: none; color: white; font-size: 12px; font-weight: bold; margin-right: 5px; border: none; cursor: pointer; }
        .btn-approve { background: var(--primary); }
        .btn-reject { background: var(--danger); }
        .btn-delete { background: #ff4757; color: white; }
        .btn-delete:hover { background: #ff6b81; }

        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-size: 14px; color: #34495e; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn-save { background: var(--primary); color: white; border: none; padding: 12px 25px; border-radius: 8px; cursor: pointer; font-weight: bold; width: 100%; font-size: 16px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2><i class="fas fa-bolt"></i> Foodie Admin</h2>
    <a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="index.php" target="_blank"><i class="fas fa-globe"></i> Fungua Tovuti</a>
    <a href="logout.php" style="margin-top: 50px; color: #e74c3c;"><i class="fas fa-power-off"></i> Ondoka</a>
</div>

<div class="main-content">
    <?php if(isset($_GET['deleted'])): ?>
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> Chakula kimefutwa kikamilifu kwenye menu!
        </div>
    <?php endif; ?>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1>Admin Dashboard</h1>
        <p style="color: #7f8c8d;">Karibu tena, <strong>Admin</strong></p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <i class="fas fa-shopping-basket"></i>
            <div><h3>Jumla ya Oda</h3><p><?php echo $total_orders; ?></p></div>
        </div>
        <div class="stat-card" style="border-left: 5px solid var(--warning);">
            <i class="fas fa-clock" style="color: var(--warning);"></i>
            <div><h3>Inasubiri</h3><p><?php echo $pending_orders; ?></p></div>
        </div>
        <div class="stat-card" style="border-left: 5px solid var(--primary);">
            <i class="fas fa-money-bill-wave" style="color: var(--primary);"></i>
            <div><h3>Mapato</h3><p>TSh <?php echo number_format($total_revenue); ?></p></div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
        
        <div class="card">
            <h3><i class="fas fa-plus-circle"></i> Ongeza Menu Mpya</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Jina la Chakula</label>
                    <input type="text" name="food_name" required>
                </div>
                <div class="form-group">
                    <label>Bei (TSh)</label>
                    <input type="number" name="price" required>
                </div>
                <div class="form-group">
                    <label>Picha</label>
                    <input type="file" name="food_image" required>
                </div>
                <button type="submit" name="add_food" class="btn-save">Hifadhi</button>
            </form>
        </div>

        <div class="card">
            <h3><i class="fas fa-utensils"></i> Dhibiti Menu</h3>
            <div style="max-height: 400px; overflow-y: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Picha</th>
                            <th>Jina</th>
                            <th>Bei</th>
                            <th>Kitendo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $menu = $conn->query("SELECT * FROM menu_items ORDER BY id DESC");
                        while($item = $menu->fetch_assoc()): ?>
                        <tr>
                            <td><img src="assets/images/<?php echo $item['image_url']; ?>" width="40" height="40" style="border-radius:5px; object-fit:cover;"></td>
                            <td><?php echo $item['food_name']; ?></td>
                            <td>TSh <?php echo number_format($item['price']); ?></td>
                            <td>
                                <a href="admin_dashboard.php?delete_id=<?php echo $item['id']; ?>" 
                                   class="btn-action btn-delete" 
                                   onclick="return confirm('Je, una uhakika unataka kufuta <?php echo $item['food_name']; ?>?')">
                                   <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="card">
        <h3><i class="fas fa-list"></i> Oda Mpya</h3>
        <table>
            <thead>
                <tr>
                    <th>Muda</th>
                    <th>Mteja</th>
                    <th>Chakula</th>
                    <th>Hali</th>
                    <th>Kitendo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $orders = $conn->query("SELECT orders.*, users.username FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.id DESC LIMIT 10");
                while($ord = $orders->fetch_assoc()): ?>
                <tr>
                    <td><?php echo date('H:i', strtotime($ord['order_date'])); ?></td>
                    <td><?php echo $ord['username']; ?></td>
                    <td><?php echo $ord['food_name']; ?></td>
                    <td><span class="status-badge <?php echo $ord['status']; ?>"><?php echo $ord['status']; ?></span></td>
                    <td>
                        <?php if($ord['status'] == 'Inasubiri'): ?>
                            <a href="api/update_order.php?id=<?php echo $ord['id']; ?>&status=Imekubaliwa" class="btn-action btn-approve">Kubali</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>