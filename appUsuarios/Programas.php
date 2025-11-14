<?php
session_start();
$_SESSION['nome_da_tela'] = 'Usuários / Programas';

// Se é uma chamada AJAX para carregar direitos, não inclui header/footer
$isAjaxCarregarDireitos = (
    $_SERVER['REQUEST_METHOD'] === 'POST' && 
    isset($_POST['acao']) && 
    $_POST['acao'] === 'carregar_direitos'
);

if (!$isAjaxCarregarDireitos) {
    include("../header.php");
}

include("modProgramas.php");

if (!$isAjaxCarregarDireitos) {
    include("../footer.php");
}
