// index.js
const express = require('express');
const axios = require('axios');
const cors = require('cors');
require('dotenv').config();

const app = express();
app.use(cors());

const redirect_uri = 'https://33dc-2a0c-5a80-d20b-4600-1151-4bf7-d6cd-aa95.ngrok-free.app/callback'; 
const client_id = process.env.SPOTIFY_CLIENT_ID;
const client_secret = process.env.SPOTIFY_CLIENT_SECRET;

// Paso 1: Redirigir al login de Spotify
app.get('/login', (req, res) => {
  const scope = 'user-read-private user-read-email user-top-read';
  const authUrl = 'https://accounts.spotify.com/authorize?' +
    new URLSearchParams({
      response_type: 'code',
      client_id,
      scope,
      redirect_uri,
    });

  res.redirect(authUrl.toString());
});

// Paso 2: Callback después del login
app.get('/callback', async (req, res) => {
  const code = req.query.code || null;
  const authOptions = {
    method: 'post',
    url: 'https://accounts.spotify.com/api/token',
    data: new URLSearchParams({
      code,
      redirect_uri,
      grant_type: 'authorization_code',
    }),
    headers: {
      Authorization: 'Basic ' + Buffer.from(client_id + ':' + client_secret).toString('base64'),
      'Content-Type': 'application/x-www-form-urlencoded',
    },
  };

  try {
    const response = await axios(authOptions);
    const access_token = response.data.access_token;

    // Redirigir al archivo PHP en tu servidor local
    res.redirect(`http://chordbeats.com/spotify-card.php?token=${access_token}`);
  } catch (error) {
    console.error(error.response?.data || error.message);
    res.send('Error autenticando: ' + JSON.stringify(error.response?.data || error.message));
  }
});

// Iniciar el servidor
app.listen(3000, () => {
  console.log('Servidor Node corriendo en http://localhost:3000');
});