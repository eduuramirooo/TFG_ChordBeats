<?php
session_start();
require_once 'conectar.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.html");
    exit;
}

$conexion = new Conectar("localhost", "root", "", "chordbeats");

$usuarioId = $_SESSION['id_usuario'];
$nombreUsuario = $_SESSION['nombre'] ?? 'Usuario';

// Obtener usuarios ficticios que compartan al menos un artista con el usuario actual
$consulta = "
SELECT DISTINCT u.id, u.username, u.foto_perfil
FROM artista_usuario au
JOIN artista_usuario au2 ON au.artista_id = au2.artista_id
JOIN usuario u ON u.id = au2.usuario_id
WHERE au.usuario_id = ?
  AND au2.usuario_id != au.usuario_id
  AND u.spotify_id LIKE 'spotify%'
";

$afines = $conexion->hacer_consulta_resultado($consulta, "i", [$usuarioId]);


// Obtener artistas de cada usuario afín
$tarjetas = [];

foreach ($afines as $afin) {
    $afinId = $afin['id'];
    $artistasAfin = $conexion->recibir_datos("
        SELECT a.nombre, a.imagen
        FROM artistas a
        JOIN artista_usuario au ON a.id = au.artista_id
        WHERE au.usuario_id = $afinId
    ");

    $tarjetas[] = [
        'id' => $afin['id'],
        'nombre' => $afin['username'],
        'foto' => $afin['foto_perfil'],
        'artistas' => $artistasAfin
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfiles afines</title>
    <link rel="stylesheet" href="/css/style-card2.css">
</head>
<body>
    <header>
        <img src="/img/logo.png" alt="Logo" width="100">
    </header>

    <div class="swipe-container" id="swipe-container">
        <?php if (count($tarjetas) > 0): ?>
            <?php foreach ($tarjetas as $i => $perfil): ?>
                <div class="swipe-card <?= $i !== 0 ? 'hidden' : '' ?>">
                <div class="card">

                    <div class="user">
                            <img src="<?= htmlspecialchars($perfil['foto']) ?>" alt="Usuario">
                            <div class="name"><?= htmlspecialchars($perfil['nombre']) ?></div>
                        </div>
    
                        <div class="details">Edad: 25<br>Ciudad: Parla</div>
    
                        <div class="title-section">Artistas más escuchados</div>
                        <div class="artists-column">
                            <?php foreach ($perfil['artistas'] as $artista): ?>
                                <div class="artist-item">
                                    <img src="<?= htmlspecialchars($artista['imagen']) ?>" alt="Artista">
                                    <div class="artist-name"><?= htmlspecialchars($artista['nombre']) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
    
                        <div class="swipe-buttons">
                            <button class="swipe-button like" onclick="irChat(<?= $perfil['id'] ?>)">💬 Chat</button>
                            <button class="swipe-button skip" onclick="skipCard(this)">⏭️ Skip</button>
                        </div>
                    </div>
                </div>    
            <?php endforeach; ?>
        <?php else: ?>
            <div class="swipe-card">
                <div class="user">
                    <img src="https://via.placeholder.com/150" alt="Nada">
                    <div class="name">No queda más gente por conocer</div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <a href="spotify-card.php" class="show-profiles-btn">⬅ Volver</a>

    <script>
        function skipCard(button) {
            const currentCard = button.closest('.swipe-card');
            const nextCard = currentCard.nextElementSibling;
            currentCard.classList.add('hidden');
            if (nextCard) {
                nextCard.classList.remove('hidden');
            } else {
                // Mostrar mensaje final si no queda nadie
                const swipeContainer = document.getElementById('swipe-container');
                swipeContainer.innerHTML = `
                    <div class="swipe-card">
                        <div class="user">
                            <img src="https://via.placeholder.com/150" alt="Nada">
                            <div class="name">No queda más gente por conocer</div>
                        </div>
                    </div>`;
            }
        }

        function irChat(userId) {
            window.location.href = 'chat.php?user=' + userId;
        }
    </script>
</body>
</html>
