<?php
// Configuração de conexão ao banco de dados
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'biotrade';

$connection = new mysqli($host, $user, $password, $database);

// Verifica conexão
if ($connection->connect_error) {
    die("Erro na conexão com o banco de dados: " . $connection->connect_error);
}
?>
