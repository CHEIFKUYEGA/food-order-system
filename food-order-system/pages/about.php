<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuhusu Sisi | FoodieExpress</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #27ae60; --dark: #2c3e50; --light: #f8f9fa; --white: #ffffff; }
        body { font-family: 'Segoe UI', Roboto, sans-serif; margin: 0; color: #444; line-height: 1.6; background: var(--white); }
        
        /* HERO SECTION */
        .hero-about { 
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1514326640560-7d063ef2aed5?auto=format&fit=crop&w=1350&q=80'); 
            height: 350px; display: flex; align-items: center; justify-content: center; color: white; text-align: center; background-size: cover; background-position: center;
        }
        .hero-about h1 { font-size: 3rem; margin-bottom: 10px; }

        .container { max-width: 1100px; margin: auto; padding: 60px 20px; }
        
        /* SECTION GRID */
        .section-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 50px; align-items: center; }
        .about-image { position: relative; }
        .about-image img { width: 100%; border-radius: 20px; box-shadow: 20px 20px 0 var(--primary); transition: 0.4s; object-fit: cover; }
        .about-image:hover img { transform: scale(1.02); }

        /* FEATURES */
        .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin-top: 60px; }
        .feature-box { background: var(--light); padding: 35px 25px; border-radius: 20px; text-align: center; transition: 0.4s; border: 1px solid #eee; }
        .feature-box:hover { transform: translateY(-10px); background: white; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border-color: var(--primary); }
        .feature-box i { font-size: 45px; color: var(--primary); margin-bottom: 20px; }
        .feature-box h3 { margin-bottom: 15px; color: var(--dark); }

        /* BUTTONS */
        .btn-container { text-align: center; margin-top: 60px; display: flex; justify-content: center; gap: 20px; }
        .btn { display: inline-block; padding: 15px 40px; background: var(--primary); color: white; text-decoration: none; border-radius: 50px; font-weight: bold; transition: 0.3s; box-shadow: 0 5px 15px rgba(39,174,96,0.3); }
        .btn:hover { background: #219150; transform: scale(1.05); }
        .btn-outline { background: transparent; border: 2px solid var(--dark); color: var(--dark); box-shadow: none; }
        .btn-outline:hover { background: var(--dark); color: white; }

        @media (max-width: 768px) {
            .hero-about h1 { font-size: 2.2rem; }
            .section-grid { text-align: center; }
            .about-image img { box-shadow: 10px 10px 0 var(--primary); }
        }
    </style>
</head>
<body>

    <div class="hero-about">
        <div>
            <h1>Tunapika kwa Upendo</h1>
            <p style="font-size: 1.2rem; opacity: 0.9;">Ladha ya kipekee, Huduma ya uhakika.</p>
        </div>
    </div>

    <div class="container">
        <div class="section-grid">
            <div class="about-image">
                <img src="../assets/images/mpishi.jpg" alt="Mpishi wa FoodieExpress">
            </div>
            <div>
                <h2 style="color:var(--primary); font-size: 2.2rem;">Sisi ni nani?</h2>
                <p><strong>FoodieExpress</strong> ni jukwaa namba moja lililoanzishwa hapa Morogoro likiwa na lengo la kuleta mapinduzi katika sekta ya vyakula. Sisi siyo tu daraja kati yako na chakula, bali ni wadau wa furaha yako ya kila siku.</p>
                <p>Tunafanya kazi na wapishi waliohitimu na wenye uzoefu wa miaka mingi katika mapishi ya kiasili na vile vya kisasa. Kila oda unayoweka inapikwa kwa umakini mkubwa kwa kuzingatia afya na usafi wa hali ya juu.</p>
                <p>Dira yetu ni kuhakikisha kila mteja anapata chakula bora, kwa bei rafiki, na kwa muda mfupi iwezekanavyo akiwa ofisini au nyumbani.</p>
            </div>
        </div>

        <h2 style="text-align:center; margin-top:80px; font-size: 2rem; color: var(--dark);">Kwanini Utuchague FoodieExpress?</h2>
        <div class="underline" style="width:60px; height:4px; background:var(--primary); margin: 15px auto 40px;"></div>
        
        <div class="features">
            <div class="feature-box">
                <i class="fas fa-truck-fast"></i>
                <h3>Uwasilishaji Haraka</h3>
                <p>Mfumo wetu wa usafirishaji ni wa kisasa. Chakula chako kitakufikia kikiwa bado cha moto na katika hali ya usalama kabisa.</p>
            </div>
            <div class="feature-box">
                <i class="fas fa-utensils"></i>
                <h3>Mapishi Bora</h3>
                <p>Wapishi wetu ni mafundi wa ladha. Tunatumia viungo asilia na siri za mapishi zinazofanya kila tonge kuwa na kumbukumbu.</p>
            </div>
            <div class="feature-box">
                <i class="fas fa-medal"></i>
                <h3>Ubora na Usafi</h3>
                <p>Tunazingatia viwango vya juu vya usafi tangu maandalizi hadi ufungaji wa chakula chako. Afya yako ni jukumu letu.</p>
            </div>
        </div>

        <div class="btn-container">
            <a href="../index.php" class="btn-outline btn"><i class="fas fa-arrow-left"></i> Rudi Nyumbani</a>
            <a href="../index.php" class="btn">Agiza Chakula Sasa</a>
        </div>
    </div>

    <footer style="background: var(--dark); color: white; text-align: center; padding: 30px; margin-top: 50px;">
        <p>&copy; 2026 FoodieExpress. Haki zote zimehifadhiwa.</p>
    </footer>

</body>
</html>