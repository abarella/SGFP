<?php
include ("lib/DB.php");
session_start();

//var_dump($_POST);
//var_dump($_GET);
/* ------- */
/* POSTS   */
/* ------- */
/*
install python on iis
https://www.youtube.com/watch?v=ma1UvzqF82Q
*/

if(isset($_POST["gravalimpcela"])){

	
	$usuario = $_POST["p_usuario"];
	$senha = $_POST["p_senha"];
	$mensa = ValidaSenha($usuario, $senha);
	if($mensa != ""){
		return;
	}
	

	$param = $_POST["gravalimpcela"];
	include("../lib/DB.php");
	$stmt = $conn->prepare($param);
	$stmt->execute();
}






if(isset($_POST["gravalimpcelaResponsaveis"])){
	include("../lib/DB.php");
	if ($_SESSION['usuarioSenha'] <> $_POST['p04']){
		echo "<script>alert('erro senha')</script>";
		//echo "<script>parent.toastApp(3000,'***   SENHA INVÁLIDA   ***','ERRO')</script>"	;
		die;
	}

	$x01 = $_POST['p01']; // id limpesa
	$x02 = $_POST['p02']; // check 0 ou 1
	$x03 = $_POST['p03']; // usuario
	$x04 = $_POST['p04']; // senha informada
	$x05 = $_SESSION['usuarioID'];

	$stmt = $conn->prepare("exec crsa.P0706_LIMPEZA_RESPONSA '".$x01."','".$x02."','".$x03 . "','". $x05 ."','".$x04 ."','',''");
	$stmt->execute();
}

if(isset($_POST["gravalimpcelaSolucoes"])){

	include("../lib/DB.php");
	if ($_SESSION['usuarioSenha'] <> $_POST['p04']){
		echo "<script>alert('erro senha')</script>";
		//echo "<script>parent.toastApp(3000,'***   SENHA INVÁLIDA   ***','ERRO')</script>"	;
		die;
	}

	$p01 = $_POST['p01']; // id limpesa
	$p02 = $_POST['p02']; // pasta
	$p03 = $_POST['p03']; // lote
	$p04 = $_POST['p04']; // senha
	$p05 = $_POST['p05']; // soluções


	$p05 = substr($p05,0,-1);
    $p06 = $_SESSION['usuarioID'];


	$query = "exec crsa.uspP0601_Solucoes ".$p01.",".$p02.",".$p03.",'".$p05."','".$p06."'" ;
	$stmt = $conn->prepare($query);
	$stmt->execute();

}


if(isset($_POST['gravaLPZ'])){
	
	include("../lib/DB.php");
	//persistir esta tabela: select * from crsa.T0601_Solucoes
	$cmbTecnico = $_POST['cmbTecnico'];
	$SenhaLPZ = $_POST['txtSenhaLPZ'];
	
	$pst_numero =$_POST['pst_numero'];
	$lote = substr($_POST['lote_LPZ'],0,3);
	$idSolu = $_POST['IdSolu'];
	$nome_mat = $_POST['nome_mat'];
	$loteIpen = $_POST['loteIpen'];
	$validade = $_POST['validade'];
	$mensa = ValidaSenha($cmbTecnico, $SenhaLPZ);

	$success = true;
	if($mensa != ""){
		$success = false;
		http_response_code(400);
		echo json_encode(array("message" => "There was an error processing the request"));
		return;
	}
	

	$stmt = $conn->prepare("exec crsa.uspP0602_Solucoes " .$pst_numero. ',' .$lote. ',' . $idSolu. ',' .$cmbTecnico );
	$stmt->execute();



}


if(isset($_POST['gravaVCD']) && !empty($_POST['gravaVCD'])) {
	include("../lib/DB.php");
	$SenhaVCD = $_POST['m_txtSenhaVCD'];
	$cmbTecnico = $_POST['m_cmbTecnico'];
	$mensa = ValidaSenha($cmbTecnico, $SenhaVCD);
	$success = true;
	if($mensa != ""){
		$success = false;
		http_response_code(400);
		echo json_encode(array("message" => "There was an error processing the request"));
		return;
	}

	$pst_numero =$_POST['pst_numero'];
	$datverficVCD = $_POST['m_datverficVCD'];
	$calibCRVCD = $_POST['m_calibCRVCD'];
	$modeloVCD = $_POST['m_modeloVCD'];
	$unidPrinVCD = $_POST['m_unidPrinVCD'];
	$localVCD = $_POST['m_localVCD'];
	$produtoVCD = $_POST['m_produtoVCD'];
	$loteVCD = $_POST['m_loteVCD'];
	$zeroVCD = $_POST['m_zeroVCD'];
	$testesisVCD = $_POST['m_testesisVCD'];
	$backgroundVCD = $_POST['m_backgroundVCD'];
	$confdadosVCD = $_POST['m_confdadosVCD'];
	$radiofonteVCD = $_POST['m_radiofonteVCD'];
	$idfonteVCD = $_POST['m_idfonteVCD'];
	$medidafonteVCD = $_POST['m_medidafonteVCD'];
	$valesperadoVCD = $_POST['m_valesperadoVCD'];
	$desvioVCD = $_POST['m_desvioVCD'];

	$repro01VCD  = $_POST['m_repro01VCD'];
	$repro02VCD  = $_POST['m_repro02VCD'];
	$repro03VCD  = $_POST['m_repro03VCD'];
	$repro04VCD  = $_POST['m_repro04VCD'];
	$repro05VCD  = $_POST['m_repro05VCD'];
	$repro06VCD  = $_POST['m_repro06VCD'];
	$repro07VCD  = $_POST['m_repro07VCD'];
	$repro08VCD  = $_POST['m_repro08VCD'];
	$repro09VCD  = $_POST['m_repro09VCD'];
	$repro10VCD  = $_POST['m_repro10VCD'];
	$reproSOMAVCD  = $_POST['m_reproSOMAVCD'];
	$reproUNMedVCD = $_POST['m_reproUNMedVCD'];
	$avg01VCD = $_POST['m_avg01VCD'];
	$avg02VCD = $_POST['m_avg02VCD'];
	$avg03VCD = $_POST['m_avg03VCD'];
	$obsVCD = $_POST['m_obsVCD'];
	


	$stmt = $conn->prepare("exec crsa.uspP0643_VerifCalibraDosesIU ".$pst_numero.", '"
	.$datverficVCD."', '"
	.$calibCRVCD."', '"
	.$modeloVCD."', '".$unidPrinVCD."', '".$localVCD."', '".$produtoVCD."', '".$loteVCD."', '".$zeroVCD."', '".$testesisVCD."', '".$backgroundVCD."', '".$confdadosVCD.
	"', '".$radiofonteVCD."', '".$idfonteVCD."', '".$medidafonteVCD."', '".$valesperadoVCD."', '".$desvioVCD."', '".$repro01VCD."', '".$repro02VCD."', '".$repro03VCD."', '".$repro04VCD."', '".$repro05VCD."', '".$repro06VCD."'
	, '".$repro07VCD."', '".$repro08VCD."', '".$repro09VCD."', '".$repro10VCD."', '".$reproSOMAVCD."', '".$reproUNMedVCD."', '".$avg01VCD."', '".$avg02VCD."', '".$avg03VCD."', '".$obsVCD."', '".$cmbTecnico."', ''");
	$stmt->execute();

}


if(isset($_POST['fonteCalib']) && !empty($_POST['fonteCalib'])) {
    $fonte = $_POST['fonteCalib'] ;
	$pst_numero = $_POST['pst_numero'];
	$tecnico = $_POST['tecnico'];

	echo ($pst_numero . ' - ' .$fonte . ' - ' .$tecnico);

	include("../lib/DB.php");
	$stmt = $conn->prepare("exec crsa.P0600_EQPTO_CALIB_A :param1, :param2, :param3");
	$param1 = $pst_numero; 
	$param2 = $fonte;
	$param3 = $tecnico; 
	$stmt->bindParam(1,  $param1, PDO::PARAM_STR);
	$stmt->bindParam(2,  $param2, PDO::PARAM_STR);
	$stmt->bindParam(3,  $param3, PDO::PARAM_STR);

	$stmt->execute();
	echo "<script>parent.toastApp(3000,'Fonte de Calibração Gravado','OK');</script>";


}

if(isset($_POST["gravaPedidoInterno"])){
	//var_dump($_POST);
	$usu = $_POST['cmbTecnico'];
	$pas = $_POST['txtSenha'];
	$pst_numero = $_POST['tpstnumero'];

	$mensa = ValidaSenha($usu, $pas);
	if($mensa != ""){
		echo "<script>parent.toastApp(3000,'".$mensa."','ERRO');</script>";
		die;
	}
	
	include("../lib/DB.php");
	$stmt = $conn->prepare("exec crsa.P0647_PEDIDO_INTERNO :param1, :param2, :param3, :param4, :param5, :param6, :param7, :param8, :param9, :param10, :param11, :param12, :param13, :param14");
	$param1 = $_POST['tpstnumero']; 
	$param2 = $_POST['txtAtvMM']; 
	$param3 = $_POST['txtVolMM']; 
	$param4 = $_POST['txtDatMM']; 
	$param5 = $_POST['txtAtvCAPS']; 
	$param6 = $_POST['txtVolCAPS']; 
	$param7 = $_POST['txtDatCAPS']; 
	$param8 = $_POST['txtAtvPesq']; 
	$param9 = $_POST['txtVolPesq']; 
	$param10 = $_POST['txtDatPesq']; 
	$param11 = $_POST['txtAtvTotal']; 
	$param12 = $_POST['txtVolTotal']; 
	$param13 = $_POST['txtDatTotal']; 
	$param14 = $usu;
	


	$param4 = str_replace('T',' ',$param4);
	$param7 = str_replace('T',' ',$param7);
	$param10 = str_replace('T',' ',$param10);
	$param13 = str_replace('T',' ',$param13);

	$stmt->bindParam(1,  $param1, PDO::PARAM_STR);
	$stmt->bindParam(2,  $param2, PDO::PARAM_STR);
	$stmt->bindParam(3,  $param3, PDO::PARAM_STR);
	$stmt->bindParam(4,  $param4, PDO::PARAM_STR);
	$stmt->bindParam(5,  $param5, PDO::PARAM_STR);
	$stmt->bindParam(6,  $param6, PDO::PARAM_STR);
	$stmt->bindParam(7,  $param7, PDO::PARAM_STR);
	$stmt->bindParam(8,  $param8, PDO::PARAM_STR);
	$stmt->bindParam(9,  $param9, PDO::PARAM_STR);
	$stmt->bindParam(10, $param10, PDO::PARAM_STR);
	$stmt->bindParam(11, $param11, PDO::PARAM_STR);
	$stmt->bindParam(12, $param12, PDO::PARAM_STR);
	$stmt->bindParam(13, $param13, PDO::PARAM_STR);
	$stmt->bindParam(14, $param14, PDO::PARAM_STR);
	
	
	
	//echo $param4;
	
	$stmt->execute();




	echo "<script>parent.toastApp(3000,'Pedido Interno Gravado','OK');</script>";
	
	// T0647_PEDIDO_INTERNO
	//echo "OK";
	//echo $pst_numero;


	
}

if(isset($_POST["gravaNovoEquipamento"])){
	//var_dump($_POST);
	//var_dump($_GET);

	include("../lib/DB.php");
	$stmt = $conn->prepare("exec crsa.P0600_EQPTO_I :param1, :param2, :param3, :param4, :param5, :param6");
	$param1 = $_POST['pst_numero'];
	$param2 = $_POST['sncr'];
	$param3 = $_POST['cmbTecnico'];
	$param4 = $_POST['m_txtSenha'];
	$param5 = "";
	$param6 = "";


	$stmt->bindParam(1, $param1, PDO::PARAM_STR);
	$stmt->bindParam(2, $param2, PDO::PARAM_STR);
	$stmt->bindParam(3, $param3, PDO::PARAM_STR);
	$stmt->bindParam(4, $param4, PDO::PARAM_STR);
	$stmt->bindParam(5, $param5, PDO::PARAM_STR);
	$stmt->bindParam(6, $param6, PDO::PARAM_STR);
	$stmt->execute();
	

	/*
	$result_check = '0';
	$result_mensa = '';

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$result_check = $row['resulta'];
		$result_mensa = $row['mensa'];
	}
	
	if ($result_check == '0'){
		echo "<script>parent.toastApp(3000,'Equipamento Incluído','OK');</script>";
	}
	else{
		echo "<script>parent.toastApp(3000,'".$result_mensa."','ERRO');</script>";
	}
	*/
}

if(isset($_POST["gravaNovoMaterial"])){
	//var_dump($_POST);
	//var_dump($_GET);

	
	include("../lib/DB.php");
	$sOrig = "";
	if ($_POST["sOrig"] == "Almoxarifado"){
		$sOrig = "1";
	}
	if ($_POST["sOrig"] == "Frascos & Soluções"){
		$sOrig = "2";
	}
	if ($_POST["sOrig"] == "Outros"){
		$sOrig = "3";
	}

	$lote = explode(" ", $_POST['LoteList']);

	$stmt = $conn->prepare("set nocount on; exec crsa.uspP0600_MATERIAIS 	:param1,  :param2,  :param3,  :param4,  :param5,
																			:param6,  :param7,  :param8,  :param9,  :param10,
																			:param11, :param12, :param13, :param14, :param15,
																			:param16, :param17, :param18, :param19, :param20, 
																			:param21, :param22, :param23, :param24, :param25
	");


	$pp1 = $_POST["txtCodigoList"];
	if ($pp1==""){
		$param1 = "0";	
	}
	else {
		$param1 = $pp1;	
	}

	


	//$param1 = "0";
	$param2 = $_POST["pst_numero"];
	$param3 = $sOrig;
	$param4 = $_POST["matMarca"];
	$param5 = $_POST["txtLoteCR"];
	$param6 = $_POST["txtQtde1"];
	$param7 = 0;//$_POST["txtQtde2"];
	$param8 = $_POST["txtPosicao"];
	$param9 = "1";
	$param10 = $_POST["cmbTecnico"];
	$param11 = $_POST["m_txtSenha"];
	$param12 = "2";
	$param13 =  $_POST["matMaterial"];
	$param14 = '0';
	$param15 = $_POST["cmbTecnico"];
	$param16 = str_replace('-','',$_POST["txtValidade"]);
	$param17 = $_POST["txtTipoCorCR"];
	$param18 = $_POST["txtLoteEsterCQ"];
	$param19 = $_POST["txtLoteIPEN"];
	$param20 = '';
	$param21 = '';
	$param22 = $_POST["txtCodigoMat"];
	$param23 = $lote[0];
	$param24 = $_POST["txtLoteFab"];
	$param25 = $_POST["txtUnidade"];
	
	//echo $param22;
	//echo $param23;
	

	
	$stmt->bindParam( 1, $param1,  PDO::PARAM_STR);
	$stmt->bindParam( 2, $param2,  PDO::PARAM_STR);
	$stmt->bindParam( 3, $param3,  PDO::PARAM_STR);
	$stmt->bindParam( 4, $param4,  PDO::PARAM_STR);
	$stmt->bindParam( 5, $param5,  PDO::PARAM_STR);
	$stmt->bindParam( 6, $param6,  PDO::PARAM_STR);
	$stmt->bindParam( 7, $param7,  PDO::PARAM_STR);
	$stmt->bindParam( 8, $param8,  PDO::PARAM_STR);
	$stmt->bindParam( 9, $param9,  PDO::PARAM_STR);
	$stmt->bindParam(10, $param10, PDO::PARAM_STR);
	$stmt->bindParam(11, $param11, PDO::PARAM_STR);
	$stmt->bindParam(12, $param12, PDO::PARAM_STR);
	$stmt->bindParam(13, $param13, PDO::PARAM_STR);
	$stmt->bindParam(14, $param14, PDO::PARAM_STR);
	$stmt->bindParam(15, $param15, PDO::PARAM_STR);
	$stmt->bindParam(16, $param16, PDO::PARAM_STR);
	$stmt->bindParam(17, $param17, PDO::PARAM_STR);
	$stmt->bindParam(18, $param18, PDO::PARAM_STR);
	$stmt->bindParam(19, $param19, PDO::PARAM_STR);
	$stmt->bindParam(20, $param20, PDO::PARAM_STR);
	$stmt->bindParam(21, $param21, PDO::PARAM_STR);
	$stmt->bindParam(22, $param22, PDO::PARAM_STR);
	$stmt->bindParam(23, $param23, PDO::PARAM_STR);
	$stmt->bindParam(24, $param24, PDO::PARAM_STR);
	$stmt->bindParam(25, $param25, PDO::PARAM_STR);
	$stmt->execute();
	

}

if(isset($_POST["btnGravaRP"])){
	//var_dump($_POST);
	//var_dump($_GET);
	include("../lib/DB.php");
	
	$stmt = $conn->prepare("set nocount on; exec crsa.Ppst_GRAVA_RD :param1,  :param2,  :param3,  :param4,  :param5,  :param6,  :param7");
	$param1 = $_POST["pstnro1"];
	$param2 = $_POST["txtObservacaoRP"];
	$param3 = $_POST["cmbProcessoProdRP"];
	$param4 = $_POST["cmbResponsavelProdRP"];
	$param5 = $_POST["txtSenhaRP"];
	$param6 = "";
	$param7 = "";
	$stmt->bindParam( 1, $param1,  PDO::PARAM_STR);
	$stmt->bindParam( 2, $param2,  PDO::PARAM_STR);
	$stmt->bindParam( 3, $param3,  PDO::PARAM_STR);
	$stmt->bindParam( 4, $param4,  PDO::PARAM_STR);
	$stmt->bindParam( 5, $param5,  PDO::PARAM_STR);
	$stmt->bindParam( 6, $param6,  PDO::PARAM_STR);
	$stmt->bindParam( 7, $param7,  PDO::PARAM_STR);
	$stmt->execute();	
	

	
	
}


if(isset($_POST["gravaRendProcesso"])){

	if (  ValidaSenha($_POST["cmbTecnico"], $_POST["txtSenha"]) !=""){
		echo "<script>parent.toastApp(3000,'Senha Inválida','ERRO')</script>";
		die;
	}

	//var_dump($_POST);

	$query= "update [crsa].[T0111_Rendimento_Processo] set 
	        tot_ped_atend = ".$_POST["txtTotPedAtend"] .",
	        tot_ped_prev = ".$_POST["txtTotPedPrev"] .",
	        tot_rendimento = ".$_POST["txtTotRend"] .",
	        cdusuario = ".$_POST["cmbTecnico"] .",
			datusu = getdate() " ."
	where id = ".$_POST["nrID"];
	

	$stmt = $conn->query($query);
	echo "<script>parent.toastApp(3000,'Rendimento do Processo Gravado','OK');</script>";

}


if(isset($_POST["gravaFrascoAmostra"])){
	//var_dump($_POST);
	//var_dump($_GET);

	$p1= $_POST["id1"];
	$p2= $_POST["id2"];
	$p3= $_POST["txtIdent"];
	$p4= $_POST["txtAtividade"];
	$p5= $_POST["txtVolume"];
	$p6 = $_SESSION['usuarioID'];
	
	include("../lib/DB.php");		
	//$stmt = $conn->prepare("exec crsa.P0551_FRASCOS_IA " . $p2 . "," . $p1 . "," . $p5 . "," . $p4 . ",'" . $p3 ."',null, null," . $p6 .",'',''");
	$stmt = $conn->prepare("exec crsa.P0551_FRASCOS_IA @p551_cq_id=".$p2.", @p551_frascos_id=".$p1.", @p551_volume=".$p5.", @p551_atividade=".$p4.", @p551_identificacaoamostra='".$p3."', @cdusuario='".$p6."', @resulta=0, @mensa = ''");
	$stmt->execute();
}

if(isset($_POST["ExcluiFrascoAmostra"])){
	$p1= $_POST["id1"];
	$p2= $_POST["id2"];
	include("../lib/DB.php");		
	$stmt = $conn->prepare("delete crsa.T0551_CQ_FRASCOS where  P551_Frascos_ID = ". $p1 . " and p551_CQ_ID = " . $p2);
	$stmt->execute();

}

if(isset($_POST["GravaAmostraCab"])){
	$p1= $_POST["p1"];
	$p2= $_POST["p2"];
	$p3= $_POST["p3"];
	$p4= $_POST["p4"];
	$p5= $_POST["p5"];
	$p6= $_POST["p6"];
	$p7= $_POST["p7"];
	$p8= $_POST["p8"];
	$p2 = str_replace(":","", $p2);


    $exec = "";
	$exec .= "exec crsa.P0551_FRASCOSCAB_IA ";
	$exec .= "@p551_cq_id				 = "  . $p1 . " , ";
	$exec .= "@p551_HoraAmostragem       = '" . $p2 . "', ";
	$exec .= "@p551_PH                   = '" . $p3 . "', ";
	$exec .= "@p551_obs                  = '" . $p4 . "', ";
	$exec .= "@pst_numero				 = "  . $p5 . ", ";
	$exec .= "@tipo_analise              = 0, ";
	$exec .= "@p053_reanaliseid          = 0, ";
	$exec .= "@cdusuario                 = " . $p6 . ", ";
	$exec .= "@senha                     = '" . $p7 . "', ";
	$exec .= "@p031_aspectoid            = " . $p8 . ", ";
	$exec .= "@resulta                   = '', ";
	$exec .= "@mensa                     = '', ";
	$exec .= "@p551_cq_id_out            = '' ";


	include("../lib/DB.php");		
	//$stmt = $conn->prepare("exec crsa.P0551_FRASCOSCAB_IA");
	$stmt = $conn->prepare($exec) ;	
	$stmt->execute();

}






if(isset($_POST["btnGravaGQ"])){
	//var_dump($_POST);
	//var_dump($_GET);
	include("../lib/DB.php");
	$stmt = $conn->prepare("set nocount on; exec crsa.Ppst_GRAVA_GQ :param1,  :param2,  :param3,  :param4,  :param5,  :param6,  :param7");
	$param1 = $_POST["pstnro2"];
	$param2 = $_POST["txtObservacaoGQ"];
	$param3 = $_POST["cmbProcessoProdGQ"];
	$param4 = $_POST["cmbResponsavelProdGQ"];
	$param5 = $_POST["txtSenhaGQ"];
	$param6 = "";
	$param7 = "";
	$stmt->bindParam( 1, $param1,  PDO::PARAM_STR);
	$stmt->bindParam( 2, $param2,  PDO::PARAM_STR);
	$stmt->bindParam( 3, $param3,  PDO::PARAM_STR);
	$stmt->bindParam( 4, $param4,  PDO::PARAM_STR);
	$stmt->bindParam( 5, $param5,  PDO::PARAM_STR);
	$stmt->bindParam( 6, $param6,  PDO::PARAM_STR);
	$stmt->bindParam( 7, $param7,  PDO::PARAM_STR);

	$stmt->execute();	

	
}

if(isset($_POST["verLoteExiste"])){
	include ("lib/DB.php");
	echo "VER EXISTE LOTE FUNÇÃO<br>";
	//var_dump($_POST);


	$stmt = $conn->prepare("exec crsa.uspP0110_LOTE_NUMERO :param1");
	$param1 = $_POST['m_txtLote'];
	$stmt->bindParam(1, $param1, PDO::PARAM_STR);
	$stmt->execute();
	
	$var1 = '';
	$var2 = '';
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		if ($row['p110situ'] == 1){
			$var1 = 0;
		}
		else{
			$var1 = number_format($row['p110atv'], 0);
			$var2 = $row['p110dtpx'];
			$var2 = substr($row['p110dtpx'],6,4). '-';
			$var2 = $var2.substr($row['p110dtpx'],3,2) . '-';
			$var2 = $var2.substr($row['p110dtpx'],0,2) ;
			$var2 = $var2.substr($row['p110dtpx'],10,6);


			$var3 = $row['p110dtvl'];
			$var3 = substr($row['p110dtvl'],6,4). '-';
			$var3 = $var3.substr($row['p110dtvl'],3,2) . '-';
			$var3 = $var3.substr($row['p110dtvl'],0,2) ;
			$var3 = $var3.substr($row['p110dtvl'],10,6);

			$var4 = number_format($row['p110cr'], 2);
			$var5 = number_format($row['p110volu'], 2);
			$var6 = number_format($row['p110espe'], 2);

		}
	}
	
	//echo $var1 .'<br>';
	//echo $var2 .'<br>';
	//echo $var3 .'<br>';
	//echo $var4 .'<br>';
	//echo $var5 .'<br>';
	//echo $var6 .'<br>';

	

	echo "<script> parent.myFunction1('".$var1."', '".$var2."', '".$var3."', '".$var4."', '".$var5."', '".$var6."'); </script>";

}

if(isset($_POST["gravaPedidoExtra"])){
	echo "Grava Pedido Extra FUNÇÃO<br>";

	$lote         = $_POST['m_txtLote'];
	$atividade    = $_POST['m_txtAtividade'];
	$calibracao   = $_POST['m_txtCalibracao'];
	$validade     = $_POST['m_txtValidade'];
	$concentracao = $_POST['m_txtConcentracao'];
	$volume       = $_POST['m_txtVolume'];
	$atvespec     = $_POST['m_txtAtivEspec'];
	$senha        = $_POST['m_txtSenha'];

	//verificar senha
	$strQS = 'crsa.P1110_confsenha';
	$strQS = $strQS . '@p1110_usuarioid=' . $_SESSION['usuarioID'];
    $strQS = $strQS . '@p1110_senha=' . $senha;

	$stmt = $conn->prepare("exec vendasPelicano.dbo.uspP1110_confsenha :param1, :param2");
	$param1 = $_SESSION['usuarioID'];
	$param2 = $senha;
	$stmt->bindParam(1, $param1, PDO::PARAM_STR);
	$stmt->bindParam(2, $param2, PDO::PARAM_STR);
	$stmt->execute();



	$senha_check = 0;
	$senha_mensa = '';
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$senha_check = $row['Resulta'];
		$senha_mensa = $row['mensa'];
	}


	if ($senha_check == 1){
		echo "<script> parent.myFunction(3000, 'Senha Não Confere', '2'); </script>";
		die;
	}
	


	$stmt = $conn->prepare("exec crsa.uspP0110_LN_ACERTO :param1, :param2, :param3, :param4, :param5, :param6");
	$param1 = $lote;
	$param2 = str_replace('-','',$calibracao);
	$param2 = str_replace('T',' ',$param2);
	$param3 = $concentracao;
	$param4 = $volume;
	$param5 = $atvespec;
	$param6 = str_replace('-','',$validade);

	$stmt->bindParam(1, $param1, PDO::PARAM_STR);
	$stmt->bindParam(2, $param2, PDO::PARAM_STR);
	$stmt->bindParam(3, $param3, PDO::PARAM_STR);
	$stmt->bindParam(4, $param4, PDO::PARAM_STR);
	$stmt->bindParam(5, $param5, PDO::PARAM_STR);
	$stmt->bindParam(6, $param6, PDO::PARAM_STR);
	$stmt->execute();
	
	$result_check = 0;
	$result_mensa = '';
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$result_check = $row['resulta'];
		$result_mensa = $row['mensa'];
	}


 
	if ($result_check == 0){
		echo "<script> parent.myFunction(3000, 'Pedido Extra gravado com sucesso.', '1'); </script>";
	}
	else{
		echo "<script> parent.myFunction(3000, '" .$result_mensa. "', '2'); </script>";
	}

}

