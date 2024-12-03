<?php
session_start(); // Inicia a sessão

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'administrador') {
    header("Location: login.php"); // Redireciona se não estiver logado ou não for administrador
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        h3 {
            color: #34495e;
            margin-bottom: 15px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            margin: 10px 0;
        }
        ul li a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
        }
        ul li a:hover {
            color: #2980b9;
        }
        .btn-container {
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #e74c3c;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Painel do Administrador</h2>
        <h3>Links Rápidos</h3>
        <ul>
            <li><a href="usuarios.php">Gerenciar Usuários</a></li>
            <li><a href="agendamentos.php">Gerenciar Agendamentos</a></li>
        </ul>
        <div class="btn-container">
            <a href="logout.php" class="btn">Sair</a>
        </div>
    </div>
    <div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
      <div class="vw-plugin-top-wrapper"></div>
    </div>
  </div>
  <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
  <script>
    new window.VLibras.Widget('https://vlibras.gov.br/app');
  </script>
</body>
</html>
