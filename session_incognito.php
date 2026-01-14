<?php
session_start();
if(isset($_POST['btn-incognito'])){
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['modo_incognito'] = true;
// We defined the id as 0 because as a guest they dont have id
    $_SESSION['id'] = 0; 
    $_SESSION['es_admin'] = 0; // Guest is never an admin
    header("Location: controlPanel.php");   
    exit();
}else{
    header("Location: login.php");
    exit();
}
?>