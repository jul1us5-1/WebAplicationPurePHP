    <?php
    session_start();
    require_once __DIR__ . '/db.php';

    $usser_mail = mysqli_real_escape_string($conn,$_POST['user-mail']);
    $password = $_POST['password'];

    $consulta = "SELECT id,password_has,fullname,es_admin FROM users WHERE username = '$usser_mail' or email = '$usser_mail'";
    $resultado = mysqli_query($conn,$consulta);
    if(mysqli_num_rows($resultado) == 1){
        //verificamos si la contraseña esta correcta
        //para eso tenemos que deshashear
        $row = mysqli_fetch_assoc($resultado);
        $hashed_password = $row['password_has'];
        if(password_verify($password,$hashed_password)){
            $_SESSION['mensaje'] = "Login exitoso! ";
            $_SESSION['name'] = $row['fullname'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['es_admin'] = $row['es_admin'];
            $_SESSION['modo_incognito'] = false;
            header("Location: controlPanel.php");
            exit;
        }else{
            $_SESSION['mensaje'] = "Usuario o contraseña incorrectos";
            header("Location: login.php");
            exit;
        }
    }else{
        $_SESSION['mensaje'] = "Usuario o contraseña incorrectos";
        header("Location: login.php");
        exit;
    }
    mysqli_close($conn);
    exit;
    ?>