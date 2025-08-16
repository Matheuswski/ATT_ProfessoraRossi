<?php
require 'includes/conexao.php';
require 'includes/funcoes.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizar($_POST['email']);

    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Gera token
        $token = bin2hex(random_bytes(32));
        $dataToken = date('Y-m-d H:i:s');

        // Salva token no banco
        $update = $conn->prepare("UPDATE usuarios SET token_recuperacao=?, data_token=? WHERE id=?");
        $update->execute([$token, $dataToken, $usuario['id']]);

        // Link de redefinição
        $link = "http://localhost/projeto_crud/redefinir_senha.php?token=$token";

        // Envio do e-mail (simples, sem SMTP)
        $assunto = "Recuperação de Senha";
        $mensagemEmail = "Clique no link para redefinir sua senha: $link";
        mail($email, $assunto, $mensagemEmail);

        $mensagem = "Se o e-mail existir no sistema, enviaremos um link para redefinir sua senha.";
    } else {
        $mensagem = "Se o e-mail existir no sistema, enviaremos um link para redefinir sua senha.";
    }
}
?>
<h2>Recuperar Senha</h2>
<form method="POST">
    <input type="email" name="email" placeholder="Seu e-mail" required>
    <button type="submit">Enviar</button>
</form>
<p><?= $mensagem ?></p>
