<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="icon.png">
    <link rel="stylesheet" href="styleRegister.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Register</title>
</head>
<body>

    <div class = "contenedor-register">
        <!-- FORMULARIO DE REGISTRO -->

        <form action="register_backend.php" method="POST" class="form-register">
            <h2>Register</h2>
            <input type="text" name="fullname" placeholder="Insert your full name" required>
            <input type="text" name="user" placeholder="Insert your new user" required>
            <input type="text" name="mail" placeholder="Insert your gmail" required>
            <input type="password" name="password" placeholder="Insert your password" required>
            <input type="password" name="password_confirm" placeholder="Insert your password again" required>
            <div class="g-recaptcha" data-sitekey="6LcWThUsAAAAABIG_Q4Qj82Z4cfSX3zcf0J03Atq"></div>
            <button type="submit" class="submit" name="submit-Register">Submit</button>
            <p>Do you have an account? Click on <a href="login.php">Here</a></p>
        </form>
    </div>
    <script src="register.js"></script>
</body>
</html>