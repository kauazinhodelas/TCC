<?php
session_start(); // Inicia a sessão

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'administrador') {
    header("Location: login.php"); // Redireciona se não estiver logado ou não for administrador
    exit();
}

include 'db.php'; // Inclui o arquivo de conexão

// Consulta para obter todos os usuários
$stmt = $conn->prepare("SELECT id, nome, email, tel, tipo FROM usuarios");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
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
            max-width: 900px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: #3498db;
        }
        a:hover {
            color: #2980b9;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
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
        .btn-add {
            background-color: #2ecc71;
        }
        .btn-add:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Gerenciar Usuários</h2>
        <h3>Usuários Cadastrados</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Tipo</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']); ?></td>
                    <td><?= htmlspecialchars($row['nome']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['tel']); ?></td>
                    <td><?= htmlspecialchars($row['tipo']); ?></td>
                    <td>
                        <a href="editar_usuario.php?id=<?= htmlspecialchars($row['id']); ?>">Editar</a>
                        <a href="deletar_usuario.php?id=<?= htmlspecialchars($row['id']); ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <div class="btn-container">
            <a href="adicionar_usuario.php" class="btn btn-add">Adicionar Usuário</a>
            <a href="administracao.php" class="btn">Voltar</a>
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

<?php
// Fecha a declaração e a conexão
$stmt->close();
$conn->close();
?>
