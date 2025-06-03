<?php
session_start();
require_once 'conectar.php';

$conexion = new Conectar("localhost", "root", "", "chordbeats");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $usuario = $conexion->hacer_consulta_resultado("SELECT username FROM usuario WHERE id = ?", "i", [$id]);

    if ($usuario) {
        $_SESSION['id_usuario'] = $id;
        $_SESSION['nombre'] = $usuario[0]['username'];

        // Redirigir al listado de chats
        header("Location: listado_chats.php");
        exit;
    } else {
        echo "❌ Usuario no encontrado.";
    }
} else {
    echo "❌ ID de usuario no proporcionado.";
}
