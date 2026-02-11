<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>
<body>
    <script>
        // Safisha data zote za mteja zilizohifadhiwa kwenye browser
        localStorage.clear();
        // Mrudishe mteja kwenye ukurasa wa mwanzo
        window.location.href = "index.php";
    </script>
</body>
</html>