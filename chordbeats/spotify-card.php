<?php
session_start();

// Si hay token por GET, úsalo y guárdalo
if (isset($_GET['token'])) {
    $_SESSION['spotify_token'] = $_GET['token'];
    $token = $_GET['token'];
}
// Si no hay token por GET, busca en sesión
elseif (isset($_SESSION['spotify_token'])) {
    $token = $_SESSION['spotify_token'];
}
// Si no hay token en ningún lado, redirige al login
else {
    header('Location: /index.html'); // O donde tengas tu login
    exit;
}

// Función para hacer peticiones a la API de Spotify
function spotifyRequest($url, $token) {
    $headers = [
        "Authorization: Bearer $token"
    ];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    return json_decode(curl_exec($ch), true);
}

// Datos del usuario
$user = spotifyRequest('https://api.spotify.com/v1/me', $token);

// Top artistas
$topArtists = spotifyRequest('https://api.spotify.com/v1/me/top/artists?limit=3', $token)['items'] ?? [];

// Top canciones
$topTracks = spotifyRequest('https://api.spotify.com/v1/me/top/tracks?limit=10', $token)['items'] ?? [];
$trackWithPreview = null;
$trackWithPreview = null;
if (!empty($topTracks)) {
    $trackWithPreview = $topTracks[array_rand($topTracks)];
}


// Mostrar la vista
include 'spotify-card-view.php';