if(isset($_POST["acao"])){
	//var_dump($_POST);
	if ($_POST['acao'] == "excluireqp"){
		include("../lib/DB.php");
		$stmt = $conn->prepare("exec crsa.P0600_EQPTO_E :param1, :param2, :param3, :param4, :param5, :param6");
		$param1 = $_POST['tpst_numero'];
		$param2 = $_POST['ideqpAlt'];
		$param3 = $_POST['cmbTecnico'];
		$param4 = $_POST['txtSenha'];
		$param5 = "";
		$param6 = "";
		$stmt->bindParam(1, $param1, PDO::PARAM_STR);
		$stmt->bindParam(2, $param2, PDO::PARAM_STR);
		$stmt->bindParam(3, $param3, PDO::PARAM_STR);
		$stmt->bindParam(4, $param4, PDO::PARAM_STR);
		$stmt->bindParam(5, $param5, PDO::PARAM_STR);
		$stmt->bindParam(6, $param6, PDO::PARAM_STR);
		$stmt->execute();
		//var_dump($_POST)."<br>";
		//echo 'ExcluirEQPTO';
	}
	
	if ($_POST['acao'] == "alterareqp"){
		//var_dump($_POST)."<br>";
		//echo $_POST[idcateg]."<br>";
		//echo $_POST[ideqpAlt]."<br>";
		//echo $_POST[cmbTecnico]."<br>";
		//echo $_POST[txtSenha]."<br>";
		include("../lib/DB.php");
		$stmt = $conn->prepare("exec crsa.P0600_EQPTO_A :param1, :param2, :param3, :param4, :param5, :param6");
		$param1 = $_POST['idcateg'];
		$param2 = $_POST['ideqpAlt'];
		$param3 = $_POST['cmbTecnico'];
		$param4 = $_POST['txtSenha'];
		$param5 = "";
		$param6 = "";
	
		$stmt->bindParam(1, $param1, PDO::PARAM_STR);
		$stmt->bindParam(2, $param2, PDO::PARAM_STR);
		$stmt->bindParam(3, $param3, PDO::PARAM_STR);
		$stmt->bindParam(4, $param4, PDO::PARAM_STR);
		$stmt->bindParam(5, $param5, PDO::PARAM_STR);
		$stmt->bindParam(6, $param6, PDO::PARAM_STR);
		$stmt->execute();
		
		$result_check = '0';
		$result_mensa = '';
		
		//while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		//	$result_check = $row['resulta'];
		//	$result_mensa = $row['mensa'];
		//}
		


		//if ($result_check == '0'){
		//	echo "<script>parent.toastApp(3000,'Equipamento Alterado','OK');</script>";
		//}
		//else{
		//	echo "<script>parent.toastApp(3000,'".$result_mensa."','ERRO');</script>";
		//}

		echo "fim de processo";
		//echo $result_mensa;

		

	}
}

if(isset($_POST["acao"])){
	//var_dump($_POST);
	if ($_POST['acao'] == "excluireqp"){
		include("../lib/DB.php");
		$stmt = $conn->prepare("exec crsa.P0600_EQPTO_E :param1, :param2, :param3, :param4, :param5, :param6");
		$param1 = $_POST['tpst_numero'];
		$param2 = $_POST['ideqpAlt'];
		$param3 = $_POST['cmbTecnico'];
		$param4 = $_POST['txtSenha'];
		$param5 = "";
		$param6 = "";
		$stmt->bindParam(1, $param1, PDO::PARAM_STR);
		$stmt->bindParam(2, $param2, PDO::PARAM_STR);
		$stmt->bindParam(3, $param3, PDO::PARAM_STR);
		$stmt->bindParam(4, $param4, PDO::PARAM_STR);
		$stmt->bindParam(5, $param5, PDO::PARAM_STR);
		$stmt->bindParam(6, $param6, PDO::PARAM_STR);
		$stmt->execute();
		//var_dump($_POST)."<br>";
		//echo 'ExcluirEQPTO';
	}

}	


if(isset($_POST["acao"])){
	if ($_POST['acao'] == "excluiInfRadio"){
		include("../lib/DB.php");		
		$stmt = $conn->prepare("delete [crsa].[T643_I131_InformRadioisotopo] where nr_ID =" . $_POST['nr_id']);
		$stmt->execute();
		echo "<script>parent.toastApp(3000,'Informações de Radio Excluido','OK');</script>";

	}
}

if(isset($_POST["acao"])){
	if ($_POST['acao'] == "excluirmat"){
		//var_dump($_POST);
		include("../lib/DB.php");


		if ( ValidaSenha($_POST["cmbTecnico"], $_POST["txtSenha"]) != ""){
			echo "<script>parent.toastApp(3000,'Senha Inválida','ERRO')</script>";
			//die;
		}
	


		
		$stmt = $conn->prepare("set nocount on;exec crsa.P0600_materiais_E :param1, :param2, :param3, :param4, :param5, :param6");
		$param1 = $_POST['p600_id'];
		$param2 = '0';
		$param3 = $_POST['cmbTecnico'];
		$param4 = $_POST['txtSenha'];
		$param5 = "0";
		$param6 = "";
	
		
		$stmt->bindParam(1, $param1, PDO::PARAM_STR);
		$stmt->bindParam(2, $param2, PDO::PARAM_INT);
		$stmt->bindParam(3, $param3, PDO::PARAM_STR);
		$stmt->bindParam(4, $param4, PDO::PARAM_STR);
		$stmt->bindParam(5, $param5, PDO::PARAM_INT);
		$stmt->bindParam(6, $param6, PDO::PARAM_STR);
		$stmt->execute();
		
		$result_check = '0';
		$result_mensa = '';
		
		//while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		//	$result_check = $row['resulta'];
		//	$result_mensa = $row['mensa'];
		//}
		


		//if ($result_check == '0'){
			echo "<script>parent.toastApp(3000,'Material Excluido','OK');</script>";
		//}
		//else{
		//	echo "<script>parent.toastApp(3000,'".$result_mensa."','ERRO');</script>";
		//}
		//echo "fim de processo";
		//echo $result_mensa;
	
		

	}
}


if(isset($_POST["acao"])){
	if ($_POST['acao'] == "excluiEscTarefa"){
		var_dump($_POST)."<br>";
		include("../lib/DB.php");		
		$stmt = $conn->prepare("delete [crsa].[T0111_ESCALA_TAREFAS] where ID =" . $_POST['id']);
		//$stmt->execute();
		//echo "<script>parent.toastApp(3000,'Registro Excluido','OK');</script>";



		if (!$stmt->execute()){
			echo "<script>parent.toastApp(3000,'OPS Algo deu errado. Sua solicitação não pode ser atendida ','ERRO')</script>";
		}
		else{
			echo "<script>parent.toastApp(3000,'Registro Excluído com SUCESSO','OK')</script>";
		}


		/*
		try{
			$stmt->execute();
			echo "<script>parent.toastApp(3000,'Registro Excluído com SUCESSO','OK')</script>";
		}catch (PDOException  $e) {
			echo "<script>parent.toastApp(3000,'".$e."','OK')</script>";
		}
		*/



	}
}




if(isset($_POST["acaodel"])){
	if ($_POST['acaodel'] == "excluiEscSemanal"){
		var_dump($_POST)."<br>";
		include("../lib/DB.php");		
		$stmt = $conn->prepare("delete [crsa].[T0111_ESCALA_SEMANAL] where ID =" . $_POST['nr_ID']);
		//$stmt->execute();
		//echo "<script>parent.toastApp(3000,'Registro Excluido','OK');</script>";



		if (!$stmt->execute()){
			echo "<script>parent.toastApp(3000,'OPS Algo deu errado. Sua solicitação não pode ser atendida ','ERRO')</script>";
		}
		else{
			echo "<script>parent.toastApp(3000,'Registro Excluído com SUCESSO','OK')</script>";
		}


	}
}


if(isset($_POST["acaodel"])){
	if ($_POST['acaodel'] == "duplicaEscSemanal"){
		var_dump($_POST)."<br>";
		include("../lib/DB.php");		
		$stmt = $conn->prepare("exec [crsa].[uspPEscalaSemanal_Duplica]");
		//$stmt->execute();
		//echo "<script>parent.toastApp(3000,'Registro Excluido','OK');</script>";



		if (!$stmt->execute()){
			echo "<script>parent.toastApp(3000,'OPS Algo deu errado. Sua solicitação não pode ser atendida ','ERRO')</script>";
		}
		else{
			echo "<script>parent.toastApp(3000,'Registro Excluído com SUCESSO','OK')</script>";
		}


	}
}




if(isset($_POST["GravaLiberaArea"])){
	//echo "GravaLibArea<br>";
	//echo $_SESSION['usuarioLogin'];
	//echo $_SESSION['usuarioSenha'];
	//echo $_SESSION['usuarioID'];
	


	if ($_SESSION['usuarioSenha'] <> $_POST['txtSenha']){
		//echo "<script>alert('erro senha')</script>";
		echo "<script>parent.toastApp(3000,'***   SENHA INVÁLIDA   ***','ERRO')</script>"	;
		die;
	}

	if ($_POST["produto"] == "rd_i131"){
		$proc = "crsa.P0643_I131_LIBERAAREA";
	}

	if ($_POST["produto"] == "rd_ga67"){
		$proc = "crsa.P0607_LIBERAAREA";
	}

	

	for ($i = 1; $i <= 7; $i++) {
		$pLin =  $_POST[$i.'linhaS'];
		$pId  =  $_POST['IDfield'.$i];
		$stmt = $conn->prepare("exec " . $proc . " :param1, :param2, :param3, :param4, :param5");
		$param1 = $_POST['tpst_numero'];
		$param2 = 'U';
		$param3 = $pId;
		$param4 = $pLin;
		$param5 = $_SESSION['usuarioID'];


		
		$stmt->bindParam(1, $param1, PDO::PARAM_STR);
		$stmt->bindParam(2, $param2, PDO::PARAM_STR);
		$stmt->bindParam(3, $param3, PDO::PARAM_STR);
		$stmt->bindParam(4, $param4, PDO::PARAM_STR);
		$stmt->bindParam(5, $param5, PDO::PARAM_STR);
		$stmt->execute();
	

	}

  
    echo "<script>parent.toastApp(3000,'Registro Gravado com SUCESSO','OK')</script>";
  

}


if(isset($_POST["GravaEmbPrimaria"])){
	//echo "GravaLibArea<br>";
	//echo $_SESSION['usuarioLogin'];
	//echo $_SESSION['usuarioSenha'];
	//echo $_SESSION['usuarioID'];

	if ($_SESSION['usuarioSenha'] <> $_POST['txtSenha']){
		//echo "<script>alert('erro senha')</script>";
		echo "<script>parent.toastApp(3000,'***   SENHA INVÁLIDA   ***','ERRO')</script>"	;
		die;
	}

	if ($_POST["produto"]  == "rd_i131"){
		$proc = "crsa.P0643_I131_EMBPRIMARIA";
	}

	if ($_POST["produto"]  == "rd_ga67"){
		$proc = "crsa.P0607_EMBPRIMARIA ";
	}

	echo $_POST["produto"];

	for ($i = 1; $i <= 2; $i++) {
		$pLin =  $_POST[$i.'linhaS'];
		$pId  =  $_POST['IDfield'.$i];
		$stmt = $conn->prepare("exec " . $proc . " :param1, :param2, :param3, :param4, :param5");
		$param1 = $_POST['tpst_numero'];'';
		$param2 = 'U';
		$param3 = $pId;
		$param4 = $pLin;
		$param5 = $_SESSION['usuarioID'];
		$stmt->bindParam(1, $param1, PDO::PARAM_STR);
		$stmt->bindParam(2, $param2, PDO::PARAM_STR);
		$stmt->bindParam(3, $param3, PDO::PARAM_STR);
		$stmt->bindParam(4, $param4, PDO::PARAM_STR);
		$stmt->bindParam(5, $param5, PDO::PARAM_STR);
		$stmt->execute();
	

	}

  
    echo "<script>parent.toastApp(3000,'Registro Gravado com SUCESSO','OK')</script>";
  

}

if(isset($_POST["GravaInfRadio"])){
	//var_dump($_POST);
	if ($_SESSION['usuarioSenha'] <> $_POST['txtSenha']){
		//echo "<script>alert('erro senha')</script>";
		echo "<script>parent.toastApp(3000,'***   SENHA INVÁLIDA   ***','ERRO')</script>";
		die;
	}

    include("../lib/DB.php");
    
	$volume1 = str_replace(',','.',$_POST['txtVolume1']);
	$volume2 = str_replace(',','.',$_POST['txtVolume2']);
	$volume3 = str_replace(',','.',$_POST['txtVolume3']);
	
	
	$top_conc1 = $_POST['txtVolume1'] != 0 ? ($_POST['txtMedDtProg1'] / $volume1) : 0;
	$top_conc2 = $_POST['txtVolume2'] != 0 ? ($_POST['txtMedDtProg2'] / $volume2) : 0;
	$top_conc3 = $_POST['txtVolume3'] != 0 ? ($_POST['txtMedDtProg3'] / $volume3) : 0;



	$qs = "exec crsa.P0643_I131_InformRadioisotopo ";
	$qs .= "@pst_numero='".$_POST['tpst_numero'] ."',";
	$qs .= "@nomefornec1='".$_POST['txtNomeFornecedor1']."',";
	$qs .= "@ativ1='".$_POST['txtAtvTotImp1']."',";
	$qs .= "@volu1='".$volume1."',";
	$qs .= "@dtreceb1='".str_replace('T',' ',str_replace('-','',$_POST['txtDtReceb1']))."',";
	$qs .= "@dtcalib1='".str_replace('T',' ',str_replace('-','',$_POST['txtDtCalib1']))."',";
	$qs .= "@vlmedida1='".$_POST['txtMedDtProg1']."',";
	$qs .= "@dtmedida1='".str_replace('T',' ',str_replace('-','',$_POST['txtDtProg1']))."',";
	$qs .= "@crteo1='" .$top_conc1."',";

	$qs .= "@nomefornec2='".$_POST['txtNomeFornecedor2']."',";
	$qs .= "@ativ2='".$_POST['txtAtvTotImp2']."',";
	$qs .= "@volu2='".$volume2."',";
	$qs .= "@dtreceb2='".str_replace('T',' ',str_replace('-','',$_POST['txtDtReceb2']))."',";
	$qs .= "@dtcalib2='".str_replace('T',' ',str_replace('-','',$_POST['txtDtCalib2']))."',";
	$qs .= "@vlmedida2='".$_POST['txtMedDtProg2']."',";
	$qs .= "@dtmedida2='".str_replace('T',' ',str_replace('-','',$_POST['txtDtProg2']))."',";
	$qs .= "@crteo2='".$top_conc2."',";

	$qs .= "@lote3='".$_POST['txtLote3']."',";
	$qs .= "@ativ3='".$_POST['txtAtvTot3']."',";
	$qs .= "@volu3='".$volume3."',";
	$qs .= "@dtreceb3='".str_replace('T',' ',str_replace('-','',$_POST['txtDtReceb3']))."',";
	$qs .= "@dtcalib3='".str_replace('T',' ',str_replace('-','',$_POST['txtDtCalib3']))."',";
	$qs .= "@vlmedida3='".$_POST['txtMedDtProg3']."',";
	$qs .= "@dtmedida3='".str_replace('T',' ',str_replace('-','',$_POST['txtDtProg3']))."',";
	$qs .= "@crteo3='".$top_conc3."',";

	$qs .= "@cdusuario='". 	$_SESSION['usuarioID'] ."',";

	$qs .= "@acao='I',";
	$qs .= "@out='X'";


    $stmt = $conn->prepare($qs);
    //$stmt->execute();
	if ($stmt->execute()) { 
		echo "<script>parent.toastApp(3000,' Registro Salvo com Sucesso ','OK')</script>";
	 } else {
		echo "<script>parent.toastApp(3000,'***   ERRO NA OPERAÇÃO   ***<br>REVISE AS INFORMAÇÕES','ERRO')</script>";
	 }



	//var_dump($_POST);
	//echo $qs;
	
	




}

if(isset($_POST["calcDilu1"])){
	//var_dump($_POST);
	$pst_numero = $_POST['ttxtPst_Numero'];
	$produto    = $_POST['ttxt_Produto'];
	$partIni    = $_POST['PedAtvIni1'];
	$partFim    = $_POST['PedAtvFim1'];
	$lote       = substr($_POST['ttxtLote'],0,3);

	//echo $lote;	

	switch ($produto) {
		case "rd_i131";
			$produto = "I-131";
		case "rd_ga67";
			$produto = "ga-67";
		case "rd_tl";
			$produto = "TLCL3";
		case "rd_mo";
			$produto = "I-131";
	}

	if ($partIni==''){$partIni=0;}
	if ($partFim==''){$partFim=0;}
	include("../lib/DB.php");
	$query = "exec sgcr.crsa.uspP0110_PEDIDOS_CONTA " .$pst_numero ."," .$partIni. ",". $partFim ; 
	$stmt = $conn->query($query);

	$regs=0;
	$parts=0;
	$lotes_atendidos = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$regs  = $row["nro_regs"];
		$parts = $row["p110atv"];
	}
	
	$query = "select  crsa.fn_LotesAtendidos('".$produto."',".$partIni.", ".$partFim.", ".$lote.") "; 
	$stmt = $conn->query($query);

	try{
		while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
			$lotes_atendidos  = $row;
		}
	}
	catch(PDOException $e){}

	$lotes_atendidos = trim($lotes_atendidos[0]['']);
	

	echo "<script>parent.document.getElementById('partidas1').value ='" .$regs."'</script>";
	echo "<script>parent.document.getElementById('totatv1').value ='" .$parts."'</script>";
	echo "<script>parent.document.getElementById('pedatend1').value ='" .$lotes_atendidos."'</script>";
	
	$partIni =  $partIni-1;
    
	$query = "exec sgcr.crsa.uspP0110_PEDIDOS_CONTA " .$pst_numero ."," ."0". ",". $partIni; 
	//echo $query;
	$stmt = $conn->query($query);
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$regs  = $row["nro_regs"];
		$parts = $row["p110atv"];
	}

	//echo "<br>".$regs;
	echo "<script>parent.document.getElementById('partidasmenor1').value ='" .$regs."'</script>";
	echo "<script>parent.document.getElementById('totatvmenor1').value ='" .$parts."'</script>";
}

if(isset($_POST["calcDilu2"])){
	//var_dump($_POST);
	$pst_numero = $_POST['ttxtPst_Numero'];
	$produto    = $_POST['ttxt_Produto'];
	$partIni    = $_POST['PedAtvIni2'];
	$partFim    = $_POST['PedAtvFim2'];
	$lote       = substr($_POST['ttxtLote'],0,3);

	switch ($produto) {
		case "rd_i131";
			$produto = "I-131";
		case "rd_ga67";
			$produto = "ga-67";
		case "rd_tl";
			$produto = "TLCL3";
		case "rd_mo";
			$produto = "I-131";
	}


	if ($partIni==''){$partIni=0;}
	if ($partFim==''){$partFim=0;}
	include("../lib/DB.php");
	$query = "exec sgcr.crsa.uspP0110_PEDIDOS_CONTA " .$pst_numero ."," .$partIni. ",". $partFim ; 
	$stmt = $conn->query($query);

	
	$regs=0;
	$parts=0;
	$lotes_atendidos = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$regs  = $row["nro_regs"];
		$parts = $row["p110atv"];
	}

	$query = "select crsa.fn_LotesAtendidos('".$produto."',".$partIni.", ".$partFim.", ".$lote.") "; 
	$stmt = $conn->query($query);

	try{
		while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
			$lotes_atendidos  = $row;
		}
	}
	catch(PDOException $e){}
	$lotes_atendidos = trim($lotes_atendidos[0]['']);

	echo "<script>parent.document.getElementById('partidas2').value ='" .$regs."'</script>";
	echo "<script>parent.document.getElementById('totatv2').value ='" .$parts."'</script>";
	echo "<script>parent.document.getElementById('pedatend2').value ='" .$lotes_atendidos."'</script>";
	
	
	$partIni =  $partIni-1;
    
	$query = "exec sgcr.crsa.uspP0110_PEDIDOS_CONTA " .$pst_numero ."," ."0". ",". $partIni; 
	//echo $query;
	$stmt = $conn->query($query);
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$regs  = $row["nro_regs"];
		$parts = $row["p110atv"];
	}

	//echo "<br>".$regs;
	echo "<script>parent.document.getElementById('partidasmenor2').value ='" .$regs."'</script>";
	echo "<script>parent.document.getElementById('totatvmenor2').value ='" .$parts."'</script>";
}

if(isset($_POST["calcDilu3"])){
	//var_dump($_POST);
	$pst_numero = $_POST['ttxtPst_Numero'];
	$produto    = $_POST['ttxt_Produto'];
	$partIni    = $_POST['PedAtvIni3'];
	$partFim    = $_POST['PedAtvFim3'];
	$lote       = substr($_POST['ttxtLote'],0,3);

	//echo $lote;	

	switch ($produto) {
		case "rd_i131";
			$produto = "I-131";
		case "rd_ga67";
			$produto = "ga-67";
		case "rd_tl";
			$produto = "TLCL3";
		case "rd_mo";
			$produto = "I-131";
	}

	if ($partIni==''){$partIni=0;}
	if ($partFim==''){$partFim=0;}
	include("../lib/DB.php");
	$query = "exec sgcr.crsa.uspP0110_PEDIDOS_CONTA " .$pst_numero ."," .$partIni. ",". $partFim ; 
	$stmt = $conn->query($query);

	$regs=0;
	$parts=0;
	$lotes_atendidos = "";
	try{
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$regs  = $row["nro_regs"];
		$parts = $row["p110atv"];
	}
	}
	catch(PDOException){

	}
	$query = "select  crsa.fn_LotesAtendidos('".$produto."',".$partIni.", ".$partFim.", ".$lote.") "; 
	$stmt = $conn->query($query);

	try{
	while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
		$lotes_atendidos  = $row;
	}
	}
	catch(PDOException $e){}

	$lotes_atendidos = trim($lotes_atendidos[0]['']);

	echo "<script>parent.document.getElementById('partidas3').value ='" .$regs."'</script>";
	echo "<script>parent.document.getElementById('totatv3').value ='" .$parts."'</script>";
	echo "<script>parent.document.getElementById('pedatend3').value ='" .$lotes_atendidos."'</script>";
	
	$partIni =  $partIni-1;
    
	$query = "exec sgcr.crsa.uspP0110_PEDIDOS_CONTA " .$pst_numero ."," ."0". ",". $partIni; 
	//echo $query;
	$stmt = $conn->query($query);
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$regs  = $row["nro_regs"];
		$parts = $row["p110atv"];
	}

	//echo "<br>".$regs;
	echo "<script>parent.document.getElementById('partidasmenor3').value ='" .$regs."'</script>";
	echo "<script>parent.document.getElementById('totatvmenor3').value ='" .$parts."'</script>";
}

if(isset($_POST["calcDilu4"])){
	//var_dump($_POST);
	$pst_numero = $_POST['ttxtPst_Numero'];
	$produto    = $_POST['ttxt_Produto'];
	$partIni    = $_POST['PedAtvIni4'];
	$partFim    = $_POST['PedAtvFim4'];
	$lote       = substr($_POST['ttxtLote'],0,3);

	//echo $lote;	

	switch ($produto) {
		case "rd_i131";
			$produto = "I-131";
		case "rd_ga67";
			$produto = "ga-67";
		case "rd_tl";
			$produto = "TLCL3";
		case "rd_mo";
			$produto = "I-131";
	}

	if ($partIni==''){$partIni=0;}
	if ($partFim==''){$partFim=0;}
	include("../lib/DB.php");
	$query = "exec sgcr.crsa.uspP0110_PEDIDOS_CONTA " .$pst_numero ."," .$partIni. ",". $partFim ; 
	$stmt = $conn->query($query);

	$regs=0;
	$parts=0;
	$lotes_atendidos = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$regs  = $row["nro_regs"];
		$parts = $row["p110atv"];
	}
	
	$query = "select  crsa.fn_LotesAtendidos('".$produto."',".$partIni.", ".$partFim.", ".$lote.") "; 
	$stmt = $conn->query($query);

	try{
	while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
		$lotes_atendidos  = $row;
	}
	}
	catch(PDOException){}
	$lotes_atendidos = trim($lotes_atendidos[0]['']);

	echo "<script>parent.document.getElementById('partidas4').value ='" .$regs."'</script>";
	echo "<script>parent.document.getElementById('totatv4').value ='" .$parts."'</script>";
	echo "<script>parent.document.getElementById('pedatend4').value ='" .$lotes_atendidos."'</script>";
	
	$partIni =  $partIni-1;
    
	$query = "exec sgcr.crsa.uspP0110_PEDIDOS_CONTA " .$pst_numero ."," ."0". ",". $partIni; 
	//echo $query;
	$stmt = $conn->query($query);
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$regs  = $row["nro_regs"];
		$parts = $row["p110atv"];
	}

	//echo "<br>".$regs;
	echo "<script>parent.document.getElementById('partidasmenor4').value ='" .$regs."'</script>";
	echo "<script>parent.document.getElementById('totatvmenor4').value ='" .$parts."'</script>";
}

