<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Obtém o ID do horário a ser editado
$id = $_GET['id'] ?? null;

if ($id) {
    // Prepara a consulta SQL para obter os dados do horário
    $stmt = $conn->prepare("SELECT data, horario, usuario_nome FROM agendamentos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $horario = $result->fetch_assoc();
    } else {
        header("Location: agendamentos.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = $_POST['data'];
        $horario_atualizado = $_POST['horario'];  // Renomeado para evitar confusão com o array $horario
        $usuario_nome = $_POST['usuario_nome'];

        // Prepara a consulta SQL para atualizar o horário
        $stmt = $conn->prepare("UPDATE agendamentos SET data = ?, horario = ?, usuario_nome = ? WHERE id = ?");
        $stmt->bind_param("sssi", $data, $horario_atualizado, $usuario_nome, $id);

        if ($stmt->execute()) {
            header("Location: agendamentos.php");
            exit();
        } else {
            $error = "Erro ao editar horário.";
        }

        $stmt->close();
    }
} else {
    header("Location: agendamentos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Horário</title>
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
        <h2>Editar Horário</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="editar_horario.php?id=<?= htmlspecialchars($id); ?>" method="POST">
            <label for="data">Data:</label>
            <input type="date" name="data" value="<?= htmlspecialchars($horario['data']); ?>" required>

            <label for="horario">Horário:</label>
            <input type="text" name="horario" value="<?= htmlspecialchars($horario['horario']); ?>" placeholder="16h30 - 17h30" required>

            <label for="usuario_nome">Nome do Usuário (deixe em branco se disponível):</label>
            <input type="text" name="usuario_nome" value="<?= htmlspecialchars($horario['usuario_nome']); ?>" placeholder="Nome do Usuário">

            <button type="submit">Salvar</button>
        </form>
        <a href="agendamentos.php">Voltar</a>
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
