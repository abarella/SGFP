
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"   integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="   crossorigin="anonymous"></script>
<script csrc="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<?php
session_start();

include("../lib/DB.php");
$query="exec crsa.uspP0706_RESPONSA_LISTA @p705_limpezaID=" . $_GET['id'] . ", @cdusuario=". $_SESSION['usuarioID'] ;
$stmt = $conn->query($query);

echo "<table name='tblResp'  id='tblResp' border=0 width=50% >";
echo "<th>Responsáveis";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    //echo "<td style='background-color:red; width: 1%'><input type='checkbox' value=".$row['p1110_usuarioid']." /></td>"; 
    
    
    $che = " ";
    if ($row['p705_LimpezaID'] == $_GET['id']){
        $che = "checked";
    }
    
    echo "<td>&nbsp;<input type='checkbox' ".$che." id=ck".$row['p1110_usuarioid']." value=".$row['p1110_usuarioid']." />&nbsp;".$row['p1110_nome']."</td>"; 
    echo "<td style='display:none'>".$row['p1110_usuarioid']."</td>"; 
    echo "</tr>";
}
echo "</table>";

echo "<table><tr>";
//echo "<td width='2px'><textarea id='txtObs' name='txtObs' rows='4' cols='50'></textarea>";
echo "<td>Senha:&nbsp;<input type='password' id='txtSenha' name='txtSenha' />";
echo "<td><input type='button' class='btn btn-primary btn-sm' value='Gravar' onclick='fu_gravaresponsaveis()' />";
echo "</tr></table>";

    //$pasta = "<script>parent.document.getElementById('tpst_numero').value</script>";
    $pasta=$_GET['pst_numero'];

    $sql = "select id_solucoes from [crsa].[T0601_Solucoes] where pst_numero = ". $pasta;
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$atividade = $row['id_solucoes'];
		
	}
	echo "<script>parent.document.getElementById('ttxtfornSel1').value = '" . trim($atividade) . "'</script>";

    echo "<script>parent.fu_populaSoluc();</script>";

    echo "<script>$('.selforn1').selectpicker('val', parent.document.getElementById('ttxtfornSel1').value.split('|'));</script>";

?>




<script>
    
    function fu_gravaresponsaveis(){
        if ('<?php echo $_SESSION['usuarioSenha']; ?>' != document.getElementById('txtSenha').value){
            parent.toastApp(3000,'***   SENHA INVÁLIDA   ***','ERRO')
            return;
        }

        for(i=1;i<tblResp.rows.length;i++){
            if (tblResp.rows[i].cells[0].children[0].checked == true){
                getSuccessOutput(tblResp.rows[i].cells[1].innerText, 1)
            }
            else{
                getSuccessOutput(tblResp.rows[i].cells[1].innerText, 0)
            }
        }
        parent.toastApp(3000,'***   REGISTROS GRAVADOS   ***','OK')
    }

    function getSuccessOutput(_p1, _chk) {
        var param = "1";
        var IDlimp = parent.document.getElementById('tId_Limpeza').value
        var _senha = document.getElementById('txtSenha').value
        $(document).ready(function(){
            $.ajax({ 
                url: '../functions.php',
                data: {gravalimpcelaResponsaveis: param,
                       p01: IDlimp, 
                       p02: _chk,
                       p03: _p1,
                       p04: _senha,
                      },
                type: 'post',
            });	
        });
        

    }


</script>