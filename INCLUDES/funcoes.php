<?php
function sanitizar($dado) {
    return htmlspecialchars(trim($dado), ENT_QUOTES, 'UTF-8');
}

function verificarLogin() {
    session_start();
    if (!isset($_SESSION['usuario'])) {
        header("Location: /projeto_crud/login.php");
        exit;
    }
}
?>
