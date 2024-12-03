<?php
include 'db.php'; // Inclui o arquivo de conexão

session_start(); // Inicia a sessão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coleta os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepara a consulta SQL para verificar as credenciais
    $stmt = $conn->prepare("SELECT id, nome, tel, senha, tipo FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Verifica se o email existe
    if ($stmt->num_rows == 1) {
        // O email existe, agora busca o nome, senha e tipo
        $stmt->bind_result($id, $nome, $tel, $hashed_senha, $tipo);
        $stmt->fetch();

        // Verifica a senha
        if (password_verify($senha, $hashed_senha)) {
            // Credenciais corretas, armazena os dados na sessão
            $_SESSION['user_id'] = $id;
            $_SESSION['user_nome'] = $nome; // Armazena o nome do usuário
            $_SESSION['user_tel'] = $tel; // Armazena o telefone do usuario
            $_SESSION['user_tipo'] = $tipo;

            // Redireciona com base no tipo de usuário
            if ($tipo === 'administrador') {
                header("Location: administracao.php"); // Página para administradores
            } else {
                header("Location: home_usuario.php"); // Página para usuários comuns
            }
            exit();
        } else {
            // Senha incorreta, redireciona com mensagem
            header("Location: ../login.php?error=dados_incorretos");
            exit();
        }
    } else {
        // Email não encontrado, redireciona com mensagem
        header("Location: ../login.php?error=dados_incorretos");
        exit();
    }

    // Fecha a declaração e a conexão
    $stmt->close();
    $conn->close();
}
?>
