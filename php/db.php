<?php
$host = 'localhost'; // O endereço do servidor do banco de dados
$db   = 'bd_consultas'; // Nome do banco de dados
$user = 'root'; // Nome de usuário do banco de dados
$pass = ''; // Senha do banco de dados

// Cria a conexão
$conn = new mysqli($host, $user, $pass, $db);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Define o charset para evitar problemas com caracteres especiais
$conn->set_charset("utf8mb4");
?>
