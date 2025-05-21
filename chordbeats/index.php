<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ChordBeats - Conecta con música</title>
  <style>
    :root {
      --green: #1FC13B;
      --pink-neon: #F45288;
      --dark: #121212;
      --light: #fff;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--dark);
      color: var(--light);
    }

    header {
      background-color: transparent;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 1.5rem;
      color: var(--green);
      font-weight: bold;
    }

    nav a {
      color: var(--light);
      text-decoration: none;
      margin: 0 1rem;
      font-weight: 500;
    }

    nav a:hover {
      color: var(--pink-neon);
    }

    .hero {
      display: flex;
      align-items: center;
      width: 90%;
      margin-left:10%;
      justify-content: space-between;
      padding: 4rem 0rem;
      flex-wrap: wrap;
    }

    .hero-text {
      max-width: 500px;
    }

    .hero-text h1 {
      font-size: 3rem;
      color: var(--light);
    }

    .hero-text p {
      font-size: 1.2rem;
      margin: 1rem 0;
    }

    .spotify-button {
      display: inline-flex;
      align-items: center;
      padding: 1rem 1.5rem;
      background-color: var(--green);
      color: var(--dark);
      text-decoration: none;
      border-radius: 50px;
      font-weight: bold;
      font-size: 1rem;
      transition: background 0.3s ease;
    }

    .spotify-button:hover {
      background-color: var(--pink-neon);
      color: var(--light);
    }

    .spotify-icon {
      width: 24px;
      height: 24px;
      margin-right: 10px;
    }

    .hero-image-stack {
      position: relative;
      width: 500px;
      height: 500px;
    }

    .hero-image-stack img {
      position: absolute;
    }

    .hero-image-stack img:nth-child(1) {
      left: -400px;
      bottom: -120px;
      width: 300px;
      z-index: 1;
    }

    .hero-image-stack img:nth-child(2) {
      right: 200px;
      top: 60px;
      width: 400px;
      z-index: 2;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">ChordBeats</div>
    <nav>
      <a href="#">Inicio</a>
      <a href="#features">Cómo funciona</a>
      <a href="#demo">Demo</a>
      <a href="#contact">Contacto</a>
    </nav>
  </header>

  <section class="hero">
    <div class="hero-text">
      <h1>Conecta con personas a través de tu música</h1>
      <p>Explora perfiles, haz match con gente afín y deja que la música hable por ti.</p>
      <a href="http://localhost:3000/login" class="spotify-button">
        <img src="/img/spotify.png" alt="Spotify" class="spotify-icon">
        Iniciar sesión con Spotify
      </a>
    </div>
    <div class="hero-image-stack">
      <img src="/img/hero2.PNG" alt="Imagen 2">
      <img src="/img/hero.PNG" alt="Imagen 1">
    </div>
  </section>
</body>
</html>

