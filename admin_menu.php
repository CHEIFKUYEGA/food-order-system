<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Menu</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'includes/admin_check.php'; ?>
    <header>
        <nav>
            <h1>Admin: Manage Menu</h1>
            <div>
                <a href="admin_dashboard.php" style="color:white; margin-right:15px;">Oda</a>
                <a href="index.php" style="color:white;">Rudi Site</a>
            </div>
        </nav>
    </header>

    <main style="padding: 20px;">
        <section id="add-food-section">
            <h3>Ongeza Chakula Kipya</h3>
            <form id="addFoodForm" style="max-width: 500px; margin: 20px 0;">
                <input type="text" id="itemName" placeholder="Jina la Chakula" required>
                <textarea id="itemDesc" placeholder="Maelezo kidogo" required style="width:100%; padding:10px; margin:10px 0;"></textarea>
                <input type="number" id="itemPrice" placeholder="Bei (TSh)" required>
                <input type="text" id="itemImage" placeholder="Jina la Picha (mf. wali.jpg)">
                <button type="submit" class="order-btn">Hifadhi Chakula</button>
            </form>
        </section>

        <hr>

        <h3>Orodha ya Menu</h3>
        <table border="1" style="width:100%; border-collapse: collapse; margin-top:20px;">
            <thead>
                <tr style="background-color: #34495e; color: white;">
                    <th>Picha</th>
                    <th>Jina</th>
                    <th>Bei</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="adminMenuBody">
                </tbody>
        </table>
    </main>

    <script src="assets/js/admin_crud.js"></script>
</body>
</html>