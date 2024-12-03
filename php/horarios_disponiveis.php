<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'usuario') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Prepara a consulta SQL para obter todos os horários disponíveis onde o usuário não agendou ainda
$stmt = $conn->prepare("SELECT id, data, horario, usuario_nome FROM agendamentos WHERE usuario_nome IS NULL OR usuario_nome = ''");

if (!$stmt) {
    die("Erro na consulta SQL: " . $conn->error);
}

$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $data, $horario, $usuario_nome);
} else {
    $nenhum_horario = true;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horários Disponíveis</title>
    <style>
        :root {
            --primary-color: #000000;
            --primary-hover: #45A049;
            --secondary-color: #E74C3C;
            --secondary-hover: #C0392B;
            --table-header-bg: #3498db;
            --table-header-text: #ffffff;
            --background-color: #f7f9fc;
            --card-bg: #ffffff;
            --text-color: #333333;
            --btn-bg: #4CAF50;
            --btn-hover-bg: #45A049;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #5baac9, #4171c9);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 900px;
            width: 100%;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            background: linear-gradient(to right, #5baac9, #4171c9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: var(--table-header-bg);
            color: var(--table-header-text);
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            text-decoration: none;
            color: white;
            background-color: var(--btn-bg);
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: 0.3s ease;
        }

        .btn:hover {
            background-color: var(--btn-hover-bg);
            transform: scale(1.05);
        }

        .btn-danger {
            background-color: var(--secondary-color);
        }

        .btn-danger:hover {
            background-color: var(--secondary-hover);
        }

        footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9rem;
            color: #777;
        }

        .icon {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Horários Disponíveis</h2>
        <div class="table-wrapper">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Ação</th>
                </tr>
                <?php if (isset($nenhum_horario)): ?>
                    <tr>
                        <td colspan="4">Nenhum horário disponível no momento.</td>
                    </tr>
                <?php else: ?>
                    <?php while ($stmt->fetch()): ?>
                        <tr>
                            <td><?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($horario, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <a href="agendar.php?id=<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>&horario=<?= htmlspecialchars($horario, ENT_QUOTES, 'UTF-8'); ?>&data=<?= htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); ?>">Agendar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </table>
        </div>
        <div class="btn-container">
            <a href="home_usuario.php" class="btn"><span class="icon">⬅</span> Voltar</a>
            <a href="logout.php" class="btn btn-danger"><span class="icon">🚪</span> Sair</a>
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
