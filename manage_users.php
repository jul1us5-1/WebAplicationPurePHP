<?php
include 'session.php';
require_once('db.php');
if($_SESSION['es_admin']!=1){
    header("Location: controlPanel.php");
    exit();
}
$result = $conn->query("SELECT * FROM users WHERE es_admin = '0' ORDER BY created_at ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleManage_users.css">
    <link rel="icon" href="icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Manage users</title>
</head>
<body>
<header class="cabecera">
        <div class="logo">Servissana</div>
        <nav>
            <a href="controlPanel.php"><i class="fas fa-home"></i>Go back</a>
            <a href="logout.php" class="btn-logout">Log out</a>
        </nav>
    </header>

    <main class="contenedor-perfil"> 
        <div class="tarjeta-perfil wide-card"> 
            <div class="avatar-seccion">
                <div class="avatar-circulo"><i class="fas fa-users-gear"></i></div>
                <h2>User Management</h2>
                <p class="rol">Manage users accounts (No admin)</p>
            </div>

            <form action="eliminar_usuarios_masivo.php" method="POST" id="form-manage">
                <div class="table-header-actions">
                    <button type="submit" class="btn-delete-mass">
                        <i class="fas fa-trash"></i> Delete selected
                    </button>
                    <p class="user-count">Total: <strong><?php echo $result->num_rows; ?></strong> users</p>
                </div>

                <div class="table-container">
                    <table class="user-table">
                        <thead>
                            <tr>
                                <th>All <input type="checkbox" id="selectAll"></th>
                                <th>ID</th>
                                <th>Fullname</th>
                                <th>Username</th>
                                <th>Register Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($user = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><input type="checkbox" name="ids[]" value="<?php echo $user['id']; ?>"></td>
                                    <td>#<?php echo $user['id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                                    <td>@<?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo date("d/m/y", strtotime($user['created_at'])); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </main>

    <script src="manage_users.js"></script>




</body>
</html>