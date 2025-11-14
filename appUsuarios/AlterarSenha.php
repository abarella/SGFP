<?php
session_start();
$_SESSION['nome_da_tela'] = 'Usuários / Alterar Senha';
include("../header.php");
include("modAlterarSenha.php");
include("../footer.php");
