const themeSwitcher = document.getElementById("toggle-theme");
const body = document.body;

// Alternar entre temas
themeSwitcher.addEventListener("click", () => {
  body.classList.toggle("dark");

  // Alterar texto do botão
  if (body.classList.contains("dark")) {
    themeSwitcher.textContent = "Modo Claro";
  } else {
    themeSwitcher.textContent = "Modo Escuro";
  }
});

// Definir tema inicial (pode ser adaptado para preferências do sistema)
if (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches) {
  body.classList.add("dark");
  themeSwitcher.textContent = "Modo Claro";
}

  