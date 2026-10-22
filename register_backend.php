<?php

//PHP MAILER
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//CONEXION AL SERVER

require_once __DIR__ . '/db.php';

//------------------
// 1. VERIFICAR reCAPTCHA
//------------------
require_once __DIR__ . '/config.php';
$secret = env('RECAPTCHA_SECRET');
$response = $_POST['g-recaptcha-response'];
$remoteip = $_SERVER['REMOTE_ADDR'];

$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip");
$captcha_success = json_decode($verify);

if (!$captcha_success->success) {
    die("Error: Debes completar el captcha correctamente.");
}
//DATOS FORMULARIO
$fullname = mysqli_real_escape_string($conn,$_POST['fullname']);
$user = mysqli_real_escape_string($conn,$_POST['user']);
$mail = mysqli_real_escape_string($conn,$_POST['mail']);
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

//VERIFICACION DE DOMIMIO DLE 
$domain = substr(strrchr($mail, "@"), 1);
if(!checkdnsrr($domain,'MX')){
    die("El dominio del correo ingresado no existe o no acepta correos.");
}

//password confirmation
if($password != $password_confirm){
    die("Las contraseñas no coinciden");
}
//password hash
$password_hash = password_hash($password,PASSWORD_DEFAULT);

//creamos codigo de activacion
$caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$activation_code = '';
for($i = 0; $i < 6; $i++){
    $activation_code .= $caracteres[random_int(0,strlen($caracteres) - 1)];
}
//creamos el tiempo de expiracion del codigo
$code_expiration = date('Y-m-d H:i:s', time() + 5*60);

//Registramos el usuario
$sql = "INSERT INTO users (fullname, username, email, password_has, activation_code, code_expiration, is_active)
        VALUES ('$fullname', '$user', '$mail', '$password_hash', '$activation_code', '$code_expiration', 0)";
//ENVIAMOS EL EMAIL CON PHPMAILER
$mailSender = new PHPMailer(true);
try{
    $mailSender->isSMTP();
    $mailSender->Host = env('SMTP_HOST', 'smtp.gmail.com');
    $mailSender->SMTPAuth = true;
    $mailSender->Username = env('SMTP_USER');  // configurado en .env
    $mailSender->Password = env('SMTP_PASS');  // contraseña de aplicación, en .env
    $mailSender->SMTPSecure = 'tls';
    $mailSender->Port = (int) env('SMTP_PORT', 587);

    $mailSender->setFrom(env('MAIL_FROM', env('SMTP_USER')), env('MAIL_FROM_NAME', 'Registro'));
    $mailSender->addAddress($mail);

    $mailSender->isHTML(true);
    $mailSender->Subject = 'Activa tu cuenta';
    $mailSender->Body    = "Tu código de activación es: <b>$activation_code</b><br><br>
                         Este código expira en 5 minutos.";
    $mailSender->send();
}catch(Exception $e){
    die("Error al enviar correo: {$mailSender->ErrorInfo}");
}

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    header("Location: activation.php");  
    exit;
} else {
    mysqli_close($conn);
    die("Error: " . mysqli_error($conn));
}

?>