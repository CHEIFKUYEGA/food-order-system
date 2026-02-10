<?php
require_once 'includes/db_connection.php';
session_start();

$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE username='$username'");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];

            echo "<script>
                localStorage.setItem('userRole', '" . $user['role'] . "');
                localStorage.setItem('username', '" . $user['username'] . "');
                window.location.href = '" . ($user['role'] == 'admin' ? 'admin_dashboard.php' : 'index.php') . "';
            </script>";
            exit();
        } else {
            $error_msg = "Password siyo sahihi!";
        }
    } else {
        $error_msg = "Mtumiaji huyu hayupo!";
    }
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Ingia | FoodieExpress</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #27ae60; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .error { color: #dc2626; background: #fee2e2; padding: 10px; border-radius: 5px; margin-bottom: 10px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="color: #27ae60;">Ingia Kazini</h2>
        <?php if($error_msg != "") echo "<div class='error'>$error_msg</div>"; ?>
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">INGIA</button>
        </form>
        <p style="font-size: 14px; margin-top: 15px;">Huna akaunti? <a href="register.php" style="color:#27ae60; text-decoration:none;">Jisajili hapa</a></p>
    </div>
</body>
</html>