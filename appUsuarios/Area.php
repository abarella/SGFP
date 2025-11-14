<?php
session_start();
$_SESSION['nome_da_tela'] = 'Usuários / Áreas';
include("../header.php");
include("modArea.php");
include("../footer.php");
