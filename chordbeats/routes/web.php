<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\SpotifyController;

Route::get('/', function () {
    return view('login');
});

Route::get('/spotify/callback', function (Illuminate\Http\Request $request) {
    $token = $request->query('token');
    // Aquí puedes guardar el token en sesión o en la base de datos
    return "Token recibido: " . $token;
});

Route::get('/spotify/callback', [SpotifyController::class, 'show']);
