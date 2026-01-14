<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$timeout = 60 * 10;

$usuario_registrado = isset($_SESSION['name']) && isset($_SESSION['id']) && $_SESSION['id'] > 0;
$usuario_incognito = isset($_SESSION['modo_incognito']) && $_SESSION['modo_incognito'] === true;
if(!$usuario_registrado && !$usuario_incognito){
    header("Location: login.php");
    exit;
}
if(isset($_SESSION['last_activity'])){
    $seconds_inactive = time() - $_SESSION['last_activity'];

    if($seconds_inactive > $timeout){
        session_unset();
        session_destroy();
        header("Location: login.php?reason=expired");
        exit;
    }
}
$_SESSION['last_activity'] = time();

if (!isset($_SESSION['es_admin'])) {
    $_SESSION['es_admin'] = 0;
}
if (!isset($_SESSION['id'])) {
    $_SESSION['id'] = 0;
}
 ?>