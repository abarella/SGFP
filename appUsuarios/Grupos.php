<?php
session_start();
$_SESSION['nome_da_tela'] = 'Usuários / Grupos';
include("../header.php");
include("modGrupos.php");
include("../footer.php");
