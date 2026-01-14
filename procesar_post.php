<?php
include 'session.php';
require_once('db.php');

if (isset($_POST['btn-publicar'])){
    $user_id = $_SESSION['id'];
    $contenido = trim($_POST['contenido']);
    $nombre_imagen = null;
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0){
        // --- SECURITY VALIDATION ---
        
        // 1. Check the content (MIME Type), not extension
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['imagen']['tmp_name']);
        finfo_close($finfo);

        $tipos_imagen_reales = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];

        // 2. Trying to read dimensions
        $es_imagen_real = getimagesize($_FILES['imagen']['tmp_name']);
        if (in_array($mime_type, $tipos_imagen_reales) && $es_imagen_real !== false) {
            
            // If everything is good, we proced to save the image
            $directorio = "uploads/";
            if (!is_dir($directorio)) mkdir($directorio, 0777, true);

            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $nombre_imagen = "post_" . time() . "_" . uniqid() . "." . $ext;
            
            move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $nombre_imagen);
            
        } else {
            // Aquí cae tu profesor si intenta subir un PDF renombrado a .JPG
            header("Location: controlPanel.php?error=archivo_falso");
            exit();
        }
    }
    if(!empty($contenido) || $nombre_imagen !== null){
        $sql = "INSERT INTO publicaciones (user_id, contenido, imagen) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $user_id, $contenido, $nombre_imagen);
        if ($stmt->execute()) {
            header("Location: controlPanel.php?success=post_created");
            exit();
        } else {
            echo "Error en la base de datos: " . $stmt->error;
        }
    }else {
        // Si ambos están vacíos, no publicamos nada
        header("Location: controlPanel.php?error=empty_fields");
        exit();
    }

}

?>