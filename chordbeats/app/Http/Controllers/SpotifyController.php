<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SpotifyController extends Controller
{
    public function show(Request $request)
    {
        $token = $request->query('token');
    
        // Obtener datos del usuario
        $userResponse = Http::withToken($token)->get('https://api.spotify.com/v1/me');
        $user = $userResponse->json();
    
        // Obtener artistas top
        $artistsResponse = Http::withToken($token)
        ->get('https://api.spotify.com/v1/me/top/artists?limit=3&time_range=short_term');
        $topArtists = $artistsResponse->json()['items'] ?? [];
        
        // Obtener 50 canciones más escuchadas
        $tracksResponse = Http::withToken($token)
            ->get('https://api.spotify.com/v1/me/top/tracks?limit=50');
        $topTracks = $tracksResponse->json()['items'] ?? [];
    
        // Filtrar canciones con preview
        $tracksWithPreview = collect($topTracks)->filter(function ($track) {
            return !empty($track['preview_url']);
        });
    
// Toma la más escuchada (primera con preview disponible)
$trackWithPreview = collect($topTracks)->firstWhere('preview_url', '!=', null)
    ?? collect($topTracks)->first();


            return view('spotify', compact('user', 'topArtists', 'topTracks', 'trackWithPreview'));

    }
    

    
}
