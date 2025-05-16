<!-- spotify-card-view.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Spotify Card</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style-card.css">
</head>
<body>

<!-- Tarjeta del usuario principal -->
<div class="card">
    <div class="user">
        <img src="<?= $user['images'][0]['url'] ?? 'https://via.placeholder.com/150' ?>" alt="User">
        <div class="name"><?= $user['display_name'] ?? 'Usuario' ?></div>
    </div>

    <div class="details">
        Edad: <br>
        Ciudad:
    </div>

    <div class="title-section">Artistas más escuchados</div>

    <div class="artists-column">
        <?php foreach ($topArtists as $artist): ?>
            <div class="artist-item">
                <img src="<?= $artist['images'][0]['url'] ?? '' ?>" alt="Artista">
                <div class="artist-name"><?= $artist['name'] ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (!empty($trackWithPreview)): ?>
        <div class="track-disc-full">
            <div class="track-meta">
                <?= $trackWithPreview['name'] ?? '' ?> - <?= $trackWithPreview['artists'][0]['name'] ?? '' ?>
            </div>
            <img src="<?= $trackWithPreview['album']['images'][0]['url'] ?? '' ?>" alt="Portada" class="disc-img">
        </div>
    <?php endif; ?>
    <button class="show-profiles-btn" onclick="mostrarPerfiles()">🎵 Ver personas afines</button>
</div>
<button class="show-profiles-btn" onclick="window.location.href='logout.php'">🚪 Cerrar sesión</button>

<!-- Contenedor para las tarjetas swipe tipo Tinder -->

<?php include 'spotify-fake-view.php'; ?>

<script>
  localStorage.setItem('spotify_token', '<?= htmlspecialchars($token) ?>');

function mostrarPerfiles() {
    const card = document.querySelector('.card');
    const fakeProfiles = document.getElementById('fake-profiles');

    // Aplicar fade out a la tarjeta
    card.classList.add('fade-out');

    // Mostrar el contenedor de perfiles falsos con visibilidad
    setTimeout(() => {
      card.style.display = 'none';
      fakeProfiles.classList.add('active');
    }, 400);
  }
  
</script>

</body>
</html>
