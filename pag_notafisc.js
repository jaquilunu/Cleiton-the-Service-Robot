// JavaScript para funcionalidades da interface da nota fiscal

document.addEventListener('DOMContentLoaded', function () {
    const emailButton = document.querySelector('.email-button');

    emailButton.addEventListener('click', function () {
        enviarNotaFiscalPorEmail();
    });
});

function enviarNotaFiscalPorEmail() {
    const confirmationMessage = document.createElement('div');
    confirmationMessage.className = 'confirmation-message';
    confirmationMessage.textContent = 'Nota fiscal enviada por e-mail com sucesso!';

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

// Estilo adicional para a mensagem de confirmação
document.head.insertAdjacentHTML('beforeend', `
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            background-color: #fff;
            width: 250px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
        }

        .logo h1 {
            font-size: 24px;
            margin: 0 0 20px;
            color: #333;
        }

        .nav ul {
            list-style-type: none;
            padding: 0;
        }

        .nav ul li {
            margin-bottom: 15px;
        }

        .nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .main-content {
            flex-grow: 1;
            padding: 40px;
            background-color: #f9f9f9;
            border-radius: 16px;
        }

        .header nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            gap: 20px;
            justify-content: flex-end;
            margin: 0 0 30px;
        }

        .header nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: color 0.3s;
        }

        .header nav ul li a:hover {
            color: #5baa61;
        }

        .invoice h1 {
            font-size: 32px;
            margin: 0 0 10px;
            color: #333;
        }

        .invoice p {
            color: #5baa61;
            font-weight: 500;
            margin: 0 0 20px;
        }

        .invoice-info h2, .invoice-items h2, .invoice-summary h2 {
            font-size: 22px;
            margin: 0 0 15px;
            color: #333;
        }

        .info-table {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .invoice-items table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            border-radius: 16px;
            overflow: hidden;
        }

        .invoice-items table th, .invoice-items table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            text-align: left;
        }

        .invoice-items table th {
            background-color: #f3f3f3;
            font-weight: 600;
        }

        .invoice-summary {
            margin-top: 30px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding: 15px;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .email-button {
            background-color: #5baa61;
            border: none;
            padding: 15px 25px;
            border-radius: 16px;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        .email-button:hover {
            background-color: #5baa61;
        }

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
