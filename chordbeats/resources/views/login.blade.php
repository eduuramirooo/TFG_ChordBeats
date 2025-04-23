<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión con Spotify</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #121212;
            color: white;
        }
        .container {
            text-align: center;
        }
        .spotify-button {
            padding: 12px 24px;
            background-color: #1DB954;
            color: white;
            border: none;
            border-radius: 24px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }
        .spotify-button:hover {
            background-color: #1ed760;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Inicia sesión con Spotify</h1>
        <a class="spotify-button" href="http://localhost:3000/login">
            Conectar con Spotify
        </a>
    </div>
</body>
</html>
