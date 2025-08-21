const themeToggle = document.querySelector('.theme-toggle');
const header = document.querySelector('header');
const logo = document.querySelector('.logo span');
const navLinks = document.querySelectorAll('nav a');
const labels = document.querySelectorAll('label');
const separator = document.querySelector('.separator');
const title = document.querySelector('h1');

themeToggle.addEventListener('click', () => {
    // Alterna a classe 'dark-theme' em todos os elementos
    document.body.classList.toggle('dark-theme');
    header.classList.toggle('dark-theme');
    logo.classList.toggle('dark-theme');  // Altera a cor do logotipo "BioTrade"

    navLinks.forEach(link => {
        link.classList.toggle('dark-theme');
    });

    labels.forEach(label => {
        label.classList.toggle('dark-theme');
    });

    separator.classList.toggle('dark-theme');
    title.classList.toggle('dark-theme');

    if (document.body.classList.contains('dark-theme')) {
        themeToggle.textContent = '☀️';
    } else {
        themeToggle.textContent = '🌙';
    }
});
