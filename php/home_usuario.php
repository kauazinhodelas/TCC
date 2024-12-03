<?php
session_start();

// Verifica se o usuário está logado e se tem o tipo correto
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'usuario') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home do Usuário</title>
    <style>
        :root {
            --primary-color: #000000;
            --primary-hover: #45A049;
            --secondary-color: #E74C3C;
            --secondary-hover: #C0392B;
            --link-color: #3498DB;
            --link-hover: #2980B9;
            --text-color: #FFFFFF;
            --card-bg: #FFFFFF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--background-gradient);
            color: var(--text-color);
            display: flex;
            background: linear-gradient(to right, #5baac9,
    rgb(65, 113, 201));
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            padding: 30px;
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        h2 {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        ul li {
            margin: 15px 0;
        }

        ul li a {
            display: block;
            text-decoration: none;
            color: var(--link-color);
            font-size: 1rem;
            padding: 10px;
            border-radius: 5px;
            background: #f4f4f4;
            transition: 0.3s;
            font-weight: bold;
        }

        ul li a:hover {
            color: var(--link-hover);
            background: #e6e6e6;
        }

        .logout-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            font-size: 1rem;
            text-decoration: none;
            background: var(--secondary-color);
            color: var(--text-color);
            border-radius: 5px;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: var(--secondary-hover);
        }

        footer {
            margin-top: 20px;
            font-size: 0.8rem;
            color: #777;
        }

        /* VLibras */
        .vlibras-wrapper {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Bem-vindo, <?= htmlspecialchars($_SESSION['user_nome']); ?>!</h2>
        <ul>
            <li><a href="horarios_disponiveis.php">Ver Horários Disponíveis</a></li>
            <li><a href="meus_agendamentos.php">Meus Agendamentos</a></li>
        </ul>
        <a class="logout-btn" href="logout.php">Sair</a>
        <footer>
            <p>&copy; <?= date('Y'); ?> UniSus - Todos os direitos reservados</p>
        </footer>
    </div>

    <!-- VLibras -->
    <div class="vlibras-wrapper">
        <div vw class="enabled">
            <div vw-access-button class="active"></div>
            <div vw-plugin-wrapper>
                <div class="vw-plugin-top-wrapper"></div>
            </div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>
</body>
</html>