if(isset($_POST["gravadilu1"])){
	
	//var_dump($_POST);
	

	if (  ValidaSenha($_POST["cmbTecnico1"], $_POST["txtSenha1"]) !=""){
		echo "<script>parent.toastApp(3000,'Senha Inválida','ERRO')</script>";
		die;
	}

	$resultFornec = "";
	foreach ($_POST["txtSolPrinForn1"] as $value)
		$resultFornec .= $value."|";

	$resultFornec = substr($resultFornec,0,-1);



	$currentDate = date('Ymd');
    include("../lib/DB.php");
	

	//var_dump($_POST);
	$resultFornec1 = "";
	$resultFornec2 = "";

	for ($x = 1; $x <= 100; $x++) {
		if ($_POST["txtSolPrinQto".$x."_1"] != ''){
			$resultFornec1 .= $_POST["txtSolPrinQto".$x."_1"] ."|";
		}	

		if ($_POST["txtSolPrinVol".$x."_1"] != ''){
			$resultFornec2 .= $_POST["txtSolPrinVol".$x."_1"] ."|";
		}	
	  }
	  $resultFornec1 = substr($resultFornec1,0,-1);
	  $resultFornec2 = substr($resultFornec2,0,-1);



	  echo $resultFornec1;
	  echo "<br>";
	  echo $resultFornec2;

	//echo $_POST["txtSolPrinQto1_1"];






	$stmt = $conn->prepare("exec crsa.P0642_GRAVA :p01, :p02, :p03, :p04, :p05, 
	                                              :p06, :p07, :p08, :p09, :p10,
												  :p11, :p12, :p13, :p14, :p15,
												  :p16, :p17, :p18, :p19, :p20,
												  :p21, :p22, :p23, :p24, :p25,
												  :p26, :p27, :p28, :p29, :p30, 
												  :p31, :p32, :p33, :p34, :p35,
												  :p36, :p37, :p38, :p39, :p40, 
												  :p41, :p42, :p43, :p44, :p45, 
												  :p46, :p47, :p98, :p99
												  ");
	$p01 = $_POST["ttxtp642_ID1"];
	$p02 = $_POST["ttxtp641_ID1"];
	$p03 = $_POST["calcDilu1"];
	$p04 = $_POST["ConcRadio1"];
	$p05 = $_POST["Fator1"];
	$p06 = $_POST["CR1"];
	$p07 = $_POST["Volume1"];
	$p08 = $_POST["Completa1ml1"];
	$p09 = $_POST["Origem1"];
	$p10 = $_POST["PedAtvIni1"];
	$p11 = $_POST["PedAtvFim1"];
	$p12 = "0";
	$p13 = "0";
	$p14 = "0";
	$p15 = $currentDate;
	$p16 = $_POST["totsobraatv1"];
	$p17 = $_POST["totsobravol1"];
	$p18 = $currentDate;
	$p19 = $_POST["totphremanec1"];
	$p20 = $_POST["ConcRadio1"];
	$p21 = $_POST["Ativ1"];
	$p22 = $_POST["totatvremanec1"];
	$p23 = $_POST["cmbTecnico1"];
	$p24 = $_POST["pedatend1"];
	$p25 = $_POST["sol_estoque1"];
	$p26 = $_POST["txtSolEstLote1"];
	
	$p27 = $_POST["sol_principal1"];
	$p28 = $resultFornec; //$_POST["txtSolPrinForn1"];
	$p29 = $_POST["txtSolPrinQto1"];
	$p30 = $_POST["txtSolPrinVol1"];

	$p31 = $_POST["txtVolHidSod1N1"];
	$p32 = $_POST["txtVolTotalHidSod1N1"];
	$p33 = $_POST["txtTempoHomeg1"];
	$p34 = $_POST["txtPresGazOx1"];
	$p35 = $_POST["txtVazOxi1"];

	$p36 = $_POST["txtConcRad80a100_1"];
	$p37 = $_POST["txtAtvTotSoluc_1"];
	$p38 = $_POST["vol_apreendil1"];
	$p39 = $_POST["sbr_Descarta1"];
	
	$p40 = $_POST["txtsobra_atv1"];
	$p41 = $_POST["txtsobra_vol1"];

	$p42 = $resultFornec1;
	$p43 = $resultFornec2;


	$p44 = $_POST["txtnro_util_sol_dilu1"];
	$p45 = $_POST["flg_util_sol_dilu1"];   //atenção, é s/n
	$p46 = $_POST["txtatv_util_sol_dilu1"];
	$p47 = $_POST["txtvol_util_sol_dilu1"];


	$p98 = "";
	$p99 = "";

	$p45 = "N";

	$stmt->bindParam( 1, $p01, PDO::PARAM_STR);
	$stmt->bindParam( 2, $p02, PDO::PARAM_STR);
	$stmt->bindParam( 3, $p03, PDO::PARAM_STR);
	$stmt->bindParam( 4, $p04, PDO::PARAM_STR);
	$stmt->bindParam( 5, $p05, PDO::PARAM_STR);
	$stmt->bindParam( 6, $p06, PDO::PARAM_STR);
	$stmt->bindParam( 7, $p07, PDO::PARAM_STR);
	$stmt->bindParam( 8, $p08, PDO::PARAM_STR);
	$stmt->bindParam( 9, $p09, PDO::PARAM_STR);
	$stmt->bindParam(10, $p10, PDO::PARAM_STR);
	$stmt->bindParam(11, $p11, PDO::PARAM_STR);
	$stmt->bindParam(12, $p12, PDO::PARAM_STR);
	$stmt->bindParam(13, $p13, PDO::PARAM_STR);
	$stmt->bindParam(14, $p14, PDO::PARAM_STR);
	$stmt->bindParam(15, $p15, PDO::PARAM_STR);
	$stmt->bindParam(16, $p16, PDO::PARAM_STR);
	$stmt->bindParam(17, $p17, PDO::PARAM_STR);
	$stmt->bindParam(18, $p18, PDO::PARAM_STR);
	$stmt->bindParam(19, $p19, PDO::PARAM_STR);
	$stmt->bindParam(20, $p20, PDO::PARAM_STR);
	$stmt->bindParam(21, $p21, PDO::PARAM_STR);
	$stmt->bindParam(22, $p22, PDO::PARAM_STR);
	$stmt->bindParam(23, $p23, PDO::PARAM_STR);
	$stmt->bindParam(24, $p24, PDO::PARAM_STR);
	$stmt->bindParam(25, $p25, PDO::PARAM_STR);
	$stmt->bindParam(26, $p26, PDO::PARAM_STR);
	$stmt->bindParam(27, $p27, PDO::PARAM_STR);
	$stmt->bindParam(28, $p28, PDO::PARAM_STR);
	$stmt->bindParam(29, $p29, PDO::PARAM_STR);
	$stmt->bindParam(30, $p30, PDO::PARAM_STR);
	$stmt->bindParam(31, $p31, PDO::PARAM_STR);
	$stmt->bindParam(32, $p32, PDO::PARAM_STR);
	$stmt->bindParam(33, $p33, PDO::PARAM_STR);
	$stmt->bindParam(34, $p34, PDO::PARAM_STR);
	$stmt->bindParam(35, $p35, PDO::PARAM_STR);
	$stmt->bindParam(36, $p36, PDO::PARAM_STR);
	$stmt->bindParam(37, $p37, PDO::PARAM_STR);
	$stmt->bindParam(38, $p38, PDO::PARAM_STR);
	$stmt->bindParam(39, $p39, PDO::PARAM_STR);
	$stmt->bindParam(40, $p40, PDO::PARAM_STR);
	$stmt->bindParam(41, $p41, PDO::PARAM_STR);
	$stmt->bindParam(42, $p42, PDO::PARAM_STR);
	$stmt->bindParam(43, $p43, PDO::PARAM_STR);
	$stmt->bindParam(44, $p44, PDO::PARAM_STR);
	$stmt->bindParam(45, $p45, PDO::PARAM_STR);
	$stmt->bindParam(46, $p46, PDO::PARAM_STR);
	$stmt->bindParam(47, $p47, PDO::PARAM_STR);
	$stmt->bindParam(48, $p98, PDO::PARAM_STR); //resulta
	$stmt->bindParam(49, $p99, PDO::PARAM_STR); //mensa

	
	try{
		$stmt->execute();
		echo "<script>parent.toastApp(3000,'Registro Gravado com SUCESSO','OK')</script>";
	}catch (PDOException  $e) {
		echo "<script>parent.toastApp(3000,'".$e."','OK')</script>";
	}

}

if(isset($_POST["gravadilu2"])){
	//var_dump($_POST);
	if (  ValidaSenha($_POST["cmbTecnico2"], $_POST["txtSenha2"]) !=""){
		echo "<script>parent.toastApp(3000,'Senha Inválida','ERRO')</script>";
		die;
	}
	
	$resultFornec = "";
	foreach ($_POST["txtSolPrinForn2"] as $value)
		$resultFornec .= $value."|";

	$resultFornec = substr($resultFornec,0,-1);


	$currentDate = date('Ymd');
    include("../lib/DB.php");
	//var_dump($_POST);
	$resultFornec1 = "";
	$resultFornec2 = "";

	for ($x = 1; $x <= 100; $x++) {
		if ($_POST["txtSolPrinQto".$x."_2"] != ''){
			$resultFornec1 .= $_POST["txtSolPrinQto".$x."_2"] ."|";
		}	

		if ($_POST["txtSolPrinVol".$x."_2"] != ''){
			$resultFornec2 .= $_POST["txtSolPrinVol".$x."_2"] ."|";
		}	
	  }
	  $resultFornec1 = substr($resultFornec1,0,-1);
	  $resultFornec2 = substr($resultFornec2,0,-1);



	  echo $resultFornec1;
	  echo "<br>";
	  echo $resultFornec2;

	//echo $_POST["txtSolPrinQto1_1"];



	$stmt = $conn->prepare("exec crsa.P0642_GRAVA :p01, :p02, :p03, :p04, :p05, 
	                                              :p06, :p07, :p08, :p09, :p10,
												  :p11, :p12, :p13, :p14, :p15,
												  :p16, :p17, :p18, :p19, :p20,
												  :p21, :p22, :p23, :p24, :p25,
												  :p26, :p27, :p28, :p29, :p30, 
												  :p31, :p32, :p33, :p34, :p35,
												  :p36, :p37, :p38, :p39, :p40, 
												  :p41, :p42, :p43, :p44, :p45, 
												  :p46, :p47, :p98, :p99
												  ");

	$p01 = $_POST["ttxtp642_ID2"];
	$p02 = $_POST["ttxtp641_ID2"];
	$p03 = $_POST["calcDilu2"];
	$p04 = $_POST["ConcRadio2"];
	$p05 = $_POST["Fator2"];
	$p06 = $_POST["CR2"];
	$p07 = $_POST["Volume2"];
	$p08 = $_POST["Completa1ml2"];
	$p09 = $_POST["Origem2"];
	$p10 = $_POST["PedAtvIni2"];
	$p11 = $_POST["PedAtvFim2"];
	$p12 = "0";
	$p13 = "0";
	$p14 = "0";
	$p15 = $currentDate;
	$p16 = $_POST["totsobraatv2"];
	$p17 = $_POST["totsobravol2"];
	$p18 = $currentDate;
	$p19 = $_POST["totphremanec2"];
	$p20 = $_POST["ConcRadio2"];
	$p21 = $_POST["Ativ2"];
	$p22 = $_POST["totatvremanec2"];
	$p23 = $_POST["cmbTecnico2"];
	$p24 = $_POST["pedatend2"];
	$p25 = $_POST["sol_estoque2"];
	$p26 = $_POST["txtSolEstLote2"];
	
	$p27 = $_POST["sol_principal2"];
	$p28 = $resultFornec; //$_POST["txtSolPrinForn2"];
	$p29 = $_POST["txtSolPrinQto2"];
	$p30 = $_POST["txtSolPrinVol2"];

	$p31 = $_POST["txtVolHidSod1N2"];
	$p32 = $_POST["txtVolTotalHidSod1N2"];
	$p33 = $_POST["txtTempoHomeg2"];
	$p34 = $_POST["txtPresGazOx2"];
	$p35 = $_POST["txtVazOxi2"];

	$p36 = $_POST["txtConcRad80a100_2"];
	$p37 = $_POST["txtAtvTotSoluc_2"];
	$p38 = $_POST["vol_apreendil2"];
	$p39 = $_POST["sbr_Descarta2"];
	
	$p40 = $_POST["txtsobra_atv2"];
	$p41 = $_POST["txtsobra_vol2"];

	$p44 = $_POST["txtnro_util_sol_dilu2"];
	$p45 = $_POST["flg_util_sol_dilu2"];   //atenção, é s/n
	$p46 = $_POST["txtatv_util_sol_dilu2"];
	$p47 = $_POST["txtvol_util_sol_dilu2"];

	$p48 = $resultFornec1;
	$p49 = $resultFornec2;


	$p98 = "";
	$p99 = "";

	

	$stmt->bindParam( 1, $p01, PDO::PARAM_STR);
	$stmt->bindParam( 2, $p02, PDO::PARAM_STR);
	$stmt->bindParam( 3, $p03, PDO::PARAM_STR);
	$stmt->bindParam( 4, $p04, PDO::PARAM_STR);
	$stmt->bindParam( 5, $p05, PDO::PARAM_STR);
	$stmt->bindParam( 6, $p06, PDO::PARAM_STR);
	$stmt->bindParam( 7, $p07, PDO::PARAM_STR);
	$stmt->bindParam( 8, $p08, PDO::PARAM_STR);
	$stmt->bindParam( 9, $p09, PDO::PARAM_STR);
	$stmt->bindParam(10, $p10, PDO::PARAM_STR);
	$stmt->bindParam(11, $p11, PDO::PARAM_STR);
	$stmt->bindParam(12, $p12, PDO::PARAM_STR);
	$stmt->bindParam(13, $p13, PDO::PARAM_STR);
	$stmt->bindParam(14, $p14, PDO::PARAM_STR);
	$stmt->bindParam(15, $p15, PDO::PARAM_STR);
	$stmt->bindParam(16, $p16, PDO::PARAM_STR);
	$stmt->bindParam(17, $p17, PDO::PARAM_STR);
	$stmt->bindParam(18, $p18, PDO::PARAM_STR);
	$stmt->bindParam(19, $p19, PDO::PARAM_STR);
	$stmt->bindParam(20, $p20, PDO::PARAM_STR);
	$stmt->bindParam(21, $p21, PDO::PARAM_STR);
	$stmt->bindParam(22, $p22, PDO::PARAM_STR);
	$stmt->bindParam(23, $p23, PDO::PARAM_STR);
	$stmt->bindParam(24, $p24, PDO::PARAM_STR);
	$stmt->bindParam(25, $p25, PDO::PARAM_STR);
	$stmt->bindParam(26, $p26, PDO::PARAM_STR);
	$stmt->bindParam(27, $p27, PDO::PARAM_STR);
	$stmt->bindParam(28, $p28, PDO::PARAM_STR);
	$stmt->bindParam(29, $p29, PDO::PARAM_STR);
	$stmt->bindParam(30, $p30, PDO::PARAM_STR);
	$stmt->bindParam(31, $p31, PDO::PARAM_STR);
	$stmt->bindParam(32, $p32, PDO::PARAM_STR);
	$stmt->bindParam(33, $p33, PDO::PARAM_STR);
	$stmt->bindParam(34, $p34, PDO::PARAM_STR);
	$stmt->bindParam(35, $p35, PDO::PARAM_STR);
	$stmt->bindParam(36, $p36, PDO::PARAM_STR);
	$stmt->bindParam(37, $p37, PDO::PARAM_STR);
	$stmt->bindParam(38, $p38, PDO::PARAM_STR);
	$stmt->bindParam(39, $p39, PDO::PARAM_STR);
	$stmt->bindParam(40, $p40, PDO::PARAM_STR);
	$stmt->bindParam(41, $p41, PDO::PARAM_STR);
	$stmt->bindParam(42, $p42, PDO::PARAM_STR);
	$stmt->bindParam(43, $p43, PDO::PARAM_STR);

	$stmt->bindParam(44, $p44, PDO::PARAM_STR);
	$stmt->bindParam(45, $p45, PDO::PARAM_STR);
	$stmt->bindParam(46, $p46, PDO::PARAM_STR);
	$stmt->bindParam(47, $p47, PDO::PARAM_STR);

	$stmt->bindParam(48, $p98, PDO::PARAM_STR); //resulta
	$stmt->bindParam(49, $p99, PDO::PARAM_STR); //mensa

	
	try{
		$stmt->execute();
		echo "<script>parent.toastApp(3000,'Registro Gravado com SUCESSO','OK')</script>";
	}catch (PDOException  $e) {
		echo "<script>parent.toastApp(3000,'".$e."','OK')</script>";
	}

	

}

if(isset($_POST["gravadilu3"])){
	//var_dump($_POST);
	if (  ValidaSenha($_POST["cmbTecnico3"], $_POST["txtSenha3"]) !=""){
		echo "<script>parent.toastApp(3000,'Senha Inválida','ERRO')</script>";
		die;
	}
	
	$resultFornec = "";
	foreach ($_POST["txtSolPrinForn3"] as $value)
		$resultFornec .= $value."|";

	$resultFornec = substr($resultFornec,0,-1);


	$currentDate = date('Ymd');
    include("../lib/DB.php");
	
	//var_dump($_POST);
	$resultFornec1 = "";
	$resultFornec2 = "";

	for ($x = 1; $x <= 100; $x++) {
		if ($_POST["txtSolPrinQto".$x."_3"] != ''){
			$resultFornec1 .= $_POST["txtSolPrinQto".$x."_3"] ."|";
		}	

		if ($_POST["txtSolPrinVol".$x."_3"] != ''){
			$resultFornec2 .= $_POST["txtSolPrinVol".$x."_3"] ."|";
		}	
	  }
	  $resultFornec1 = substr($resultFornec1,0,-1);
	  $resultFornec2 = substr($resultFornec2,0,-1);



	  //echo $resultFornec1;
	  //echo "<br>";
	  //echo $resultFornec2;

	//echo $_POST["txtSolPrinQto1_1"];

	$stmt = $conn->prepare("exec crsa.P0642_GRAVA 	:p01, :p02, :p03, :p04, :p05, 
													:p06, :p07, :p08, :p09, :p10,
													:p11, :p12, :p13, :p14, :p15,
													:p16, :p17, :p18, :p19, :p20,
													:p21, :p22, :p23, :p24, :p25,
													:p26, :p27, :p28, :p29, :p30, 
													:p31, :p32, :p33, :p34, :p35,
													:p36, :p37, :p38, :p39, :p40, 
													:p41, :p42, :p43, :p44, :p45, 
													:p46, :p47, :p98, :p99
													");

	$p01 = $_POST["ttxtp642_ID3"];
	$p02 = $_POST["ttxtp641_ID3"];
	$p03 = $_POST["calcDilu3"];
	$p04 = $_POST["ConcRadio3"];
	$p05 = $_POST["Fator3"];
	$p06 = $_POST["CR3"];
	$p07 = $_POST["Volume3"];
	$p08 = $_POST["Completa1ml3"];
	$p09 = $_POST["Origem3"];
	$p10 = $_POST["PedAtvIni3"];
	$p11 = $_POST["PedAtvFim3"];
	$p12 = "0";
	$p13 = "0";
	$p14 = "0";
	$p15 = $currentDate;
	$p16 = $_POST["totsobraatv3"];
	$p17 = $_POST["totsobravol3"];
	$p18 = $currentDate;
	$p19 = $_POST["totphremanec3"];
	$p20 = $_POST["ConcRadio3"];
	$p21 = $_POST["Ativ3"];
	$p22 = $_POST["totatvremanec3"];
	$p23 = $_POST["cmbTecnico3"];
	$p24 = $_POST["pedatend3"];
	$p25 = $_POST["sol_estoque3"];
	$p26 = $_POST["txtSolEstLote3"];
	
	$p27 = $_POST["sol_principal3"];
	$p28 = $resultFornec; //$_POST["txtSolPrinForn3"];
	$p29 = $_POST["txtSolPrinQto3"];
	$p30 = $_POST["txtSolPrinVol3"];

	$p31 = $_POST["txtVolHidSod1N3"];
	$p32 = $_POST["txtVolTotalHidSod1N3"];
	$p33 = $_POST["txtTempoHomeg3"];
	$p34 = $_POST["txtPresGazOx3"];
	$p35 = $_POST["txtVazOxi3"];

	$p36 = $_POST["txtConcRad80a100_3"];
	$p37 = $_POST["txtAtvTotSoluc_3"];
	$p38 = $_POST["vol_apreendil3"];
	$p39 = $_POST["sbr_Descarta3"];
	
	$p40 = $_POST["txtsobra_atv3"];
	$p41 = $_POST["txtsobra_vol3"];

	$p42 = $resultFornec1;
	$p43 = $resultFornec2;

	$p44 = $_POST["txtnro_util_sol_dilu3"];
	$p45 = $_POST["flg_util_sol_dilu3"];   //atenção, é s/n
	$p46 = $_POST["txtatv_util_sol_dilu3"];
	$p47 = $_POST["txtvol_util_sol_dilu3"];


	$p98 = "";
	$p99 = "";



	$stmt->bindParam( 1, $p01, PDO::PARAM_STR);
	$stmt->bindParam( 2, $p02, PDO::PARAM_STR);
	$stmt->bindParam( 3, $p03, PDO::PARAM_STR);
	$stmt->bindParam( 4, $p04, PDO::PARAM_STR);
	$stmt->bindParam( 5, $p05, PDO::PARAM_STR);
	$stmt->bindParam( 6, $p06, PDO::PARAM_STR);
	$stmt->bindParam( 7, $p07, PDO::PARAM_STR);
	$stmt->bindParam( 8, $p08, PDO::PARAM_STR);
	$stmt->bindParam( 9, $p09, PDO::PARAM_STR);
	$stmt->bindParam(10, $p10, PDO::PARAM_STR);
	$stmt->bindParam(11, $p11, PDO::PARAM_STR);
	$stmt->bindParam(12, $p12, PDO::PARAM_STR);
	$stmt->bindParam(13, $p13, PDO::PARAM_STR);
	$stmt->bindParam(14, $p14, PDO::PARAM_STR);
	$stmt->bindParam(15, $p15, PDO::PARAM_STR);
	$stmt->bindParam(16, $p16, PDO::PARAM_STR);
	$stmt->bindParam(17, $p17, PDO::PARAM_STR);
	$stmt->bindParam(18, $p18, PDO::PARAM_STR);
	$stmt->bindParam(19, $p19, PDO::PARAM_STR);
	$stmt->bindParam(20, $p20, PDO::PARAM_STR);
	$stmt->bindParam(21, $p21, PDO::PARAM_STR);
	$stmt->bindParam(22, $p22, PDO::PARAM_STR);
	$stmt->bindParam(23, $p23, PDO::PARAM_STR);
	$stmt->bindParam(24, $p24, PDO::PARAM_STR);
	$stmt->bindParam(25, $p25, PDO::PARAM_STR);
	$stmt->bindParam(26, $p26, PDO::PARAM_STR);
	$stmt->bindParam(27, $p27, PDO::PARAM_STR);
	$stmt->bindParam(28, $p28, PDO::PARAM_STR);
	$stmt->bindParam(29, $p29, PDO::PARAM_STR);
	$stmt->bindParam(30, $p30, PDO::PARAM_STR);
	$stmt->bindParam(31, $p31, PDO::PARAM_STR);
	$stmt->bindParam(32, $p32, PDO::PARAM_STR);
	$stmt->bindParam(33, $p33, PDO::PARAM_STR);
	$stmt->bindParam(34, $p34, PDO::PARAM_STR);
	$stmt->bindParam(35, $p35, PDO::PARAM_STR);
	$stmt->bindParam(36, $p36, PDO::PARAM_STR);
	$stmt->bindParam(37, $p37, PDO::PARAM_STR);
	$stmt->bindParam(38, $p38, PDO::PARAM_STR);
	$stmt->bindParam(39, $p39, PDO::PARAM_STR);
	$stmt->bindParam(40, $p40, PDO::PARAM_STR);
	$stmt->bindParam(41, $p41, PDO::PARAM_STR);
	$stmt->bindParam(42, $p42, PDO::PARAM_STR);
	$stmt->bindParam(43, $p43, PDO::PARAM_STR);

	$stmt->bindParam(44, $p44, PDO::PARAM_STR);
	$stmt->bindParam(45, $p45, PDO::PARAM_STR);
	$stmt->bindParam(46, $p46, PDO::PARAM_STR);
	$stmt->bindParam(47, $p47, PDO::PARAM_STR);

	$stmt->bindParam(48, $p98, PDO::PARAM_STR); //resulta
	$stmt->bindParam(49, $p99, PDO::PARAM_STR); //mensa

	
	try{
		$stmt->execute();
		echo "<script>parent.toastApp(3000,'Registro Gravado com SUCESSO','OK')</script>";
	}catch (PDOException  $e) {
		echo "<script>parent.toastApp(3000,'".$e."','OK')</script>";
	}

	

}

if(isset($_POST["gravadilu4"])){
	//var_dump($_POST);
	if (  ValidaSenha($_POST["cmbTecnico4"], $_POST["txtSenha4"]) !=""){
		echo "<script>parent.toastApp(3000,'Senha Inválida','ERRO')</script>";
		die;
	}
	
	$resultFornec = "";
	foreach ($_POST["txtSolPrinForn4"] as $value)
		$resultFornec .= $value."|";

	$resultFornec = substr($resultFornec,0,-1);


	$currentDate = date('Ymd');
    include("../lib/DB.php");
	

	//var_dump($_POST);
	$resultFornec1 = "";
	$resultFornec2 = "";

	for ($x = 1; $x <= 100; $x++) {
		if ($_POST["txtSolPrinQto".$x."_4"] != ''){
			$resultFornec1 .= $_POST["txtSolPrinQto".$x."_4"] ."|";
		}	

		if ($_POST["txtSolPrinVol".$x."_4"] != ''){
			$resultFornec2 .= $_POST["txtSolPrinVol".$x."_4"] ."|";
		}	
	  }
	  $resultFornec1 = substr($resultFornec1,0,-1);
	  $resultFornec2 = substr($resultFornec2,0,-1);



	  //echo $resultFornec1;
	  //echo "<br>";
	  //echo $resultFornec2;

	//echo $_POST["txtSolPrinQto1_1"];
	$stmt = $conn->prepare("exec crsa.P0642_GRAVA 	:p01, :p02, :p03, :p04, :p05, 
													:p06, :p07, :p08, :p09, :p10,
													:p11, :p12, :p13, :p14, :p15,
													:p16, :p17, :p18, :p19, :p20,
													:p21, :p22, :p23, :p24, :p25,
													:p26, :p27, :p28, :p29, :p30, 
													:p31, :p32, :p33, :p34, :p35,
													:p36, :p37, :p38, :p39, :p40, 
													:p41, :p42, :p43, :p44, :p45, 
													:p46, :p47, :p98, :p99
													");

	$p01 = $_POST["ttxtp642_ID4"];
	$p02 = $_POST["ttxtp641_ID4"];
	$p03 = $_POST["calcDilu4"];
	$p04 = $_POST["ConcRadio4"];
	$p05 = $_POST["Fator4"];
	$p06 = $_POST["CR4"];
	$p07 = $_POST["Volume4"];
	$p08 = $_POST["Completa1ml4"];
	$p09 = $_POST["Origem4"];
	$p10 = $_POST["PedAtvIni4"];
	$p11 = $_POST["PedAtvFim4"];
	$p12 = "0";
	$p13 = "0";
	$p14 = "0";
	$p15 = $currentDate;
	$p16 = $_POST["totsobraatv4"];
	$p17 = $_POST["totsobravol4"];
	$p18 = $currentDate;
	$p19 = $_POST["totphremanec4"];
	$p20 = $_POST["ConcRadio4"];
	$p21 = $_POST["Ativ4"];
	$p22 = $_POST["totatvremanec4"];
	$p23 = $_POST["cmbTecnico4"];
	$p24 = $_POST["pedatend4"];
	$p25 = $_POST["sol_estoque4"];
	$p26 = $_POST["txtSolEstLote4"];
	
	$p27 = $_POST["sol_principal4"];
	$p28 = $resultFornec; //$_POST["txtSolPrinForn4"];
	$p29 = $_POST["txtSolPrinQto4"];
	$p30 = $_POST["txtSolPrinVol4"];

	$p31 = $_POST["txtVolHidSod1N4"];
	$p32 = $_POST["txtVolTotalHidSod1N4"];
	$p33 = $_POST["txtTempoHomeg4"];
	$p34 = $_POST["txtPresGazOx4"];
	$p35 = $_POST["txtVazOxi4"];

	$p36 = $_POST["txtConcRad80a100_4"];
	$p37 = $_POST["txtAtvTotSoluc_4"];
	$p38 = $_POST["vol_apreendil4"];
	$p39 = $_POST["sbr_Descarta4"];
	
	$p40 = $_POST["txtsobra_atv4"];
	$p41 = $_POST["txtsobra_vol4"];

	$p42 = $resultFornec1;
	$p43 = $resultFornec2;

	$p44 = $_POST["txtnro_util_sol_dilu4"];
	$p45 = $_POST["flg_util_sol_dilu4"];   //atenção, é s/n
	$p46 = $_POST["txtatv_util_sol_dilu4"];
	$p47 = $_POST["txtvol_util_sol_dilu4"];


	$p98 = "";
	$p99 = "";

	$p45 = "N";



	$stmt->bindParam( 1, $p01, PDO::PARAM_STR);
	$stmt->bindParam( 2, $p02, PDO::PARAM_STR);
	$stmt->bindParam( 3, $p03, PDO::PARAM_STR);
	$stmt->bindParam( 4, $p04, PDO::PARAM_STR);
	$stmt->bindParam( 5, $p05, PDO::PARAM_STR);
	$stmt->bindParam( 6, $p06, PDO::PARAM_STR);
	$stmt->bindParam( 7, $p07, PDO::PARAM_STR);
	$stmt->bindParam( 8, $p08, PDO::PARAM_STR);
	$stmt->bindParam( 9, $p09, PDO::PARAM_STR);
	$stmt->bindParam(10, $p10, PDO::PARAM_STR);
	$stmt->bindParam(11, $p11, PDO::PARAM_STR);
	$stmt->bindParam(12, $p12, PDO::PARAM_STR);
	$stmt->bindParam(13, $p13, PDO::PARAM_STR);
	$stmt->bindParam(14, $p14, PDO::PARAM_STR);
	$stmt->bindParam(15, $p15, PDO::PARAM_STR);
	$stmt->bindParam(16, $p16, PDO::PARAM_STR);
	$stmt->bindParam(17, $p17, PDO::PARAM_STR);
	$stmt->bindParam(18, $p18, PDO::PARAM_STR);
	$stmt->bindParam(19, $p19, PDO::PARAM_STR);
	$stmt->bindParam(20, $p20, PDO::PARAM_STR);
	$stmt->bindParam(21, $p21, PDO::PARAM_STR);
	$stmt->bindParam(22, $p22, PDO::PARAM_STR);
	$stmt->bindParam(23, $p23, PDO::PARAM_STR);
	$stmt->bindParam(24, $p24, PDO::PARAM_STR);
	$stmt->bindParam(25, $p25, PDO::PARAM_STR);
	$stmt->bindParam(26, $p26, PDO::PARAM_STR);
	$stmt->bindParam(27, $p27, PDO::PARAM_STR);
	$stmt->bindParam(28, $p28, PDO::PARAM_STR);
	$stmt->bindParam(29, $p29, PDO::PARAM_STR);
	$stmt->bindParam(30, $p30, PDO::PARAM_STR);
	$stmt->bindParam(31, $p31, PDO::PARAM_STR);
	$stmt->bindParam(32, $p32, PDO::PARAM_STR);
	$stmt->bindParam(33, $p33, PDO::PARAM_STR);
	$stmt->bindParam(34, $p34, PDO::PARAM_STR);
	$stmt->bindParam(35, $p35, PDO::PARAM_STR);
	$stmt->bindParam(36, $p36, PDO::PARAM_STR);
	$stmt->bindParam(37, $p37, PDO::PARAM_STR);
	$stmt->bindParam(38, $p38, PDO::PARAM_STR);
	$stmt->bindParam(39, $p39, PDO::PARAM_STR);
	$stmt->bindParam(40, $p40, PDO::PARAM_STR);
	$stmt->bindParam(41, $p41, PDO::PARAM_STR);
	$stmt->bindParam(42, $p42, PDO::PARAM_STR);
	$stmt->bindParam(43, $p43, PDO::PARAM_STR);

	$stmt->bindParam(44, $p44, PDO::PARAM_STR);
	$stmt->bindParam(45, $p45, PDO::PARAM_STR);
	$stmt->bindParam(46, $p46, PDO::PARAM_STR);
	$stmt->bindParam(47, $p47, PDO::PARAM_STR);

	$stmt->bindParam(48, $p98, PDO::PARAM_STR); //resulta
	$stmt->bindParam(49, $p99, PDO::PARAM_STR); //mensa

	
	try{
		$stmt->execute();
		echo "<script>parent.toastApp(3000,'Registro Gravado com SUCESSO','OK')</script>";
	}catch (PDOException  $e) {
		echo "<script>parent.toastApp(3000,'".$e."','OK')</script>";
	}

	

}

if(isset($_POST["GravaSobraFinal"])){

	if ($_SESSION['usuarioSenha'] <> $_POST['SenhaSobraFinal']){
		echo "<script>parent.toastApp(3000,'***   SENHA INVÁLIDA   ***','ERRO')</script>";
		die;
	}

    include("../lib/DB.php");

	$p641_id = $_POST["ttxtp641_ID1"];
	$volume     = $_POST["txtVolSbrFim"];
	$atividade  = $_POST["txtAtvSbrFim"];
	$data       = $_POST["txtDatSbrFim"];
	$usuario    = $_SESSION['usuarioID'];
	$senha      = $_POST["SenhaSobraFinal"];

	$stmt = $conn->prepare("exec crsa.P0641_SOBRA_GRAVA :p01, :p02, :p03, :p04, :p05, :p06, :p07, :p08");
	$p01 = $p641_id;
	$p02 = $volume;
	$p03 = $atividade;
	$p04 = $data;
	$p05 = $usuario;
	$p06 = $senha;
	$p07 = '';
	$p08 = '';

	$p04 = substr($p04,0,4) . substr($p04,5,2) . substr($p04,8,2) . ' ' .substr($p04,11,6);

	//echo $p04;

	$stmt->bindParam( 1, $p01, PDO::PARAM_STR);
	$stmt->bindParam( 2, $p02, PDO::PARAM_STR);
	$stmt->bindParam( 3, $p03, PDO::PARAM_STR);
	$stmt->bindParam( 4, $p04, PDO::PARAM_STR);
	$stmt->bindParam( 5, $p05, PDO::PARAM_STR);
	$stmt->bindParam( 6, $p06, PDO::PARAM_STR);
	$stmt->bindParam( 7, $p07, PDO::PARAM_STR);
	$stmt->bindParam( 8, $p08, PDO::PARAM_STR);
	    
	if ($stmt->execute()) { 
		echo "<script>parent.toastApp(3000,' Registro Salvo com Sucesso ','OK');  parent.AfterCloseModal()</script>";
	 } else {
		echo "<script>parent.toastApp(3000,'***   ERRO NA OPERAÇÃO   ***<br>REVISE AS INFORMAÇÕES','ERRO')</script>";
	}

}



if(isset($_POST["btnGravaOper"])){


	//'pstnro' => string '27168' (length=5)
	//'cmbCalculo1' => string '0' (length=1)
	//'cmbCalculo2' => string '0' (length=1)
	//'cmbCalculo3' => string '0' (length=1)
	//'cmbPinca1' => string '0' (length=1)
	//'cmbPinca2' => string '0' (length=1)
	//'cmbPinca3' => string '0' (length=1)
	//'cmbSAS1' => string '0' (length=1)
	//'cmbSAS2' => string '0' (length=1)
	//'cmbSAS3' => string '0' (length=1)
	//'cmbLacracao1' => string '0' (length=1)
	//'cmbLacracao2' => string '0' (length=1)
	//'cmbLacracao3' => string '0' (length=1)
	//'cmbTecnico' => string '3523' (length=4)
	//'txtSenha' => string '0103' (length=4)


	$mensa = ValidaSenha($_POST["cmbTecnico"], $_POST["txtSenha"]);
	if($mensa != ""){
		echo "<script>parent.toastApp(3000,'".$mensa."','ERRO');</script>";
		die;
	}

	$stmt = $conn->prepare("exec crsa.uspP0095_Operadores	:p01, :p02, :p03, :p04, :p05, 
															:p06, :p07, :p08, :p09, :p10,
															:p11, :p12, :p13, :p14, :p15");

	$p01 = $_POST["pstnro"];
	$p02 = $_POST["cmbCalculo1"];
	$p03 = $_POST["cmbCalculo2"];
	$p04 = $_POST["cmbCalculo3"];
	$p05 = $_POST["cmbPinca1"];
	$p06 = $_POST["cmbPinca2"];
	$p07 = $_POST["cmbPinca3"];
	$p08 = $_POST["cmbSAS1"];
	$p09 = $_POST["cmbSAS2"];
	$p10 = $_POST["cmbSAS3"];
	$p11 = $_POST["cmbLacracao1"];
	$p12 = $_POST["cmbLacracao2"];
	$p13 = $_POST["cmbLacracao3"];
	$p14 = $_POST["cmbTecnico"];
	$p15 = "1";
	
	$stmt->bindParam( 1, $p01, PDO::PARAM_STR);
	$stmt->bindParam( 2, $p02, PDO::PARAM_STR);
	$stmt->bindParam( 3, $p03, PDO::PARAM_STR);
	$stmt->bindParam( 4, $p04, PDO::PARAM_STR);
	$stmt->bindParam( 5, $p05, PDO::PARAM_STR);
	$stmt->bindParam( 6, $p06, PDO::PARAM_STR);
	$stmt->bindParam( 7, $p07, PDO::PARAM_STR);
	$stmt->bindParam( 8, $p08, PDO::PARAM_STR);
	$stmt->bindParam( 9, $p09, PDO::PARAM_STR);
	$stmt->bindParam(10, $p10, PDO::PARAM_STR);
	$stmt->bindParam(11, $p11, PDO::PARAM_STR);
	$stmt->bindParam(12, $p12, PDO::PARAM_STR);
	$stmt->bindParam(13, $p13, PDO::PARAM_STR);
	$stmt->bindParam(14, $p14, PDO::PARAM_STR);
	$stmt->bindParam(15, $p15, PDO::PARAM_STR);
	
	

	try{
		$stmt->execute();
		echo "<script>parent.toastApp(3000,'Registro Gravado com SUCESSO','OK')</script>";
	}catch (PDOException  $e) {
		echo "<script>parent.toastApp(3000,'".$e."','OK')</script>";
	}


}


if(isset($_POST["gravaNovoInfRadio"])){
	//var_dump($_POST);
	if ($_SESSION['usuarioSenha'] <> $_POST['m_txtSenha']){
		echo "<script>parent.toastApp(3000,'***   SENHA INVÁLIDA   ***','ERRO')</script>";
		die;
	}

    include("../lib/DB.php");

	$volume1 = str_replace(',','.',$_POST['txtVolume1']);
	
	
	$top_conc1 = $_POST['txtVolume1'] != 0 ? ($_POST['txtMedDtProg1'] / $volume1) : 0;
	$qs = "exec crsa.P0643_I131_InformRadioisotopo ";
	$qs .= "@pst_numero='".$_POST['tpst_numero'] ."',";
	$qs .= "@nomefornec1='".$_POST['txtNomeFornecedor1']."',";
	$qs .= "@ativ1='".$_POST['txtAtvTotImp1']."',";
	$qs .= "@volu1='".$volume1."',";
	$qs .= "@dtreceb1='".str_replace('T',' ',str_replace('-','',$_POST['txtDtReceb1']))."',";
	$qs .= "@dtcalib1='".str_replace('T',' ',str_replace('-','',$_POST['txtDtCalib1']))."',";
	$qs .= "@vlmedida1='".$_POST['txtMedDtProg1']."',";
	$qs .= "@dtmedida1='".str_replace('T',' ',str_replace('-','',$_POST['txtDtProg1']))."',";
	$qs .= "@crteo1='" .$top_conc1."',";
	$qs .= "@cdusuario='". 	$_SESSION['usuarioID'] ."',";
	$qs .= "@nr_ID='".$_POST['tnr_ID'] ."',";

	if ($_POST['tnr_ID'] == ''){
		$qs .= "@acao='I',";
	}
	else{
		$qs .= "@acao='U',";
	}


	$qs .= "@out='X'";


    $stmt = $conn->prepare($qs);
    
	if ($stmt->execute()) { 
		echo "<script>parent.toastApp(3000,' Registro Salvo com Sucesso ','OK');  parent.AfterCloseModal()</script>";
	 } else {
		echo "<script>parent.toastApp(3000,'***   ERRO NA OPERAÇÃO   ***<br>REVISE AS INFORMAÇÕES','ERRO')</script>";
	}



	//var_dump($_POST);
	echo $qs;
	
	




}


if(isset($_POST["InserirTarefa"])){

	//var_dump($_POST);


	include("../lib/DB.php");

	if ($_POST['nr_ID']=="")
	{
		if ($_SESSION['usuarioSenha'] <> $_POST['txtSenha']){
			echo "<script>parent.toastApp(3000,'***   SENHA INVÁLIDA   ***','ERRO')</script>";
			die;
		}
		$qs = "insert into [crsa].[T0111_ESCALA_TAREFAS] (nome, cdusuario, datatualizacao) values ('".$_POST['txtNomeTarefa']."', '".$_SESSION['usuarioID']."' , getdate()) ";	
	}
	else 
	{
		if ($_SESSION['usuarioSenha'] <> $_POST['m_txtSenha']){
			echo "<script>parent.toastApp(3000,'***   SENHA INVÁLIDA   ***','ERRO')</script>";
			die;
		}
	
		$qs = "update [crsa].[T0111_ESCALA_TAREFAS] set nome            = '".$_POST['m_txtNome']."',
		                                                cdusuario       = '".$_SESSION['usuarioID']."',
														datatualizacao  = getdate() 
		
		where id = " . $_POST['nr_ID'];	
	}

	//$qs = "insert into [crsa].[T0111_ESCALA_TAREFAS] (nome) values ('".$_POST['txtNomeTarefa']."') ";
	$stmt = $conn->prepare($qs);
    
	if ($stmt->execute()) { 
		echo "<script>parent.toastApp(3000,' Registro Salvo com Sucesso ','OK');  parent.AfterCloseModal()</script>";
	 } else {
		echo "<script>parent.toastApp(3000,'***   ERRO NA OPERAÇÃO   ***<br>REVISE AS INFORMAÇÕES','ERRO')</script>";
	}






}

if(isset($_POST["InserirEscalaSenanal"])){
	//var_dump($_POST);
	//die;


	if ($_SESSION['usuarioSenha'] <> $_POST['txtSenha']){
		echo "<script>parent.toastApp(3000,'***   SENHA INVÁLIDA   ***','ERRO')</script>";
		die;
	}

	
	include("../lib/DB.php");




	if ($_POST['nr_ID']=="")
	{

		/* verifica se ja existe lote e tarefa cadastrada */
		$sql = "
		select top 1 'x' as teste from [crsa].[T0111_ESCALA_SEMANAL] 
		where lotes = ".$_POST['txtLotes']." 
		  and id_tarefa = ".$_POST['selTarefas'] ;
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$ver = "0";
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$ver = "1";
		}
	
		if ($ver=="1"){
			echo "<script>parent.toastApp(3000,'***   REGISTRO JÁ EXISTE  ***','ERRO')</script>";
			die;
		}
		/* verifica se ja existe lote e tarefa cadastrada FIM */


		$sql = "insert into [crsa].[T0111_ESCALA_SEMANAL] (lotes, produto, dat_inicial,	dat_final, dat_exec, id_tarefa,	nom_responsaveis, id_tipoprocesso, cdusuario, datatualizacao) values (";
		$sql .= "'" . $_POST['txtLotes'] . "',";
		$sql .= "'" . $_POST['cmbprod'] . "',";
		$sql .= "'" . $_POST['txPeriodoINI'] . "',";
		$sql .= "'" . $_POST['txPeriodoATE'] . "',";
		$sql .= "'" . str_replace("T", " ", trim($_POST['txDataExecucao'])) . "',";
		$sql .= "'" . $_POST['selTarefas'] . "',";
		$sql .= "'" . $_POST['txtdisponiveis'] . "',";
		$sql .= "'" . $_POST['selTipProc'] . "',";
		$sql .= "'" . $_SESSION['usuarioID'] . "',";
		$sql .= "getdate() )";


		$sql .= "update [crsa].[T0111_ESCALA_SEMANAL]  ";
		$sql .= "set id_tipoprocesso = " . $_POST['selTipProc'];
		$sql .= "where lotes = " . $_POST['txtLotes'];

	}
	else{
		$sql = "update [crsa].[T0111_ESCALA_SEMANAL] set ";
		$sql .= "lotes            = '" . $_POST['txtLotes'] . "',";
		$sql .= "produto          = '" . $_POST['cmbprod'] . "',";
		$sql .= "dat_inicial      = '" . $_POST['txPeriodoINI'] . "',";
		$sql .= "dat_final        = '" . $_POST['txPeriodoATE'] . "',";
		$sql .= "dat_exec         = '" . str_replace("T", " ", trim($_POST['txDataExecucao'])) . "',";
		$sql .= "id_tarefa        = '" . $_POST['selTarefas'] . "',";
		$sql .= "nom_responsaveis = '" . $_POST['txtdisponiveis'] . "',";
		$sql .= "id_tipoprocesso  = '" . $_POST['selTipProc'] . "',";
		$sql .= "cdusuario        = '" . $_SESSION['usuarioID'] . "',";
		$sql .= "datatualizacao  = getdate()";
		$sql .= " where id = " .$_POST['nr_ID'];

		$sql .= "update [crsa].[T0111_ESCALA_SEMANAL]  ";
		$sql .= "set id_tipoprocesso = " . $_POST['selTipProc'];
		$sql .= " where lotes = " . $_POST['txtLotes'];

	
	}

	
	echo $sql;

	
	$stmt = $conn->prepare($sql);
    
	if ($stmt->execute()) { 
		echo "<script>parent.toastApp(3000,' Registro Salvo com Sucesso ','OK');  parent.AfterCloseModal()</script>";
	 } else {
		echo "<script>parent.toastApp(3000,'***   ERRO NA OPERAÇÃO   ***<br>REVISE AS INFORMAÇÕES','ERRO')</script>";
	}
	

}




/* ------- */
/* FUNÇÕES */
/* ------- */


function MontaGridEquipamentos($_pst_numero)
{
        //echo ($_SG['rf']);

        $pst_numero = $_pst_numero; //$_REQUEST[""];
        include("../lib/DB.php");
        $query = "exec crsa.uspP0600_EQPTO_LISTA " .$pst_numero. ",''"; 
        $stmt = $conn->query($query);
        $prep = "";

        $prep =  "<form action=''  target='_top' method='POST' name='form1eqp' id='form1eqp' enctype='multipart/form-data'>";
        $prep .= "<input type='hidden' name='ideqp' id='ideqp' value='' />";
        $prep .= "<input type='hidden' name='ideqpAlt' id='ideqpAlt' value='' />";
		$prep .= "<input type='hidden' name='idcateg' id='idcateg' value='' />";
        $prep .= "<input type='hidden' name='acao' id='acao' value='' />";
        $prep .= "<input type='hidden' name='tpst_numero' id='tpst_numero' value='". $pst_numero ."' />";
        $contador1 = 1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prep .= "<tr>";
            $prep .= "<td>";
            $prep .= "<button type='submit' class='btn btn-sm btn-outline-primary' onclick='excluiEqp(".$row["p1500_eqptoid"].", ".$contador1.")' id='ExcluirEQPTO".$contador1."' name='ExcluirEQPTO".$contador1."' target='processarEQ' form='form1eqp'><i class='fas fa-trash'></i></button>";
            $prep .= "<input type='hidden' id='row1500".$contador1."' name='row1500".$contador1."' value='".$row["p1500_eqptoid"]."' style='width:40px;' />";
			$prep .= "<input type='hidden' id='row26".$contador1."'   name='row26".$contador1."' value='".$row["p026_categoriaId"]."' style='width:40px;' />";
            $prep .= "<input type='hidden' id='row600" .$contador1."' name='row600" .$contador1."' value='".$row["p600_equipamentoid"]."' style='width:60px;' />";
            $prep .= "</td>";
            $prep .= "<td>".$row["p026_categoria"]. "</td>";
            $prep .= "<td>".RetornaNroCREqpto($row["p026_categoriaId"], $row["p1500_eqptoid"], $contador1)."</td>";
            $prep .= "<td>".$row["p600_validade"]. "</td>";
            $prep .= "<td>".$row["p600_preventiva_validade"]. "</td>";
            $prep .= "<td>".$row["descricao"]."</td>";
            $prep .= "</tr>";
            $contador1++;
        }
        $prep .= "</form>";
        return $prep;
}

function GridMateriais(){
	include("../lib/DB.php");
	$query = "select NrEtqFrc, prodetq_produto, LoteCR, convert(varchar(10),ProdVali,103) ProdVali
from crsa.tetq402_produto  a
left outer join crsa.tetq400_etqfrasco b on(a.prodetq_codigo=b.prodetq_codigo) 
where 1=1
  and prodetq_Ativo = 'S'

";

	$stmt = $conn->query($query);
	$prep = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

		$prep .= "<tr>";
		$prep .= "<td class='text-center'><i class='fas fa-check' style='color: #005af5; height:20px; cursor:pointer'</td>";
		$prep .= "<td>".$row["NrEtqFrc"]. "</td>";
		$prep .= "<td>".$row["prodetq_produto"]. "</td>";
		$prep .= "<td>".$row["LoteCR"]. "</td>";
		$prep .= "<td>".$row["ProdVali"]. "</td>";
		$prep .= "</tr>";
	}
	return $prep;	
}


function MontaGridMateriais(){
	include("../lib/DB.php");
	$lote = explode(" ", $_GET['lote']);
	$query = "set nocount on; exec crsa.uspP0600_MATERIAL_SELlote " . $lote[0]; 
	$stmt = $conn->query($query);
	$prep = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

		$prep .= "<tr>";
		$prep .= "<td class='text-center'><i class='fas fa-check' style='color: #005af5; height:20px; cursor:pointer'</td>";
		$prep .= "<td>".$row["codigo"]. "</td>";
		$prep .= "<td>".$row["material"]. "</td>";
		$prep .= "<td>".$row["lote_ipen"]. "</td>";
		$prep .= "<td>".$row["lote_fornecedor"]. "</td>";
		$prep .= "<td>".$row["lote_cr"]. "</td>";
		$prep .= "<td>".$row["validade"]. "</td>";
		$prep .= "<td>".$row["quantidade"]. "</td>";
		$prep .= "<td>".$row["un"]. "</td>";
		$prep .= "<td>".$row["origem"]. "</td>";
		$prep .= "<td>".$row["p015_marcacd"]. "</td>";
		$prep .= "<td>".$row["p030_material_tipo_id"]. "</td>";

		$prep .= "</tr>";
	}
	return $prep;	
}

function CategoriaEquipamentos(){
	/* preeche o combo do modal */
	include("../lib/DB.php");

	$tpst_numero = $_GET['pst_numero'];

	$query = "select p026_CategoriaID, p1500_EqptoID, p1500_NumCR, p1500_dspatrim from crsa.T1500_EQUIPAMENTO 	where p026_CategoriaID is not null ";
	$query .= "and p1500_EqptoID not in (Select p1500_eqptoid  From crsa.T0600_EQUIPAMENTO where pst_numero = '".$tpst_numero."')";
	$query .= "order by 1,2 ";
	$stmt = $conn->query($query);
	$prep1 = "";
	$prep1 .= "[";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep1 .=  '{"id":"'.$row['p026_CategoriaID'].'"';
		$prep1 .=  ',"idsel":"'.$row['p1500_EqptoID'].'"';	
		$prep1 .=  ',"descr":"'. $row["p1500_NumCR"].' - ';
		$prep1 .=  preg_replace('/[^A-Za-z0-9\- ]/', '', $row["p1500_dspatrim"]).'"},';
	}
	
	$prep1 = substr($prep1,0,-1);
	$prep1 .= "]";
	//echo "<script>alert('".$prep1."')</script>";
	echo "<script>var nameList='".$prep1."'</script>";

	
	$query = "exec crsa.uspP0026_EQPTO_CATEGORIA 'A'";
	$stmt = $conn->query($query);
	$prep = "";
	$prep .= "<select name='eqpCategoria' id='eqpCategoria' class='form-control form-control-sm' onchange='TrocaCategoria(this.value)' style='width:100%' >";
	$prep .= "<option value=0>Selecione</option>";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "<option value=".$row["p026_CategoriaID"].">".$row["p026_Categoria"]."</option>";
	}
	$prep .= "</select>";
	return $prep;
}

