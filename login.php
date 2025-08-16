<?php
session_start();
require 'includes/conexao.php';
require 'includes/funcoes.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizar($_POST['email']);
    $senha = $_POST['senha'];

    $sql = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $sql->execute([$email]);
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario['nome'];
        $_SESSION['id'] = $usuario['id'];
        header("Location: index.php");
        exit;
    } else {
        $erro = "E-mail ou senha inválidos!";
    }
}
?>
<form method="POST">
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Entrar</button>
    <p style="color:red;"><?= $erro ?></p>
</form>
<a href="esqueci_senha.php">Esqueci minha senha</a>
