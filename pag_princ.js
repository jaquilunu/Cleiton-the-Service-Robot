const modeToggle = document.getElementById('mode-toggle');
const body = document.body;

modeToggle.addEventListener('click', () => {
  body.classList.toggle('dark-mode');
  if (body.classList.contains('dark-mode')) {
    modeToggle.textContent = '☀️'; 
  } else {
    modeToggle.textContent = '🌙'; 
  }
  
});
