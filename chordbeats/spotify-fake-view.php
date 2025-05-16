<div id="fake-profiles" class="active">
  <div class="swipe-container">

    <!-- Tarjeta de usuario falso -->
    <div class="card">
      <div class="user">
        <img src="img/fake1.jpg" alt="Foto del usuario">
        <div class="name">Lucía</div>
      </div>

      <div class="details">Edad: 22 | Ciudad: Barcelona</div>

      <div class="title-section">Artistas más escuchados</div>
      <div class="artists-column">
        <div class="artist-item">
          <img src="img/artista1.jpg" alt="Artista 1">
          <div class="artist-name">Aitana</div>
        </div>
        <div class="artist-item">
          <img src="img/artista2.jpg" alt="Artista 2">
          <div class="artist-name">Bad Gyal</div>
        </div>
        <div class="artist-item">
          <img src="img/artista3.jpg" alt="Artista 3">
          <div class="artist-name">Quevedo</div>
        </div>
      </div>

      <div class="track-disc-full">
        <div class="track-meta">
          Canción favorita<br>
          <strong>Columbia</strong>
        </div>
        <img class="disc-img" src="img/columbia.jpg" alt="Portada Columbia">
      </div>
    </div>

    <!-- Botones debajo de la tarjeta -->
    <div class="swipe-buttons">
      <button class="swipe-button skip">Ignorar</button>
      <button class="swipe-button like">Like</button>
    </div>

  </div>
</div>


<script>
  let current = 0;
  function nextCard() {
    const currentCard = document.getElementById(`card-${current}`);
    current++;
    const nextCard = document.getElementById(`card-${current}`);
    if (currentCard) currentCard.classList.add('hidden');
    if (nextCard) nextCard.classList.remove('hidden');
    else alert("¡Has terminado de ver los perfiles!");
  }
</script>
