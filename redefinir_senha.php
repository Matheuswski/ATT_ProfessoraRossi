<?php
require 'includes/conexao.php';
require 'includes/funcoes.php';

$token = $_GET['token'] ?? '';
$mensagem = '';

if (!$token) {
    die("Token inválido!");
}

// Verifica se o token é válido e não expirou
$stmt = $conn->prepare("SELECT id, data_token FROM usuarios WHERE token_recuperacao = ?");
$stmt->execute([$token]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Token inválido!");
}

// Verifica expiração (1 hora)
$dataToken = strtotime($usuario['data_token']);
if (time() - $dataToken > 3600) {
    die("Token expirado!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha = $_POST['senha'];
    $confirma = $_POST['confirmar'];

    if ($senha === $confirma) {
        $hash = password_hash($senha, PASSWORD_DEFAULT);

        // Atualiza senha e limpa token
        $update = $conn->prepare("UPDATE usuarios SET senha=?, token_recuperacao=NULL, data_token=NULL WHERE id=?");
        $update->execute([$hash, $usuario['id']]);

        $mensagem = "Senha redefinida com sucesso! <a href='login.php'>Clique aqui para entrar</a>";
    } else {
        $mensagem = "As senhas não coincidem!";
    }
}
?>
<h2>Redefinir Senha</h2>
<form method="POST">
    <input type="password" name="senha" placeholder="Nova senha" required>
    <input type="password" name="confirmar" placeholder="Confirmar senha" required>
    <button type="submit">Redefinir</button>
</form>
<p><?= $mensagem ?></p>
