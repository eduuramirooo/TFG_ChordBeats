<?php
session_start();
require_once 'Conectar.php';

$conexion = new Conectar("localhost", "root", "", "chordbeats");

// 1. Obtener token de Spotify
if (isset($_GET['token'])) {
    $_SESSION['spotify_token'] = $_GET['token'];
    $token = $_GET['token'];
} elseif (isset($_SESSION['spotify_token'])) {
    $token = $_SESSION['spotify_token'];
} else {
    header("Location: index.html");
    exit;
}

// 2. Función para llamar a la API de Spotify
function spotifyRequest($url, $token) {
    $headers = ["Authorization: Bearer $token"];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    return json_decode(curl_exec($ch), true);
}

// 3. Obtener datos del usuario
$userSpotify = spotifyRequest('https://api.spotify.com/v1/me', $token);

$spotifyId = $userSpotify['id'];
$nombreVisible = $userSpotify['display_name'] ?? 'Usuario';
$fotoPerfil = $userSpotify['images'][0]['url'] ?? null;

// 4. Verificar si ya existe el usuario
$existeUsuario = $conexion->recibir_datos("SELECT id FROM usuario WHERE spotify_id = '$spotifyId'");

if (!empty($existeUsuario)) {
    $usuarioId = $existeUsuario[0]['id'];
} else {
    $consulta = "INSERT INTO usuario (spotify_id, username, foto_perfil) VALUES (?, ?, ?)";
    $usuarioId = $conexion->hacer_consulta($consulta, "sss", [$spotifyId, $nombreVisible, $fotoPerfil]);
}

// 5. Guardar en sesión
$_SESSION['id_usuario'] = $usuarioId;
$_SESSION['nombre'] = $nombreVisible;
$_SESSION['foto_perfil'] = $fotoPerfil;
// 6. Obtener artistas top
$topArtists = spotifyRequest('https://api.spotify.com/v1/me/top/artists?limit=3', $token)['items'] ?? [];

foreach ($topArtists as $artista) {
    $spotifyArtistId = $artista['id'];
    $nombre = $artista['name'];
    $imagen = $artista['images'][0]['url'] ?? null;

    // Verificar si el artista ya existe
    $existeArtista = $conexion->recibir_datos("SELECT id FROM artistas WHERE spotify_id = '$spotifyArtistId'");
    if (!empty($existeArtista)) {
        $artistaId = $existeArtista[0]['id'];
    } else {
        $consulta = "INSERT INTO artistas (spotify_id, nombre, imagen) VALUES (?, ?, ?)";
        $artistaId = $conexion->hacer_consulta($consulta, "sss", [$spotifyArtistId, $nombre, $imagen]);
    }

    // Verificar si ya existe la relación
    $existeRelacion = $conexion->recibir_datos(
        "SELECT 1 FROM artista_usuario WHERE usuario_id = $usuarioId AND artista_id = $artistaId"
    );

    if (empty($existeRelacion)) {
        $consulta = "INSERT INTO artista_usuario (usuario_id, artista_id) VALUES (?, ?)";
        $conexion->hacer_consulta($consulta, "ii", [$usuarioId, $artistaId]);
    }
}

// 7. Obtener top canciones
$topTracks = spotifyRequest('https://api.spotify.com/v1/me/top/tracks?limit=10&time_range=short_term', $token)['items'] ?? [];
$trackWithPreview = null;
if (!empty($topTracks)) {
    $trackWithPreview = $topTracks[array_rand($topTracks)];
}

// 8. Mostrar vista final
include 'spotify-card-view.php';


