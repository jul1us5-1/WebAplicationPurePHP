<?php
session_start();

// Revisamos si existe un mensaje de login
$login_message = "";
if(isset($_SESSION['mensaje'])){
    $login_message = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']); // lo borramos para que no aparezca al recargar
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="icon.png">
    <link rel="stylesheet" href="styleLogin.css">
    <title>Login</title>
</head>
<body>
    <div class = "contenedor-login">
        <form action="login_backend.php" method="POST" class="form-login">
            <h2>Login</h2>
            <input type="text" name="user-mail" placeholder="Insert your user or gmail" autocomplete="off" required>
            <input type="password" name="password" placeholder="Insert your password" autocomplete="off" required>
            <button type="submit" class="submit" name="submit-login">Submit</button>
        </form>
        <p>¿Do you want to log in as guest mode?</p>
        <form action="session_incognito.php" method="POST" class="Form-login">
            <button type="submit" class="submit" name="btn-incognito" id="submit-guest">
                Guest Mode
            </button>
        </form>
        <div class="login-footer">
            <p class="no-account">You dont have an account? Click on <a href="register.php">Here</a></p>
            <p class="forgot-password">Forgot your password? Click on <a href="resetPassword.php">Here</a></p>
        </div>
    <p><?= $login_message;?> </p>
    </div>
    
</body>
</html>