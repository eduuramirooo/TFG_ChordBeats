<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cerrando sesión...</title>
  <script>
    // Borra el token del almacenamiento local
    localStorage.removeItem('spotify_token');
    // Redirige al inicio después de 500ms
    setTimeout(() => {
      window.location.href = "/";
    }, 500);
  </script>
</head>
<body>
  <p style="color:white; text-align:center; font-family:sans-serif; margin-top:50px;">
    Cerrando sesión...
  </p>
</body>
</html>
