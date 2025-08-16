<?php
require '/includes/funcoes.php';
require '/includes/conexao.php';
verificarLogin();

$stmt = $conn->query("SELECT id, nome, email FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<table border="1">
<tr><th>ID</th><th>Nome</th><th>Email</th><th>Ações</th></tr>
<?php foreach ($usuarios as $u): ?>
<tr>
    <td><?= $u['id'] ?></td>
    <td><?= $u['nome'] ?></td>
    <td><?= $u['email'] ?></td>
    <td>
        <a href="editar.php?id=<?= $u['id'] ?>">Editar</a> |
        <a href="excluir.php?id=<?= $u['id'] ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
    </td>
</tr>
<?php endforeach; ?>
</table>
<a href="cadastrar.php">Novo Usuário</a>
