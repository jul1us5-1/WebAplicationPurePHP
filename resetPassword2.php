<?php
session_start();
if(isset($_SESSION['mensaje'])){
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="icon.png">
    <link rel="stylesheet" href="styleRegister.css">
    <title>Password Forgotten</title>
</head>
<body>
    <div class = "contenedor-register">
        <form action="resPass2_backend.php" method="POST" class="form-register">
            <h2>Password Forgotten</h2>
            <input type="text" name="emailUser" placeholder="Insert your email or usser" autocomplete="off" required>
            <input type="text" name="activation_code" placeholder="Insert your activation code" autocomplete="off" required>
            <button type="submit" class="submit" name="submit-Activation">Set new password</button>
       </form>
    <p><?php echo $mensaje ?? ""; ?></p>
    </div>
</body>
</html>