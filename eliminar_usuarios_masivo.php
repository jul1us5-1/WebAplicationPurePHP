<?php
include 'session.php';
require_once('db.php');

if($_SESSION['es_admin']==1 || isset($_POST['ids'])){
    $ids = $_POST['ids'];
    $ids_limpios = array_map('intval', $ids);
    $lista_ids = implode(',', $ids_limpios);
    //deleteamos publicaciones
    $conn->query("DELETE FROM publicaciones WHERE user_id IN ($lista_ids)");

    $sql = "DELETE FROM users WHERE id IN ($lista_ids) AND es_admin = '0'";
    if ($conn->query($sql)) {
        header("Location: manage_users.php?msg=vaporized");
    } else {
        echo "Error en el sistema.";
    }
}else{
    header("Location: manage_users.php");
}

?>