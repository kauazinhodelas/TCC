<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="estilo.css">
    <title>Cadastro</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-in">
            <form method="post" action="./php/cadastrar_usuario.php">
                <h1>Registrar Conta</h1>
                <?php if (isset($_GET['error']) && $_GET['error'] == 'email_existente'): ?>
    <p style="color:red;">Este email já está cadastrado.</p>
<?php endif; ?>

                <span>Use seu e-mail para cadastro</span>
                <input type="text" placeholder="Nome" required id="nome" name="nome">
                <input type="text" placeholder="Telefone " required id="tel" name="tel">
                <input type="email" placeholder="Email" required id="email" name="email">
                <input type="password" placeholder="Senha" required id="senha" name="senha">
                <button type="submit">Registrar</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>Bem Vindo de Volta !</h1>
                    <p>Insira seus dados pessoais para usar todos os recursos do site</p>
                    <a href="./login.php" class="btnformlr" id="login">Logar</a>
                </div>
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
