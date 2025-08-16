<?php
require '../includes/conexao.php';
require '../includes/funcoes.php';
require '../includes/cabecalho.php';
verificarLogin();

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = sanitizar($_POST['nome']);
    $email = sanitizar($_POST['email']);
    $senha = $_POST['senha'];

    $check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $check->execute([$email]);
    if ($check->fetch()) {
        $mensagem = "E-mail já cadastrado!";
    } else {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $hash]);
        header("Location: listar.php");
        exit;
    }
}
?>

<h2 class="mb-3">Cadastrar Usuário</h2>
<?php if ($mensagem): ?>
<div class="alert alert-danger"><?= $mensagem ?></div>
<?php endif; ?>

<form method="POST" class="card p-4 shadow-sm">
  <div class="mb-3">
    <label class="form-label">Nome</label>
    <input type="text" name="nome" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">E-mail</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Senha</label>
    <input type="password" name="senha" class="form-control" required>
  </div>
  <button type="submit" class="btn btn-success">Salvar</button>
  <a href="listar.php" class="btn btn-secondary">Voltar</a>
</form>

<?php require '../includes/rodape.php'; ?>

