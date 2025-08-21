// JavaScript para a página de pagamento

document.addEventListener('DOMContentLoaded', function () {
    const submitButton = document.querySelector('.submit-button');
    const form = document.querySelector('form');

    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Evita o envio do formulário
        confirmarPagamento();
    });

    function confirmarPagamento() {
        const confirmationMessage = document.createElement('div');
        confirmationMessage.className = 'confirmation-message';
        confirmationMessage.textContent = 'Pagamento confirmado com sucesso! Obrigado por sua compra.';

        // Adiciona uma animação de fade-in
        confirmationMessage.style.opacity = '0';
        document.body.appendChild(confirmationMessage);

        setTimeout(() => {
            confirmationMessage.style.transition = 'opacity 0.5s ease-in-out';
            confirmationMessage.style.opacity = '1';
        }, 100);

        // Remove a mensagem após alguns segundos
        setTimeout(() => {
            confirmationMessage.style.transition = 'opacity 0.5s ease-in-out';
            confirmationMessage.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(confirmationMessage);
            }, 500);
        }, 3000);
    }
});

// Estilo adicional para a mensagem de confirmação
document.head.insertAdjacentHTML('beforeend', `
    <style>
        .confirmation-message {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #5baa61;
            color: #fff;
            padding: 15px;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            font-weight: bold;
            z-index: 1000;
        }
    </style>
`);
