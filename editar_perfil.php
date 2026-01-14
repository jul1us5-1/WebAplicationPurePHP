<?php 
include("session.php"); 
require_once('db.php');
$usuario_real = isset($_SESSION['id']) && $_SESSION['id'] > 0 && empty($_SESSION['modo_incognito']);
if(!$usuario_real){
    header("Location: controlPanel.php");
    exit();
}
$name = $_SESSION['name'];
$id = $_SESSION['id'];
$mensaje = $_SESSION['mensaje_editar_perfil'] ?? "";
unset($_SESSION['mensaje_editar_perfil']);

$sql = "SELECT * from users where id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$id);
if($stmt->execute()){
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $email = $row['email'];
    $username = $row['username'];
}else{
    die("No se pudo establecer la conexion con la base de datos");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="icon.png">
    <link rel="stylesheet" href="style_editar_perfil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Edit Profile</title>
</head>
<body>
    <header class="cabecera">
        <div class="logo">Servissana</div>
        <nav>
            <a href="controlPanel.php">Inicio</a>
        </nav>
    </header>
    <div class="main-content">
        <div class = "contenedor-register">
            <!-- FORMULARIO DE EDICION -->

            <form action="editar_perfil_backend.php" method="POST" class="form-register">
                <h2>Edit Profile</h2>
                <div class = "dato-input">
                    <label>Fullname</label>
                    <input type="text" name="fullname" value = "<?php echo $name; ?>" required>
                </div>
                <div class = "dato-input">
                    <label>Username</label>
                    <input type="text" name="user" value = "<?php echo $username; ?>"required>
                </div>
                <div class = "dato-input">
                    <label>New Password (Optional)</label>
                    <div class = "password-wrapper">
                        <input type="password" name="password" class = "pass-field" placeholder="New password (optional)">
                        <i class="fas fa-eye toggle-eye"></i>
                    </div>
                </div>
                <div class = "dato-input">
                    <label>Confirm Password</label>
                    <div class = "password-wrapper">
                        <input type="password" class = "pass-field" name="password_confirm" placeholder="Confirm new password">
                        <i class="fas fa-eye toggle-eye"></i>
                    </div>
                </div>
                <div class="g-recaptcha" data-sitekey="6LcWThUsAAAAABIG_Q4Qj82Z4cfSX3zcf0J03Atq"></div>
                <div class = "dato-input">
                    <label>Old password</label>
                    <div class = "password-wrapper">
                        <input type="password" class = "pass-field" name="password_original" placeholder = "Insert your old password to proceed" required>
                        <i class="fas fa-eye toggle-eye"></i>
                    </div>
                </div>
                <button type="submit" class="submit" name="submit-Register">Change Data</button>
            </form>
            <p class = "mensaje_final"><?= $mensaje;?> </p>
        </div>
    </div>
    <script src="editar_perfil.js"></script>
</body>
</html>