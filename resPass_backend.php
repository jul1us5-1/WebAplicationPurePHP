<?php
//PHP MAILER
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//CONEXION AL SERVER

require_once __DIR__ . '/db.php';

$emailUser = mysqli_real_escape_string($conn,$_POST['email_usser']);

// verificamos si existe
$sql1 = "SELECT id, email FROM users WHERE email = '$emailUser'";
$result = mysqli_query($conn,$sql1);
if(mysqli_num_rows($result) === 0){
    die("There is no account linked to your email or username");
}

$row = mysqli_fetch_assoc($result);
$id = $row['id'];

// creamos el activation_code 
$caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$activation_code = '';
for($i = 0; $i < 6; $i++){
    $activation_code .= $caracteres[random_int(0,strlen($caracteres) - 1)];
}
//creamos el tiempo de expiracion del codigo
$code_expiration = date('Y-m-d H:i:s', time() + 5*60);

//Updateamos en la DB
$sql2 = "UPDATE users SET activation_code = '$activation_code', code_expiration = '$code_expiration' where
id = '$id'";
$result2 = mysqli_query($conn,$sql2);
if(!$result2){
    die("ERROR: The account could not be updated");
}
//enviamos el gmail
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
    $mailSender->addAddress($emailUser);

    $mailSender->isHTML(true);
    $mailSender->Subject = 'Recupera tu cuenta';
    $mailSender->Body    = "Tu código de recuperacion de cuenta es: <b>$activation_code</b><br><br>
                         Este código expira en 5 minutos.";
    $mailSender->send();
}catch(Exception $e){
    die("Error al enviar correo: {$mailSender->ErrorInfo}");
}
header("Location: resetPassword2.php");
exit;
?>