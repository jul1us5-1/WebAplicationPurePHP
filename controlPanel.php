<?php
include 'session.php';
$es_usuario_real = isset($_SESSION['id']) && $_SESSION['id'] > 0 && empty($_SESSION['modo_incognito']);
$clase_extra = $es_usuario_real ? '' : 'guest-mode';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleControlPanel.css">
    <link rel="icon" href="icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Control panel</title>
</head>
<body>
<nav class="navbar <?php echo $clase_extra; ?>">
    <div class="nav-left">
        <p class="welcome">
            Hi, 
            <?php
                if (isset($_SESSION['name'])) {
                    echo htmlspecialchars($_SESSION['name']); 
                } else {
                    echo "Guest"; 
                }
            ?>
        </p>
    </div>
    <ul class="nav-menu">
        <?php 
        $es_usuario_real = isset($_SESSION['id']) && $_SESSION['id'] > 0 && $_SESSION['modo_incognito']===false;
        if ($es_usuario_real): 
        ?>
            <li><a href="perfil.php">Profile</a></li>    
            <?php if(isset($_SESSION['es_admin']) && $_SESSION['es_admin'] == 1): ?>
                <li><a href="manage_users.php">Manage users</a></li>
            <?php endif; ?>
            <li><a id="salir" href="logout.php">Log out</a></li>
        <?php else: ?>
            <li><a href="login.php">Log in</a></li>
            <li><a href="register.php">Sign up</a></li> 
        <?php endif; ?>    
    </ul>
</nav>
<div class="main-feed">
    <?php if(isset($_SESSION['id']) && $_SESSION['id'] > 0 && empty($_SESSION['modo_incognito'])): ?>
        <section class="create-post-container">
            <div class="user-avatar">
                <img src="https://ui-avatars.com/api/?name=<?php echo $_SESSION['name']; ?>&background=0D8ABC&color=fff" alt="Avatar">
            </div>
            
            <form action="procesar_post.php" method="POST" enctype="multipart/form-data" class="post-form">
                <textarea name="contenido" placeholder="¿What are you thinking about, <?php echo explode(' ', $_SESSION['name'])[0]; ?>?" required></textarea>
                
                <hr class="divider">
                
                <div class="post-actions">
                    <div class="btn-upload">
                        <label for="file-upload" class="action-item">
                            <i class="fas fa-image" style="color: #45bd62;"></i> Picture/video
                        </label>
                        <div class="upload_image">
                            <input id="file-upload" type="file" name="imagen" accept="image/*" style="display: none;">
                        </div>
                    </div>  
                    <div class="action-item">
                        <i class="fas fa-smile" style="color: #f7b928;"></i>Feeling
                    </div>
                    
                    <button type="submit" name="btn-publicar" class="btn-post">Post</button>
                </div>
            </form>
        </section>
    <?php endif; ?> 
    <div id="feed">
        <?php include 'cargar_posts.php'; ?>
    </div>
</div>
    
</body>
</html>