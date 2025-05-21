<?php
if (!isset($_SESSION['id_usuario'])) {
    die("Sesión no iniciada. Redirigiendo...");
    exit;
}

$nombreUsuario = $_SESSION['nombre'] ?? 'Usuario';
$fotoPerfil = $_SESSION['foto_perfil'] ?? 'https://via.placeholder.com/150';


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Spotify Card</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style-card.css">
</head>

<body>
    <header>
        <img src="/img/logo.png" alt="Logo" width="150">
    </header>

    <!-- Tarjeta del usuario principal -->
    <div class="card">
        <div class="user">
           <a href="/estadisticas.php"> <img src="<?= htmlspecialchars($fotoPerfil) ?>" alt="User"></a>
            <div class="name"><?= htmlspecialchars($nombreUsuario) ?></div>
        </div>

        <div class="details">
            Edad: 19<br>
            Ciudad: Parla
        </div>

        <div class="title-section">Artistas más escuchados</div>

        <div class="artists-column">
            <?php foreach ($topArtists as $artist): ?>
                <div class="artist-item">
                    <img src="<?= htmlspecialchars($artist['images'][0]['url'] ?? '') ?>" alt="Artista">
                    <div class="artist-name"><?= htmlspecialchars($artist['name']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($trackWithPreview)): ?>
            <div class="track-disc-full">
                <a class="chat-toggle-btn" href="listado_chats.php">
                    <img src="/img/chat.svg" alt="Chat">
                </a>
                <div class="track-meta">
                    <?= htmlspecialchars($trackWithPreview['name'] ?? '') ?> - 
                    <?= htmlspecialchars($trackWithPreview['artists'][0]['name'] ?? '') ?>
                </div>
                <img src="<?= htmlspecialchars($trackWithPreview['album']['images'][0]['url'] ?? '') ?>" alt="Portada" class="disc-img">
            </div>
        <?php endif; ?>

        <a href="perfiles.php" class="show-profiles-btn">Personas con tu ritmo</a>
    </div>

    <button class="show-profiles-btn" onclick="window.location.href='logout.php'">Cerrar sesión</button>

    <!-- Contenedor para las tarjetas swipe -->
    <div id="fake-profiles" style="display:none"></div>

    <script>
        localStorage.setItem('spotify_token', '<?= htmlspecialchars($token) ?>');
         document.addEventListener("DOMContentLoaded", () => {
    const cards = document.querySelectorAll(".card, .swipe-card");
    cards.forEach(card => {
      card.style.opacity = "1";
      card.style.animation = "slideFadeIn 0.7s ease";
    });
  });
    </script>


</body>
</html>
