<?php
include('session.php');
require_once('db.php');

//<input type="hidden" name="id_post" value="<?php echo $id_post;">
//<input type="text" name="contenido" placeholder="Escribe un comentario..." required>
//button type="submit" class="btn-send-comment"><i class="fas fa-paper-plane"></i></button>

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contenido'])){
    $id_post = $_POST['id_post'];
    $contenido = trim($_POST['contenido']);
    $contenido_com = strip_tags($contenido);
    $user_id = $_SESSION['id'];
    if(!empty($contenido_com)){
        $stmt = $conn->prepare("INSERT INTO comentarios (id_post, user_id, contenido) VALUES (?, ?, ?)");
        $stmt->bind_param("iis",$id_post,$user_id,$contenido_com);
        if ($stmt->execute()) {
            // 6. Si fue exitoso, regresamos a la página de donde venía el usuario
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "We can't save the comment: " . $conn->error;
        }
    }else {
        // Si el texto estaba vacío, regresamos sin hacer nada
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}else{
    header("Location: controlPanel.php");
    exit();
}
?>