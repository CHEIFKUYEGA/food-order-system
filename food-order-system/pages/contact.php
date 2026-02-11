<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wasiliana Nasi | FoodieExpress</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #27ae60; --dark: #2c3e50; --bg: #f4f7f6; --white: #ffffff; }
        body { font-family: 'Segoe UI', sans-serif; margin: 0; background: var(--bg); color: var(--dark); }
        
        .contact-hero { 
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1534536281715-e28d76689b4d?auto=format&fit=crop&w=1350&q=80');
            height: 300px; display: flex; align-items: center; justify-content: center; color: white; text-align: center; background-size: cover; background-position: center;
        }

        .container { max-width: 1100px; margin: -50px auto 50px; padding: 0 20px; }
        
        .contact-wrapper { 
            display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; 
        }

        /* INFO CARDS */
        .info-card { 
            background: var(--white); padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center;
        }
        .info-card i { font-size: 40px; color: var(--primary); margin-bottom: 20px; }
        .info-card h3 { margin-bottom: 10px; }
        .info-card p { color: #666; font-size: 1.1rem; }

        /* CONTACT FORM */
        .contact-form { 
            background: var(--white); padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
        }
        .contact-form h2 { margin-bottom: 25px; color: var(--primary); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
        .form-group input, .form-group textarea { 
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; outline: none; transition: 0.3s; font-family: inherit;
        }
        .form-group input:focus, .form-group textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1); }
        
        .btn-send { 
            background: var(--primary); color: white; border: none; padding: 15px 30px; border-radius: 10px; cursor: pointer; font-weight: bold; width: 100%; font-size: 16px; transition: 0.3s;
        }
        .btn-send:hover { background: #219150; transform: translateY(-2px); }

        .back-home { text-align: center; margin-top: 30px; }
        .back-home a { color: var(--dark); text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; gap: 8px; }
        .back-home a:hover { color: var(--primary); }
    </style>
</head>
<body>

    <div class="contact-hero">
        <div>
            <h1>Tupo Hapa Kwa Ajili Yako</h1>
            <p>Una swali au unataka kutoa oda maalum? Tuandikie sasa.</p>
        </div>
    </div>

    <div class="container">
        <div class="contact-wrapper">
            <div class="contact-info">
                <div class="info-card" style="margin-bottom: 20px;">
                    <i class="fas fa-phone-alt"></i>
                    <h3>Tupigie</h3>
                    <p>0617 175 328</p>
                    <p>0712 XXX XXX</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-map-marker-alt"></i>
                    <h3>Ofisi Zetu</h3>
                    <p>Morogoro Mjini, Tanzania</p>
                    <p>Mkabala na Soko Kuu</p>
                </div>
            </div>

            <div class="contact-form">
                <h2>Tuma Ujumbe</h2>
                <form action="#" method="POST">
                    <div class="form-group">
                        <label>Jina Kamili</label>
                        <input type="text" name="name" placeholder="Andika jina lako..." required>
                    </div>
                    <div class="form-group">
                        <label>Barua Pepe (Email)</label>
                        <input type="email" name="email" placeholder="Andika email yako..." required>
                    </div>
                    <div class="form-group">
                        <label>Ujumbe Wako</label>
                        <textarea name="message" rows="5" placeholder="Andika unachotaka kutuambia..." required></textarea>
                    </div>
                    <button type="submit" class="btn-send">Tuma Ujumbe Sasa</button>
                </form>
            </div>
        </div>

        <div class="back-home">
            <a href="../index.php"><i class="fas fa-arrow-left"></i> Rudi Nyumbani kutaizama Menu</a>
        </div>
    </div>

    <footer style="background: var(--dark); color: white; text-align: center; padding: 20px;">
        <p>&copy; 2024 FoodieExpress. Usafi na Ladha ni Jukumu Letu.</p>
    </footer>

</body>
</html>