function MarcaMateriais(){
	/* preeche o combo do modal */
	include("../lib/DB.php");

	$tpst_numero = $_GET['pst_numero'];
	
	$query = "exec crsa.uspP0015_MARCA_LISTA '1'";
	$stmt = $conn->query($query);
	$prep = "";
	$prep .= "<select name='matMarca' id='matMarca' class='form-control form-control-sm' style='width:100%' >";
	$prep .= "<option value=0>Selecione</option>";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "<option value=".$row["p015_marcacd"].">".$row["p015_marca"]."</option>";
	}
	$prep .= "</select>";
	return $prep;
}

function MaterialMateriais(){
	/* preeche o combo do modal */
	include("../lib/DB.php");

	$tpst_numero = $_GET['pst_numero'];
	
	$query = "exec crsa.uspP0030_MATERIAL_TIPO '1'";
	$stmt = $conn->query($query);
	$prep = "";
	$prep .= "<select name='matMaterial' id='matMaterial' class='form-control form-control-sm'  style='width:100%' >";
	$prep .= "<option value=0>Selecione</option>";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "<option value=".$row["p030_material_tipo_id"].">".$row["p030_material_tipo"]."</option>";
	}
	$prep .= "</select>";
	return $prep;
}

function RetornaVerifCela($_pst_numero){
	include("../lib/DB.php");
	$query = "exec crsa.uspP0600_LISTA_CELA " .$_pst_numero; 
	$stmt = $conn->query($query);
	$prep = "";
	$id1600="";
	$categoria="";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "CELA CR: ".$row["p1500_numcr"];
		$prep .= "<br>";
		$prep .= "Responsável: ".$row["p600_tecniconome"];
		$prep .= "<br>";
		$prep .= "Data ".$row["p600_tecnicodata"];
		$prep .= "<br>";
		$prep .= "Observação: ".$row["p600_obs"];
		$prep .= "<br>";
		$prep .= "Qtde não conforme: ".$row["nao_conforme2"];
		$id1600 = $row["p600_checklist_id"];
		$categoria = $row["p026_categoriaid"];
	}

	//echo "<script>alert('".$id1600."')</script>";
	echo "<script>
		document.getElementById('txtIdCelaRep').value = '" . $id1600    . "'" . "
		document.getElementById('txtCategoria').value = '" . $categoria . "'
		</script>";

		$_SESSION['NRCELA'] =  $id1600;

		


	return $prep;
}

