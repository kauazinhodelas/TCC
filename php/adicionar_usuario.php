<?php
session_start(); // Inicia a sessão

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'administrador') {
    header("Location: login.php"); // Redireciona se não estiver logado ou não for administrador
    exit();
}

include 'db.php'; // Inclui o arquivo de conexão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); // Criptografa a senha
    $tipo = $_POST['tipo'] ?? 'usuario'; // Tipo padrão é 'usuario'

    // Prepara a consulta SQL para inserir o novo usuário
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, tel, senha, tipo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nome, $email, $tel, $senha, $tipo);

    if ($stmt->execute()) {
        header("Location: usuarios.php"); // Redireciona após a adição
        exit();
    } else {
        $error = "Erro ao adicionar usuário.";
    }

    // Fecha a declaração
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Usuário</title>
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
        input[type="text"],
        input[type="email"],
        input[type="password"],
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
        <h2>Adicionar Usuário</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="adicionar_usuario.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <label for="tel">Telefone:</label>
            <input type="tel" name="tel" required>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" required>
            <label for="tipo">Tipo:</label>
            <select name="tipo">
                <option value="usuario">Usuário</option>
                <option value="administrador">Administrador</option>
            </select>

            <button type="submit">Adicionar</button>
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
