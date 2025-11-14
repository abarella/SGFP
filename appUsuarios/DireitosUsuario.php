<?php
session_start();
$_SESSION['nome_da_tela'] = 'Usuários / Direitos Usuário';

// Verificar se é uma requisição AJAX
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

if (!$isAjax) {
    include("../header.php");
}

include("modDireitosUsuario.php");

if (!$isAjax) {
    include("../footer.php");
}
?>