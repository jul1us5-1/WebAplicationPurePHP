<?php 
include("session.php"); 
require_once('db.php');
//info importante
$id = $_SESSION['id'];

//sacamos toda la info

$fullname = trim($_POST['fullname']);
$username = trim($_POST['user']);
$email = trim($_POST['mail']);
$new_password = $_POST['password'];
$new_password_comf = $_POST['password_confirm'];
$password_original = $_POST['password_original'];

//creo que primero tendríamos que verificar la validez del nuevo email
$email = trim($email);

if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $_SESSION['mensaje_editar_perfil'] = "Error: El formato del correo es inválido";
    header("Location: editar_perfil.php");
    exit;
}
$domain = substr(strrchr($email, "@"), 1);
if (!checkdnsrr($domain, 'MX')) {
    $_SESSION['mensaje_editar_perfil'] = "El dominio del correo ingresado no es válido o no puede recibir mensajes.";
    header("Location: editar_perfil.php");
    exit;
}

// VERIFICAR reCAPTCHA
$secret = "TU_RECAPTCHA_SECRET";
$response = $_POST['g-recaptcha-response'];
$remoteip = $_SERVER['REMOTE_ADDR'];

$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip");
$captcha_success = json_decode($verify);

if (!$captcha_success->success) {
    $_SESSION['mensaje_editar_perfil'] = "Error: Debes completar el captcha correctamente.";
    header("Location: editar_perfil.php");
    exit;
}
//hacemos consulta sql para verificar que la contraseña original coincida
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$password_has = $row['password_has'];

//verificamos que la contraseña este bien
if(!$row || !password_verify($password_original,$password_has)){
    $_SESSION['mensaje_editar_perfil'] = "La antigua contraseña es incorrecta";
    header("Location: editar_perfil.php");
    exit;
}
//si el usuario puso una nueva contraseña
if(!empty($new_password)){
    //verificamos que ambas contraseñas sean lo mismo tambien
    if($new_password != $new_password_comf){
        $_SESSION['mensaje_editar_perfil'] = "Las contraseñas no coinciden";
        header("Location: editar_perfil.php");
        exit;
    }
    $final_password = password_hash($new_password,PASSWORD_DEFAULT);
}else{
    $final_password = $password_has;
}

//si todo esta corercto procedemos 
$sql_upd = "UPDATE users SET fullname = ?, username = ?, email = ?, password_has = ? WHERE id = ?";
$stmt_upd = $conn->prepare($sql_upd);
$stmt_upd->bind_param("ssssi",$fullname,$username,$email,$final_password,$id);

if($stmt_upd->execute()){
    $_SESSION['mensaje_editar_perfil'] = "Perfil actualizado correctamente";
    // Actualiza la sesión para que los cambios se vean ya
    $_SESSION['name'] = $fullname;
} else {
    $_SESSION['mensaje_editar_perfil'] = "Error al actualizar.";
}
header("Location: editar_perfil.php");
exit;
?>