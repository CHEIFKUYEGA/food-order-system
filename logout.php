<?php
session_start();
// Futa session zote za server
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logging Out...</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f4f4f4; }
    </style>
</head>
<body>
    <div style="text-align: center;">
        <h2>Unatolewa kwenye mfumo...</h2>
        <p>Tafadhali subiri kidogo.</p>
    </div>

    <script>
        // 1. Safisha data zote za mteja zilizopo kwenye browser (LocalStorage)
        localStorage.removeItem("userId");
        localStorage.setItem("userName", "");
        localStorage.clear();

        // 2. Mpeleke mteja kwenye ukurasa wa nyumbani baada ya sekunde 1
        setTimeout(() => {
            window.location.href = "index.php";
        }, 1000);
    </script>
</body>
</html>