<?php
require 'includes/funcoes.php';
verificarLogin();
?>
<h1>Bem-vindo, <?= $_SESSION['usuario'] ?></h1>
<a href="usuarios/listar.php">Gerenciar Usuários</a>
<a href="logout.php">Sair</a>