function RetornaLimpCela($_pst_numero){
	include("../lib/DB.php");
	$query = "exec crsa.uspP0601_Materiais " .$_pst_numero; 
	$stmt = $conn->query($query);
	$prep = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "Responsável: ".$row["p1110_nome"];
		$prep .= "<br>";
		$prep .= "Data ". FormataDataHora($row["dat_atualizacao"]);
	}
	return $prep;
}

function RetornaFornDilu($_pst_numero){
	include("../lib/DB.php");
	$query = "select nr_ID,nome_lote from crsa.T643_I131_InformRadioisotopo where pst_numero = " .$_pst_numero; 
	$stmt = $conn->query($query);
	$prep = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "<option  value='".$row["nr_ID"] ."'>" . $row["nome_lote"] ."</option>";
	}
	
	return $prep;
	
}

function RetornaCMBProdutos(){
	
	include("../lib/DB.php");
	$query = "select prod_codigo, nome_comercial 
				from vendaspelicano.dbo.T0250_PRODUTO 
				where prod_ativo='A'  
				order by nome_comercial 
			"; 
	
	$stmt = $conn->query($query);
	$prep = "<select  id='cmbprod' name='cmbprod' class='form-control '>";
	$prep .= "<option value = '0'>Selecione</option>";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "<option value = '".$row["prod_codigo"]."'>". $row["nome_comercial"]."</option>";
	}
	$prep .= "</select>";


	return $prep;

}

function RetornaAtividadeSolicitadas($_pst_numero){
	$pst_numero = $_pst_numero; //$_REQUEST[""];
	include("../lib/DB.php");
	$query = "set nocount on;exec crsa.[uspP0110_ATIVIDADE_SOLICITADA] " .$pst_numero. ", '', '', '', '', ''"; 
	$stmt = $conn->query($query);
	$prep = "";
	$v1 = 0;
	$v2 = 0;

	//print_r($query);
	//print_r($stmt);
	//print_r($stmt);
	//print_r($conn);
	//die();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$v1 = $v1 + ($row["p110atv"] * $row["partidas"]); 
		$v2 = $v2 + (($row["p110atv"] * $row["partidas"]) * 37); 
	}
	$prep = $v1 . "-" . $v2;

	
	return $prep;
	
}

function RetornaSolicitadasLista($_pst_numero){
	$pst_numero = $_pst_numero; //$_REQUEST[""];
	include("../lib/DB.php");
	$query = "set nocount on;exec crsa.[uspP0110_ATIVIDADE_SOLICITADA] " .$pst_numero. ", '', '', '', '', ''"; 
	$stmt = $conn->query($query);
	$prep = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "<tr>";
		$prep .= "<td>" .$row["p110atv"] . "</td>";
		$prep .= "<td>" .$row["partidas"] . "</td>";
		$prep .= "</tr>";
	}
	return $prep;
}

function RetornaFracCliente($_pst_numero){
	$pst_numero = $_pst_numero; //$_REQUEST[""];
	include("../lib/DB.php");
	$query = "exec crsa.uspP0600_FRACIONAMENTO_RD " .$pst_numero. ", '', '', ''"; 
	$stmt = $conn->query($query);
	$prep = "";
	try{
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$prep .= "<tr>";
			$prep .= "<td>" .$row["p110chve"] . "</td>";
			$prep .= "<td>" .$row["Cli_Dest_Responsavel"] . "</td>";
			$prep .= "<td>" .$row["atvidade_mci"] . "</td>";
			$prep .= "<td>" .$row["atividade_mbq"] . "</td>";
			$prep .= "<td>" .$row["atividade_enviada"] . "</td>";
			$prep .= "<td>" .$row["p110qtde"] . "</td>";
			$prep .= "<td>" .$row["p110volu"] . "</td>";
			$prep .= "<td>" .$row["status"] . "</td>";
			$prep .= "</tr>";
		}
	}	
	catch (PDOException){
		$prep;
	}

	return $prep;
}

function RetornaLiberaArea($_pst_numero){
	//var_dump($_POST);
	//var_dump($_GET);
	$pst_numero = $_pst_numero; //$_REQUEST[""];
	$produto = $_GET['produto'];
	//echo $produto;
	if ($produto == 'rd_i131'){
		$query = "exec crsa.P0643_I131_LIBERAAREA " .$pst_numero. ", @tiposaida=1"; 
	}
	if ($produto == 'rd_tl'){
		$query = "exec crsa.P0643_I131_LIBERAAREA " .$pst_numero. ", @tiposaida=1"; 
	}

	if ($produto == 'rd_ga67'){
		$query = "exec crsa.P0607_LIBERAAREA " .$pst_numero. ", @tiposaida=1"; 

	}



	
	include("../lib/DB.php");
	//$query = "exec crsa.P0643_I131_LIBERAAREA " .$pst_numero. ", @tiposaida=1"; 
	$stmt = $conn->query($query);
	$prep = "";
	$conta = 1;
	$chkN = "";
	$chkS = "";
	try{

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "<tr>";
		$prep .= "<td>" .$row["P643_LibArea"] . "</td>";
		$prep .= "<td>" .$row["P643_Descricao"] . "</td>";
		$prep .= "<td>"; 

		if ($row["P643_Flag"] == "S"){
			$chkN = "";
			$chkS = "checked";
		}
		else {
			$chkN = "checked";
			$chkS = "";

		}

		$prep .= '<div class="text-nowrap">';
		$prep .= "<input type='radio' id='" . $conta . "linhaS' name='" . $conta . "linhaS' "  . $chkS . " value='S'> SIM&nbsp;&nbsp;";
		$prep .= "<input type='radio' id='" . $conta . "linhaS' name='" . $conta . "linhaS' "  . $chkN . " value='N'> NÃO";
		$prep .= '</div>';
		$prep .= '<td style="display:none"><input type="text" id="IDfield' . $conta . '" name="IDfield' . $conta . '" value ="' .$row['P643_Id']. '"/></td>';

		$prep .= "</td>";
		$prep .= "</tr>";
		$conta=$conta+1;
	}

}
catch(PDOException){

}
	return $prep;

}

function RetornaEmbalagemPrimaria($_pst_numero){
	$pst_numero = $_pst_numero; //$_REQUEST[""];
	$produto = $_GET['produto'];
	//echo $produto;
	if ($produto == 'rd_i131'){
		$query = "exec crsa.P0643_I131_EMBPRIMARIA " .$pst_numero. ", @tiposaida=1"; 
	}
	if ($produto == 'rd_tl'){
		$query = "exec crsa.P0643_TLCL3_EMBPRIMARIA " .$pst_numero. ", @tiposaida=1"; 
	}

	if ($produto == 'rd_ga67'){
		$query = "exec crsa.P0607_EMBPRIMARIA " .$pst_numero. ", @tiposaida=1"; 
	}

	include("../lib/DB.php");
	$stmt = $conn->query($query);
	$prep = "";
	$conta = 1;
	$chkN = "";
	$chkS = "";
	try{
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "<tr>";
		$prep .= "<td>" .$row["P643_EmbPrimaria"] . "</td>";
		$prep .= "<td>" .$row["P643_Descricao"] . "</td>";
		$prep .= "<td>"; 

		if ($row["P643_Flag"] == "S"){
			$chkN = "";
			$chkS = "checked";
		}
		else {
			$chkN = "checked";
			$chkS = "";

		}

		//$prep .= '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
		//			<input type="checkbox" class="custom-control-input" id="linha'.$conta.'">
		//			<label class="custom-control-label" for="customSwitch3">Aprovado</label>
	    //			</div>';
		$prep .= '<div class="text-nowrap">';
		$prep .= "<input type='radio' id='" . $conta . "linhaS' name='" . $conta . "linhaS' "  . $chkS . " value='S'> SIM&nbsp;&nbsp;";
		$prep .= "<input type='radio' id='" . $conta . "linhaS' name='" . $conta . "linhaS' "  . $chkN . " value='N'> NÃO";
		$prep .= '</div>';
		$prep .= '<td style="display:none"><input type="text" id="IDfield' . $conta . '" name="IDfield' . $conta . '" value ="' .$row['P643_Id']. '"/></td>';

		$prep .= "</td>";
		$prep .= "</tr>";
		$conta=$conta+1;
	}
}
catch(PDOException){

}
	return $prep;

}

function GravaLiberaArea(){
	echo "fez<br>";
}

function ValidaSenha($usuario, $senha){

	
	$resulta = "0";
	$mensa = "";
	$p1110_usuarioid=$usuario;
	$p1110_senha=$senha;
	include("lib/DB.php");
	$sql = "exec sgcr.crsa.[P1110_CONFSENHA] @p1110_usuarioid = :p1110_usuarioid, @p1110_senha = :p1110_senha, @resulta = :resulta, @mensa = :mensa";
	$stmt = $conn->prepare($sql);


	/* input */
	$stmt->bindParam(':p1110_usuarioid', $usuario, PDO::PARAM_STR);
	$stmt->bindParam(':p1110_senha', $senha, PDO::PARAM_STR);
	/* output */
	$stmt->bindParam(':resulta', $resulta, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000);
	$stmt->bindParam(':mensa', $mensa, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000);
	$stmt->execute();
	$stmt->nextRowset();  
	//echo $resulta;
	//echo $mensa;
	
	return $mensa;


}

function RetornaNroCREqpto($ideqp, $eqptoid, $contador)
{
        include("../lib/DB.php");
        $query = "exec crsa.P1500_Equipamento " .$ideqp. ",'1'"; 
        $stmt = $conn->query($query);
        $prep = "<select onchange='alteraEqp(this.value, ".$contador.")' id='cmbEquipamento".$contador."' name='cmbEquipamento".$contador."'>";
        $selected = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row["p1500_EqptoID"] == $eqptoid){
                $selected = "selected";
            }
            $prep .= "<option ". $selected ."  value = '".$row["p1500_EqptoID"]."'>". $row["p1500_NumCR"]."</option>";
            $selected = "";
        }
        $prep .="</select>";
        return $prep;
}

function FormataDataISO($strdata){
	$p1 = substr($strdata,6,4);
	$p2 = substr($strdata,3,2);
	$p3 = substr($strdata,0,2);
	$p4 = $p1.'-'.$p2.'-'.$p3;
	return $p4;
}

function FormataDataHora($strdata){
	$p1 = substr($strdata,0,4);
	$p2 = substr($strdata,5,2);
	$p3 = substr($strdata,8,2);
	$p4 = $p3.'/'.$p2.'/'.$p1;
	$p4 = $p4 .  substr($strdata,10,6);
	return $p4;
	//echo $p4."<br>";
}




function RetornaMateriais(){

	//$lote =  $_GET['lote']; 
	//$lote = substr($lote,0,-2);
	$pst_numero = $_GET['pst_numero']; 

	
	include("../lib/DB.php");
	// futuramente colocar essa proc que virá das requisições
	//$query = "exec crsa.uspMateriais '" .$lote ."'"; 
	//$stmt = $conn->query($query);

	try{
	$sql = "set nocount on; exec crsa.uspP0600_MATERIAIS_LISTA " .$pst_numero.",1, ''"; 
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	}
	catch(PDOException){}
	$prep = "";

	
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

		$paramedit = "onclick = fu_edtMaterial('";
		$paramedit = $paramedit . trim($row["p600_id"]);
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . trim($row["p600_sistema"]);
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . trim($row["p600_codAlmoxMaterial"]);
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . str_replace(" ", "¬", trim($row["p600_lote"]));
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . trim($row["p600_lote2"]);
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . trim($row["p015_marcacd"]);
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . trim($row["p030_material_tipo_id"]);
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . FormataDataISO(trim($row["p600_Validade"]));
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . str_replace(" ", "¬", trim($row["p600_Tipo_Cor_CR"]));
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . str_replace(" ", "¬", trim($row["p600_LteCtrQtde"]));
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . trim($row["p047_UnidadeDsc"]);
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . str_replace(" ", "¬", trim($row["p600_Material"]));
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . number_format($row["p600_qtde1"], 2);
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . $row["p600_posicaotela"];
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . trim($row["p600_LoteIpen"]);
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . str_replace(" ", "¬", trim($row["p600_LoteFornec"]));

		$paramedit = $paramedit ."')";

		//echo $paramedit;


		$prep .= "<tr>";
		$prep .= "<td>";
		$prep .= "<button type='button' class='btn btn-sm btn-outline-primary' ".$paramedit." id='editmat' name='editmat' target='processarMAT' form='processarMAT'><i class='fas fa-edit'></i></button>";
		$prep .= "<button type='button' class='btn btn-sm btn-outline-primary' onclick=fu_delMaterial('".$row["p600_id"]."')  id='delmat'  name='delmat'  target='processarMAT' form='processarMAT'><i class='fas fa-trash'></i></button>";
		$prep .=  "<input type='hidden' name='param1' value='".$row["p600_id"]."' />" ;
		$prep .=  "<input type='hidden' name='param2' value='".trim($row["p600_codAlmoxMaterial"])."' />" ;

		$prep .= "</td>";
		$prep .= "<td>".$row["p600_posicaotela"]. "</td>";
		$prep .= "<td>".$row["p600_material"]. "</td>";
		$prep .= "<td>".$row["p600_lote"]. "</td>";
		$prep .= "<td>".$row["p015_marca"]. "</td>";
		$prep .= "<td>".$row["p600_Validade"]. "</td>";
		$prep .= "<td>".number_format($row["p600_qtde1"], 2, ',', '.'). "</td>";
		$prep .= "<td>".$row["p047_UnidadeDsc"]. "</td>";
		
		//$prep .= "<td>".number_format($row["p600_qtde2"], 2, ',', '.'). "</td>";
		//$prep .= "<td>".$row["unidade2"]. "</td>";
		$prep .= "</tr>";
	}

		
	return $prep;

}

function RetornaAmostras(){

	//$lote =  $_GET['lote']; 
	//$lote = substr($lote,0,-2);
	$pst_numero = $_GET['pst_numero']; 

	
	include("../lib/DB.php");
	// futuramente colocar essa proc que virá das requisições
	//$query = "exec crsa.uspMateriais '" .$lote ."'"; 
	//$stmt = $conn->query($query);

	$sql0 = "set nocount on; exec crsa.uspP0551_LISTA0 " . $_GET['pst_numero'] . "," . $_SESSION['usuarioID'];
	$stmt0 = $conn->prepare($sql0);
	$stmt0->execute();
	while ($row0 = $stmt0->fetch(PDO::FETCH_ASSOC)) {
		$p551_cq_id = $row0["p551_cq_id"];
	}

	if ($p551_cq_id==''){
		$p551_cq_id ='0';
	}

	$sql = "set nocount on; exec crsa.uspP0551_LISTA " . $p551_cq_id . ",1,".$_SESSION['usuarioID']; 
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$prep = "";

	 
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

		$paramedit = "onclick = fu_edtAmostra('";
		$paramedit = $paramedit . trim($row["p551_frascos_id"]);
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . trim($row["p551_cq_id"]);
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . trim($row["p551_identificacaoamostra"]);
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . number_format(trim($row["p551_atividade"]),2);
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . number_format(trim($row["p551_volume"]),2);
		$paramedit = $paramedit ."')";
		
		//echo $paramedit;


		$prep .= "<tr>";
		$prep .= "<td>";
		$prep .= "<button type='button' class='btn btn-sm btn-outline-primary' ".$paramedit." id='editmat' name='editmat' target='processarMAT' form='processarMAT'><i class='fas fa-edit'></i></button>";
		$prep .= "<button type='button' class='btn btn-sm btn-outline-primary' onclick=fu_delAmostra(".$row["p551_frascos_id"]."," . trim($row["p551_cq_id"]) . ")  id='delmat'  name='delmat'  target='processarMAT' form='processarMAT'><i class='fas fa-trash'></i></button>";
		//$prep .=  "<input type='hidden' name='param1' value='".$row["p600_id"]."' />" ;
		//$prep .=  "<input type='hidden' name='param2' value='".trim($row["p600_codAlmoxMaterial"])."' />" ;

		$prep .= "</td>";
		$prep .= "<td>".$row["p551_identificacaoamostra"]. "</td>";
		$prep .= "<td>".number_format($row["p551_atividade"], 2, ',', '.') . "</td>";
		$prep .= "<td>".number_format($row["p551_volume"], 2, ',', '.') . "</td>";
		$prep .= "</tr>";
	}

		
	return $prep;

}


function CarregaSolucao(){
	$pst_numero = $_GET['pst_numero'];
	include("../lib/DB.php");
	$NrEtqFrc  = '';
	$prodetq_produto='';
	$loteCR='';
	$validade='';

	$sql = "
	select NrEtqFrc, prodetq_produto, LoteCR, convert(varchar(10),ProdVali,103) ProdVali
from crsa.tetq402_produto  a
left outer join crsa.tetq400_etqfrasco b on(a.prodetq_codigo=b.prodetq_codigo) 
inner join crsa.T0601_Solucoes c on c.id_solucoes = b.NrEtqFrc
where 1=1
  and prodetq_Ativo = 'S'
  and pst_numero = ".$pst_numero; 

	$stmt = $conn->prepare($sql);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$NrEtqFrc = $row["NrEtqFrc"];
		$prodetq_produto = $row["prodetq_produto"];
		$loteCR = $row["LoteCR"];
		$validade = $row["ProdVali"];
	}
	echo "<script>document.getElementById('txtIdSolu').value = '".$NrEtqFrc."' </script>";
	echo "<script>document.getElementById('txtNomeMat').value = '".$prodetq_produto."' </script>";
	echo "<script>document.getElementById('txtLoteIpen').value = '".$loteCR."' </script>";
	echo "<script>document.getElementById('txtValidade').value = '".$validade."' </script>";
	

}


function CarregaAmostras(){
	$pst_numero = $_GET['pst_numero']; 

	
	include("../lib/DB.php");



	$sql = "set nocount on; exec crsa.uspP0551_LISTA0 " .$pst_numero.",".$_SESSION['usuarioID']; 


	$stmt = $conn->prepare($sql);
	$stmt->execute();


	$p551_cq_id="";
	$p551_obs="";
	$p551_ph="";
	$p551_horaamostragem="";
	$p031_aspectoid="";

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$p551_cq_id = $row["p551_cq_id"];
		$p551_obs = $row["p551_obs"];
		$p551_ph = $row["p551_ph"];
		$p551_horaamostragem= $row["p551_horaamostragem"];
		$p031_aspectoid= $row["p031_aspectoid"];
	}

	$p551_horaamostragem = substr($p551_horaamostragem,0,2) . ":" .substr($p551_horaamostragem,2,2);
	echo "<script>document.getElementById('p551_cq_id').value = '".$p551_cq_id."' </script>";
	echo "<script>document.getElementById('p551_obs').value = '".$p551_obs."' </script>";
	echo "<script>document.getElementById('p551_ph').value = '".$p551_ph."' </script>";
	echo "<script>document.getElementById('p551_horaamostragem').value = '".$p551_horaamostragem."' </script>";
	echo "<script>document.getElementById('cmbAspecto').value = '".$p031_aspectoid."' </script>";

	$p612_transferenciaid = "";
	try{
		$sql1 = "exec crsa.R0612_AMOSTRAGEM_LISTA " .$p551_cq_id;
		$stmt1 = $conn->prepare($sql1);
		$stmt1->execute();


		
		while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
			$p612_transferenciaid =  $row1["p612_transferenciaid"];
		}
	}
	catch( PDOException){}
	echo "<script>document.getElementById('p612_transferenciaid').value = '".$p612_transferenciaid."' </script>";

}

function CarregaTecnicoResponsavel($tipo)
{

	if ($tipo == 1){/* pinça*/ 		$cmbidname = "cmbPinca"; }
	if ($tipo == 2){/* calculo*/ 	$cmbidname = "cmbCalculo"; }
	if ($tipo == 3){/* sas*/ 		$cmbidname = "cmbSAS"; }
	if ($tipo == 4){/* lacre*/ 		$cmbidname = "cmbLacracao"; }
	if ($tipo == 5){/* teccalc*/ 	$cmbidname = "cmbTecnicoCalc"; }


        include("../lib/DB.php");
        $query = "exec crsa.uspP1110_USUARIOS "; 
        $stmt = $conn->query($query);
        $prep = "<select  id='".$cmbidname."' name='".$cmbidname."' class='form-control form-control-sm'>";
        $selected = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row["p1110_usuarioid"] == $_SESSION['usuarioID']){
                $selected = "selected";
            }
            $prep .= "<option ". $selected ."  value = '".$row["p1110_usuarioid"]."'>". $row["p1110_nome"]."</option>";
            $selected = "";
        }
        $prep .="</select>";
        return $prep;
        
}

function CarregaTecnicoResponsavelNivel($tipo, $nivel)
{

	if ($tipo == 1){/* pinça*/ 		$cmbidname = "cmbPinca" . $nivel; }
	if ($tipo == 2){/* calculo*/ 	$cmbidname = "cmbCalculo" . $nivel; }
	if ($tipo == 3){/* sas*/ 		$cmbidname = "cmbSAS" . $nivel; }
	if ($tipo == 4){/* lacre*/ 		$cmbidname = "cmbLacracao" . $nivel; }
	if ($tipo == 5){/* teccalc*/ 	$cmbidname = "cmbTecnicoCalc" . $nivel; }


        include("../lib/DB.php");
        $query = "exec crsa.uspP1110_USUARIOS "; 
        $stmt = $conn->query($query);
        $prep = "<select  id='".$cmbidname."' name='".$cmbidname."' class='form-control form-control-sm'>";
		$prep .= "<option  value = '0'>Selecione</option>";
        $selected = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row["p1110_usuarioid"] == $_SESSION['usuarioID']){
                //$selected = "selected";
            }
            $prep .= "<option ". $selected ."  value = '".$row["p1110_usuarioid"]."'>". $row["p1110_nome"]."</option>";
            $selected = "";
        }
        $prep .="</select>";
        return $prep;

}

function CarregaTecnico()
{
        include("../lib/DB.php");
        $query = "exec crsa.uspP1110_USUARIOS_I131 "; 
        $stmt = $conn->query($query);
        $prep = "<select  id='cmbTecnico' name='cmbTecnico' class='form-control form-control-sm'>";
        $selected = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row["p1110_usuarioid"] == $_SESSION['usuarioID']){
                $selected = "selected";
            }
            $prep .= "<option ". $selected ."  value = '".$row["p1110_usuarioid"]."'>". $row["p1110_nome"]."</option>";
            $selected = "";
        }
        $prep .="</select>";
        return $prep;
        
}

function CarregaTecnicoVCD()
{
        include("../lib/DB.php");
        $query = "exec crsa.uspP1110_USUARIOS_I131 "; 
        $stmt = $conn->query($query);
        $prep = "<select  id='cmbTecnicoVCD' name='cmbTecnicoVCD' class='form-control form-control-sm'>";
        $selected = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row["p1110_usuarioid"] == $_SESSION['usuarioID']){
                $selected = "selected";
            }
            $prep .= "<option ". $selected ."  value = '".$row["p1110_usuarioid"]."'>". $row["p1110_nome"]."</option>";
            $selected = "";
        }
        $prep .="</select>";
        return $prep;
        
}

function CarregaTecnicoLPZ()
{
        include("../lib/DB.php");
        $query = "exec crsa.uspP1110_USUARIOS_I131 "; 
        $stmt = $conn->query($query);
        $prep = "<select  id='cmbTecnicoLPZ' name='cmbTecnicoLPZ' class='form-control form-control-sm'>";
        $selected = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row["p1110_usuarioid"] == $_SESSION['usuarioID']){
                $selected = "selected";
            }
            $prep .= "<option ". $selected ."  value = '".$row["p1110_usuarioid"]."'>". $row["p1110_nome"]."</option>";
            $selected = "";
        }
        $prep .="</select>";
        return $prep;
        
}


function CarregaTecnicoDilu($n)
{
        include("../lib/DB.php");
        $query = "exec crsa.uspP1110_USUARIOS_I131 "; 
        $stmt = $conn->query($query);
        $prep = "<select  id='cmbTecnico".$n."' name='cmbTecnico".$n."' class='form-control form-control-sm'>";
        $selected = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row["p1110_usuarioid"] == $_SESSION['usuarioID']){
                $selected = "selected";
            }
            $prep .= "<option ". $selected ."  value = '".$row["p1110_usuarioid"]."'>". $row["p1110_nome"]."</option>";
            $selected = "";
        }
        $prep .="</select>";
        return $prep;
        
}

