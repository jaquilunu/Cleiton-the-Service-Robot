<?php
session_start();
if (!isset($_SESSION["admin"])) {
    die("Esse email não é para você!");
}

include 'database.php';

// Consulta para gráfico de barras (vendas por produto)
$sqlBarras = "SELECT p.nome, SUM(v.quantidade) as total_vendido, p.estoque 
              FROM vendas v 
              JOIN produtos p ON v.produto_id = p.id 
              GROUP BY p.id";
$resultBarras = $connection->query($sqlBarras);

$nomes = [];
$quantidades = [];
$estoques = [];
while ($row = $resultBarras->fetch_assoc()) {
    $nomes[] = $row['nome'];
    $quantidades[] = $row['total_vendido'];
    $estoques[] = $row['estoque'];
}

// Consulta para gráfico de linha (vendas por dia)
$sqlLinha = "SELECT DATE(data_venda) as dia, SUM(quantidade) as total_vendido
             FROM vendas
             GROUP BY DATE(data_venda)
             ORDER BY DATE(data_venda)";
$resultLinha = $connection->query($sqlLinha);

$dias = [];
$quantidadesPorDia = [];
while ($row = $resultLinha->fetch_assoc()) {
    $dias[] = date("d/m/Y", strtotime($row['dia'])); 
    $quantidadesPorDia[] = $row['total_vendido'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard BioTrade</title>
  <link rel="stylesheet" href="dash.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <header>
    <nav>
      <div class="logo">BioTrade</div>
      <ul>
        <li><a href="pag_TelaMerca.html">Mercadoria</a></li>
        <li><a href="pag_relatorio.html">Relatórios</a></li>
        <li><a href="pag_TelaForn.html">Fornecedores</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="overview">
      <h1>Vendas</h1>
      <div class="metrics">
        <div class="metric">Vendas Este Mês<br><span>R$17000</span></div>
        <div class="metric">Vendas Este Ano<br><span>R$27000</span></div>
        <div class="metric">Lucro Este Mês<br><span>R$5000</span></div>
      </div>
      <canvas id="vendasPorDia"></canvas>

    </section>

    <section class="overview">
      <h2>Estoque</h2>
      <div class="stock-metrics">
      
        <div class="stock-item">Quantidade Vendida<br><span>8</span></div>
        <div class="stock-item">Estoque Atual Produtos<br><span>70</span></div>
        
      </div>
      <canvas id="graficoVendas"></canvas>
    </section>

 
  </main>

  <footer>
    <p>© 2024 BioTrade. Todos os direitos reservados.</p>
  </footer>

  <script>
    // Gráfico de barras (vendas por produto e estoque)
    const ctxBarras = document.getElementById('graficoVendas').getContext('2d');
    const graficoVendas = new Chart(ctxBarras, {
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

    // Gráfico de linha (vendas por dia)
    const ctxLinha = document.getElementById('vendasPorDia').getContext('2d');
    const vendasPorDia = new Chart(ctxLinha, {
        type: 'line',
        data: {
            labels: <?= json_encode($dias) ?>, 
            datasets: [{
                label: 'Quantidade Vendida',
                data: <?= json_encode($quantidadesPorDia) ?>, 
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4 
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Data'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Quantidade Vendida'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Quantidade: ${context.raw}`;
                        }
                    }
                }
            }
        }
    });
  </script>
</body>
</html>
