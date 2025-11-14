<?php
session_start();
$_SESSION['nome_da_tela'] = 'Usuários / Sistemas';

// Se é uma chamada AJAX, não inclui header/footer
$isAjaxRequest = (
    $_SERVER['REQUEST_METHOD'] === 'POST' && 
    isset($_POST['acao']) && 
    in_array($_POST['acao'], ['ajax_request']) // Para futuras chamadas AJAX se necessário
);

if (!$isAjaxRequest) {
    include("../header.php");
}

include("modSistema.php");

if (!$isAjaxRequest) {
    include("../footer.php");
}