function CarregaCalculosImportado($apresenta, $tipo){
	/*
	***** Isso deu certo - Chama a proc e pega a lista e o retorno ***** 
	$tpst_numero = $_GET['pst_numero'];
	include("../lib/DB.php");
	$out_number = 0;
	$sql = "exec crsa.[spAlberto] @err = :out_number";
	$stmt = $conn->prepare($sql) ;
	$stmt->bindParam(':out_number', $out_number, PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 32);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		echo $row["name"] ."<br>";
	}
	$stmt->nextRowset();  
	echo 'Output number ' . $out_number;
	*/

	$tpst_numero = $_GET['pst_numero'];
	include("../lib/DB.php");
	$total_ativ = 0;
	$total_vol = 0;
	$total_corrigido = 0;
	$sql = "exec sgcr.crsa.[uspP0184_Recebimento_lista] @pst_numero = :pst_numero, @tipo = :tipo,  @total_ativ = :total_ativ, @total_vol = :total_vol, @total_corrigido = :total_corrigido";
	$stmt = $conn->prepare($sql);
	/* input */
	$stmt->bindParam(':pst_numero', $tpst_numero, PDO::PARAM_STR);
	$stmt->bindParam(':tipo', $tipo, PDO::PARAM_INT);
	/* output */
	$stmt->bindParam(':total_ativ', $total_ativ, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000);
	$stmt->bindParam(':total_vol', $total_vol, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000);
	$stmt->bindParam(':total_corrigido', $total_corrigido, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000);
	$stmt->execute();


	if($tipo==2)
	{
		$_ativ = "atividade";
		$_vol = "volume";
		$_atc = "ativ_corrigida";
	}
	else{
		$_ativ = "atividade";
		$_vol = "volume";
		$_atc = "ativ_corrigida";
	}


	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		if ($apresenta==0){
			$prep .= "<tr>";
			$prep .= "<td>--</td>";
			$prep .= "<td>".$row["p184_identificacao"] ."</td>";
			$prep .= "<td class='text-right'>".number_format($row[$_ativ], 2, ',', '.') ."</td>";
			$prep .= "<td class='text-right'>".number_format($row[$_vol], 2, ',', '.') ."</td>";
			$thisdate = $row["dtcl"];
			//$thisdate = substr($thisdate,8,2)."/".substr($thisdate,5,2)."/".substr($thisdate,0,4)." ".substr($thisdate,10,6);
			$prep .= "<td class='text-center'>".$thisdate."</td>";
			$prep .= "<td class='text-right'>".number_format($row[$_atc], 2, ',', '.') ."</td>";
			$prep .= "<tr>";
		}
	}
	$stmt->nextRowset();  
	$total_ativ = number_format($total_ativ, 2, ',', '.'); 
	$total_vol = number_format($total_vol, 2, ',', '.'); 
	$total_corrigido = number_format($total_corrigido, 2, ',', '.'); 

	echo "<script>document.getElementById('tot_atv_imp').value = '".$total_ativ."' </script>";
	echo "<script>document.getElementById('tot_vol_imp').value = '".$total_vol."' </script>";
	echo "<script>document.getElementById('tot_atvc_imp').value = '".$total_corrigido."' </script>";


	echo "<script>document.getElementById('tot_atv_med').value = '".$total_ativ."' </script>";
	echo "<script>document.getElementById('tot_vol_med').value = '".$total_vol."' </script>";
	echo "<script>document.getElementById('tot_atvc_med').value = '".$total_corrigido."' </script>";


	return $prep;


}

function CarregaProducaoIpen(){
	$tpst_numero = $_GET['pst_numero'];
	include("../lib/DB.php");
	$sql = "exec sgcr.crsa.[uspP0640_ENVIO_LISTA2] @pst_numero_dist = :pst_numero";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':pst_numero', $tpst_numero, PDO::PARAM_STR);
	$stmt->execute();

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "<tr>";
		$prep .= "<td>" . number_format($row["p640_atividade"], 2, ',', '.')  ."</td>";
		$prep .= "<td>" . number_format($row["p640_volume"], 2, ',', '.')  ."</td>";
		$prep .= "<td>".$row["p640_data"] ."</td>";
		$prep .= "<td>" . number_format($row["p640_atividade"], 2, ',', '.')  ."</td>";
		$prep .= "<tr>";
	}

	return $prep;
}

function CarregaSobras(){
	$tpst_numero = $_GET['pst_numero'];
	include("../lib/DB.php");
	$sql = "exec sgcr.crsa.[uspP0608_SOBRAS_LISTA] '".$tpst_numero."',0,0";
	$stmt = $conn->prepare($sql);

	//$stmt->bindParam(':pst_numero', $tpst_numero, PDO::PARAM_STR);
	//$stmt->bindParam(':total_vol', 0, PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
	//$stmt->bindParam(':total_ativ', 0, PDO::PARAM_int|PDO::PARAM_INPUT_OUTPUT, 4000);
	$stmt->execute();
	$prep = "";


	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "<tr>";
		$prep .= "<td>--</td>";
		$prep .= "<td>".$row["lote"] ."</td>";
		$prep .= "<td>".$row["p608_md_atividade"] ."</td>";
		$prep .= "<td>".$row["p608_md_volume"] ."</td>";
		$prep .= "<td>".$row["p608_md_cr"] ."</td>";
		$prep .= "<td>".$row["p608_md_data"] ."</td>";
		$prep .= "<td>".$row["atividade_corrigida"] ."</td>";
		$prep .= "<tr>";
	}

	return $prep;
}

function CarregaCalculos(){
	//var_dump($_GET);
	$tpst_numero = $_GET['pst_numero'];
	include("../lib/DB.php");
	$query = "exec crsa.uspP0641_I131_LISTA '".$tpst_numero."'"; 
	$stmt = $conn->query($query);
	$txtCalcDtProducao="";
	$txtCalcDtCalibracao="";
	$txtCalcDistribPart="";
	$txtCalcDistribAtvTot="";
	$p641_imp_atvm="0";
	$p641_imp_volm="0";
	$p641_imp_datam="";
	$p641_imp_fatorm="0";
	$imp_corrigido="0";
	$p641_ipen_atvm="0";
	$p641_ipen_volm="0";
	$p641_ipen_datam="";
	$p641_ipen_fatorm="0";
	$pen_corrigido="0";

	$p641_Sb_atvm="0";
	$p641_Sb_Volm="0";
	$p641_sb_datam="";
	$p641_Sb_Fatorm="0";
	$sobras_corrigido="0";
	
	$p641_PincaRsp="0";
	$p641_CalculoRsp="0";
	$p641_sasRsp="0";
	$p641_lacracaoRsp="0";

	$p641_sobraatv=0;
	$p641_sobravol=0;
	$p641_sobradata="";


	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$txtCalcDtProducao = $row["p641_producao"];
		$txtCalcDtCalibracao = $row["p641_Calibracao"];
		$txtCalcDistribPart = $row["p641_partidas"];
		$txtCalcDistribAtvTot=$row["p641_AtividadeDistribuida"];
		$p641_imp_atvm=$row["p641_imp_atvm"];
		$p641_imp_volm=$row["p641_imp_volm"];
		$p641_imp_datam=$row["p641_imp_datam"];
		$p641_imp_fatorm=$row["p641_imp_fatorm"];
		$imp_corrigido=$row["imp_corrigido"];
		$p641_ipen_atvm=$row["p641_ipen_atvm"];
		$p641_ipen_volm=$row["p641_ipen_volm"];
		$p641_ipen_datam=$row["p641_ipen_datam"];
		$p641_ipen_fatorm=$row["p641_ipen_fatorm"];
		$ipen_corrigido=$row["ipen_corrigido"];

		$p641_Sb_atvm=$row["p641_Sb_atvm"];
		$p641_Sb_Volm=$row["p641_Sb_Volm"];
		$p641_sb_datam=$row["p641_sb_datam"];
		$p641_Sb_Fatorm=$row["p641_Sb_Fatorm"];
		$sobras_corrigido=$row["sobras_corrigido"];

		$p641_PincaRsp=$row["p641_PincaRsp"];
		$p641_CalculoRsp=$row["p641_CalculoRsp"];
		$p641_sasRsp=$row["p641_sasRsp"];
		$p641_lacracaoRsp=$row["p641_lacracaoRsp"];
		$p641_sobraatv=$row["p641_sobraatv"];
		$p641_sobravol=$row["p641_sobravol"];
		$p641_sobradata=$row["p641_sobradata"];


	}




	$p1 = substr($txtCalcDtProducao,6,4);
	$p2 = substr($txtCalcDtProducao,3,2);
	$p3 = substr($txtCalcDtProducao,0,2);
	$p4 = $p1.'-'.$p2.'-'.$p3.'T'.substr($txtCalcDtProducao,11,5);
	echo "<script>document.getElementById('txtCalcDtProducao').value = '".$p4."' </script>";
	$p1 = substr($txtCalcDtCalibracao,6,4);
	$p2 = substr($txtCalcDtCalibracao,3,2);
	$p3 = substr($txtCalcDtCalibracao,0,2);
	$p4 = $p1.'-'.$p2.'-'.$p3.'T'.substr($txtCalcDtCalibracao,11,5);
	echo "<script>document.getElementById('txtCalcDtCalibracao').value = '".$p4."' </script>";
	echo "<script>document.getElementById('txtCalcDistribPart').value = '".$txtCalcDistribPart."' </script>";
	echo "<script>document.getElementById('txtCalcDistribAtvTot').value = '".$txtCalcDistribAtvTot."' </script>";
	echo "<script>document.getElementById('p641_imp_atvm').innerText = '".number_format($p641_imp_atvm, 2, ',', '.')."' </script>";
	echo "<script>document.getElementById('p641_imp_volm').innerText = '".number_format($p641_imp_volm, 2, ',', '.')."' </script>";
	echo "<script>document.getElementById('p641_imp_datam').innerText = '".$p641_imp_datam."' </script>";
	echo "<script>document.getElementById('p641_imp_fatorm').innerText = '".number_format($p641_imp_fatorm, 4, ',', '.')."' </script>";
	echo "<script>document.getElementById('imp_corrigido').innerText = '".number_format($imp_corrigido, 2, ',', '.')."' </script>";
	echo "<script>document.getElementById('p641_ipen_atvm').innerText = '".number_format($p641_ipen_atvm, 2, ',', '.')."' </script>";
	echo "<script>document.getElementById('p641_ipen_volm').innerText = '".number_format($p641_ipen_volm, 2, ',', '.')."' </script>";
	echo "<script>document.getElementById('p641_ipen_datam').innerText = '".$p641_ipen_datam."' </script>";
	echo "<script>document.getElementById('p641_ipen_fatorm').innerText = '".number_format($p641_ipen_fatorm, 4, ',', '.')."' </script>";
	echo "<script>document.getElementById('ipen_corrigido').innerText = '".number_format($ipen_corrigido, 2, ',', '.')."' </script>";

	echo "<script>document.getElementById('p641_Sb_atvm').innerText = '".number_format($p641_Sb_atvm, 2, ',', '.')."' </script>";
	echo "<script>document.getElementById('p641_Sb_Volm').innerText = '".number_format($p641_Sb_Volm, 2, ',', '.')."' </script>";
	echo "<script>document.getElementById('p641_sb_datam').innerText = '".$p641_sb_datam."' </script>";
	echo "<script>document.getElementById('p641_Sb_Fatorm').innerText = '".number_format($p641_Sb_Fatorm, 4, ',', '.')."' </script>";
	echo "<script>document.getElementById('sobras_corrigido').innerText = '".number_format($sobras_corrigido, 2, ',', '.')."' </script>";

	echo "<script>document.getElementById('p641_PincaRsp').value = '".$p641_PincaRsp."' </script>";
	echo "<script>document.getElementById('p641_CalculoRsp').value = '".$p641_CalculoRsp."' </script>";
	echo "<script>document.getElementById('p641_sasRsp').value = '".$p641_sasRsp."' </script>";
	echo "<script>document.getElementById('p641_lacracaoRsp').value = '".$p641_lacracaoRsp."' </script>";


	//$p641_sobraatv = number_format($p641_sobraatv, 2, '.', ',');
	//$p641_sobravol = number_format($p641_sobravol, 2, '.', ',');

	if ($p641_sobraatv ==""){
		$p641_sobraatv = 0;
	} 

	if ($p641_sobravol ==""){
		$p641_sobravol = 0;
	} 


	echo "<script>document.getElementById('txtAtvSbrFim').value = '".$p641_sobraatv."' </script>";
	echo "<script>document.getElementById('txtVolSbrFim').value = '".$p641_sobravol."' </script>";




	$p1 = substr($p641_sobradata,6,4);
	$p2 = substr($p641_sobradata,3,2);
	$p3 = substr($p641_sobradata,0,2);
	$p4 = $p1.'-'.$p2.'-'.$p3.'T'.substr($p641_sobradata,11,5);


	echo "<script>document.getElementById('txtDatSbrFim').value = '".$p4."' </script>";
	


}

function carregaFatorDecaimento($produto){

	$produto = 'I-131';
	include("../lib/DB.php");
	$query = "exec crsa.[uspP0602_FD_LISTA] '" .$produto. "'"; 
	$stmt = $conn->query($query);
	$prep = "";

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "<tr>";
		$prep .= "<td><i class='fas fa-check' style='color: #005af5; height:20px; cursor:pointer' onclick='fu_calcDecaimento(".$row["p602_minutosfator"].")'></i></td>";
		$prep .= "<td>".$row["p602_minutos"]. "</td>";
		$prep .= "<td>".$row["p602_horas"]. "</td>";
		$prep .= "<td>".$row["p602_dias"]. "</td>";
		$prep .= "<td>".$row["p602_minutosfator"]. "</td>";
		$prep .= "<td>".$row["p602_Total_Minutos"]. "</td>";
		$prep .= "</tr>";
	}


	return $prep;

}

if (isset($_POST['retormaFatorDecaimento']))
{

	$dt1 = $_POST["m_data1"];
	$dt2 = $_POST["m_data2"];
	$prd = $_POST["prd"];
	$prod = $_POST["m_prod"];
	$minutos = "";
	$prep1 = "";

	include("../lib/DB.php");
	$query = "select datediff(n, '".$dt1."','".$dt2."') minutos"; 
	$stmt = $conn->query($query);

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$minutos = $row["minutos"];
	}

	$query1 = "set nocount on; exec [crsa].[uspP0602_FATOR_DECAIMENTO] @produto = '".$prod."', @minutos = ".$minutos; 
	$stmt1 = $conn->query($query1);
	while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
		$prep1 = $row1["fator"];
	}

	if ($prep1==""){$prep1= '1.0000';}

	$prep1 = number_format($prep1,4);

/*
	Incluir esta funcionalidade quando preecher a data da medida
	                       --CR MEDIDA   DATA CALIBRAÇÃO
	select datediff(n, '20231218 10:11','20231222 12:00')
	exec [crsa].[uspP0602_FATOR_DECAIMENTO] @produto = 'TLCL3', @minutos = 5869
	*/
	echo($prep1);
	return;
}

function carregaDiluicao($n){
	
	$tpst_numero = $_GET['pst_numero'];
	include("../lib/DB.php");
	$sql = "exec sgcr.[crsa].[uspP0642_I131_LISTA] ".$n.",".$tpst_numero;
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	$p642_ID = 0;
	$p641_ID = 0;
	$p642_Diluicao_numero = 0;

	$p642_Fator = 0;
	$p642_CR = 0;
	$p642_CR_fator = 0;
	$p642_Volume = 0;
	$p642_AtvRef = 0;
	$p642_I_P = '';
	$p642_vol1ml = 0;
	$p642_FaixaInicio = 0;
	$p642_FaixaFim = 0;
	$sobra_utilizada = 0;
	$p642_ph = 0;
	$p642_sbm_vol = 0;
	$p642_sbm_atv = 0;

	$util_sol_estoque="";
	$sol_est_lote="";
	$sol_princ_lote="";
	$sol_princ_qto=0;
	$sol_princ_vol=0;
	$volhidsod1n=0;
	$voltotalhidsod1n=0;
	$tempohomeg = 0;
	$presgasoxi = 0;
	$vazoxi = 0;
	$concradio80100 = 0;
	$atvTotSoluc = 0;
	$vol_apreendil = "";
	$sbr_descarta="";
	$sobra_atv = 0;
	$sobra_vol = 0;
	$sol_princ_Qto_ARR="";
	$sol_princ_Vol_ARR="";


	$nro_util_sol_dilu = 0;
	$flg_util_sol_dilu = "N";
	$atv_util_sol_dilu = 0;
	$vol_util_sol_dilu = 0;
	

	
	

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$p642_ID = $row['p642_ID'];
		$p641_ID = $row['p641_ID'];
		$p642_Diluicao_numero = $row['p642_Diluicao_numero'];
		$p642_Fator = $row['p642_Fator'];
		$p642_CR = $row['p642_CR'];
		$p642_CR_fator = $row['p642_CR_fator'];
		$p642_Volume= $row['p642_Volume'];
		$p642_AtvRef= $row['p642_AtvRef'];
		$p642_I_P= $row['p642_I_P'];
		$p642_vol1ml = $row['p642_vol1ml'];
		$p642_FaixaInicio = $row['p642_FaixaInicio'];
		$p642_FaixaFim = $row['p642_FaixaFim'];
		$sobra_utilizada = $row['sobra_utilizada'];
		$p642_ph  = $row['p642_ph'];
		$p642_sbm_vol= $row['p642_sbm_vol'];
		$p642_sbm_atv= $row['p642_sbm_atv'];


		$util_sol_estoque =$row['util_sol_estoque'];
		$sol_est_lote=$row['sol_Est_Lote'];
		$sol_princ_lote=$row['sol_Princ_Lote'];
		$sol_princ_qto=$row['Sol_Princ_Qto']; 
		$sol_princ_vol=$row['Sol_Princ_Vol']; 
		$volhidsod1n= $row['VolHidSod1N']; 
		$voltotalhidsod1n = $row['VolTotalHidSod1N']; 
		$tempohomeg = $row['TempoHomeg']; 
		$presgasoxi = $row['PresGazOx']; 
		$vazoxi = $row['VazOxi']; 
		$concradio80100 = $row['ConcRad80a100']; 
		$atvTotSoluc = $row['AtvTotSoluc']; 
		$vol_apreendil =$row['vol_apreendil']; 
		$sbr_descarta = $row['sbr_Descarta'];
		$sobra_atv = $row['sobra_atv'];
		$sobra_vol = $row['sobra_vol'];
		$sol_princ_Qto_ARR=$row['sol_princ_Qto_ARR'];
		$sol_princ_Vol_ARR=$row['sol_princ_Vol_ARR'];

		$nro_util_sol_dilu = $row['nro_util_sol_dilu'];
		$flg_util_sol_dilu = $row['flg_util_sol_dilu'];
		$atv_util_sol_dilu = $row['atv_util_sol_dilu'];
		$vol_util_sol_dilu = $row['vol_util_sol_dilu'];
	

	}
	




	$p642_Fator    		= number_format($p642_Fator, 4, '.', ',');
	$p642_CR       		= number_format($p642_CR, 2, '.', ',');
	$p642_CR_fator 		= number_format($p642_CR_fator, 2);
	$p642_Volume   		= number_format($p642_Volume, 2, '.', ',');
	$sobra_utilizada 	= number_format($sobra_utilizada, 2, '.', ',');
	//$p642_ph 			= str_replace(',','.',ltrim($p642_ph));
	$p642_sbm_atv 		= number_format($p642_sbm_atv, 2, '.', ',');
	$p642_sbm_vol 		= number_format($p642_sbm_vol, 2, '.', ',');
	$sobra_utilizada 	= str_replace(',','',$sobra_utilizada);
	$p642_sbm_atv 		= str_replace(',','',$p642_sbm_atv);
	$p642_sbm_vol 		= str_replace(',','',$p642_sbm_vol);
	$p642_CR_fator 		= str_replace(',','',$p642_CR_fator);
	$sobra_vol	 		= number_format($sobra_vol, 2, '.', ',');
	$sol_princ_vol	 	= number_format($sol_princ_vol, 2, '.', ',');
	$volhidsod1n	 	= number_format($volhidsod1n, 2, '.', ',');
	$voltotalhidsod1n   = number_format($voltotalhidsod1n, 2, '.', ',');
	$concradio80100     = number_format($concradio80100, 2, '.', ',');
	//$p642_ph     		= number_format($p642_ph, 2, '.', ',');
	$vol_util_sol_dilu  = number_format($vol_util_sol_dilu, 2, '.', ',');





    //$row = $stmt->fetch();
	if ($p641_ID==0) { 
	
		$sql1 = "exec sgcr.[crsa].[uspP0641_I131_LISTA] ".$tpst_numero;
		$stmt1 = $conn->prepare($sql1);
		$stmt1->execute();
		while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
			$p641_ID = $row1['p641_ID'];
		}
	}


	echo "<script>document.getElementById('Fator".$n."').value = '".$p642_Fator."'</script>";
	echo "<script>document.getElementById('ConcRadio".$n."').value = '".$p642_CR."'</script>";
	echo "<script>document.getElementById('CR".$n."').value = '".$p642_CR_fator."'</script>";
	echo "<script>document.getElementById('CR".$n."').value = '".$p642_CR_fator."'</script>";
	echo "<script>document.getElementById('Volume".$n."').value = '".$p642_Volume."'</script>";
	echo "<script>document.getElementById('Ativ".$n."').value = '".$p642_AtvRef."'</script>";
	echo "<script>document.getElementById('Origem".$n."').value = '".$p642_I_P."'</script>";
	echo "<script>document.getElementById('Completa1ml".$n."').value = '".$p642_vol1ml."'</script>";
	echo "<script>document.getElementById('PedAtvIni".$n."').value = '".$p642_FaixaInicio."'</script>";
	echo "<script>document.getElementById('PedAtvFim".$n."').value = '".$p642_FaixaFim."'</script>";
	echo "<script>document.getElementById('totatvremanec".$n."').value = '".$sobra_utilizada."'</script>";
	echo "<script>document.getElementById('totphremanec".$n."').value = '".$p642_ph."'</script>";
	echo "<script>document.getElementById('totsobravol".$n."').value = '".$p642_sbm_vol."'</script>";
	echo "<script>document.getElementById('totsobraatv".$n."').value = '".$p642_sbm_atv."'</script>";
	echo "<script>document.getElementById('ttxtp642_ID".$n."').value = '".$p642_ID."'</script>";
	echo "<script>document.getElementById('ttxtp641_ID".$n."').value = '".$p641_ID."'</script>";
	echo "<script>document.getElementById('ttxtfornSel".$n."').value = '".$sol_princ_lote."'</script>";
	

	echo "<script>document.getElementById('txtnro_util_sol_dilu".$n."').value = '".$nro_util_sol_dilu."'</script>";
	echo "<script>document.getElementById('txtatv_util_sol_dilu".$n."').value = '".$atv_util_sol_dilu."'</script>";
	echo "<script>document.getElementById('txtvol_util_sol_dilu".$n."').value = '".$vol_util_sol_dilu."'</script>";


	
	

	if ($flg_util_sol_dilu == "S"){
		echo "<script>document.getElementById('flg_util_sol_diluS".$n."').checked = 'checked'</script>";
	}
	else {
		echo "<script>document.getElementById('flg_util_sol_diluN".$n."').checked = 'checked'</script>";
	}


	
	if ($util_sol_estoque == "S"){
		echo "<script>document.getElementById('sol_estoqueS".$n."').checked = 'checked'</script>";	
	}
	if ($util_sol_estoque == "N"){
		echo "<script>document.getElementById('sol_estoqueN".$n."').checked = 'checked'</script>";	
	}


	echo "<script>document.getElementById('txtSolEstLote".$n."').value = '".$sol_est_lote."'</script>";

	if ($sol_princ_lote == "1"){
		echo "<script>document.getElementById('sol_fornprincipal1S".$n."').checked = 'checked'</script>";	
	}
	if ($sol_princ_lote == "2"){
		echo "<script>document.getElementById('sol_fornprincipal1N".$n."').checked = 'checked'</script>";	
	}



	echo "<script>document.getElementById('txtSolPrinQto".$n."').value = '".$sol_princ_qto."'</script>";
	echo "<script>document.getElementById('txtSolPrinVol".$n."').value = '".$sol_princ_vol."'</script>";	
	echo "<script>document.getElementById('txtVolHidSod1N".$n."').value = '".$volhidsod1n."'</script>";
	echo "<script>document.getElementById('txtVolTotalHidSod1N".$n."').value = '".$voltotalhidsod1n."'</script>";
	echo "<script>document.getElementById('txtTempoHomeg".$n."').value = '".$tempohomeg."'</script>";	
	echo "<script>document.getElementById('txtPresGazOx".$n."').value = '".$presgasoxi."'</script>";
	echo "<script>document.getElementById('txtVazOxi".$n."').value = '".$vazoxi."'</script>";
	echo "<script>document.getElementById('txtConcRad80a100_".$n."').value = '".$concradio80100."'</script>";
	echo "<script>document.getElementById('txtAtvTotSoluc_".$n."').value = '".$atvTotSoluc."'</script>";
	if ($vol_apreendil == "S"){
		echo "<script>document.getElementById('vol_apreendil1S".$n."').checked = 'checked'</script>";	
	}
	if ($vol_apreendil == "N"){
		echo "<script>document.getElementById('vol_apreendil1N".$n."').checked = 'checked'</script>";	
	}
	if ($sbr_descarta == "S"){
		echo "<script>document.getElementById('sbr_Descarta1S".$n."').checked = 'checked'</script>";	
	}
	if ($sbr_descarta == "N"){
		echo "<script>document.getElementById('sbr_Descarta1N".$n."').checked = 'checked'</script>";	
	}
	echo "<script>document.getElementById('txtsobra_atv".$n."').value = '".$sobra_atv."'</script>";
	echo "<script>document.getElementById('txtsobra_vol".$n."').value = '".$sobra_vol."'</script>";
	echo "<script>fuCalcPartidas(".$n.")</script>";



	//$qtf = explode("|", $sol_princ_Qto_ARR);
	//$vlf = explode("|", $sol_princ_Vol_ARR);

	//echo "<script>alert(" . count($qtf) . ")</script>";
	//echo "<script>alert('".$qtf."')</script>";

	echo "<script>document.getElementById('ttxtfornQtoARR".$n."').value = '".$sol_princ_Qto_ARR."'</script>";
	echo "<script>document.getElementById('ttxtfornVolARR".$n."').value = '".$sol_princ_Vol_ARR."'</script>";
	



}

