<?php
include 'database.php';


$sql = "SELECT p.nome, SUM(v.quantidade) as total_vendido, p.estoque 
        FROM vendas v 
        JOIN produtos p ON v.produto_id = p.id 
        GROUP BY p.id";
$result = $connection->query($sql);

$nomes = [];
$quantidades = [];
$estoques = [];
while ($row = $result->fetch_assoc()) {
    $nomes[] = $row['nome'];
    $quantidades[] = $row['total_vendido'];
    $estoques[] = $row['estoque'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Vendas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="pag_merca.css">
</head>
<body>
    <header>
        <div class="header-bar">
            <h1>BioTrade</h1>
        </div>
    </header>
    <main>
        <h1>Relatório de Vendas</h1>
        <canvas id="graficoVendas"></canvas>
        <script>
            const ctx = document.getElementById('graficoVendas').getContext('2d');
            const graficoVendas = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($nomes) ?>,
                    datasets: [
                        {
                            label: 'Quantidade Vendida',
                            data: <?= json_encode($quantidades) ?>,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Estoque Atual',
                            data: <?= json_encode($estoques) ?>,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </main>
</body>
</html>
