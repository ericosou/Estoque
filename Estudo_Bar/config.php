<?php
// Dados de conexão com o banco de dados
$host = 'localhost'; // Ajuste conforme necessário
$dbname = 'estudo_bar'; // Ajuste conforme necessário
$user = 'root'; // Ajuste conforme necessário
$pass = ''; // Ajuste conforme necessário

try {
    // Cria uma nova instância PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    // Define o modo de erro do PDO para exceções
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Exibe uma mensagem de erro caso a conexão falhe
    die("Connection failed: " . $e->getMessage());
}
?>
