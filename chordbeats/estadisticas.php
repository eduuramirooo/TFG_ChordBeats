<?php
session_start();
require_once 'Conectar.php';

if (!isset($_SESSION['spotify_token'])) {
    header('Location: index.html');
    exit;
}

$token = $_SESSION['spotify_token'];

// Función para llamar a Spotify
function spotifyRequest($url, $token) {
    $headers = ["Authorization: Bearer $token"];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    return json_decode(curl_exec($ch), true);
}

// Obtener top 30 artistas
$topArtists = spotifyRequest('https://api.spotify.com/v1/me/top/artists?time_range=short_term&limit=30', $token)['items'] ?? [];

// Obtener top 30 canciones
$topTracks = spotifyRequest('https://api.spotify.com/v1/me/top/tracks?time_range=short_term&limit=30', $token)['items'] ?? [];

include 'estadisticas-view.php';
