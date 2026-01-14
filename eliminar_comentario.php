<?php
include('session.php');
require_once('db.php');
// 1. VALIDACIÓN: ¿Existe la variable en la URL?
if(isset($_GET['id_c'])){
    $id_comentario = $_GET['id_c'];

    // 2. CONSULTA DE VERIFICACIÓN
    $stmt = $conn->prepare("SELECT user_id FROM comentarios WHERE id_comentario = ?");
    $stmt->bind_param("i", $id_comentario);
    
    if($stmt->execute()){
        $result = $stmt->get_result();
        
        if($row = $result->fetch_assoc()){
            
            // 3. AUTORIZACIÓN: ¿Es dueño O es admin?
            // Nota: isset() en es_admin evita errores si la variable no está definida
            $es_admin = isset($_SESSION['es_admin']) && $_SESSION['es_admin'] == 1;
            
            if($row['user_id'] == $_SESSION['id'] || $es_admin){
                
                // 4. ELIMINACIÓN
                $stmt2 = $conn->prepare("DELETE FROM comentarios WHERE id_comentario = ?");
                $stmt2->bind_param("i", $id_comentario);
                $stmt2->execute();
                $stmt2->close();
                
            } else {
                echo '
                <div class="mensaje-error">
                    <i class="fas fa-exclamation-circle"></i> 
                    No tienes permiso para eliminar este comentario.
                </div>';
            }
        }
    }
    $stmt->close();
}

$pagina_anterior = $_SERVER['HTTP_REFERER'] ?? 'controlPanel.php';
header("Location: $pagina_anterior");
exit();
?>