<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Spotify Card</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --green: #1DB954;
            --dark: #121212;
            --light: #fff;
        }

        body {
            background-color: var(--dark);
            font-family: 'Segoe UI', sans-serif;
            color: var(--light);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: #1e1e1e;
            width: 340px;
            height: 600px;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
            position: relative;
            overflow: hidden;
        }

        .user {
            text-align: center;
            margin-bottom: 10px;
        }

        .user img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 3px solid var(--green);
            object-fit: cover;
        }

        .user .name {
            margin-top: 10px;
            font-size: 1.2em;
            font-weight: bold;
        }

        .details {
            text-align: center;
            font-size: 0.9em;
            color: #bbb;
            margin-bottom: 20px;
        }

        .title-section {
            font-size: 1.1em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .artists-column {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .artist-item {
            display: flex;
            align-items: center;
            gap: 10px;
            opacity: 0.7;
            transition: 0.3s ease;
        }

        .artist-item img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }

        .artist-name {
            font-size: 0.95em;
            font-weight: bold;
        }

        .track-disc {
            position: absolute;
            bottom: 20px;
            right: 20px;
            text-align: right;
        }

        .track-disc img {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            object-fit: cover;
            animation: spin 10s linear infinite;
            box-shadow: 0 0 10px rgba(0,0,0,0.7);
            border: 2px solid white;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        audio {
            display: none;
        }
        .track-disc-full {
    position: absolute;
    bottom: 20px;
    right: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    text-align: right;
    max-width: 80%;
}

.track-disc-full .track-meta {
    font-size: 0.85em;
    color: #ccc;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.track-disc-full .disc-img {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    object-fit: cover;
    animation: spin 10s linear infinite;
    box-shadow: 0 0 10px rgba(0,0,0,0.7);
    border: 2px solid white;
}

    </style>
</head>
<body>
    <div class="card">
        {{-- Usuario --}}
        <div class="user">
            <img src="{{ $user['images'][0]['url'] ?? 'https://via.placeholder.com/150' }}" alt="User">
            <div class="name">{{ $user['display_name'] ?? 'Usuario' }}</div>
        </div>

        {{-- Detalles --}}
        <div class="details">
            Edad: <br>
            Ciudad:
        </div>

        {{-- Título --}}
        <div class="title-section">Artistas más escuchados</div>

        {{-- Artistas --}}
        <div class="artists-column">
            @foreach($topArtists as $artist)
                <div class="artist-item">
                    <img src="{{ $artist['images'][0]['url'] ?? '' }}" alt="Artista">
                    <div class="artist-name">{{ $artist['name'] }}</div>
                </div>
            @endforeach
        </div>

        {{-- Portada canción girando --}}
        @if(!empty($trackWithPreview))
        <div class="track-disc-full">
    <div class="track-meta">
        {{ $trackWithPreview['name'] ?? '' }} - {{ $trackWithPreview['artists'][0]['name'] ?? '' }}
    </div>
    <img src="{{ $trackWithPreview['album']['images'][0]['url'] ?? '' }}" alt="Portada" class="disc-img">
</div>


            @if(!empty($trackWithPreview['preview_url']))
                <audio autoplay loop>
                    <source src="{{ $trackWithPreview['preview_url'] }}" type="audio/mpeg">
                </audio>
                <script>
                    const audio = document.querySelector('audio');
                    if (audio) audio.volume = 0.3;
                </script>
            @endif
        @endif
    </div>
</body>
</html>
