<?php
session_start();
require_once 'conectar.php';

// Conexión a la base de datos (ajusta los parámetros)
$bbdd = new Conectar("localhost", "root", "", "chordbeats");

$id_usuario = $_SESSION['id_usuario'];

// Consulta para obtener los chats en los que el usuario está involucrado
$consulta = "
SELECT 
    chats.id AS id_chat,
    u.id AS usuario_id,
    u.username as nombre,
    u.foto_perfil
FROM chats
JOIN usuario u 
    ON (u.id = chats.id_usuario1 AND chats.id_usuario2 = $id_usuario)
    OR (u.id = chats.id_usuario2 AND chats.id_usuario1 = $id_usuario)
";

$chats = $bbdd->recibir_datos($consulta);
?>

<!-- Estilos -->
<link rel="stylesheet" href="/css/chat.css">

<!-- Contenedor -->
<div class="chat-container">
    <h2 class="chat-title">Tus conversaciones</h2>
    <div class="chat-box">
        <?php if (!empty($chats)): ?>
            <?php foreach ($chats as $chat): ?>
                <div class="chat-header">
                    <img class="chat-logo" src="<?= htmlspecialchars($chat['foto_perfil']) ?>" alt="Foto de perfil">
                    <p class="chat-title"><?= htmlspecialchars($chat['nombre']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No tienes conversaciones aún.</p>
        <?php endif; ?>
    </div>
</div>