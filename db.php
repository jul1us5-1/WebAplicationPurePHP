<?php
require_once __DIR__ . '/config.php';

$server   = env('DB_HOST', 'localhost');
$username = env('DB_USER', 'root');
$password = env('DB_PASS', '');
$database = env('DB_NAME', 'servissana_db');

// Establecer la conexión
$conn = mysqli_connect($server, $username, $password, $database);

// Verificar la conexión
if (!$conn) {
    die("Conexion Fallida: " . mysqli_connect_error());
}

// Configurar el conjunto de caracteres a UTF-8 (Vital para tildes y ñ)
mysqli_set_charset($conn, "utf8");
?>
