<?php 
session_start();
$_SESSION['nome_da_tela'] = 'Escala / Escala Semanal';
include ('../functions.php');
include("../header.php");
//include("CabecFolha.php");
include("modEscala_Semanal.php");
//include("../footer.php");
?>