function CarregaPedidoInterno($_pst_numero){

	include("../lib/DB.php");
	$sql = "exec sgcr.[crsa].[uspP0647_Pedido_Interno] ".$_pst_numero;
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	$AtvMM    = '0';
	$VolMM    = '0';
	$DatMM    = '0';
	$AtvCAPS  = '0';
	$VolCAPS  = '0';
	$DatCAPS  = '0';
	$AtvPesq  = '0';
	$VolPesq  = '0';
	$DatPesq  = '0';
	$AtvTotal = '0';
	$VolTotal = '0';
	$DatTotal = '0';

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$AtvMM = $row['AtvMM'];
		$VolMM = $row['VolMM'];
		$DatMM = $row['DatMM'];
		$AtvCAPS = $row['AtvCAPS'];
		$VolCAPS = $row['VolCAPS'];
		$DatCAPS = $row['DatCAPS'];
		$AtvPesq = $row['AtvPesq'];
		$VolPesq = $row['VolPesq'];
		$DatPesq = $row['DatPesq'];
		$AtvTotal = $row['AtvTotal'];
		$VolTotal = $row['VolTotal'];
		$DatTotal = $row['DatTotal'];
	}


	$AtvMM =  number_format($AtvMM, 0);
	$VolMM =  number_format($VolMM, 2, '.', ',');
	$AtvCAPS =  number_format($AtvCAPS, 0);
	$VolCAPS =  number_format($VolCAPS, 2, '.', ',');
	$AtvPesq =  number_format($AtvPesq, 0);
	$VolPesq =  number_format($VolPesq, 2, '.', ',');
	$AtvTotal =  number_format($AtvTotal, 0);
	$VolTotal =  number_format($VolTotal, 2, '.', ',');
	$AtvMM = str_replace(',','',$AtvMM);
	$VolMM = str_replace(',','',$VolMM);
	$AtvCAPS = str_replace(',','',$AtvCAPS);
	$VolCAPS = str_replace(',','',$VolCAPS);
	$AtvPesq = str_replace(',','',$AtvPesq);
	$VolPesq = str_replace(',','',$VolPesq);
	$AtvTotal = str_replace(',','',$AtvTotal);
	$VolTotal = str_replace(',','',$VolTotal);

	echo "<script>document.getElementById('txtAtvMM').value = '".$AtvMM."'</script>";
	echo "<script>document.getElementById('txtVolMM').value = '".$VolMM."'</script>";
	echo "<script>document.getElementById('txtDatMM').value = '".$DatMM."'</script>";
	echo "<script>document.getElementById('txtAtvCAPS').value = '".$AtvCAPS."'</script>";
	echo "<script>document.getElementById('txtVolCAPS').value = '".$VolCAPS."'</script>";
	echo "<script>document.getElementById('txtDatCAPS').value = '".$DatCAPS."'</script>";
	echo "<script>document.getElementById('txtAtvPesq').value = '".$AtvPesq."'</script>";
	echo "<script>document.getElementById('txtVolPesq').value = '".$VolPesq."'</script>";
	echo "<script>document.getElementById('txtDatPesq').value = '".$DatPesq."'</script>";
	echo "<script>document.getElementById('txtAtvTotal').value = '".$AtvTotal."'</script>";
	echo "<script>document.getElementById('txtVolTotal').value = '".$VolTotal."'</script>";
	echo "<script>document.getElementById('txtDatTotal').value = '".$DatTotal."'</script>";
}

function CarregaFonteCalib($_pst_numero){

	include("../lib/DB.php");
	$sql = "exec sgcr.[crsa].[P0600_EQPTO_LISTA_CALIB] " . $_pst_numero . ",'T'";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$font_calib='';
	try{
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$font_calib = $row['fonte_calib'];
	}
	}
	catch(PDOException){

	}
	echo "<script>document.getElementById('txtfontcalib').value = '".$font_calib."'</script>";

}

function CarregaFonteCalibCMB(){
	include("../lib/DB.php");
	$sql = "select prod_codigo, nome_comercial 
	from vendasPelicano.dbo.T0250_Produto 
	where prod_categoria=1 and prod_ativo = 'a'
	 ";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$prep = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "<option value='". $row['nome_comercial']."'>". $row['nome_comercial']."</option>";
	}
	echo $prep;

}


function CarregaReconMat(){
	$tpst_numero = $_GET['pst_numero'];
	include("../lib/DB.php");
	$sql = "exec sgcr.[crsa].[uspReconcMat_I131] " .$tpst_numero;
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

		if ($row["id"] == 1){
			echo "<script>document.getElementById('nome1').innerText = '".$row['nome']."'</script>";
			echo "<script>document.getElementById('valor1').innerText = '".$row['valor']."'</script>";
		}

		if ($row["id"] == 2){
			echo "<script>document.getElementById('nome2').innerText = '".$row['nome']."'</script>";
			echo "<script>document.getElementById('valor2').innerText = '".$row['valor']."'</script>";
		}

		if ($row["id"] == 3){
			echo "<script>document.getElementById('nome3').innerText = '".$row['nome']."'</script>";
			echo "<script>document.getElementById('valor3').innerText = '".$row['valor']."'</script>";
		}
		if ($row["id"] == 4){
			echo "<script>document.getElementById('nome4').innerText = '".$row['nome']."'</script>";
			echo "<script>document.getElementById('valor4').innerText = '".$row['valor']." %'</script>";
		}

	}



}


function CarregaRespAreaRP(){
	include("../lib/DB.php");
	$sql = "exec crsa.uspP1110_Responsavel_Area @p052_grupocd=2 ";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	$prep = "";
	$prep = "<option value=0>Selecione</option>";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$respcod = $row['p1110_usuarioid'];
		$respnom = $row['p1110_nome'];
		$prep .= "<option value=".$respcod.">".$respnom."</option>";
	}
	echo $prep;
}

function CarregaProcProdRP(){
	include("../lib/DB.php");
	$sql = "exec crsa.uspP0070_STATUS_RD ";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	$prep = "";
	$prep = "<option value=0>Selecione</option>";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$respcod = $row['p070_statuscd'];
		$respnom = $row['p070_status'];
		$prep .= "<option value=".$respcod.">".$respnom."</option>";
	}
	echo $prep;
}

function CarregaRespAreaCQ(){
	include("../lib/DB.php");
	$sql = "exec crsa.uspP1110_USUARIOS_SEL006 13 ";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	$prep = "";
	$prep = "<option value=0>Selecione</option>";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$respcod = $row['p1110_usuarioid'];
		$respnom = $row['p1110_nome'];
		$prep .= "<option value=".$respcod.">".$respnom."</option>";
	}
	echo $prep;
}

function CarregaDadosRP($_pst_numero){
	//include("../lib/DB.php");
	//$sql = "exec crsa.uspP0070_STATUS_RD ";
	//$stmt = $conn->prepare($sql);
	//$stmt->execute();

	include("../lib/DB.php");
	$sql = "exec crsa.[uspPPST_PRODUCAO_LISTA2] " . $_pst_numero;
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$pst_rd_obs = $row['pst_rd_obs'];
		$pst_rd_status = $row['pst_rd_status'];
		$pst_rd_responsavel = $row['pst_rd_responsavel'];
		$p033_ResultadoID = $row['p033_ResultadoID'];
		$pst_gq_obs = $row['pst_gq_obs'];
		$p033_GarantiaQualidade = $row['p033_GarantiaQualidade'];
		
	}

	echo "<script>document.getElementById('txtObservacaoRP').value = '" . $pst_rd_obs . "'</script>";
	echo "<script>document.getElementById('cmbProcessoProdRP').value = '" . $pst_rd_status . "'</script>";
	echo "<script>document.getElementById('cmbResponsavelProdRP').value = '" . $pst_rd_responsavel . "'</script>";
	echo "<script>document.getElementById('cmbProcessoProdGQ').value = '" . $p033_ResultadoID . "'</script>";
	echo "<script>document.getElementById('txtObservacaoGQ').value = '" . $pst_gq_obs . "'</script>";
	echo "<script>document.getElementById('cmbResponsavelProdGQ').value = '" . $p033_GarantiaQualidade . "'</script>";

	
	
}

function CarregaAtualizacaoRP($_pst_numero){
	//include("../lib/DB.php");
	//$sql = "exec crsa.uspP0070_STATUS_RD ";
	//$stmt = $conn->prepare($sql);
	//$stmt->execute();

	include("../lib/DB.php");
	$sql = "exec crsa.uspPPST_ULTIMA_ATUALIZACAO 9," . $_pst_numero;
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$atualizacao = $row['atualizacao'];
	}

	echo "<script>document.getElementById('txtatualizacaoRP').innerHTML = '" . $atualizacao . "'</script>";
	echo "<script>document.getElementById('txtatualizacaoGQ').innerHTML = '" . $atualizacao . "'</script>";
	
	
}

function CarregaOperadores($_pst_numero){
	include("../lib/DB.php");
	$sql = "exec crsa.uspP0095_Operadores " . $_pst_numero;
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		echo "<script>document.getElementById('cmbCalculo1').value = '" . $row["id_oper_calc_1"] . "'</script>";
		echo "<script>document.getElementById('cmbCalculo2').value = '" . $row["id_oper_calc_2"] . "'</script>";
		echo "<script>document.getElementById('cmbCalculo3').value = '" . $row["id_oper_calc_3"] . "'</script>";
		echo "<script>document.getElementById('cmbPinca1').value = '" . $row["id_oper_pinca_1"] . "'</script>";
		echo "<script>document.getElementById('cmbPinca2').value = '" . $row["id_oper_pinca_2"] . "'</script>";
		echo "<script>document.getElementById('cmbPinca3').value = '" . $row["id_oper_pinca_3"] . "'</script>";
		echo "<script>document.getElementById('cmbSAS1').value = '" . $row["id_oper_sas_1"] . "'</script>";
		echo "<script>document.getElementById('cmbSAS2').value = '" . $row["id_oper_sas_2"] . "'</script>";
		echo "<script>document.getElementById('cmbSAS3').value = '" . $row["id_oper_sas_3"] . "'</script>";
		echo "<script>document.getElementById('cmbLacracao1').value = '" . $row["id_oper_lacre_1"] . "'</script>";
		echo "<script>document.getElementById('cmbLacracao2').value = '" . $row["id_oper_lacre_2"] . "'</script>";
		echo "<script>document.getElementById('cmbLacracao3').value = '" . $row["id_oper_lacre_3"] . "'</script>";
		
		echo "<script>document.getElementById('cmbTecnico').value = '" . $row["id_oper"] . "'</script>";


	}


}

function carregaLotesAtendidos(){

	$lote = $_GET['lote'];
	$lote = substr($lote,0,3);
	$_pst_numero = $_GET['pst_numero'];
	$prod = "";
	if ($_GET['produto'] == 'rd_tl'){
		$prod = 'tlcl3';
	}

	if ($_GET['produto'] == 'rd_ga67'){
		$prod = 'ga-67';
	}

	//echo $lote;
	//echo $prod;

	include("../lib/DB.php");
	
	$sql = "select  crsa.fn_LotesAtendidos('" . $prod . "',0, 999999, ".$lote.") as lotes";
	//echo $sql;
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$lotes = $row['lotes'];
	}
	echo "<script>document.getElementById('txtPedAtendidos').value = '" . trim($lotes) . "'</script>";

	$sql1 = "set nocount on;  exec crsa.[uspP0110_ATIVIDADE_SOLICITADA]  ".$_pst_numero.", '', '', '', '', ''";
	$stmt1 = $conn->prepare($sql1);
	$stmt1->execute();
	$atividade = 0;
	while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
		$atividade = $atividade + ( $row1['p110atv'] * $row1['partidas']);
		
	}
	echo "<script>document.getElementById('txtTotalDistrib').value = '" . trim($atividade) . "'</script>";



}



function RetornaSoluSelec($pasta){

	include("../lib/DB.php");

	//$pasta = "<script>parent.document.getElementById('tpst_numero').value<script>";
	//$pasta = "27168";

	$sql = "select id_solucoes from [crsa].[T0601_Solucoes] where pst_numero = ". $pasta;
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$atividade = $row['id_solucoes'];
		
	}
	echo "<script>document.getElementById('ttxtfornSel1').value = '" . trim($atividade) . "'</script>";

}

function RetornaSolucaoLimpCela(){
	include("../lib/DB.php");
	$query = "exec crsa.uspPMateSolucoes";
	$stmt = $conn->query($query);
	$prep = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "<option  value='".$row["NrEtqFrc"] ."'>" . $row["material"] ."</option>";
	}
	
	return $prep;
	
}



function carregaAspecto(){
	include("../lib/DB.php");
        $query = "exec [crsa].[uspP0031_ASPECTO] "; 
        $stmt = $conn->query($query);
        $prep = "<select  id='cmbAspecto' name='cmbAspecto' class='form-control form-control-sm'>";
        $selected = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prep .= "<option ". $selected ."  value = '".$row["p031_AspectoID"]."'>". $row["p031_Aspecto"]."</option>";
        }
        $prep .="</select>";
        return $prep;
}



function RetornaInfRadio($_pst_numero, $tot){
	//echo "teste";
	include("../lib/DB.php");
	$sql = "exec [crsa].[R0643_I131_InformRadioisotopo] " . $_pst_numero;
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$prep = "";
	$totalAtv=0.00;
	$edtfil="";


	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$edtfil="";
		$edtfil .=$row["nr_ID"] .",";
		$edtfil .= "'".str_replace(" ", "¬", trim($row["nome_lote"]))."'";
		
		$paramedit = "onclick = alteraIR('";
		$paramedit = $paramedit . trim($row["nr_ID"]);
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . str_replace(" ", "¬", trim($row["nome_lote"]));

		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . str_replace(" ", "¬", trim($row["ativ"]));

		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . str_replace(" ", "¬", trim($row["volu"]));

		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . str_replace(" ", "¬", trim($row["dtreceb"]));

		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . str_replace(" ", "¬", trim($row["dtcalib"]));

		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . str_replace(" ", "¬", trim($row["vlmedida"]));

		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . str_replace(" ", "¬", trim($row["dtmedida"]));

		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . str_replace(" ", "¬", trim($row["crteo"]));




		$paramedit = $paramedit . "')";


		$prep = $prep . "<tr>";
		$prep = $prep . "<td>";
		$prep = $prep ."<button type='button' class='btn btn-sm btn-outline-primary' $paramedit id='AlterarInfRadio' name='AlterarInfRadio' target='processarIR' form='formInfRadio'><i class='fas fa-edit'></i></button>";
		$prep = $prep ."<button type='submit' class='btn btn-sm btn-outline-primary' onclick='excluiIR(".$row["nr_ID"] .")' id='ExcluirInfRadio' name='ExcluirInfRadio' target='processarIR' form='formInfRadio'><i class='fas fa-trash'></i></button>";
		

		
		$prep = $prep ."</td>";
		$prep = $prep . "<td>" . $row["nome_lote"] . "</td>";
		$prep = $prep . "<td>" . number_format($row["ativ"], 2, ',', '.') . "</td>";
		$prep = $prep . "<td>" . number_format($row['volu'], 2, ',', '.') . "</td>";
		$prep = $prep . "<td>" . FormataDataHora($row["dtreceb"]) . "</td>";
		$prep = $prep . "<td>" . FormataDataHora($row["dtcalib"]) . "</td>";
		$prep = $prep . "<td>" . number_format($row["vlmedida"],2, ',', '.') . "</td>";
		$prep = $prep . "<td>" . FormataDataHora($row["dtmedida"]) . "</td>";
		$prep = $prep . "<td>" . number_format($row["crteo"],2, ',', '.') . "</td>";
		$prep = $prep . "</tr>";
		$totalAtv = $totalAtv + $row["vlmedida"];
	}
	
	//print number_format($totalAtv,2,',','.');
	echo "<script>parent.document.getElementById('TAr1').innerHTML = " . '$totalAtv' . "</script>";
	if ($tot != 'S'){
		return $prep;
	}
	if ($tot != 'N'){
		return number_format($totalAtv,2,',','.');
	}



}


function RetornaEscalaTarefas(){
	include("../lib/DB.php");
	
	$query = "select id,nome from  [crsa].[T0111_ESCALA_TAREFAS]"; 
	$stmt = $conn->query($query);
	$paramedit="";
	$prep = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$paramedit = "onclick = fu_edtEscTarrefa('";
		$paramedit = $paramedit . trim($row["id"]);
		$paramedit = $paramedit . "','" . str_replace(" ", "¬", trim($row["nome"]));
		$paramedit = $paramedit ."')";
		$prep .= "<tr>";
		$prep = $prep . "<td>";
		$prep = $prep ."<button type='button' class='btn btn-sm btn-outline-primary' $paramedit id='AlterarEscTar' name='AlterarEscTar' target='processar' form='formEscalaLocal' ><i class='fas fa-edit'></i></button>";
		$prep = $prep ."<button type='submit' class='btn btn-sm btn-outline-primary' onclick='excluiEscTar(".$row["id"] .")' id='ExcluirEscTar' name='ExcluirEscTar' target='processar' form='formEscalaLocal'><i class='fas fa-trash'></i></button>";
		$prep = $prep . "</td>";
		$prep .= "<td style='text-align:center;'>".$row["id"]. "</td>";
		$prep .= "<td>".$row["nome"]. "</td>";
		$prep .= "</tr>";
	}
	return $prep;
}

function RetornaEscalaTarefasSenanal(){
	include("../lib/DB.php");
	
	$query = "select id,nome from  [crsa].[T0111_ESCALA_TAREFAS]"; 
	$stmt = $conn->query($query);
	$paramedit="";
	$prep = "";
	$prep .= "<option value=0>Selecione</option>";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "<option value=".$row["id"].">".$row["nome"]."</option>";
	}
	return $prep;
}


function RetornaEscalaTipoProcesso(){
	include("../lib/DB.php");
	
	$query = "select id,nome from  [crsa].[T0111_ESCALA_TIPOPROCESSO]"; 
	$stmt = $conn->query($query);
	$paramedit="";
	$prep = "";
	$prep .= "<option value=0>Selecione</option>";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "<option value=".$row["id"].">".$row["nome"]."</option>";
	}
	return $prep;

}




function RetornaEscalaSemanal(){

	include("../lib/DB.php");

	$query = "set nocount on; exec [crsa].[uspP0111_ESCALA_SEMANAL_LISTA]";


	$stmt = $conn->query($query);
	//$stmt->execute();
	$prep = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$var1 = substr($row['dat_inicial'],8,2). '/';
		$var1 = $var1.substr($row['dat_inicial'],5,2) . '/';
		$var1 = $var1.substr($row['dat_inicial'],0,4) ;
		
		$var2 = substr($row['dat_final'],8,2). '/';
		$var2 = $var2.substr($row['dat_final'],5,2) . '/';
		$var2 = $var2.substr($row['dat_final'],0,4) ;
		
		$var3 = $row["nom_responsaveis"];
		$var3 = str_replace("\r","<br>",$var3);
			//$var4 = str_replace(" ","¬",trim($row["nom_responsaveis"]));
			//$var4 = str_replace("\r\n","¢",trim($var4));
		//$var4 = 'eita';

		$var5 = substr($row['dat_exec'],8,2). '/';
		$var5 = $var5.substr($row['dat_exec'],5,2) . '/';
		$var5 = $var5.substr($row['dat_exec'],0,4) ;
		$var5 = $var5.substr($row['dat_exec'],10,6) ;
		$var5 = str_replace(" ","¬",$var5);

		$var6 = $row["nom_processo"];


		$paramedit = "onclick = fuEditaEscala('";
		$paramedit = $paramedit . trim($row["id"]);
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . str_replace(" ", "¬", trim($row["lotes"]));
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . str_replace(" ", "¬", trim($row["id_tarefa"]));
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . str_replace(" ", "¬", trim($row["produto"]));
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . $var1;
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . $var2;
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . $var4;
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . $var5;
		$paramedit = $paramedit . "','";
		$paramedit = $paramedit . trim($row["id_tipoprocesso"]);
		$paramedit = $paramedit . "')";


		


		$prep .= "<tr>";
		$prep .= "<td>";
		$prep .= "<button data-toggle='tooltip' data-placement='top' title='Editar Escala'   type='button' class='btn btn-sm btn-outline-primary'  ".$paramedit."><i class='fas fa-edit'></i></button>";
		$prep .= "<button data-toggle='tooltip' data-placement='top' title='Imprimir Escala' type='button' class='btn btn-sm btn-outline-primary'  onclick='fuAbre(\"".$var1."\"," ."\"".$var2."\")'><i class='fas fa-print'></i></button>";
		$prep .= "<button data-toggle='tooltip' data-placement='top' title='Excluir Escala'  type='button' class='btn btn-sm btn-outline-primary'  onclick='fuDeleta(".trim($row["id"]).")'><i class='fas fa-trash'></i></button>";
		$prep .= "</td>";


		$prep .= "<td>".$row["id"]."</td>";
		$prep .= "<td>".$row["lotes"]."</td>";
		$prep .= "<td>".$row["nome_comercial"]."</td>";
		$prep .= "<td>".$var6."</td>";
		$prep .= "<td>".$var1."</td>";
		
		$prep .= "<td>".$var2."</td>";
		$prep .= "<td>".str_replace("¬", " ",$var5)."</td>";
		$prep .= "<td>".$row["nome"]."</td>";
		$prep .= "<td>".$var3."</td>";
		$prep .= "</tr>";

	}



	return $prep;

}


function RetornaRendProcesso(){
	$_v1 = explode(' ', $_GET["lote"]);


	$_pst = $_GET["pst_numero"];
	$_prod = "";
	
	if ($_GET["produto"] == "rd_i131"){
		$_prod = "I-131";
	}




	include("../lib/DB.php");

	$query = "
			select sum(A.p1) tot_ped_atend, sum(A.p2) tot_ped_prev, (sum(A.p1) / sum(A.p1)) * 100.00 prc_process
			from
			(
			Select pst_partidas p1, 0 p2
					From crsa.TPST_PASTA a
				where pst_numero=".$_pst."

			union all

			select 0 p1, count(*) p2
					from vendaspelicano..tcacp110 
					where p110prod='".$_prod."'      
					and p110lote=".$_v1[0]." 
					and p110serie='".$_v1[1]."' 
					and p110situ=0 
					--and p110extra=0  
			) A

	";

	$query = "exec crsa.uspPRendimentoProcesso " . $_pst;
	

	

	$stmt = $conn->query($query);
	$prep1 = "";
	$prep2 = "";
	$prep3 = "";
	$prep4 = "zero";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
	{
		$prep1 = $row["tot_ped_atend"];
		$prep2 = $row["tot_ped_prev"];
		$prep3 = $row["prc_process"];
	}
	//echo 	$row;

	echo "<script>document.getElementById('txtTotPedAtend').value = ".$prep1."</script>";
	echo "<script>document.getElementById('txtTotPedPrev').value = ".$prep2."</script>";
	echo "<script>document.getElementById('txtTotRend').value = ".$prep3.".toFixed(2)</script>";


	$query = "select id teste from [crsa].[T0111_Rendimento_Processo] where pst_numero = ".$_pst;
	$stmt = $conn->query($query);
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
	{
		$prep4 =  $row["teste"];
	}
	
	
	if ( $prep4 == "zero"){
		$query = "insert into [crsa].[T0111_Rendimento_Processo] ( pst_numero, tot_ped_atend,tot_ped_prev,tot_rendimento,cdusuario) values  (
		 ".$_pst.",".$prep1."," .$prep2."," .$prep3.",".$_SESSION['usuarioID'].")";
		 $stmt = $conn->query($query);

	}

	$query = "select * from [crsa].[T0111_Rendimento_Processo] where pst_numero = ".$_pst;
	$stmt = $conn->query($query);
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
	{
		echo "<script>document.getElementById('nrID').value = ".$row["id"]."</script>" ;
		echo "<script>document.getElementById('txtTotPedAtend').value = ".$row["tot_ped_atend"]."</script>";
		echo "<script>document.getElementById('txtTotPedPrev').value = ".$row["tot_ped_prev"]."</script>";
		echo "<script>document.getElementById('txtTotRend').value = ".$row["tot_rendimento"].".toFixed(2)</script>";
		echo "<script>document.getElementById('cmbTecnico').value = ".$row["cdusuario"]."</script>";
	
	}



}


function RetornaListaLimpCelaContagem($celaID){
	//$celaID = "<script>document.write(document.getElementById('txtIdCelaRep').value)</script>";
	//$celaID = $_COOKIE['NRCELA'];
	$celaID = $_SESSION['NRCELA'];
	

	//echo $celaID;
	include("../lib/DB.php");
	$query = "exec crsa.[uspP0600_CK_LISTA] '" . $celaID . "','',''";
	$stmt = $conn->query($query);
	$naoconforme = 0;
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
	{
		
		if ($row['p600_tipo'] != 1 ){
			
			$naoconforme = $naoconforme + $row['p600_conforme'];
		}
		
	}

	echo "<script>spnConforme.innerHTML=".$naoconforme."</script>";

	if ($naoconforme != 0){
		echo "<script>
				var tipoArea = document.getElementById('ckTipoArea');
				var tipoCorr = document.getElementById('ckTipoCorr');
				tipoArea.disabled = false;
				tipoCorr.disabled = false;
			</script>";
	}


}



function RetornaListaLimpCelaOBS($celaID){
	//$celaID = "<script>document.write(document.getElementById('txtIdCelaRep').value)</script>";
	//$celaID = $_COOKIE['NRCELA'];
	$celaID = $_SESSION['NRCELA'];
	//echo $celaID;
	include("../lib/DB.php");
	$query = "exec crsa.[uspP0600_CK_LISTA] '" . $celaID . "','',''";
	$stmt = $conn->query($query);
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
	{
		$result = $row['p600_obs'];
	}

	echo $result;

}

function RetornaListaLimpCela($celaID){
	//$celaID = "<script>document.write(document.getElementById('txtIdCelaRep').value)</script>";
	//$celaID = $_COOKIE['NRCELA'];
	$celaID = $_SESSION['NRCELA'];
	//echo $celaID;
	include("../lib/DB.php");
	$query = "exec crsa.[uspP0600_CK_LISTA] '" . $celaID . "','',''";
	$stmt = $conn->query($query);
	
	$clsHeader = "style='background-color:navy; color:#fff'";
	$clsLinhaI = "style='background-color:#cfd0d2; color:#033081'";
	$clsLinhaP = "style='background-color:#fff; color:#033081'";
	$clsLinha = "";

	$result = "<table name='tbDados' id='tbDados' class='display  nowrap' style='width:100%'>";
	$result .= "<th ".$clsHeader .">ITEM VERIFICADO</th>";
	$result .= "<th ".$clsHeader .">Assinale o item NÃO CONFORME</th>";
	$result .= "<th ".$clsHeader .">&nbsp;</th>";
	$controle1 = "";
	$controle2 = "";
	

	try{
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
	{
		if($row['p600_itemtela'] % 2 == 0) {$clsLinha = $clsLinhaP;}else{$clsLinha = $clsLinhaI;}

		$result .= "<tr  ".$clsLinha .">";
		if ($controle1 != $row['p600_itemtela'] ){
			$result .= "<td>";
			$result .= "<b>" .$row['p600_itemtela'] . ".&nbsp;" . $row['p600_itemverifica']."</b>" ;

			$result .= "</td>";
			$controle1 = $row['p600_itemtela'];
		}
		else{
			$result .= "<td></td>";
		}

		if ($row['p600_tipo'] == 1){
			$result .= "<td>";
			$result .= "<input id=".$row['p600_itensid']."  type=radio value='' ";
			
			if($row['p600_conforme'] == 1){
				$result .= "  checked";
			}
			else{
				$result .= "  ";
			}

			$result .= "   name=rdSistemas".$row['p600_checklist_id1'].">&nbsp;".$row['itemnaoconforme'];
			$result .= "</td>";
		}
		else{
			$result .= "<td>" . "<input onclick=javascript:soma(this); id=ck" . $row['p600_itensid'] . " type=checkbox value=" . $row['p600_itensid'];  
			
			if($row['p600_conforme'] == 1){
				$result .= "  checked";
			}
			else{
				$result .= "  ";
			}


			$result .= " name=ck" . $row['p600_checklist_id1'] . ">&nbsp;" . $row['itemnaoconforme'];
			if($row['p600_tipo'] == 4) {
				$result .= "<input id=txt" . $row['p600_itensid'] . " maxLength=50 name=txt" . $row['p600_itensid'] . " value='". $row['valor']."'  >";
			}
			$result .= "</td>";
		}

		if ($controle2 != $row['p600_itemtela'] ){
			$result .= "<td>";
			$result .= "<input onclick=javascript:selecionaNA(this); id=".$row['p600_itensid']."  type=checkbox value='' name=".$row['p600_checklist_id1'].">&nbsp;N.A.";
			$result .= "</td>";
			$controle2 = $row['p600_itemtela'];
		}else{
			$result .= "<td>&nbsp;</td>";
		}


		$result .= "<td style='display:none'>";
		$chave = $row['p600_checklist_id1']."|".$row['p600_itensid']."|".$row['p600_tipo']."|".$row['p600_itemtela']."|".$row['p600_checklist_id'];
		$result .= $chave;
		$result .= "</td>";


		$result .= "</tr>";
		
		echo "<script>document.getElementById('spnProduto').innerHTML= '".$row['prd1']."' </script>";
		echo "<script>document.getElementById('spnLoteValor').innerHTML= ' <b>Lote: </b>".$row['prd_lote']. " - ". $row['prd_serie']."' </script>";
		

	}

	$result .= "</table>";
}
catch(PDOException){

}		

	echo $result;
}

