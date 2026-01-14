<?php 
include("session.php"); 
require_once('db.php');
if($_SESSION['modo_incognito']===true){
    header("Location: controlPanel.php");
    exit();
}
$name = isset($_SESSION['name'])? $_SESSION['name'] : "Invitado-".rand(1000,9999);
$id = isset($_SESSION['id'])? $_SESSION['id'] : "XXXXX";

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();
$result = $stmt->get_result();
$rows = $result->fetch_assoc();

$user_name = $rows['username'];
$is_active = $rows['is_active'];
$created_at = $rows['created_at'];
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_perfil.css">
    <link rel="icon" href="icon.png">
    <title>Mi Perfil - Servissana</title>
</head>
<body>

    <header class="cabecera">
        <div class="logo">Servissana</div>
        <nav>
            <a href="controlPanel.php">Control Panel</a>
            <a href="logout.php" class="btn-logout">Log out</a>
        </nav>
    </header>

    <main class="contenedor-perfil">
        <div class="tarjeta-perfil">
            <div class="avatar-seccion">
                <div class="avatar-circulo">
                    <?php echo strtoupper(substr($_SESSION['name'], 0, 1)); ?>
                </div>
                <h2>¡Hola, <?php echo $_SESSION['name']; ?>!</h2>
                <p class="rol">Usuario Registrado</p>
            </div>

            <div class="info-seccion">
                <h3>Información de la Cuenta</h3>
                <div class="dato">
                    <label>Fullname:</label>
                    <span><?php echo $_SESSION['name']; ?></span>
                </div>
                <div class="dato">
                    <label>Username:</label>
                    <span><?php echo $user_name; ?></span>
                </div>
                <div class="dato">
                    <label>Id:</label>
                    <span>
                        <?php echo $id; ?>
                    </span>
                </div>
                <div class="dato">
                    <label>Fecha de creacion:</label>
                    <span><?php echo $created_at    ; ?></span>
                </div>
                <div class="dato">
                    <label>Estado de sesión:</label>
                    <span class="tag-activo">Activo</span>
                </div>
                <div class="dato">
                    <label>Última actividad:</label>
                    <span><?php echo date("H:i:s", $_SESSION['last_activity']); ?></span>
                </div>
            </div>
            <div class="acciones">
                <button type="button" class="btn-editar">Editar Perfil</button>
            </div>
        </div>
        <div id="feed" class = "muro-usuario">
            <?php include 'cargar_posts_usuario.php'; ?>
        </div>
    </main>
<script src="perfil.js"></script>
</body>
</html>