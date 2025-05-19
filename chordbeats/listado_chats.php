<?php
session_start();
require_once 'conectar.php';

// Conexión a la base de datos (ajusta los parámetros)
$bbdd = new Conectar("localhost", "root", "", "chordbeats");

$id_usuario = $_SESSION['id_usuario'];

// Consulta para obtener los chats en los que el usuario está involucrado
$consulta = "
SELECT 
    chats.id AS id_chats,
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
<link rel="stylesheet" href="/css/listado_chats.css">

<!-- Contenedor -->
<div class="chat-container">
    <h2 class="chat-title">Mis conversaciones</h2>
    <div class="chat-box">
        <?php if (!empty($chats)): ?>
            <?php foreach ($chats as $chat): ?>
                <a href="chat.php?id=<?= $chat['id_chats'] ?>" class="chat-header chat-preview">
                    <img class="chat-logo" src="<?= htmlspecialchars($chat['foto_perfil']) ?>" alt="Foto de perfil">
                    <p class="chat-title"><?= htmlspecialchars($chat['nombre']) ?></p>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="chat-title">No tienes conversaciones aún.</p>
        <?php endif; ?>
    </div>

    <!-- Botón volver -->
    <a href="index.php" class="volver-btn">Volver al inicio</a>
</div>
</div>