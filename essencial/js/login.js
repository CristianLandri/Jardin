document.getElementById('loginForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  const nombre = document.getElementById('usuario').value;

  try {
  const resp = await fetch('https://juegosinfantiles.tecnica4berazategui.edu.ar/essencial/excepcional/login.php', { 
      method: 'POST', 
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: new URLSearchParams({ nombre })
    });

    if (!resp.ok) throw new Error("Error de conexión con el servidor");

    const data = await resp.json();

    if (data.error) {
      alert(data.error);
    } else {
      if (data.mensaje) {
        alert(data.mensaje);
      }
      localStorage.setItem('usuario', data.nombre);
  window.location.href = 'https://juegosinfantiles.tecnica4berazategui.edu.ar/essencial/principal.html';
    }
  } catch (error) {
    alert("Error de conexión con el servidor");
    console.error(error);
  }
});
