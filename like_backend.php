<?php
include('session.php');
require_once('db.php');

if(!empty($_GET['id_post'])){
    $id_post_rec = $_GET['id_post'];
    $id_user_orig = $_SESSION['id'];
    //primero deberiamos chekear si existe el like si existe lo quitamos y si no lo agregamos
    $stmt = $conn->prepare("SELECT id_like FROM likes where id_post = ? and user_id = ?");
    $stmt->bind_param("ii",$id_post_rec,$id_user_orig);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $delete = $conn->prepare("DELETE FROM likes WHERE id_post = ? AND user_id = ?");
        $delete->bind_param("ii", $id_post_rec, $id_user_orig);
        $delete->execute();
    }else{
        $insert = $conn->prepare("INSERT INTO likes (id_post, user_id) VALUES (?, ?)");
        $insert->bind_param("ii",$id_post_rec,$id_user_orig);
        $insert->execute();
    }
}
header("Location: controlPanel.php");
exit();


?>