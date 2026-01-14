<?php
require_once('db.php');

function mostrarComentarios($id_post, $id_visitante, $solo_propios = false) {
    global $conn;
    
    // Ensure session is started to access $_SESSION['es_admin']
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Prepare query based on whether we filter by user
    if ($solo_propios) {
        $stmt = $conn->prepare("SELECT c.*, u.fullname FROM comentarios c JOIN users u ON c.user_id = u.id 
                                WHERE c.id_post = ? AND c.user_id = ? ORDER BY c.fecha_comentario DESC");
        $stmt->bind_param("ii", $id_post, $id_visitante);
    } else {
        $stmt = $conn->prepare("SELECT c.*, u.fullname FROM comentarios c JOIN users u ON c.user_id = u.id 
                                WHERE c.id_post = ? ORDER BY c.fecha_comentario DESC");
        $stmt->bind_param("i", $id_post);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo '<div class="comentarios-lista">';
    while ($com = $result->fetch_assoc()) {
        echo '<div class="comentario-item">';
        echo '<strong>' . htmlspecialchars($com['fullname']) . '</strong>: ';
        echo '<span>' . nl2br(htmlspecialchars($com['contenido'])) . '</span>';
        
        // Check if the current user is the comment author or an admin
        $es_autor = ($com['user_id'] == $id_visitante);
        $es_admin = (isset($_SESSION['es_admin']) && $_SESSION['es_admin'] == 1);

        if ($es_autor || $es_admin) {
            echo ' <a href="eliminar_comentario.php?id_c=' . $com['id_comentario'] . '" 
                     class="btn-borrar-comentario" 
                     onclick="return confirm(\'¿Borrar comentario?\')">
                     <i class="fas fa-times" style="color:red;"></i>
                   </a>';
        }
        echo '</div>';
    }
    echo '</div>';
}

// Updated function signature to accept the visitor's ID
function mostrarPublicacion($row, $id_visitante, $permitir_eliminar = false, $solo_mis_comentarios = false) {
    global $conn;
    $fullname = htmlspecialchars($row['fullname']);
    $fecha = date("d M, H:i", strtotime($row['fecha_publicacion']));
    $contenido = nl2br(htmlspecialchars($row['contenido']));
    $id_post = $row['id_post'];
    $imagen = $row['imagen'];
    $usuario_real = isset($_SESSION['id']) && $_SESSION['id'] > 0 && empty($_SESSION['modo_incognito']);
    // REMOVED: $id_usuario_actual = $row['user_id']; 
    // We now use the passed $id_visitante

    ?>
    <article class="post-card">
        <div class="post-header">
            <img src="https://ui-avatars.com/api/?name=<?php echo $fullname; ?>&background=random" class="avatar-mini">
            <div class="post-info">
                <span class="post-author"><?php echo $fullname; ?></span>
                <span class="post-date"><?php echo $fecha; ?></span>
            </div>
        </div>

        <div class="post-body">
            <p><?php echo $contenido; ?></p>
            <?php if (!empty($imagen)): ?>
                <div class="post-img-container">
                    <img src="ver_foto.php?id_p=<?php echo $id_post; ?>" class="post-img">
                </div>
            <?php endif; ?>
        </div>
        <div class="post-footer">
            <?php if($usuario_real): ?>
                <?php 
                    // 1. Usar un nombre de variable consistente
                    $stmt_l = $conn->prepare("SELECT COUNT(*) as total FROM likes WHERE id_post = ?");
                    $stmt_l->bind_param("i", $id_post);
                    $stmt_l->execute();
                    $res_likes = $stmt_l->get_result();
                    $data_likes = $res_likes->fetch_assoc();
                    $total_likes = $data_likes['total'];
                ?>
                <div class="interact-actions">
                    <button class="btn-interact" id = "btn-like" onclick="window.location.href='like_backend.php?id_post=<?php echo $id_post; ?>'">
                        <i class="far fa-thumbs-up"></i>Like
                        <span class="likes-count">(<?php echo $total_likes; ?>)</span>
                    </button>
                    
                    <button class="btn-interact" onclick="document.getElementById('comentario-input-<?php echo $id_post; ?>').focus()">
                        <i class="far fa-comment"></i> Comentar
                    </button>
                </div>
            <?php endif; ?>

            <?php 
            // Verificación de permisos para eliminar
            if ($permitir_eliminar || (isset($_SESSION['es_admin']) && $_SESSION['es_admin'] == 1)): ?>
                <a href="eliminar_post.php?id_p=<?php echo $id_post; ?>" class="btn-eliminar" onclick="return confirm('¿Estás seguro?');">
                    <i class="fas fa-trash-alt"></i> Eliminar
                </a>
            <?php endif; ?>
        </div>
        
        <div class="post-comments-section">
            <?php 
            // Pass the visitor ID correctly to the comments function
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            mostrarComentarios($id_post, $id_visitante, $solo_mis_comentarios); 
            ?>
            <?php if($usuario_real):?>
                <form action="guardar_comentario.php" method="POST" class="comment-form">
                    <input type="hidden" name="id_post" value="<?php echo $id_post; ?>">
                    <input type="text" name="contenido" id="comentario-input-<?php echo $id_post; ?>" placeholder="Escribe un comentario..." required>
                    <button type="submit" class="btn-send-comment"><i class="fas fa-paper-plane"></i></button>
                </form>
            <?php endif;?>
        </div>
    </article>
    
    <style>
        .btn-eliminar {
            color: #e74c3c;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 6px;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-eliminar:hover {
            background-color: #fdeaea;
            color: #c0392b;
        }
        .btn-eliminar i {
            font-size: 1rem;
        }
        /* Estilos tipo Red Social */
        .post-comments-section {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-top: 1px solid #eee;
            border-radius: 0 0 12px 12px;
        }

        .comentario-item {
            background: #ebedf0;
            padding: 8px 12px;
            border-radius: 18px;
            margin-bottom: 8px;
            font-size: 0.9rem;
            width: fit-content;
            max-width: 90%;
            position: relative; /* Para posicionar la X */
            padding-right: 30px; /* Espacio para la X */
        }

        .comentario-item strong {
            display: block;
            font-size: 0.8rem;
            color: #1c1e21;
        }

        .comment-form {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            align-items: center;
        }

        .comment-form input {
            flex: 1;
            border: 1px solid #ddd;
            padding: 8px 15px;
            border-radius: 20px;
            outline: none;
            font-size: 0.9rem;
        }

        .btn-send-comment {
            background: none;
            border: none;
            color: #007bff;
            cursor: pointer;
            font-size: 1.1rem;
        }

        .btn-send-comment:hover { color: #0056b3; }

        .btn-borrar-comentario {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            text-decoration: none;
            font-weight: bold;
            opacity: 0.6;
            transition: 0.2s;
        }

        .btn-borrar-comentario:hover {
            opacity: 1;
            transform: translateY(-50%) scale(1.2);
        }
        .mensaje-error {
            background-color: #ffebee; /* Fondo rojo muy suave */
            color: #c62828;            /* Texto rojo oscuro */
            border: 1px solid #ef9a9a; /* Borde rojo suave */
            padding: 15px;
            margin: 20px auto;
            border-radius: 8px;
            text-align: center;
            max-width: 600px;
            font-weight: 500;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .no-posts{
            color: black;
        }
        /* Contenedor principal del footer */
        .post-footer {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between; /* Separa interacción de eliminar */
            padding: 10px 15px;
            border-top: 1px solid #eee;
            background-color: #fafafa;
        }

        /* Grupo de botones (Like y Comentar) */
        .interact-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        /* Estilo base para los botones de interacción */
        .btn-interact {
            background: none;
            border: none;
            color: #65676b; /* Gris estilo Facebook/Instagram */
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background 0.2s, color 0.2s;
            padding: 8px 12px;
            border-radius: 6px;
        }
        /* Efecto Hover para Like y Comentar */
        .btn-interact:hover {
            background-color: rgba(0, 0, 0, 0.05);
            color: #000;
        }

        /* El contador de likes al lado del texto */
        .likes-count {
            font-size: 0.9rem;
            color: #444;
            font-weight: bold;
            margin-left: -5px; /* Lo acerca un poco al icono */
        }

        /* Botón de Eliminar (Rojo para advertencia) */
        .btn-eliminar {
            color: #dc3545;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 8px 12px;
            border-radius: 6px;
            transition: 0.3s;
        }

        .btn-eliminar:hover {
            background-color: #fff1f0;
            color: #a71d2a;
        }

        /* Iconos de FontAwesome (si los usas) */
        .btn-interact i, .btn-eliminar i {
            font-size: 1.1rem;
        }
    </style>
    <?php
}
?>