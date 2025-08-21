const { enviarNotaFiscalPorEmail } = require("./pag_notafisc");

document.addEventListener('DOMContentLoaded', function () {
    const emailButton = document.querySelector('.email-button');

    emailButton.addEventListener('click', function () {
        enviarNotaFiscalPorEmail();
    });
});
