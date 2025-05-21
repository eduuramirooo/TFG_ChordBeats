<?php
session_start();
require_once 'conectar.php';

if (!isset($_SESSION['id_usuario']) || !isset($_GET['chat_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos no válidos']);
    exit;
}

$bbdd = new Conectar("localhost", "root", "", "chordbeats");

$id_usuario = $_SESSION['id_usuario'];
$id_chat = intval($_GET['chat_id']);
$ultimo_id = isset($_GET['ultimo_id']) ? intval($_GET['ultimo_id']) : 0;

$consulta = "
    SELECT mensajes.id, mensajes.id_usuario, mensajes.mensaje, mensajes.fecha 
    FROM mensajes 
    WHERE mensajes.id_chats = ? AND mensajes.id > ? 
    ORDER BY mensajes.id ASC
";

$mensajes = $bbdd->hacer_consulta_resultado($consulta, "ii", [$id_chat, $ultimo_id]);

echo json_encode($mensajes);
