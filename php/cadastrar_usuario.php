<?php
include 'db.php'; // Inclui o arquivo de conexão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coleta os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); // Hash da senha
    $tipo = 'usuario'; // Tipo padrão

    // Verifica se o email já está cadastrado
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email já cadastrado, redireciona para a página de cadastro com mensagem
        header("Location: ../register.php?error=email_existente");
        exit();
    } else {
        // Prepara a consulta SQL para inserir o novo usuário
        $stmt->close(); // Fecha a declaração anterior
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, tel, senha, tipo) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nome, $email, $tel, $senha, $tipo);

        // Executa a consulta e verifica se o cadastro foi bem-sucedido
        if ($stmt->execute()) {
            // Cadastro bem-sucedido, redireciona para a tela de login
            header("Location: ../login.php");
            exit();
        } else {
            echo "Erro ao cadastrar usuário: " . $stmt->error;
        }
    }

    // Fecha a declaração e a conexão
    $stmt->close();
    $conn->close();
}
?>
