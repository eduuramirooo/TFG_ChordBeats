<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis estadísticas</title>
    <link rel="stylesheet" href="/css/style-card.css">
    <style>
        
        body {
            background-color: #121212;
            color: white;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            text-align: center;
            margin: 20px 0;
        }

        .estadisticas-container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        .botones-estadisticas {
            text-align: center;
            margin-bottom: 20px;
        }

        .botones-estadisticas button {
            padding: 10px 25px;
            margin: 0 10px;
            border: none;
            border-radius: 25px;
            background-color: #1DB954;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .botones-estadisticas button:hover {
            background-color: #1ed760;
        }

        .estadisticas-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 25px;
        }

        .estadisticas-item {
            background-color: #1e1e1e;
            border-radius: 15px;
            padding: 10px;
            color: white;
            text-align: center;
            transform: scale(0.9);
            opacity: 0; /* Inicialmente oculto */
        }

        .estadisticas-item img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 8px;
        }

        .nombre {
            font-weight: bold;
            font-size: 0.95em;
        }

        .subtexto {
            font-size: 0.85em;
            color: #ccc;
        }

        .oculto {
            display: none;
        }

        .activo {
            display: grid;
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.9) translateY(20px);
            }
            60% {
                opacity: 1;
                transform: scale(1.05) translateY(-5px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
.estadisticas-item:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px #F45288;
    transition: all 0.3s ease;
}


    </style>
</head>
<body>
    <header>
        <img src="/img/logo.png" alt="Logo" width="150">
    </header>

    <div class="estadisticas-container">
        <div class="botones-estadisticas">
            <button onclick="mostrar('artistas')">🎧 Ver artistas</button>
            <button onclick="mostrar('canciones')">🎵 Ver canciones</button>
        </div>

        <div id="seccion-artistas" class="estadisticas-grid activo">
            <?php foreach ($topArtists as $artist): ?>
                <div class="estadisticas-item">
                    <img src="<?= htmlspecialchars($artist['images'][0]['url'] ?? '') ?>" alt="Artista">
                    <div class="nombre"><?= htmlspecialchars($artist['name']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="seccion-canciones" class="estadisticas-grid oculto">
            <?php foreach ($topTracks as $track): ?>
                <div class="estadisticas-item">
                    <img src="<?= htmlspecialchars($track['album']['images'][0]['url'] ?? '') ?>" alt="Canción">
                    <div class="nombre"><?= htmlspecialchars($track['name']) ?></div>
                    <div class="subtexto"><?= htmlspecialchars($track['artists'][0]['name']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<a href="spotify-card.php" class="show-profiles-btn" style="margin-bottom: 1%;">⬅ Volver al perfil</a>


    <script>
        function aplicarAnimaciones(contenedor) {
            const items = contenedor.querySelectorAll('.estadisticas-item');
            items.forEach((item, index) => {
                // Reinicia animación
                item.style.animation = 'none';
                item.style.opacity = '0';
                item.offsetHeight; // Forzar reflujo
                item.style.animation = `bounceIn 0.6s ease forwards`;
                item.style.animationDelay = `${index * 50}ms`;
            });
        }

        function mostrar(tipo) {
            const artistas = document.getElementById('seccion-artistas');
            const canciones = document.getElementById('seccion-canciones');

            if (tipo === 'artistas') {
                canciones.classList.add('oculto');
                canciones.classList.remove('activo');

                artistas.classList.remove('oculto');
                artistas.classList.add('activo');
                aplicarAnimaciones(artistas);
            } else {
                artistas.classList.add('oculto');
                artistas.classList.remove('activo');

                canciones.classList.remove('oculto');
                canciones.classList.add('activo');
                aplicarAnimaciones(canciones);
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            const artistas = document.getElementById('seccion-artistas');
            aplicarAnimaciones(artistas);
        });
    </script>
</body>
</html>
