<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'usuario') {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Obtém o ID do horário a ser agendado
$id = $_GET['id'] ?? null;
$horario = $_GET['horario'];
$data = $_GET['data'];

if ($id) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $usuario_nome = $_SESSION['user_nome']; // Pega o nome do usuário da sessão

        // Verifica se o horário já foi reservado
        $stmt_check = $conn->prepare("SELECT usuario_nome FROM agendamentos WHERE id = ?");
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        $agendamento = $result->fetch_assoc();

        if ($agendamento['usuario_nome']) {
            $error = "Este horário já foi agendado por outro usuário.";
        } else {
            // Atualiza o horário para atribuí-lo ao usuário
            $stmt = $conn->prepare("UPDATE agendamentos SET usuario_nome = ? WHERE id = ?");
            $stmt->bind_param("si", $usuario_nome, $id);

            if ($stmt->execute()) {
                $success = "Horário agendado com sucesso!";

                // As suas credenciais da conta Twilio
                $account_sid = 'AC1abc1f8679de4940f28c427c840155ef'; // Substitua pelo seu Account SID
                $auth_token = 'f0cef9054221b513949a1ee8ea4bdcde'; // Substitua pelo seu Auth Token

                // O número para o qual você está enviando a mensagem (incluindo o código do país)
                $to_phone_number = $_SESSION['user_tel']; // Substitua pelo número de destino

                // Seu número de telefone Twilio (incluindo o código do país)
                $from_phone_number = '+19014251104'; // Substitua pelo seu número Twilio

                // O corpo da mensagem
                $message_body = 'Seu horário foi agendado pela UniSus com sucesso Data: ' . $data . ' Horário: ' . $horario;

                // URL da API do Twilio
                $url = 'https://api.twilio.com/2010-04-01/Accounts/' . $account_sid . '/Messages.json';

                // Dados que serão enviados via POST
                $data = array(
                    'To' => $to_phone_number,
                    'From' => $from_phone_number,
                    'Body' => $message_body,
                );

                // Inicia a sessão cURL
                $curl = curl_init($url);

                // Configurações do cURL
                curl_setopt($curl, CURLOPT_POST, true); // Define o método como POST
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Retorna o resultado da requisição
                curl_setopt($curl, CURLOPT_USERPWD, $account_sid . ':' . $auth_token); // Autenticação com Account SID e Auth Token
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data)); // Envia os dados em formato de formulário

                // Executa a requisição e captura a resposta
                $response = curl_exec($curl);

                // Verifica se houve erro na requisição
                if (curl_errno($curl)) {
                } else {
                    // Exibe a resposta da API (opcional)
                }

                // Fecha a sessão cURL
                curl_close($curl);
            } else {
                $error = "Erro ao agendar horário.";
            }

            $stmt->close();
        }
        $stmt_check->close();
    }
} else {
    header("Location: horarios_disponiveis.php");
    exit();
}
?>

<?php

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'usuario') {
    header("Location: login.php");
    exit();
}

include 'db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$horario = isset($_GET['horario']) ? htmlspecialchars($_GET['horario']) : null;
$data = isset($_GET['data']) ? htmlspecialchars($_GET['data']) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_nome = $_SESSION['user_nome'];

    // Atualiza o banco de dados para registrar o agendamento
    $stmt = $conn->prepare("UPDATE agendamentos SET usuario_nome = ? WHERE id = ?");
    $stmt->bind_param("si", $usuario_nome, $id);

    if ($stmt->execute()) {
        $success = "Agendamento realizado com sucesso!";
    } else {
        $error = "Erro ao realizar o agendamento. Tente novamente.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Horário</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            background: linear-gradient(to right, #5baac9, rgb(65, 113, 201));
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        .success {
            color: #4CAF50;
            font-weight: bold;
        }

        .error {
            color: #E74C3C;
            font-weight: bold;
        }

        button {
            background-color: #4CAF50;
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            color: #3498db;
            background-color: #e9f5fb;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        a:hover {
            color: #ffffff;
            background-color: #3498db;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        footer {
            margin-top: 20px;
            font-size: 0.9rem;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Agendar Horário</h2>
        <?php if (isset($success)): ?>
            <p class="success"><?= htmlspecialchars($success); ?></p>
        <?php elseif (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        <?php else: ?>
            <p>Você está prestes a agendar o horário:</p>
            <p><strong>Data:</strong> <?= htmlspecialchars($data); ?></p>
            <p><strong>Horário:</strong> <?= htmlspecialchars($horario); ?></p>
            <form method="POST">
                <button type="submit">Confirmar Agendamento</button>
            </form>
        <?php endif; ?>
        <a href="horarios_disponiveis.php">Voltar</a>
        <a href="logout.php">Sair</a>
        <footer>&copy; <?= date('Y'); ?> UniSus - Todos os direitos reservados.</footer>
    </div>
</body>

</html>


<?php
$conn->close();
?>
