<?php
//conexion a la base de datos
session_start();
require_once __DIR__ . '/db.php';
//obtenemos los valores
$email = mysqli_real_escape_string($conn,$_POST['emailUser']);
$activation_code = mysqli_real_escape_string($conn,$_POST['activation_code']);

//corremos las secuencia sql
$sql = "SELECT id,code_expiration FROM users WHERE email = '$email' and activation_code = '$activation_code'";
$resultado = mysqli_query($conn,$sql);
if(!$resultado || mysqli_num_rows($resultado) === 0){
    $_SESSION['mensaje'] = "Codigo Incorrecto";
    header("Location: resetPassword2.php");
    exit;
}
$row = mysqli_fetch_assoc($resultado);

//verificamos el expiration time
if(strtotime($row['code_expiration']) < time()){
    $_SESSION['mensaje'] = "El código ha expirado. Registra de nuevo.";
    header("Location: resetPassword2.php");
    exit;
}
//si todo esta correcto updateamos los valores y redireccionamos a un panel
//donde podra cambiar de contraseña
$sql2 = "UPDATE users SET activation_code = NULL, code_expiration = NULL where
email = '$email'";
$_SESSION['temp_mail'] = $email;
header("Location: changePassword.php");
exit;
?>