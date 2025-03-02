<?php
session_start();
$sesion_iniciada = isset($_SESSION["usuario_id"]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LayList</title>
    <link rel="stylesheet" href="CSS/global.css">
    <link rel="stylesheet" href="CSS/about_me.css">
</head>
<body>
    <div class="menu">
        <a href="about_me.php">Acerca</a>
        <?php if ($sesion_iniciada): ?>
            <a href="panelusuario.php">To-do List</a>
            <div class="perfil-container">
                <span id="nombre-usuario">Usuario</span>
                <img src="IMG/default_perfil.jpg" alt="Perfil" class="img-perfil" id="btn-perfil">
                <div class="menu-drop" id="menu-drop">
                    <form method="POST">
                        <button class="btn" id="btn-foto">Cambiar Foto</button>
                        <button class="btn" id="btn-sesion" onclick="window.location.href='cerrar_sesion.php'">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="container">
        <div class="about-me">
            <div class="profile-header">
                <img src="IMG/gato_corbata.jpg" alt="Mi foto" class="profile-photo">
                <h1>Adriana Bonilla</h1>
                <p class="profile-title">Creador de LayList</p>
            </div>
            <div class="profile-content">
                <p>
                    ¡Hola! Soy Adriana, la creadora de LayList. Me apasiona la productividad y la organización, y LayList es mi forma de ayudar a otros a mantenerse al día con sus tareas.
                </p>

                <h2>Mis habilidades</h2>
                <ul class="skills-list">
                    <li>Programación en Python, Java, JavaScript y HTML</li>
                    <li>Desarrollo web básico</li>
                </ul>
                <h2>Contáctame</h2>
                <div class="social-links">
                    <a href="#" class="social-link">Whatsapp</a>
                    <a href="#" class="social-link">Facebook</a>
                    <a href="#" class="social-link">Twitter</a>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        © 2025 Lay-List | Todos los derechos reservados
    </footer>
    <script src="JS/script.js"></script>
    <script src="JS/scriptFoto.js"></script>
</body>
</html>