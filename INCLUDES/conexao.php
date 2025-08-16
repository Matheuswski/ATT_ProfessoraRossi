<?php
$host = 'localhost';
$dbname = 'projeto_crud';
$username = 'root'; // ou seu usuário do MySQL
$password = ''; // sua senha do MySQL

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
    die();
}
?>
