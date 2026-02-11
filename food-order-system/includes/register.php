<?php
// 1. UNGANISHA NA DATABASE
require_once 'includes/db_connection.php';

$error_msg = "";

// 2. LOGIC YA KUSAJILI (Inatokea fomu ikitumwa)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Chukua data kutoka kwenye fomu
    $user = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $pass = $_POST['password'];
    
    // Ficha password kwa usalama (Hashing)
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Angalia kama username au email tayari vipo kwenye database
    $check = $conn->query("SELECT * FROM users WHERE username='$user' OR email='$email'");
    
    if ($check->num_rows > 0) {
        $error_msg = "Samahani! Jina hili au Email imeshatumika tayari.";
    } else {
        // Ingiza mtumiaji mpya kwenye database
        // Tunatumia 'user' kama role ya kienyeji kwa kila anayejisajili
        $sql = "INSERT INTO users (username, email, password, role) VALUES ('$user', '$email', '$hashed_password', 'user')";
        
        if ($conn->query($sql)) {
            // Ikishafanikiwa, mpeleke kwenye login.php
            echo "<script>
                alert('Hongera! Usajili umekamilika. Sasa unaweza kuingia.');
                window.location.href = 'login.php';
            </script>";
            exit();
        } else {
            $error_msg = "Kuna tatizo limetokea: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jisajili | FoodieExpress</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #27ae60; --dark: #2c3e50; }
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .reg-card { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%; max-width: 380px; text-align: center; }
        .logo { color: var(--primary); font-size: 28px; margin-bottom: 10px; font-weight: bold; }
        h2 { color: var(--dark); margin-bottom: 25px; font-size: 22px; }
        input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 15px; transition: 0.3s; }
        input:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 5px rgba(39, 174, 96, 0.2); }
        button { width: 100%; padding: 13px; background: var(--primary); color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; transition: 0.3s; }
        button:hover { background: #219150; transform: translateY(-2px); }
        .error-box { background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; border: 1px solid #fecaca; }
        .footer-text { margin-top: 20px; font-size: 14px; color: #666; }
        .footer-text a { color: var(--primary); text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="reg-card">
    <div class="logo"><i class="fas fa-utensils"></i> FoodieExpress</div>
    <h2>Fungua Akaunti</h2>

    <?php if($error_msg != ""): ?>
        <div class="error-box">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error_msg; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="register.php">
        <input type="text" name="username" placeholder="Jina la Mtumiaji (Username)" required>
        <input type="email" name="email" placeholder="Barua Pepe (Email)" required>
        <input type="password" name="password" placeholder="Neno la Siri (Password)" required>
        <button type="submit">JISAJILI SASA</button>
    </form>

    <div class="footer-text">
        Tayari una akaunti? <br>
        <a href="login.php">Ingia hapa</a>
    </div>
</div>

</body>
</html>