<?php
include('session.php');
require_once('db.php');

if(isset($_GET['id_p'])){
    $id_post = $_GET['id_p'];
    $user_id = $_SESSION['id'];
    $es_admin = $_SESSION['es_admin'];

    $stmt = $conn->prepare("SELECT imagen FROM publicaciones WHERE id_post = ?");
    $stmt->bind_param("i",$id_post);
    $stmt->execute();
    $result = $stmt->get_result();
    if($row = $result->fetch_assoc()){
        $dueno_post = $row['user_id'];
        $nombre_imagen = $row['imagen'];
        //validacion de seguridad 2, es dueño o es el admin? 
        if($dueno_post == $user_id || $es_admin == 1){
            

            $del = $conn->prepare("DELETE FROM publicaciones WHERE id_post = ? AND user_id = ?");
            $del->bind_param("ii",$id_post,$dueno_post);

            if($del->execute()){
                if ($nombre_imagen && file_exists("uploads/" . $nombre_imagen)) {
                    unlink("uploads/" . $nombre_imagen);
                }
                $location = ($es_admin == 1) ? "controlPanel.php":"perfil.php";
                header("Location: $location?success=deleted");
                exit();
            }
        }else{
            header("Location: controlPanel.php?error=unauthorized");
            exit();
        }
    }
}


?>