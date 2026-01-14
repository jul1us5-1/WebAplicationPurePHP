    <?php
    session_start();
    if(!isset($_SESSION['temp_mail'])){
        header("Location: resetPassword.php");
        exit;
    }else{
        $mail =$_SESSION['temp_mail'];
        unset($_SESSION['temp_mail']);
    } 

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
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script src = "changePassword.js"></script>
        <title>Changing Password</title>
    </head>
    <body>
        <div class = "contenedor-register">
            <form action="changePass_backend.php" method="POST" class="form-register">
                <h2>Password Forgotten</h2>
                <input type="hidden" name="email" value="<?= $mail ?>">
                <input type="text" name="password1" placeholder="Insert your new password" autocomplete="off" required>
                <input type="text" name="password2" placeholder="Insert again your new password" autocomplete="off" required>
                <div class="g-recaptcha" data-sitekey="6LcWThUsAAAAABIG_Q4Qj82Z4cfSX3zcf0J03Atq"></div>
                <button type="submit" class="submit" name="submit-Activation">Change my password</button>
        </form>
        <p><?php echo $mensaje ?? ""; ?></p>
        </div>
    </body>
    </html>