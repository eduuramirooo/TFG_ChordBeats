<?php
session_start();
require_once 'conectar.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['id_usuario']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$bbdd = new Conectar("localhost", "root", "", "chordbeats");

$id_usuario = $_SESSION['id_usuario'];
$entrada = intval($_GET['id']); // puede ser id_chat o id_usuario_destino

// Comprobar si $entrada es un chat válido
$datos_chat = $bbdd->hacer_consulta_resultado(
    "SELECT id, id_usuario1, id_usuario2 FROM chats WHERE id = ? AND (id_usuario1 = ? OR id_usuario2 = ?)",
    "iii",
    [$entrada, $id_usuario, $id_usuario]
);

$es_chat_existente = !empty($datos_chat);
$usuario_destino = null;
$id_chat = null;
$id_otro = null;
$mensajes = [];

if ($es_chat_existente) {
    // Es un chat válido
    $id_chat = $entrada;
    $fila = $datos_chat[0];
    $id_otro = ($fila['id_usuario1'] == $id_usuario) ? $fila['id_usuario2'] : $fila['id_usuario1'];

    // Obtener mensajes
$consulta = "SELECT mensajes.id, mensajes.id_usuario, mensaje, fecha, usuario.username as username, usuario.foto_perfil as foto_perfil 
             FROM mensajes 
             JOIN usuario ON usuario.id = mensajes.id_usuario 
             WHERE mensajes.id_chats = $id_chat 
             ORDER BY mensajes.id ASC";

    $mensajes = $bbdd->recibir_datos($consulta);
} else {
    // Aún no existe el chat → tratamos $_GET['id'] como ID del otro usuario
    $id_otro = $entrada;
}

// Obtener datos del otro usuario (nombre + foto)
if ($id_otro && $id_otro != $id_usuario) {
    $usuario_destino = $bbdd->hacer_consulta_resultado(
        "SELECT id, username, foto_perfil FROM usuario WHERE id = ?",
        "i",
        [$id_otro]
    );
} else {
    die("ID inválido.");
}

// Envío de mensaje (crear chat si no existe aún)
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['mensaje'])) {
    $mensaje = $_POST['mensaje'];
    $fecha = date("Y-m-d H:i:s");

    if (!$id_chat) {
        // Crear nuevo chat
        $bbdd->hacer_consulta(
            "INSERT INTO chats (id_usuario1, id_usuario2) VALUES (?, ?)",
            "ii",
            [$id_usuario, $id_otro]
        );
        $id_chat = $bbdd->ultimo_id();
    }

    // Insertar mensaje
    $consulta = "INSERT INTO mensajes (id_chats, id_usuario, mensaje, fecha) VALUES (?, ?, ?, ?)";
    $bbdd->hacer_consulta($consulta, "iiss", [$id_chat, $id_usuario, $mensaje, $fecha]);

    header("Location: chat.php?id=$id_chat");
    exit;
}
?>


<link rel="stylesheet" href="/css/chat.css">

<div class="chat-container">
    <?php if (!empty($usuario_destino)): ?>
        <div class="chat-header">
            <a href="spotify-card.php">
                <img src="<?= htmlspecialchars($usuario_destino[0]['foto_perfil']) ?>" alt="Logo" class="chat-logo">
            </a>
            <h1 class="chat-title"><?= htmlspecialchars($usuario_destino[0]['username']) ?></h1>
        </div>
    <?php endif; ?>

    <a href="listado_chats.php" class="back-button" title="Volver a chats">
        <img src="/img/back.svg" width="30px" alt="Volver" class="icon-white">
    </a>

    <div class="chat-box">
        <?php if (empty($mensajes)): ?>
            <div class="chat-message info-message">
                Aún no hay mensajes. ¡Empieza la conversación!
            </div>
        <?php endif; ?>
<?php foreach ($mensajes as $msg): ?>
    <div class="chat-message <?= $msg['id_usuario'] == $id_usuario ? 'chat-message-right' : 'chat-message-left' ?>"
         data-id="<?= $msg['id'] ?>">
        <?= htmlspecialchars($msg['mensaje']) ?>
    </div>
<?php endforeach; ?>

    </div>

    <form class="chat-form" method="POST" action="chat.php?id=<?= $id_chat ?? $id_otro ?>">
        <input type="text" name="mensaje" placeholder="Escribe un mensaje..." required>
        <button type="submit">Enviar</button>
    </form>
</div>

<!-- Sonido de notificación -->
<audio id="chat-sound" src="/audio/match.mp3" preload="auto"></audio>

<script>
    const chatBox = document.querySelector('.chat-box');
    const sound = document.getElementById('chat-sound');
    const idChat = <?= json_encode($id_chat ?? $id_otro) ?>;
    const idUsuario = <?= json_encode($id_usuario) ?>;

    // Obtener último mensaje ya existente
    let ultimoId = 0;
    document.querySelectorAll('.chat-message').forEach(msg => {
        const id = parseInt(msg.dataset.id);
        if (id > ultimoId) ultimoId = id;
    });

    // Scroll hacia el final del chat al cargar la página
    window.addEventListener('load', () => {
        chatBox.scrollTop = chatBox.scrollHeight;
    });

    function cargarMensajes() {
        fetch(`cargar_mensajes.php?chat_id=${idChat}&ultimo_id=${ultimoId}`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    data.forEach(msg => {
                        const div = document.createElement('div');
                        div.className = 'chat-message ' +
                            (msg.id_usuario == idUsuario ? 'chat-message-right' : 'chat-message-left');
                        div.dataset.id = msg.id;
                        div.textContent = msg.mensaje;

                        chatBox.appendChild(div);
                        ultimoId = msg.id;

                        if (msg.id_usuario != idUsuario) {
                            sound.play();
                        }
                    });

                    // Scroll al fondo después de cargar mensajes nuevos
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            })
            .catch(err => console.error("Error cargando mensajes:", err));
    }

    setInterval(cargarMensajes, 1000);
</script>



