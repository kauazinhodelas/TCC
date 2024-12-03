<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="estilo.css">
    <title>Unisus Login</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-in">
            <form id="loginForm" method="post" action="./php/login.php">
                <h1>Fazer Login</h1>
                <?php if (isset($_GET['error'])): ?>
        <p style="color:red;">
            <?php
                if ($_GET['error'] == 'dados_incorretos') {
                    echo "Email ou Senha Incorretos";
                }
            ?>
        </p>
    <?php endif; ?>
                <span>Utilize seu email e senha</span>
                <input type="email" placeholder="Email" id="email" name="email">
                <input type="password" placeholder="Senha" id="senha" name="senha">
                <button type="submit">Logar</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>Bem Vindo, Amigo!</h1>
                    <p>Insira seus dados pessoais para usar todos os recursos do site</p>
                    <a href="./register.php" class="btnformlr" = "register">Cadastrar</a>
                </div>
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