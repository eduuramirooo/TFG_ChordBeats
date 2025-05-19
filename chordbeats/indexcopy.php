<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicia sesión - ChordBeats</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/login.css">
</head>
<body>

  <div class="container">
    <div class="login-box">
      <img src="/img/logo.png" alt="ChordBeats Logo" class="logo">

      <h1>Bienvenido a ChordBeats</h1>
      <p class="description">
        Descubre personas con tus mismos gustos musicales.<br>
        Conecta a través de la música.
      </p>

      <a href="http://localhost:3000/login" class="spotify-button">
        <img src="/img/spotify.png" alt="Spotify" class="spotify-icon">
        Iniciar sesión con Spotify
      </a>
    </div>
  </div>

  <script>
    const token = localStorage.getItem('spotify_token');

    if (token) {
      window.location.href = '/spotify-card.php';
    }
  </script>

</body>
</html>

