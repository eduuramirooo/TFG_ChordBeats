<?php
$token = $_GET['token'] ?? null;

if ($token) {
    // Puedes guardarlo en sesión, base de datos, etc.
    // Por ahora, solo lo mostramos
    echo "<h1>Token recibido de Spotify:</h1>";
    echo "<p>$token</p>";
} else {
    echo "<p>No se recibió ningún token.</p>";
}
?>