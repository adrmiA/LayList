<?php
require_once("database.php");

$error_login = "";
$error_registro = "";

function clearErrors() {
    global $error_login, $error_registro;
    $error_login = "";
    $error_registro = "";
}

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login_email"])) {
        $email = $_POST["login_email"];
        $password = $_POST["login_password"];

        $sql = "SELECT id, contrasena FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            if (password_verify($password, $usuario['contrasena'])) {
                session_start();
                $_SESSION["usuario_id"] = $usuario['id'];
                header("Location: panelusuario.php");
                exit();
            } else {
                $error_login = "Contraseña incorrecta.";
            }
        } else {
            $error_login = "Correo electrónico no encontrado.";
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register_submit"])) {
        $nombre = $_POST["register_nombre"];
        $email = $_POST["register_email"];
        $password = $_POST["register_password"];

        $sql_check = "SELECT email FROM usuarios WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->execute([$email]);

        if ($stmt_check->fetch(PDO::FETCH_ASSOC)) {
            $error_registro = "e-mail existente";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (nombre, email, contrasena) VALUES (:nombre, :email, :contrasena)";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['nombre' => $nombre, 'email' => $email, 'contrasena' => $hashed_password]);

            if ($stmt->rowCount() > 0) {
              $usuario_id = $conn->lastInsertId();
              $foto_perfil = "IMG/perfil_" . $usuario_id . ".jpg"; 
              copy("IMG/default_perfil.jpg", $foto_perfil);
              $sql_foto = "UPDATE usuarios SET foto_perfil = ? WHERE id = ?";
              $stmt_foto = $conn->prepare($sql_foto);
              $stmt_foto->execute([$foto_perfil, $usuario_id]);
              $error_registro = "Registro exitoso. Ahora puedes iniciar sesión.";
            } else {
                $error_registro = "Error al registrar el usuario.";
                var_dump($nombre, $email, $hashed_password);
            }
        }
    }
} catch (PDOException $e) {
    $error_registro = "Error de base de datos: " . $e->getMessage();
    $error_login = "Error de base de datos";
} catch (Exception $e) {
    $error_registro = "Error inesperado: " . $e->getMessage();
    $error_login = "Error inesperado";
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    clearErrors();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LayList</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/registro.css">
    <link rel="stylesheet" href="CSS/global.css">
</head>
<body>
    <div class="menu">
        <a href="about_me.php">Acerca</a>
        <a href="registro.php">To-do List</a>
    </div>

    <main>
        <div class="img-logo">
            <img src="IMG/logo.png" alt="Logo">
        </div>
        <div class="contenedor_todo">
            <div class="caja_trasera">
                <div class="caja_trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn_iniciar-sesion">Iniciar Sesión</button>
                </div>
                <div class="caja_trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <button id="btn_registrarse">Regístrarse</button>
                </div>
            </div>

            <div class="contenedor_login-register">
                <form action="" method="POST" class="formulario_login">
                    <h2>Iniciar Sesión</h2>
                    <input type="text" name="login_email" placeholder="Correo Electronico">
                    <input type="password" name="login_password" placeholder="Contraseña">
                    <button>Entrar</button>
                    <p class="error-message"><?php echo $error_login; ?></p>
                </form>

                <form action="" method="POST" class="formulario__register">
                    <h2>Regístrarse</h2>
                    <input type="text" name="register_nombre" placeholder="Nombre completo">
                    <input type="text" name="register_email" placeholder="Correo Electronico">
                    <input type="password" name="register_password" placeholder="Contraseña">
                    <button type="submit" name="register_submit">Regístrarse</button>
                    <p class="error-message"><?php echo $error_registro; ?></p>
                </form>
            </div>
        </div>

    </main>

    <script src="./JS/scriptRegistro.js"></script>
</body>
<footer class="footer">
    © 2025 Lay-List | Todos los derechos reservados
