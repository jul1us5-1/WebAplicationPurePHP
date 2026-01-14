<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="icon.png">
    <link rel="stylesheet" href="styleRegister.css">
    <title>Activation</title>
</head>
<body>
    <div class = "contenedor-register">
        <form action="resPass_backend.php" method="POST" class="form-register">
            <h2>Password Forgotten</h2>
            <input type="text" name="email_usser" placeholder="Insert your email" required>
            <button type="submit" class="submit" name="submit-Activation">Send activation code</button>
        </form>
    </div>
</body>
</html>