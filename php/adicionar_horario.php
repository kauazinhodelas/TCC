<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST['data'];
    $horario = $_POST['horario'];
    $usuario_nome = $_POST['usuario_nome'] ? $_POST['usuario_nome'] : null; // Captura o nome do usuário ou define como nulo

    // Prepara a consulta SQL para inserir o novo horário
    $stmt = $conn->prepare("INSERT INTO agendamentos (data, horario, usuario_nome) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $data, $horario, $usuario_nome);

    if ($stmt->execute()) {
        header("Location: agendamentos.php");
        exit();
    } else {
        $error = "Erro ao adicionar horário.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Horário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
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
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="date"],
        input[type="text"],
        button {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        a {
            color: #3498db;
            text-decoration: none;
            margin-top: 20px;
        }
        a:hover {
            color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Adicionar Horário</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="adicionar_horario.php" method="POST">
            <label for="data">Data:</label>
            <input type="date" name="data" required>

            <label for="horario">Horário:</label>
            <input type="text" name="horario" placeholder="11h30 - 17h30" required>

            <label for="usuario_nome">Nome do Usuário (deixe em branco se disponível):</label>
            <input type="text" name="usuario_nome" placeholder="Nome do Usuário">

            <button type="submit">Adicionar</button>
        </form>
        <a href="agendamentos.php">Voltar</a> | <a href="logout.php">Sair</a>
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

<?php
$conn->close();
?>
