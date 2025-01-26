<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KPH Perhutani Padangan</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <img src="images/logo_kph_pdgn.png" alt="logo kph" class="login-logo">
        <p class="logo-text">KPH PERHUTANI PADANGAN</p>
        <form method="POST" action="login_procces.php">
            <label for="NPK">NPK:</label>
            <input type="text" id="NPK" name="NPK" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>

</body>
</html>
