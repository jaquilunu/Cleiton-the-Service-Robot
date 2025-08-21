<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quant'])) {
    $produto_id = 3; // ID do produto no banco de dados
    $quantidade = (int)$_POST['quant'];

    // Validar e buscar informações do produto
    $stmt = $connection->prepare("SELECT preco, vendidos, estoque FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $produto_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $produto = $result->fetch_assoc();

    if ($produto && $produto['estoque'] >= $quantidade) {
        $total = $produto['preco'] * $quantidade;

        // Inserir a venda no banco de dados
        $stmt = $connection->prepare("INSERT INTO vendas (produto_id, quantidade, total) VALUES (?, ?, ?)");
        $stmt->bind_param("iid", $produto_id, $quantidade, $total);
        $stmt->execute();

        // Atualizar o estoque do produto
        $novo_estoque = $produto['estoque'] - $quantidade; 
        $produto_id = 3; 
        $vendido =  $produto["vendidos"]+ $quantidade;

        $stmt = $connection->prepare("UPDATE produtos SET estoque = ? , vendidos = ? WHERE id = ?");
        $stmt->bind_param("iii", $novo_estoque, $vendido, $produto_id);
        $stmt->execute();

        // Redirecionar para a página de nota fiscal
        header("Location: pix.php?venda_id=" . $connection->insert_id . "&nome=" . $_POST["nome"] ."&telefone=" .$_POST["telefone"]."&endereco=" .$_POST["endereco"]."&telefone=" .$_POST["telefone"]."&estado=" .$_POST["estado"]."&cep=" .$_POST["cep"]."&cidade=" .$_POST["cidade"]."&quantidade=" .$_POST["quantidade"]);
        exit;
    } else {
        echo "<p style='color:red;'>Estoque insuficiente para a quantidade solicitada.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pag_pagamento.css">
    <title>Pagamento - BioTrade</title>
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
            flex-direction: column;
            min-height: 100vh;
            padding: 20px;
        }

        @media (min-width: 768px) {
            .container {
                flex-direction: row;
            }
        }

        .sidebar {
            background-color: #fff;
            width: 100%;
            max-width: 250px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            margin-bottom: 20px;
        }

        @media (min-width: 768px) {
            .sidebar {
                margin-right: 20px;
                margin-bottom: 0;
            }
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
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 16px;
        }

        @media (min-width: 768px) {
            .main-content {
                padding: 40px;
            }
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .pix-info {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
        }

        .pix-info h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .pix-info p {
            font-size: 18px;
            line-height: 1.6;
        }

        .submit-button {
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

        .submit-button:hover {
            background-color: #4e8a49;
        }

        .product-details {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 40px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .product-image {
            max-width: 300px;
            width: 100%;
            border-radius: 16px;
            margin-bottom: 20px;
        }

        .product-price {
            font-size: 24px;
            color: #5baa61;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .product-description {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 24px;
            }

            .submit-button {
                width: 100%;
                padding: 15px;
                font-size: 1em;
            }

            .product-price {
                font-size: 20px;
            }

            .product-description {
                font-size: 16px;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo">
                <h1>BioTrade</h1>
            </div>
            <nav class="nav">
                <ul>
                <li><a href="pag_princ.html">Início</a></li>
                <li><a href="pag_princ.html#Produto">Produtos</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <div class="product-details">
                <img src="img/plastico.png"Biogás da decomposição de plástico" class="product-image">
                <h2>Polioretano da Decomposição de Plástico</h2>
                <p class="product-price">R$ 1.646,22 /cada</p>
                <p class="product-description">O polímero é um plástico obtido do craqueamento catalítico do petróleo, o qual dá origem a nafta, de onde se extrai o monômero eteno que ao ser polimerizado resulta no polietileno.</p>
            </div>
            <h1>Pagamento via Pix</h1>
            <form method="post">
                
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="cep">CEP</label>
                    <input type="text" id="cep" name="cep" placeholder="00000-000" required>
                </div>
                <div class="form-group">
                    <label for="quant">Quantidade</label>
                    <input type="number" id="quant" name="quant" min="1" required>
                </div>
                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input type="text" id="cep" name="endereco" required>
                </div>
                <div class="form-group">
                    <label for="cidade">Cidade</label>
                    <input type="text" id="cep" name="cidade" required>
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <input type="text" id="cep" name="estado" required>
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" id="cep" name="telefone" required>
                </div>
                <div class="pix-info">
                    <h2>Chave Pix</h2>
                    <p>Utilize a seguinte chave Pix para efetuar o pagamento:</p>
                    <p><strong>123.456.789-00</strong> (CPF)</p>
                </div>
                <button type="submit" class="submit-button">Confirmar Pagamento Pix</button>
            </form>
        </main>
    </div>
</body>
</html>
