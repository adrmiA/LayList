<?php
// Incluir el archivo de configuración de la base de datos
require_once("database.php");

// Iniciar sesión (asumiendo que tienes un sistema de inicio de sesión)
session_start();
if (!isset($_SESSION["usuario_id"])) {
    // Redirigir a la página de inicio de sesión si no hay sesión
    header("Location: registro.php");
    exit();
}

$usuario_id = $_SESSION["usuario_id"];

try {
    // Obtener el nombre actual del usuario y la foto de perfil
    $sql_usuario = "SELECT nombre, foto_perfil FROM usuarios WHERE id = ?";
    $stmt_usuario = $conn->prepare($sql_usuario);
    $stmt_usuario->execute([$usuario_id]);
    $row_usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);

    if ($row_usuario) {
        $nombre_actual = $row_usuario["nombre"];
        $foto_perfil_actual = $row_usuario["foto_perfil"];
    } else {
        $nombre_actual = "Usuario"; // Valor predeterminado si no se encuentra el usuario
        $foto_perfil_actual = "IMG/default_perfil.jpg"; // Valor predeterminado para la foto de perfil
    }

    // Procesar el cambio de nombre
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"])) {
        $nuevo_nombre = $_POST["nombre"];
        $sql_update = "UPDATE usuarios SET nombre = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->execute([$nuevo_nombre, $usuario_id]);

        if ($stmt_update->rowCount() > 0) {
            $nombre_actual = $nuevo_nombre; // Actualizar el nombre mostrado
        } else {
            echo "Error al actualizar el nombre.";
        }
    }
} catch (PDOException $e) {
    echo "Error de base de datos: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LayList</title>
    <link rel="stylesheet" href="CSS/global.css">
    <link rel="stylesheet" href="CSS/panel.css">
    <script defer src="JS/script.js"></script> 
    <script defer src="JS/scriptFoto.js"></script> 
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> 
</head>
<body>
    <div class="menu">
        <a href="about_me.php">Acerca</a>
        <a href="panelusuario.php">To-do List</a>
        <div class="perfil-container">
            <span id="nombre-usuario"><?php echo htmlspecialchars($nombre_actual); ?></span>
            <img src="<?php echo htmlspecialchars($foto_perfil_actual); ?>" alt="Perfil" class="img-perfil" id="btn-perfil">
            <div class="menu-drop" id="menu-drop">
                <form method="POST">
                    <button class="btn" id="btn-foto">Cambiar Foto</button>
                    <button class="btn" id="btn-sesion" onclick="window.location.href='cerrar_sesion.php'">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="todo-app">
            <h2>Bandeja de entrada</h2>
            <div class="row">
                <input type="text" id="input-box" placeholder="Añadir tarea">
                <button onclick="addTask()">Agregar</button>
            </div>
            <ul id="list-container"></ul>
        </div>
    </div>
    <footer class="footer">
        © 2025 Lay-List | Todos los derechos reservados
    </footer>
</body>
</html>