<?php
session_start();
require_once 'conectar.php';

if (!isset($_SESSION['id_usuario']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$bbdd = new Conectar("localhost", "root", "", "chordbeats");

$id_usuario = $_SESSION['id_usuario'];
$id_chat = intval($_GET['id']); // Seguridad básica

// Envío de mensaje
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['mensaje'])) {
    $mensaje = $_POST['mensaje'];
    $fecha = date("Y-m-d H:i:s");

    $consulta = "INSERT INTO mensajes (id_chats, id_usuario, mensaje, fecha) VALUES (?, ?, ?, ?)";
    $bbdd->hacer_consulta($consulta, "iiss", [$id_chat, $id_usuario, $mensaje, $fecha]);
}

// Obtener mensajes de este chat
$consulta = "SELECT id_usuario, mensaje, fecha, usuario.username as username, usuario.foto_perfil as foto_perfil FROM mensajes JOIN usuario ON usuario.id = mensajes.id_usuario WHERE id_chats = $id_chat ORDER BY fecha ASC";
$mensajes = $bbdd->recibir_datos($consulta);
$consulta2 = "
SELECT 
    chats.id AS id_chats,
    u.id AS usuario_id,
    u.username as nombre,
    u.foto_perfil
FROM chats
JOIN usuario u 
    ON (u.id = chats.id_usuario1 AND chats.id_usuario2 = $id_usuario)
    OR (u.id = chats.id_usuario2 AND chats.id_usuario1 = $id_usuario)
WHERE chats.id = $id_chat
;";
$mensajes2 = $bbdd->recibir_datos($consulta2);
?>

<link rel="stylesheet" href="/css/chat.css">

<div class="chat-container">
    <div class="chat-header" <?php foreach ($mensajes2 as $msg2): ?>>
            <a href="spotify-card.php">
                <img src="<?= htmlspecialchars($msg2['foto_perfil']) ?>" alt="Logo" class="chat-logo">
            </a>
            <h1 class="chat-title"><?= htmlspecialchars($msg2['nombre']) ?></h1>
        </div>
        <a href="listado_chats.php" class="back-button" title="Volver a chats">
            <img src="/img/atras.png" width="30px" alt="Volver">
        </a>
    <?php endforeach; ?>
    <div class="chat-box">
        <?php foreach ($mensajes as $msg): ?>
            <div class="chat-message 
                <?= $msg['id_usuario'] == $id_usuario ? 'chat-message-right' : 'chat-message-left' ?>">
                <?= htmlspecialchars($msg['mensaje']) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Formulario de envío -->
    <form class="chat-form" method="POST">
        <input type="text" name="mensaje" placeholder="Escribe un mensaje..." required>
        <button type="submit">Enviar</button>
    </form>
</div>