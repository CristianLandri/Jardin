const symbols = ["🍎","🍌","🍇","🍒","🍉","🍍"];
let cards = [...symbols, ...symbols].sort(() => 0.5 - Math.random());

const gameBoard = document.getElementById("gameBoard");
const timerBar = document.getElementById("timerBar");
const endModal = new bootstrap.Modal(document.getElementById('endModal'));
const modalTitle = document.getElementById('modalTitle');
const modalEmoji = document.getElementById('modalEmoji');
const modalButtons = document.getElementById('modalButtons');
const modalImageContainer = document.getElementById('modalImageContainer');

let firstCard = null;
let lockBoard = true;
let matches = 0;
let wrongMatches = 0;
let timer = 50;
const maxTime = 50;
let timerInterval;

// Crear el tablero 3x4
for (let i = 0; i < 3; i++) {
  const row = document.createElement("div");
  row.className = "row g-3 justify-content-center";
  for (let j = 0; j < 4; j++) {
    const symbol = cards[i * 4 + j];
    const col = document.createElement("div");
    // Use col-6 col-md-3 for better spacing: 2 cards per row on mobile, 4 on desktop
    col.className = "col-6 col-md-3 d-flex justify-content-center";
    col.innerHTML = `
      <div class="memory-card">
        <div class="front">${symbol}</div>
        <div class="back">❓</div>
      </div>`;
    row.appendChild(col);
  }
  gameBoard.appendChild(row);
}

// Mostrar cartas inicialmente
const allCards = document.querySelectorAll(".memory-card");
allCards.forEach(card => card.classList.add("flipped"));
setTimeout(() => {
  allCards.forEach(card => card.classList.remove("flipped"));
  lockBoard = false;
  startTimer();
}, 8000);

// Event listeners para las cartas
allCards.forEach(card => {
  card.addEventListener("click", () => {
    if (lockBoard || card.classList.contains("flipped")) return;
    card.classList.add("flipped");
    playSound("flipSound");

    if (!firstCard) {
      // store the whole card element
      firstCard = card;
      return;
    }

    // second card clicked: lock the board until we evaluate
    lockBoard = true;
    const secondCard = card;
    checkMatch(firstCard, secondCard);
    firstCard = null;
  });
});

function checkMatch(card1, card2) {
  const val1 = card1.querySelector('.front').textContent;
  const val2 = card2.querySelector('.front').textContent;

  if (val1 === val2) {
    playSound("matchSound");
    card1.classList.add("disabled");
    card2.classList.add("disabled");
    timer = Math.min(timer + 3, maxTime);
    updateTimerBar();
    matches++;
    // release the lock so player can continue
    lockBoard = false;
    if (matches === symbols.length) gameOver(true);
  } else {
    wrongMatches++;
    playSound("failSound");
    setTimeout(() => {
      card1.classList.remove("flipped");
      card2.classList.remove("flipped");
      // unlock after cards are flipped back
      lockBoard = false;
    }, 800);
  }
}

function startTimer() {
  timerInterval = setInterval(() => {
    timer -= 0.1;
    if (timer <= 0) {
      timer = 0;
      clearInterval(timerInterval);
      gameOver(false);
    }
    updateTimerBar();
  }, 100);
}

function updateTimerBar() {
  const percentage = (timer / maxTime) * 100;
  timerBar.style.width = percentage + "%";
  timerBar.style.backgroundColor = percentage < 30 ? "#dc3545" : "#28a745";
}

function playSound(id) {
  const sound = document.getElementById(id);
  sound.currentTime = 0;
  sound.play();
}

function gameOver(won) {
  lockBoard = true;
  stopTimer();
  modalButtons.innerHTML = "";
  modalImageContainer.innerHTML = "";

  modalTitle.textContent = won ? "¡Ganaste!!! 🎉" : "¡Perdiste!";
  modalTitle.style.color = won ? "#28a745" : "#dc3545";

  const img = document.createElement("img");
  img.src = won ? "ganaste-removebg-preview.png" : "perdiste-Photoroom.png";
  img.style.width = "200px";
  img.alt = won ? "Ganaste" : "Perdiste";
  modalImageContainer.appendChild(img);

  function makeBtn(text, handler, cls) {
    const b = document.createElement('button');
    b.type = 'button';
    b.className = cls || 'btn';
    b.textContent = text;
    b.addEventListener('click', handler);
    return b;
  }

  modalButtons.appendChild(makeBtn('Reintentar', () => location.reload(), 'btn btn-primary'));

 if (win) {
  modalButtons.appendChild(makeBtn('Siguiente juego ➡️', () => { window.location.href = 'https://juegosinfantiles.tecnica4berazategui.edu.ar/juegos/Memoria/3x4.html'; }));
  }

  modalButtons.appendChild(makeBtn('Volver al inicio', () => { window.location.href = 'https://juegosinfantiles.tecnica4berazategui.edu.ar/juegos/Memoria/index.html'; }));
  
  if (win) {
    const info = document.createElement('div');
    info.className = 'w-100 mt-2';
    info.innerHTML = `<small>Has ganado <strong>${puntosGanados}</strong> puntos (fallos: ${wrongMatches})</small>`;
    document.querySelector('#endModal .modal-content').appendChild(info);
  }
  
  endModal.show();
  
  if (win) {
    setTimeout(() => { window.location.href = 'https://juegosinfantiles.tecnica4berazategui.edu.ar/essencial/principal.html'; }, 600000);
  }
}

function stopTimer() {
  clearInterval(timerInterval);
}

async function sendPoints(points) {
  const nombre = localStorage.getItem('usuario');
  if (!nombre) return console.warn('No hay usuario en localStorage, puntos no enviados');
  try {
  const resp = await fetch('/essencial/excepcional/sumar_puntos.php', {
      method: 'POST',
      body: new URLSearchParams({ nombre, puntos: points })
    });
    const data = await resp.json();
    console.log('Respuesta sumar_puntos:', data);
    if (data && typeof data.puntos !== 'undefined') {
      localStorage.setItem('puntos', data.puntos);
    }
  } catch (err) {
    console.error('Error enviando puntos:', err);
  }
}
