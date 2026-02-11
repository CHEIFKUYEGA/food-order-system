<?php
session_start();
require_once 'includes/db_connection.php';

// LOGIC YA KUPROCESS ODA ZA KIKAPU
if(isset($_POST['checkout']) && isset($_SESSION['user_id'])){
    $u_id = $_SESSION['user_id'];
    $cart_data = json_decode($_POST['cart_json'], true);
    
    foreach($cart_data as $item) {
        $f_name = $conn->real_escape_string($item['name']);
        $f_price = $conn->real_escape_string($item['price']);
        $conn->query("INSERT INTO orders (user_id, food_name, price, status) VALUES ('$u_id', '$f_name', '$f_price', 'Inasubiri')");
    }
    echo "<script>alert('Oda zako zimepokelewa! Tafadhali tuma malipo sasa.'); window.location.href='index.php';</script>";
}

$search_query = "";
if(isset($_POST['search'])) {
    $search_query = $conn->real_escape_string($_POST['search_term']);
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieExpress | Agiza Chakula Kitamu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { 
            --primary: #27ae60; 
            --dark: #2c3e50; 
            --bg: #f4f7f6; 
            --accent: #e67e22; 
            --white: #ffffff;
        }
        
        body { font-family: 'Segoe UI', Roboto, sans-serif; background: var(--bg); margin: 0; overflow-x: hidden; color: var(--dark); }
        
        /* NAVBAR (Imerudishwa kama ya mwanzo) */
        .navbar { 
            background: var(--white); 
            padding: 10px 8%; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.08); 
            position: sticky; 
            top: 0; 
            z-index: 1000; 
        }
        .logo { color: var(--primary); font-size: 26px; font-weight: 800; text-decoration: none; display: flex; align-items: center; gap: 10px; }
        .nav-menu { display: flex; align-items: center; gap: 25px; }
        .nav-menu a { text-decoration: none; color: var(--dark); font-weight: 600; transition: 0.3s; font-size: 15px; }
        .nav-menu a:hover { color: var(--primary); transform: translateY(-2px); }
        
        .cart-icon { position: relative; cursor: pointer; font-size: 22px; color: var(--dark); transition: 0.3s; }
        .cart-icon:hover { color: var(--primary); }
        .cart-count { position: absolute; top: -12px; right: -12px; background: var(--accent); color: white; border-radius: 50%; padding: 2px 7px; font-size: 11px; font-weight: bold; border: 2px solid var(--white); }

        /* HERO SLIDER */
        .hero-slider { height: 500px; position: relative; overflow: hidden; background: #000; }
        .slide { width: 100%; height: 100%; position: absolute; background-size: cover; background-position: center; transition: 1s ease; opacity: 0; display: flex; align-items: center; justify-content: center; }
        .slide::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); }
        .slide.active { opacity: 1; }
        .hero-content { position: relative; z-index: 10; color: white; text-align: center; max-width: 700px; padding: 20px; }
        .hero-content h1 { font-size: 3.5rem; margin-bottom: 10px; text-shadow: 2px 2px 10px rgba(0,0,0,0.5); }
        
        /* TYPING EFFECT BOX */
        .typing-box { font-size: 1.5rem; margin-bottom: 20px; font-weight: 300; }
        #changing-text { color: var(--accent); font-weight: bold; border-right: 2px solid var(--accent); padding-right: 5px; }

        .search-box { margin-top: 30px; background: white; padding: 8px; border-radius: 50px; display: flex; box-shadow: 0 10px 25px rgba(0,0,0,0.3); }
        .search-box input { border: none; padding: 12px 25px; outline: none; border-radius: 50px; width: 350px; font-size: 16px; }
        .search-box button { background: var(--primary); border: none; color: white; padding: 12px 35px; border-radius: 50px; cursor: pointer; font-weight: bold; transition: 0.3s; }

        /* MENU SECTION (Imerudishwa kama ya mwanzo) */
        .menu-container { padding: 60px 8%; }
        .section-header { text-align: center; margin-bottom: 50px; }
        .food-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 35px; }
        .food-card { background: var(--white); border-radius: 25px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.05); transition: 0.4s ease; border: 1px solid #eee; }
        .food-card img { width: 100%; height: 220px; object-fit: cover; }
        .food-info { padding: 25px; }
        .btn-add-cart { background: var(--dark); color: white; border: none; padding: 14px; border-radius: 12px; cursor: pointer; width: 100%; font-weight: 600; }

        /* SIDEBAR & CART */
        .cart-sidebar { position: fixed; right: -400px; top: 0; width: 380px; height: 100%; background: white; box-shadow: -10px 0 30px rgba(0,0,0,0.15); z-index: 2000; transition: 0.5s; padding: 30px; display: flex; flex-direction: column; }
        .cart-sidebar.open { right: 0; }
        .cart-items { flex: 1; overflow-y: auto; }
        .btn-checkout { background: var(--primary); color: white; border: none; padding: 18px; border-radius: 15px; width: 100%; cursor: pointer; font-weight: 800; }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="index.php" class="logo"><i class="fas fa-utensils"></i> FoodieExpress</a>
        
        <div class="nav-menu">
            <a href="index.php">Nyumbani</a>
            <a href="pages/about.php">Kuhusu Sisi</a>
            <a href="pages/contact.php">Mawasiliano</a>
            
            <div id="auth-links" style="display: flex; align-items: center; gap: 15px;">
                <a href="login.php"><i class="fas fa-user-circle"></i> Ingia</a>
                <a href="register.php" style="background:var(--primary); color:white; padding:5px 15px; border-radius:20px;">Jisajili</a>
            </div>

            <span class="cart-icon" onclick="toggleCart()">
                <i class="fas fa-shopping-basket"></i>
                <span class="cart-count" id="cart-count">0</span>
            </span>
        </div>
    </nav>

    <header class="hero-slider">
        <div class="slide active" style="background-image: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1350&q=80')">
            <div class="hero-content">
                <h1>Ladha ya Nyumbani Inakufuata!</h1>
                <div class="typing-box">Unatamani <span id="changing-text"></span></div>
                <form class="search-box" method="POST">
                    <input type="text" name="search_term" placeholder="Unatamani kula nini leo?">
                    <button type="submit" name="search">Tafuta</button>
                </form>
            </div>
        </div>
        <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=1350&q=80')">
            <div class="hero-content">
                <h1>Nyama Choma & Misosi Mikali</h1>
                <p>Tunafanya delivery ya haraka popote ulipo mjini.</p>
            </div>
        </div>
    </header>

    <section class="menu-container">
        <div class="section-header">
            <h2>Menu yetu ya Leo</h2>
            <div style="width: 80px; height: 4px; background: var(--primary); margin: auto;"></div>
        </div>

        <div class="food-grid">
            <?php
            $sql = ($search_query != "") ? "SELECT * FROM menu_items WHERE food_name LIKE '%$search_query%' ORDER BY id DESC" : "SELECT * FROM menu_items ORDER BY id DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $img_src = "assets/images/".$row['image_url'];
                    echo '
                    <div class="food-card">
                        <img src="'.$img_src.'" onerror="this.src=\'https://via.placeholder.com/300x220?text=Chakula+Kizuri\'">
                        <div class="food-info">
                            <div class="food-name">'.$row['food_name'].'</div>
                            <div class="food-price">TSh '.number_format($row['price']).'</div>
                            <button class="btn-add-cart" onclick="addToCart(\''.$row['food_name'].'\', '.$row['price'].')">
                                <i class="fas fa-cart-plus"></i> Weka Kikapuni
                            </button>
                        </div>
                    </div>';
                }
            }
            ?>
        </div>
    </section>

    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header" style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #eee; padding-bottom:10px;">
            <h3>Kikapu Chako</h3>
            <i class="fas fa-times" onclick="toggleCart()" style="cursor:pointer; font-size:1.5rem;"></i>
        </div>
        <div class="cart-items" id="cartItems"></div>
        <div class="cart-footer" style="margin-top:20px;">
            <h4 id="cartTotal">Jumla: TSh 0</h4>
            <form method="POST">
                <input type="hidden" name="cart_json" id="cartInput">
                <button type="submit" name="checkout" class="btn-checkout" onclick="return validateCheckout()">LIPA NA KAMILISHA ODA</button>
            </form>
        </div>
    </div>

    <script>
        // JS KWA AJILI YA TYPING EFFECT
        const maneno = ["Wali wa Nyama?", "Chips Kuku?", "Samaki wa Kupaka?", "Pizza ya Kuku?"];
        let wordIndex = 0; let charIndex = 0; let isDeleting = false;
        const textElement = document.getElementById("changing-text");

        function type() {
            const currentWord = maneno[wordIndex];
            if (isDeleting) {
                textElement.textContent = currentWord.substring(0, charIndex - 1);
                charIndex--;
            } else {
                textElement.textContent = currentWord.substring(0, charIndex + 1);
                charIndex++;
            }
            if (!isDeleting && charIndex === currentWord.length) {
                isDeleting = true; setTimeout(type, 2000);
            } else if (isDeleting && charIndex === 0) {
                isDeleting = false; wordIndex = (wordIndex + 1) % maneno.length; setTimeout(type, 500);
            } else {
                setTimeout(type, isDeleting ? 50 : 150);
            }
        }
        type();

        // SLIDER BACKGROUND
        let slides = document.querySelectorAll('.slide');
        let currentSlide = 0;
        setInterval(() => {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        }, 5000);

        // LOGIC YA KIKAPU (CART)
        let cart = [];
        function addToCart(name, price) {
            cart.push({name, price});
            updateCartUI();
            document.getElementById('cartSidebar').classList.add('open');
        }
        function toggleCart() { document.getElementById('cartSidebar').classList.toggle('open'); }
        function updateCartUI() {
            const list = document.getElementById('cartItems');
            const totalDisplay = document.getElementById('cartTotal');
            list.innerHTML = ""; let total = 0;
            cart.forEach((item, index) => {
                total += item.price;
                list.innerHTML += `<div style="display:flex; justify-content:space-between; padding:10px; border-bottom:1px solid #eee;">
                    <span>${item.name}</span>
                    <strong>TSh ${item.price.toLocaleString()}</strong>
                </div>`;
            });
            document.getElementById('cart-count').innerText = cart.length;
            totalDisplay.innerText = "Jumla: TSh " + total.toLocaleString();
            document.getElementById('cartInput').value = JSON.stringify(cart);
        }

        function validateCheckout() {
            if(!localStorage.getItem("userRole")) {
                alert("Tafadhali Ingia kwanza!"); window.location.href = 'login.php'; return false;
            }
            if(cart.length === 0) { alert("Kikapu kiko wazi!"); return false; }
            return confirm("Thibitisha Oda? Malipo: 0617175328 (SALUMU)");
        }

        // ILE NAVBAR LOGIC YAKO YA MWANZO
        function updateNavbar() {
            const authLinks = document.getElementById('auth-links');
            const role = localStorage.getItem("userRole");
            if(role) {
                let html = `<a href="my_orders.php">Oda Zangu</a>`;
                if(role === 'admin') { html += `<a href="admin_dashboard.php" style="color:var(--accent); font-weight:bold;">Admin Panel</a>`; }
                html += `<a href="#" onclick="logout()" style="color:#888;">Logout</a>`;
                authLinks.innerHTML = html;
            }
        }
        function logout() {
            if(confirm("Toka?")) { localStorage.clear(); window.location.href = 'logout.php'; }
        }
        updateNavbar();
    </script>
</body>
</html>