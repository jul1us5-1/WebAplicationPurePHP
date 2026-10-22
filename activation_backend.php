<?php
session_start();

require_once __DIR__ . '/db.php';

$email = mysqli_real_escape_string($conn, $_POST['email']);
$activation_code = mysqli_real_escape_string($conn, $_POST['activation_code']);

// Buscamos si coincide el código con ese email
$sql = "SELECT id, code_expiration 
        FROM users 
        WHERE email = '$email' 
        AND activation_code = '$activation_code'
        AND is_active = 0";
$mensaje = " ";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) === 0) {
    $_SESSION['mensaje_activacion'] = "Código incorrecto.";
    header("Location: activation.php");
    exit;
}

$row = mysqli_fetch_assoc($result);

// Verificar expiración
if (strtotime($row['code_expiration']) < time()) {
    $_SESSION['mensaje_activacion'] = "El código ha expirado. Registra de nuevo.";
    header("Location: activation.php");
    exit;
}


// Activar la cuenta
$update = "UPDATE users SET is_active = 1, activation_code = NULL, 
code_expiration = NULL WHERE email = '$email'";
if(mysqli_query($conn, $update)){
    $_SESSION['mensaje_activacion'] = "Se ha registrado correctamente";
    $_SESSION['redirect_url'] = "controlPanel.php";
    $_SESSION['redirect_time'] = 3;
     header("Location: activation.php");
}
else{
     $_SESSION['mensaje_activacion'] = "No se ha podido registrar, hay algun problema.";
     $_SESSION['redirect_url'] = null;
     header("Location: activation.php");
}
mysqli_close($conn);
exit;
