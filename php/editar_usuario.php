<?php
session_start(); // Inicia a sessão

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'administrador') {
    header("Location: login.php"); // Redireciona se não estiver logado ou não for administrador
    exit();
}

include 'db.php'; // Inclui o arquivo de conexão

// Obtém o ID do usuário a ser editado
$id = $_GET['id'] ?? null;

if ($id) {
    // Prepara a consulta SQL para obter os dados do usuário
    $stmt = $conn->prepare("SELECT nome, email, tel, tipo FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    } else {
        header("Location: usuarios.php"); // Redireciona se o usuário não for encontrado
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];
        $tipo = $_POST['tipo'];

        // Prepara a consulta SQL para atualizar o usuário
        $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, email = ?, tel = ?, tipo = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nome, $email, $tel, $tipo, $id);

        if ($stmt->execute()) {
            header("Location: usuarios.php"); // Redireciona após a edição
            exit();
        } else {
            $error = "Erro ao editar usuário.";
        }

        // Fecha a declaração
        $stmt->close();
    }
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
    <title>Editar Usuário</title>
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
        input[type="text"],
        input[type="email"],
        select,
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
        <h2>Editar Usuário</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="editar_usuario.php?id=<?= htmlspecialchars($id); ?>" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($user['nome']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>

            <label for="tel">Telefone: </label>
            <input type="tel" name="tel" value="<?= htmlspecialchars($user['tel']); ?>" required>

            <label for="tipo">Tipo:</label>
            <select name="tipo" required>
                <option value="usuario" <?= $user['tipo'] === 'usuario' ? 'selected' : ''; ?>>Usuário</option>
                <option value="administrador" <?= $user['tipo'] === 'administrador' ? 'selected' : ''; ?>>Administrador</option>
            </select>

            <button type="submit">Salvar</button>
        </form>
        <a href="usuarios.php">Voltar</a> | <a href="logout.php">Sair</a>
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
