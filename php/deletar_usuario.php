<?php
session_start(); // Inicia a sessão

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'administrador') {
    header("Location: login.php"); // Redireciona se não estiver logado ou não for administrador
    exit();
}

include 'db.php'; // Inclui o arquivo de conexão

// Obtém o ID do horário a ser excluído
$id = $_GET['id'] ?? null;

if ($id) {
    // Prepara a consulta SQL para excluir o horário
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $success_message = "Usuario excluído com sucesso!"; // Mensagem de sucesso
    } else {
        $error = "Erro ao excluir Usuario.";
    }

    // Fecha a declaração
    $stmt->close();
} else {
    header("Location: usuarios.php"); // Redireciona se não houver ID
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        .error {
            color: red;
            text-align: center;
        }
        .success {
            color: green;
            text-align: center;
        }
        a {
            display: inline-block;
            margin-top: 10px;
            text-align: center;
            color: #3498db;
            text-decoration: none;
        }
        a:hover {
            color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Excluir Usuario</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        <?php elseif (isset($success_message)): ?>
            <p class="success"><?= htmlspecialchars($success_message); ?></p>
        <?php endif; ?>
        <a href="usuarios.php">Voltar</a>
        <a href="logout.php">Sair</a>
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
