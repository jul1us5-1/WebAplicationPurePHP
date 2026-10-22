    <?php
session_start();
//CONEXION AL SERVER

require_once __DIR__ . '/db.php';
//Verificamos si esq esta el email

if(!isset($_POST['email'])){
    header("Location: resetPassword.php");
    exit;
}

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
//Obtenemos los datos

$email = $_POST['email'];
$password1 = mysqli_real_escape_string($conn,$_POST['password1']);
$password2 = mysqli_real_escape_string($conn,$_POST['password2']);

//verificamos la coincidencia de las contraseñas
if($password1 !== $password2){
    $_SESSION['mensaje'] = "Las contraseñas no coinciden :(";
    header("Location: changePassword.php");
    exit;
}
// Validar longitud mínima
if(strlen($password1) < 8){
    $_SESSION['mensaje'] = "La contraseña debe tener al menos 8 caracteres.";
    header("Location: changePassword.php");
    exit;
}

// Verificar que contenga letras y números
if(!preg_match('/[a-zA-Z]/', $password1) || !preg_match('/[0-9]/', $password1)){
    $_SESSION['mensaje'] = "La contraseña debe contener letras y números.";
    header("Location: changePassword.php");
    exit;
}

//hasheamos la contraseña
$hashed_password = password_hash($password1,PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password_has = ?, activation_code = NULL, 
code_expiration = NULL WHERE email = ?");
$stmt->bind_param("ss",$hashed_password,$email);

if($stmt->execute()){
    $_SESSION['mensaje'] = "Contraseña cambiada correctamente.";
    header("Location: login.php"); // redirige al login
    exit;
}else{
    $_SESSION['mensaje'] = "Error al actualizar la contraseña.";
    header("Location: changePassword.php");
    exit;
}
?>