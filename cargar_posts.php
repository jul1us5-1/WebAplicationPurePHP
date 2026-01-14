<?php
include_once('funciones.php');
require_once('db.php');

$mi_id = $_SESSION['id'];

$sql = "SELECT p.*, u.fullname, u.username 
        FROM publicaciones p 
        JOIN users u ON p.user_id = u.id 
        ORDER BY p.fecha_publicacion DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // 1. Allow deleting post or comments if 
        // im the owner or Admin
        $es_mio = ($row['user_id'] == $mi_id);
        
        // 2. If we want to see everyone's publications ($only_my_comments = false)
        mostrarPublicacion($row, $mi_id, $es_mio, false);
    }
} else {
    echo '<div class="no-posts">
            <i class="fas fa-ghost"></i>
            <p>Aún no hay publicaciones.</p>
          </div>';
}
?>