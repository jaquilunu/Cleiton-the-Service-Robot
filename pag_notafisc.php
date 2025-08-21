<!DOCTYPE html>
<?php
$nome = $_GET["nome"] ?? "";
$telefone = $_GET["telefone"] ?? "";
$endereco = $_GET["endereco"] ?? "";
$estado = $_GET["estado"] ?? "";
$cep = $_GET["cep"] ?? "";
$cidade = $_GET["cidade"] ?? "";

$quantidade = $_GET["quant"] ?? 0;

$produto1 = 164622 * $quantidade;
$produto2 = 120000 * $quantidade;
$produto3 = 155050 * $quantidade;

?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Fiscal - BioTrade</title>
    <link rel="stylesheet" href="pag_notafisc.css">
</head>
<body>
    <div class="container">
    
        </aside>
        <main class="main-content">
            <header class="header">
                <nav>
                    <ul>
                        
                    </ul>
                </nav>
            </header>
            <section class="invoice">
                <h1>Nota fiscal</h1>
                <p>Número 001-002-2022 emitida em 02/11/2024</p>

                <div class="invoice-info">
                    <h2>Informações de venda</h2>
                    <div class="info-table">
                        <div class="info-row">
                            <span>Nome</span>
                            <span><?php echo $nome;  ?></span>
                        </div>
                        <div class="info-row">
                            <span>Telefone</span>
                            <span>1<?php echo $telefone;  ?></span>
                        </div>
                        <div class="info-row">
                            <span>Endereço</span>
                            <span><?php echo $endereco;  ?></span>
                        </div>
                        <div class="info-row">
                            <span>Cidade</span>
                            <span><?php echo $cidade;  ?></span>
                        </div>
                        <div class="info-row">
                            <span>Estado</span>
                            <span><?php echo $estado;  ?></span>
                        </div>
                        <div class="info-row">
                            <span>CEP</span>
                            <span><?php echo $cep;  ?></span>
                        </div>
                    </div>
                </div>

                <div class="invoice-items">
                    <h2>Itens da nota fiscal</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Preço unitário</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Subproduto A</td>
                                <td><?php echo $quantidade;  ?></td>
                                <td>R$1.646,22</td>
                                <td>$10</td>
                            </tr>
                            <tr>
                                <td>Subproduto B</td>
                                <td>2</td>
                                <td>R$1.200,00</td>
                                <td>$40</td>
                            </tr>
                            <tr>
                                <td>Subproduto C</td>
                                <td>3</td>
                                <td>R$1.550,50</td>
                                <td>$90</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="invoice-summary">
                    <h2>Resumo</h2>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>$140</span>
                    </div>
                    <div class="summary-row">
                        <span>Taxa de envio</span>
                        <span>$1000</span>
                    </div>
                    <div class="summary-row">
                        <span>Total</span>
                        <span><?php 
                       
                        
                        $total = $produto1 + $produto2 + $produto3;
                        $valorFormatado = "R$" . number_format($total, 2, ',', '.');
                        echo $valorFormatado;
                        
                        
                        
                        
                        ?></span>
                    </div>
                </div>

                <button class="email-button">Enviar por e-mail</button>
            </section>
        </main>
    </div>
    <script src="pag_notafisc.js" type="module"></script>


</body>
</html>