function RetornaListaUsuariosCMB(){
	
	include("../lib/DB.php");
	$query = "
	select p1110_usuarioid, p1110_nome 
	FROM [crsa].[T1110_USUARIOS] 
	where p1110_ativo='A'
	AND p1110_usuarioid <> 0
	order by p1110_nome";

	$stmt = $conn->query($query);
	$prep = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "<option value='". $row['p1110_usuarioid']."'>". $row['p1110_nome']."</option>";
	}
	echo $prep;




}

function RetornaEqpCelaCMB(){
	
	$celaID = $_SESSION['NRCELA'];

	include("../lib/DB.php");
	$query = "exec crsa.uspP1500_EQTO_SBSG2 ". $celaID;

	$stmt = $conn->query($query);
	$prep = "<select id='cmbCela' name='cmbCela' class='form-control-sm'>";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= "<option value='". $row['p1500_eqptoid']."'>". $row['descricao']."</option>";
	}
	$prep .= "</select>";
	echo $prep;




}



function RetornaCalibDose(){
	include("../lib/DB.php");
	$query = "exec crsa.uspP0643_VerifCalibraDoses ". $_GET['pst_numero'];

	$stmt = $conn->query($query);
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		echo "<script>document.getElementById('m_datverficVCD').value = '".$row['dat_verificacao']."'</script>";
		echo "<script>document.getElementById('m_calibCRVCD').value = '".$row['txt_calib']."'</script>";
		echo "<script>document.getElementById('m_modeloVCD').value = '".$row['txt_modelo']."'</script>";
		echo "<script>document.getElementById('m_unidPrinVCD').value = '".$row['txt_unidprincipal']."'</script>";
		echo "<script>document.getElementById('m_localVCD').value = '".$row['txt_local']."'</script>";
		echo "<script>document.getElementById('m_produtoVCD').value = '".$row['txt_produto']."'</script>";
		echo "<script>document.getElementById('m_loteVCD').value = '".$row['txt_lote']."'</script>";
		echo "<script>document.getElementById('m_zeroVCD').value = '".$row['txt_zero']."'</script>";
		echo "<script>document.getElementById('m_testesisVCD').value = '".$row['txt_testesist']."'</script>";
		echo "<script>document.getElementById('m_backgroundVCD').value = '".$row['txt_background']."'</script>";
		echo "<script>document.getElementById('m_confdadosVCD').value = '".$row['txt_confdados']."'</script>";
		echo "<script>document.getElementById('m_radiofonteVCD').value = '".$row['txt_radiofonte']."'</script>";
		echo "<script>document.getElementById('m_idfonteVCD').value = '".$row['txt_identfonte']."'</script>";
		echo "<script>document.getElementById('m_medidafonteVCD').value = '".$row['val_medidafonte']."'</script>";
		echo "<script>document.getElementById('m_valesperadoVCD').value = '".$row['val_valesperado']."'</script>";
		echo "<script>document.getElementById('m_desvioVCD').value = '".number_format($row['val_desvio'],2)."'</script>";
		echo "<script>document.getElementById('m_repro01VCD').value = '".number_format($row['val_leitura01'],2)."'</script>";
		echo "<script>document.getElementById('m_repro02VCD').value = '".number_format($row['val_leitura02'],2)."'</script>";
		echo "<script>document.getElementById('m_repro03VCD').value = '".number_format($row['val_leitura03'],2)."'</script>";
		echo "<script>document.getElementById('m_repro04VCD').value = '".number_format($row['val_leitura04'],2)."'</script>";
		echo "<script>document.getElementById('m_repro05VCD').value = '".number_format($row['val_leitura05'],2)."'</script>";
		echo "<script>document.getElementById('m_repro06VCD').value = '".number_format($row['val_leitura06'],2)."'</script>";
		echo "<script>document.getElementById('m_repro07VCD').value = '".number_format($row['val_leitura07'],2)."'</script>";
		echo "<script>document.getElementById('m_repro08VCD').value = '".number_format($row['val_leitura08'],2)."'</script>";
		echo "<script>document.getElementById('m_repro09VCD').value = '".number_format($row['val_leitura09'],2)."'</script>";
		echo "<script>document.getElementById('m_repro10VCD').value = '".number_format($row['val_leitura10'],2)."'</script>";
		echo "<script>document.getElementById('m_reproSOMAVCD').value = '".number_format($row['val_somaleitura'],2)."'</script>";
		echo "<script>document.getElementById('m_reproUNMedVCD').value = '".$row['txt_unidmed']."'</script>";
		echo "<script>document.getElementById('m_avg01VCD').value = '".number_format($row['val_medleitura'],2)."'</script>";
		echo "<script>document.getElementById('m_avg02VCD').value = '".number_format($row['val_limiteinferior'],2)."'</script>";
		echo "<script>document.getElementById('m_avg03VCD').value = '".number_format($row['val_limitesuperior'],2)."'</script>";
		echo "<script>document.getElementById('m_obsVCD').value = '".$row['txt_obs']."'</script>";



	}
	

} 




function carregaLimpezaCelaGlove(){
	include("../lib/DB.php");

	if ($_GET["txtlote"] =='')
	{
		return;
	}


	$query = "exec [crsa].[uspP0705_LIMPEZA_LISTA] @cdusuario = " . $_SESSION['usuarioID'] . ",@lote=". $_GET["txtlote"] .", @mes=0, @ano = 0, @ordem=0, @tipo=0, @resulta='', @mensa=''";
	$stmt = $conn->query($query);
	$paramedit = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$paramedit =      $row['p705_limpezaid'];
		$paramedit .= ",".$row['pst_lote'];
		$paramedit .= ",".$row['pst_numero'];
		
		echo "<tr>";
		echo "<td>";
		if ($row['p705_limpezaid'] !=""){
			echo "<input type='button' class='btn btn-sm btn-outline-primary fa fa-edit' onclick=fu_editVerCela('".$paramedit."') />";
		}
		echo "</td>";
		echo "<td>" . $row['p705_limpezaid'] ."</td>";
		echo "<td>" . $row['pst_produto510'] ."</td>";
		echo "<td>" . $row['pst_numero'] ."</td>";
		echo "<td>" . $row['Lote'] . "</td>";
		echo "<td>" . $row['p100producao'] ."</td>";
		echo "<td>" . $row['p705_Limpeza_Data'] ."</td>";
		echo "<td>" . $row['resp_informacao'] ."</td>";
		
		
		echo "</tr>";

		//RetornaSoluSelec($row['pst_numero']);
	}
}


function carregaLimpezaCelaGloveFantante(){
	include("../lib/DB.php");
	if ($_GET["txtlote"] =='')
	{
		return;
	}

	$query = "exec [crsa].[uspP0705_LIMPEZA_LISTA] @cdusuario = " . $_SESSION['usuarioID'] . ",@lote=". $_GET["txtlote"] .", @mes=0, @ano = 0, @ordem=0, @tipo=1, @resulta='', @mensa=''";
	$stmt = $conn->query($query);
	echo "<table id='tblIncLimpCela' name='tblIncLimpCela' class='display compact table-striped table-bordered responsive nowrap' style='width:20%; font-size:12px; font-family: Tahoma'>";
	echo "<thead style='background-color:#556295; color:#f2f3f7'>";
	echo "<th>&nbsp;</th>";
	echo "<th>Produção</th>";
	echo "<th>Nro. CR</th>";
	echo "<th>Série</th>";
	echo "</thead>";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>";
		echo "<td><input id='chk' name='chk' type='checkbox' value='".$row['pst_numero']."' /></td>";
		echo "<td>" . $row['pst_produto510'] ."</td>";
		echo "<td>CR-" . $row['pst_numero'] ."</td>";
		echo "<td>" . $row['pst_serie'] . "</td>";
		echo "</tr>";
	}
	echo "</table>";

}


function carregaCalcFolhaTalio($pst_numero){
	//echo "calc folha de tálio ". $pst_numero;
	include("../lib/DB.php");
	$query = "exec crsa.uspP0638_TALIO_LISTA ".$pst_numero;

	$stmt = $conn->query($query);
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		//echo $row['p638_Calibracao'];

		$var1 = $row['p638_dtcl6a'];
		$p1 = substr($var1,6,4);
		$p2 = substr($var1,3,2);
		$p3 = substr($var1,0,2);
		$p4 = $p1.'-'.$p2.'-'.$p3.'T'.substr($var1,11,5);

		echo "<script>document.getElementById('txtTalioId').value = '" . $row['p638_TalioID'] . "'</script>";
		echo "<script>document.getElementById('txtTotalPartidas').value = '" . $row['p638_Partidas'] . "'</script>";
		echo "<script>document.getElementById('txtcrmedida').value = '" . $row['p638_CR6a'] . "'</script>";
		echo "<script>document.getElementById('txtDtCrMedida').value = '" . $p4 . "'</script>";
		echo "<script>document.getElementById('txtVolumeFinal').value = '" .  $row['p638_vtot'] . "'</script>";
		}
	}
	
	function carregaCalcFolhaGalio($pst_numero){
		include("../lib/DB.php");
		
		$query = "set nocount on; exec crsa.uspP0621_GALIO_LISTA ".$pst_numero;
		$stmt = $conn->query($query);
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			
			$var1 = $row['p621_data'];
			$p1 = substr($var1,6,4);
			$p2 = substr($var1,3,2);
			$p3 = substr($var1,0,2);
			$p4 = $p1.'-'.$p2.'-'.$p3.'T'.substr($var1,11,5);

			$p5=  number_format($row['p621_CR'],2,'.',',');

			echo "<script>document.getElementById('txtGalioId').value = '" . $row['p621_GALIOID'] . "'</script>";
			echo "<script>document.getElementById('txtTotalPartidas').value = '" . $row['p621_Partidas'] . "'</script>";
			echo "<script>document.getElementById('txtcrmedida').value = '" . $p5 . "'</script>";
			echo "<script>document.getElementById('txtDtCrMedida').value = '" . $p4 . "'</script>";
		}
	
			
	$query1 = "Select p551_ph 	From  crsa.T0551_CQ_FRASCOS_CAB where pst_numero=".$pst_numero;
	$stmt1 = $conn->query($query1);
	while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
		echo "<script>document.getElementById('txtPH').value = '" . $row1['p551_ph'] . "'</script>";
	}

	

	$query2 = "select vlmedida, volu from crsa.T643_I131_InformRadioisotopo where pst_numero = ".$pst_numero;
	$stmt2 = $conn->query($query2);
	while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
		echo "<script>document.getElementById('txtAtvTotSol').value = '" . $row2['vlmedida'] . "'</script>";
		echo "<script>document.getElementById('txtVolumeFinal').value = '" . $row2['volu'] . "'</script>";
		//print_r ($row2['ativ']);
	}

	$query = "exec crsa.P0607_PROCEDTOS @acao = 'S', @pst_numero = ".$pst_numero;
	$stmt = $conn->query($query);
	
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		echo "<script>document.getElementById('txtAquecLig').value = '" . $row['rea_aq_ini'] . "'</script>";
		echo "<script>document.getElementById('txtAquecDesLig').value = '" . $row['rea_aq_fim'] . "'</script>";
		echo "<script>document.getElementById('txtTemperatura').value = '" . $row['rea_temper'] . "'</script>";
		echo "<script>document.getElementById('txtDuluIni').value = '" . $row['dilu_ini'] . "'</script>";
		echo "<script>document.getElementById('txtDuluFim').value = '" . $row['dilu_fim'] . "'</script>";
		echo "<script>document.getElementById('txtVolGalioBal').value = '" . $row['dilu_vol'] . "'</script>";
		echo "<script>document.getElementById('txtVolCitratoBal').value = '" . $row['dilu_vol_bal'] . "'</script>";
		echo "<script>document.getElementById('txtAtivInic').value = '" . $row['frac_atv_ini'] . "'</script>";
		echo "<script>document.getElementById('txtAtivFinal').value = '" . $row['frac_atv_fim'] . "'</script>";
		//echo "<script>document.getElementById('txtPedAtendidos').value = '" . $row['frac_lotes_atend'] . "'</script>";
		echo "<script>document.getElementById('txtTotalPartidas').value = '" . $row['frac_tot_partida'] . "'</script>";
		echo "<script>document.getElementById('txtTotalDistrib').value = '" . $row['frac_atv_total'] . "'</script>";
		$frac_vol_apres = $row['frac_vol_apres'];
		if ($frac_vol_apres == 'N') {echo "<script>document.getElementById('txtVolNessaDiluN').checked = 'checked'</script>";}
		else{echo "<script>document.getElementById('txtVolNessaDiluS').checked = 'checked'</script>";}
		echo "<script>document.getElementById('txtSobraVal0').value = '" . $row['frac_vol_atv'] . "'</script>";
		echo "<script>document.getElementById('txtSobraVol0').value = '" . $row['frac_vol_vol'] . "'</script>";
		$frac_descarta = $row['frac_descarta'];
		if ($frac_descarta == 'N') {echo "<script>document.getElementById('txtDescartaN').checked = 'checked'</script>";}
		else{echo "<script>document.getElementById('txtDescartaS').checked = 'checked'</script>";}
		echo "<script>document.getElementById('txtPH').value = '" . number_format($row['frac_ph'],2) . "'</script>";
		//echo "<script>document.getElementById('txtAtvTotSol').value = '" . number_format($row['frac_tot_sol'],2) . "'</script>";
		//echo "<script>document.getElementById('txtVolumeFinal').value = '" . number_format($row['frac_vol_fim'],2) . "'</script>";
		//echo "<script>document.getElementById('txtDtCrMedida').value = '" . $row['frac_dt_medida'] . "'</script>";
		echo "<script>document.getElementById('fator_decai').value = '" . number_format($row['frac_fat_deca'],4) . "'</script>";
		echo "<script>document.getElementById('crvoldtcal').value = '" . number_format($row['frac_cr_calib'],2) . "'</script>";
		$frac_sobra = $row['frac_sobra'];
		if ($frac_sobra == 'N') {echo "<script>document.getElementById('txtSobraN').checked = 'checked'</script>";}
		else{echo "<script>document.getElementById('txtSobraS').checked = 'checked'</script>";}
		echo "<script>document.getElementById('txtSobraValQtd').value = '" . number_format($row['frac_sobra_atv'],2) . "'</script>";
		echo "<script>document.getElementById('txtSobraVol').value = '" . number_format($row['frac_sobra_vol'],2) . "'</script>";
		echo "<script>document.getElementById('txtIniAutoClav').value = '" . $row['estr_autoc_ini'] . "'</script>";
		echo "<script>document.getElementById('txtTempIniAutoClav').value = '" . $row['estr_temp_ini'] . "'</script>";
		echo "<script>document.getElementById('txtFimAutoClav').value = '" . $row['estr_autoc_fim'] . "'</script>";
		echo "<script>document.getElementById('txtTempFimAutoClav').value = '" . $row['estr_temp_fim'] . "'</script>";
		echo "<script>document.getElementById('txtPressIni').value = '" . $row['estr_press_ini'] . "'</script>";
		echo "<script>document.getElementById('txtPressFim').value = '" . $row['estr_press_fim'] . "'</script>";
		$estr_reg_proc = $row['estr_reg_proc'];
		if ($estr_reg_proc == 'N') {echo "<script>document.getElementById('txtImpAutClavN').checked = 'checked'</script>";}
		else{echo "<script>document.getElementById('txtImpAutClavS').checked = 'checked'</script>";}
		$estr_ocorr = $row['estr_ocorr'];
		if ($estr_ocorr == 'N') {echo "<script>document.getElementById('txtOcorrAutClavN').checked = 'checked'</script>";}
		else{echo "<script>document.getElementById('txtOcorrAutClavS').checked = 'checked'</script>";}
		echo "<script>document.getElementById('txtOcorrencia').value = '" . $row['estr_obs'] . "'</script>";


	}


	$lote = $_GET['lote'];
	$lote = substr($lote,0,3);



	$sql = "";
	$sql .= "select MIN(p110atv) min_part, MAX(p110atv) max_part, SUM(p110atv) tot_part, COUNT(*) tot_distr ";
	$sql .= "from VendasPelicano.dbo.TCACP110  ";
	$sql .= "where 1=1  ";
	$sql .= "  and p110lote = ".$lote."  ";
	$sql .= "  and p110prod = 'ga-67' "; 
	$sql .= "  and p110situ = 0 ";
	
	$stmt = $conn->query($sql);
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		echo "<script>document.getElementById('txtAtivInic').value = '" . $row['min_part'] . "'</script>";
		echo "<script>document.getElementById('txtAtivFinal').value = '" . $row['max_part'] . "'</script>";
		echo "<script>document.getElementById('txtTotalDistrib').value = '" . $row['tot_part'] . "'</script>";
		echo "<script>document.getElementById('txtTotalPartidas').value = '" . $row['tot_distr'] . "'</script>";
	}

}




if(isset($_POST["RetornaUsuariosAssocCMB"])){
	include("../lib/DB.php");
	$query = "exec crsa.uspPEscalaUsuarios ".$_POST['lote'] . "," . $_POST['tarefa'] ;

	$stmt = $conn->query($query);
	$prep = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$prep .= $row['param']           . "," . 
		         $row['p1110_usuarioid'] . "," . 
				 $row['p1110_nome'] . "," ;
	}

	$prep = substr($prep,0,-1);
	echo $prep;


	//echo "getreturnassoc('" . $_POST['lote'] . "','". $_POST['tarefa'] . "')";

	//echo "assoc,3140, Alberto, dispon,222, Jose";




}


if(isset($_POST["gravadiluTalio"])){

	//procedure original P0638_TALIO 
	print_r('grava dilu talio<hr>');
	//print_r($_POST);
	print_r($_POST['txtTalioId'].'<br>');
	print_r($_POST['txtpst_numero'].'<br>');
	print_r($_POST['txtPH'].'<br>');
    print_r($_POST);
}

if(isset($_POST["gravadiluGalio"])){
	print_r('grava dilu galio<hr>');
	//print_r($_POST);
	//print_r($_POST['cmbTecnico']);
	//print_r($_POST['txtSenha']);
	$mensa = ValidaSenha($_POST['cmbTecnico'], $_POST['txtSenha']);
	if($mensa != ""){
		echo "<script>parent.toastApp(3000,'***   SENHA INVÁLIDA   ***','ERRO')</script>";
		return;
	}
	include("../lib/DB.php");

	$p1 = $_POST['txtDtCrMedida'];
	$p1 = str_replace('-','', $p1);
	$p1 = str_replace('T',' ', $p1);


	$p2 = $_POST['txtDatCalib'];
	$p2 = str_replace('-','', $p2);
	$p2 = str_replace('T',' ', $p2);



	$query = "exec crsa.P0607_PROCEDTOS ";
	$query .= "@acao = 'U',"; 
	$query .= "@p607_id = ".$_POST['txtGalioId'].",";
	$query .= "@pst_numero = ".$_POST['txtpst_numero'].',';
	$query .= "@rea_aq_ini = '" .$_POST['txtAquecLig']."',";
	$query .= "@rea_aq_fim = '" .$_POST['txtAquecDesLig']."',";
	$query .= "@rea_temper = '" .$_POST['txtTemperatura']."',";
	$query .= "@dilu_ini = '" .$_POST['txtDuluIni']."',";
	$query .= "@dilu_fim = '" .$_POST['txtDuluFim']."',";
	$query .= "@dilu_vol = '" .$_POST['txtVolGalioBal']."',";
	$query .= "@dilu_vol_bal = '" .$_POST['txtVolCitratoBal']."',";
	$query .= "@frac_atv_ini = '" .$_POST['txtAtivInic']."',";
	$query .= "@frac_atv_fim = '" .$_POST['txtAtivFinal']."',";
	$query .= "@frac_lotes_atend = '" .$_POST['txtPedAtendidos']."',";
	$query .= "@frac_tot_partida = '" .$_POST['txtTotalPartidas']."',";
	$query .= "@frac_atv_total = '" .$_POST['txtTotalDistrib']."',";
	$query .= "@frac_cr_cal = '" .$_POST['txtcrmedida']."',";
	$query .= "@frac_vol_apres = '" .$_POST['txtVolNessaDilu']."',";
	$query .= "@frac_vol_atv = '" .$_POST['txtSobraVal0']."',";
	$query .= "@frac_vol_vol = '" .$_POST['txtSobraVol0']."',";
	$query .= "@frac_descarta = '" .$_POST['txtDescarta']."',";
	$query .= "@frac_vol_fim = '" .$_POST['txtVolumeFinal']."',";
	$query .= "@frac_tot_sol = '" .$_POST['txtAtvTotSol']."',";
	$query .= "@frac_ph = '" .$_POST['txtPH']."',";
	$query .= "@frac_dt_medida = '" .$p1."',";
	$query .= "@frac_fat_deca = '" .$_POST['fator_decai']."',";
	$query .= "@frac_cr_calib = '" .$_POST['crvoldtcal']."',";
	$query .= "@frac_sobra = '" .$_POST['txtSobra']."',";
	$query .= "@frac_sobra_atv = '" .$_POST['txtSobraValQtd']."',";
	$query .= "@frac_sobra_vol = '" .$_POST['txtSobraVol']."',";
	$query .= "@frac_dt_calib = '" .$p2."',";
	$query .= "@estr_autoc_ini = '" .$_POST['txtIniAutoClav']."',";
	$query .= "@estr_temp_ini = '" .$_POST['txtTempIniAutoClav']."',";
	$query .= "@estr_autoc_fim = '" .$_POST['txtFimAutoClav']."',";
	$query .= "@estr_temp_fim = '" .$_POST['txtTempFimAutoClav']."',";
	$query .= "@estr_press_ini = '" .$_POST['txtPressIni']."',";
	$query .= "@estr_press_fim = '" .$_POST['txtPressFim']."',";
	$query .= "@estr_reg_proc = '" .$_POST['txtImpAutClav']."',";
	$query .= "@estr_ocorr = '" .$_POST['txtOcorrAutClav']."',";
	$query .= "@estr_obs = '" .$_POST['txtOcorrencia']."',";
	$query .= "@p607_cdusuario = '" .$_POST['cmbTecnico']."'";




	//var_dump($_POST);
	
	
	
	
	$stmt = $conn->query($query);
	
	
	
	echo "<script>parent.toastApp(3000,'***   REGISTRO GRAVADO COM SUCESSO   ***','OK')</script>";

	





}

if(isset($_POST["bntGravaLimpCela"])){
	var_dump($_POST);


	if ($_SESSION['usuarioSenha'] <> $_POST['txtSenha']){
		echo "<script>parent.toastApp(3000,'***   SENHA INVÁLIDA   ***','ERRO')</>"	;
		die;
	}


	if ($_POST['txtSenha'] == ""){
		echo "<script>parent.toastApp(3000,'Informe a Senha','ERRO');</script>";
		die;
	}
	if ($_POST['pst_to_add'] == ""){
		echo "<script>parent.toastApp(3000,'Nenhum lote selecionado','ERRO');</script>";
		die;
	}
	if ($_POST['datlimpeza'] == ""){
		echo "<script>parent.toastApp(3000,'Informe a data da limpeza','ERRO');</script>";
		die;
	}

	include("../lib/DB.php");
	$dtlimpeza = $_POST['datlimpeza'];
	$dtlimpeza = str_replace('-','',$dtlimpeza);
	$query = "set nocount on; exec [crsa].[uspP0705_LIMPEZA_GET_ID] '" . $dtlimpeza ."',''," .$_SESSION['usuarioID']."," .$_SESSION['usuarioID'];
	$stmt = $conn->query($query);
	$limpezaid = "";
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    	$limpezaid = $row['p705_limpezaid'];
	}

	$pst_to_add = explode(",", $_POST['pst_to_add']);

	foreach ($pst_to_add as $values)
	{

		$query1 =  "exec crsa.P0706_CELA_PRODUTO '" . $values."','".$limpezaid."',1,'".$_SESSION['usuarioID']."','".$_POST['txtSenha']."', '',''";
		echo $query1;
		$stmt1 = $conn->query($query1);
	}

	echo "<script>parent.toastApp(3000,'Registros Atualizados','OK');</script>";
	echo "<script>parent.formVerCela.submit();</script>";

	
}




function converteTagToArrays($txtTag, $selecionado = false): array 
{



	$strTag = '';
	foreach($txtTag as $key => $tag){
		foreach($tag as $k => $str) {
			$strTag .= $str;
		}
	}
	$strTag = str_replace('/>', '>', $strTag);

	preg_match_all( '/<row\s*(\w+=".*?")>/', $strTag, $matches );

	$f = function($array)
	{
		array_unshift($array, null);
		return call_user_func_array('array_map', $array);
	};

	$matches = array_map(

		function ($current) use ($f) {

			$attributes = preg_split(

				'/\s*(\w+)="(.*?)\s*"/',

				$current, 'NULL', PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE
			);

			$transposed = $f(array_chunk($attributes, 2));

			return array_combine($transposed[0], $transposed[1]);
		},

		$matches[1]
	);

	$newArray = $matches;

	if ($selecionado) {
		$newArray = [];
		foreach($matches as $k => $match){
			if (array_key_exists('selecionado', $match)) {
				$newArray[] = $match;
			}
		}
	}

	return $newArray;
}
 


