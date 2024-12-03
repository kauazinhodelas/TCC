<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'usuario') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Prepara a consulta SQL para obter os agendamentos do usuário
$usuario_nome = $_SESSION['user_nome'];
$stmt = $conn->prepare("SELECT id, data, horario FROM agendamentos WHERE usuario_nome = ?");
$stmt->bind_param("s", $usuario_nome);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Agendamentos</title>
    <style>
        :root {
            --primary-color: #4CAF50;

            --secondary-color: #E74C3C;
            --table-header-bg: #3498db;
            --table-header-text: #ffffff;
            --background-color: #f7f9fc;
            --card-bg: #ffffff;
            --text-color: #333333;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            display: flex;
            background: linear-gradient(to right, #5baac9,
    rgb(65, 113, 201));
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 800px;
            width: 100%;
            text-align: center;
        }

        h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th {
            background-color: var(--table-header-bg);
            color: var(--table-header-text);
            padding: 15px;
        }

        td {
            padding: 12px;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 1rem;
            text-decoration: none;
            color: #fff;
            background-color: var(--primary-color);
            border-radius: 5px;
            transition: 0.3s ease;
        }

        .btn:hover {
            background-color: #3e8e41;
        }

        .btn-danger {
            background-color: var(--secondary-color);
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        footer {
            margin-top: 20px;
            font-size: 0.9rem;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Meus Agendamentos</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Horário</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']); ?></td>
                        <td><?= htmlspecialchars($row['data']); ?></td>
                        <td><?= htmlspecialchars($row['horario']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Você ainda não possui agendamentos.</p>
        <?php endif; ?>
        <div class="btn-container">
            <a href="home_usuario.php" class="btn">Voltar</a>
            <a href="logout.php" class="btn btn-danger">Sair</a>
        </div>
        <footer>&copy; <?= date('Y'); ?> UniSus - Todos os direitos reservados.</footer>
    </div>

    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
