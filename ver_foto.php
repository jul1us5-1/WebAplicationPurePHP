<?php
include 'session.php'; 
require_once('db.php');

// Change 'id' to 'id_p' to clarify things
if (isset($_GET['id_p'])) {
    $id_post = $_GET['id_p'];
    // Search the image asociated to the specific ID 
    $stmt = $conn->prepare("SELECT imagen FROM publicaciones WHERE id_post = ?");
    $stmt->bind_param("i", $id_post);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $nombre_archivo = $row['imagen'];
        $ruta_real = "uploads/" . $nombre_archivo;
        if ($nombre_archivo && file_exists($ruta_real)) {
            $ext = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));
            // MIME's types mapping for pictures
            $mimetypes = [
                'jpg'  => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png'  => 'image/png',
                'gif'  => 'image/gif'
            ];
            $content_type = $mimetypes[$ext] ?? 'application/octet-stream';
            header("Content-Type: $content_type");
            header("Content-Length: " . filesize($ruta_real));
            readfile($ruta_real);
            exit;
        }
    }
}
// Si no hay id_p o no existe la imagen, no mostramos nada
header("HTTP/1.0 404 Not Found");
?>