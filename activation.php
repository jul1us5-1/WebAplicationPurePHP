<?php
session_start();

// Revisar si hay un mensaje en la sesión
$mensaje = '';
$redirect_url = '';
$redirect_time = 0;

if (isset($_SESSION['mensaje_activacion'])) {
    $mensaje = $_SESSION['mensaje_activacion'];
    // Borrar el mensaje para que no aparezca al recargar la página
    unset($_SESSION['mensaje_activacion']);
}
if (isset($_SESSION['redirect_url'])) {
    $redirect_url = $_SESSION['redirect_url'];
    // Borrar el mensaje para que no aparezca al recargar la página
    unset($_SESSION['redirect_url']);
}
if (isset($_SESSION['redirect_time'])) {
    $redirect_time = $_SESSION['redirect_time'];
    // Borrar el mensaje para que no aparezca al recargar la página
    unset($_SESSION['redirect_time']);
}
?>

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
        <form action="activation_backend.php" method="POST" class="form-register">
            <h2>Activation</h2>
            <input type="text" name="email" placeholder="Insert your email" required>
            <input type="text" name="activation_code" placeholder="Insert your activation code" required>
            <button type="submit" class="submit" name="submit-Activation">Activate</button>
        </form>
        <p> <?= $mensaje; ?> </p>
    </div>
    <?php if ($redirect_url && $redirect_time > 0): ?>
    <script>
        setTimeout(function() {
            window.location.href = "<?= $redirect_url ?>";
        }, <?= $redirect_time * 1000 ?>);
    </script>
    <?php endif; ?>
</body>
</html>