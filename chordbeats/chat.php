<?php
require 'conectar.php';
$conexion = new Conectar("localhost", "root", "", "chordbeats");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['mensaje'])) {
    $mensaje = trim($_POST['mensaje']);
    $consulta = "INSERT INTO mensajes (mensaje, id_usuario) VALUES (?, 1)";
    $conexion->hacer_consulta($consulta, "s", [$mensaje]);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Chat - ChordBeats</title>
    <link rel="stylesheet" href="/css/chat.css">
</head>

<body>
    <div class="chat-container">
        <div class="chat-header">
            <a href="spotify-card.php">
                <img src="img/logo.png" alt="Logo" class="chat-logo">
            </a>
            <h1 class="chat-title">ChordBeats Chat</h1>
        </div>

        <div class="chat-box" id="chatBox">
            <?php
            $mensajes = $conexion->recibir_datos("SELECT mensaje, id_usuario FROM mensajes ORDER BY id ASC");
            foreach ($mensajes as $msg) {
                $clase = ($msg['id_usuario'] == 1) ? 'chat-message-right' : 'chat-message-left';
                echo "<div class='chat-message $clase'>" . htmlspecialchars($msg['mensaje']) . "</div>";
            }
            ?>
        </div>

        <form method="POST" class="chat-form">
            <input type="text" name="mensaje" placeholder="Escribe tu mensaje..." required>
            <button type="submit">Enviar</button>
        </form>
        <a href="spotify-card.php" class="volver-btn">Volver al inicio</a>
    </div>

</body>

</html>