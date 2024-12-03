<?php
session_start();

// Destrói a sessão
session_unset();
session_destroy();

// Redireciona para a página de login
header("Location: ../index.html");
exit();
?>
