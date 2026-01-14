<?php
include_once('funciones.php'); // Usamos include_once para evitar errores de duplicidad
require_once('db.php');

$mi_id = $_SESSION['id'];

// Consulta avanzada: Posts propios O posts ajenos donde YO comenté
$sql = "SELECT DISTINCT p.*, u.fullname, u.username 
        FROM publicaciones p 
        JOIN users u ON p.user_id = u.id 
        LEFT JOIN comentarios c ON p.id_post = c.id_post 
        WHERE p.user_id = ? OR c.user_id = ? 
        ORDER BY p.fecha_publicacion DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $mi_id, $mi_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Flag: ¿Es mi post? (Para mostrar botón eliminar post)
        $es_mio = ($row['user_id'] == $mi_id);
        
        // Llamada: (fila, tu_id, permitir_borrar_post, mostrar_solo_mis_comentarios)
        mostrarPublicacion($row, $mi_id, $es_mio, true);
    }
} else {
    echo '<div class="no-posts"><p>Aún no tienes actividad para mostrar.</p></div>';
}
?>