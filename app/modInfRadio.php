<?php include ('../functions.php')?>

<?php
    include("../lib/DB.php");

    $fornec1 = '';
    $ativ1 = '0';
    $volu1 = '0';
    $dtreceb1 = '';
    $dtcalib1 = '';
    $vlmedida1 = '0';
    $dtmedida1 = '';
    $C1 = ''; 

    $fornec2 = '';
    $ativ2 = '0';
    $volu2 = '0';
    $dtreceb2 = '';
    $dtcalib2 = '';
    $vlmedida2 = '0';
    $dtmedida2 = '';
    $C2 = ''; 

    $lote3 = '';
    $ativ3 = '0';
    $volu3 = '0';
    $dtreceb3 = '';
    $dtcalib3 = '';
    $vlmedida3 = '0';
    $dtmedida3 = '';
    $C3 = ''; 

    $TAr1 = $vlmedida1;
    $TAr2 = $vlmedida2;
    $TAr3 = $vlmedida3;
    $TAr4 = $ativ1 + $ativ2 + $ativ3;



    $query = "exec crsa.P0643_I131_InformRadioisotopo "; 
    $stmt = $conn->prepare("exec crsa.P0643_I131_InformRadioisotopo @pst_numero= ".$pst_numero.", @acao='S', @out='T'");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $fornec1 = $row['nomefornec1'];
        $ativ1 = $row['ativ1'];
        $volu1 = $row['volu1'];
        $dtreceb1 = $row['dtreceb1'];
        $dtcalib1 = $row['dtcalib1'];
        $vlmedida1 = $row['vlmedida1'];
        $dtmedida1 = $row['dtmedida1'];
        $C1 = $row['crteo1']; 
    
        $fornec2 = $row['nomefornec2'];
        $ativ2 = $row['ativ2'];
        $volu2 = $row['volu2'];
        $dtreceb2 = $row['dtreceb2'];
        $dtcalib2 = $row['dtcalib2'];
        $vlmedida2 = $row['vlmedida2'];
        $dtmedida2 = $row['dtmedida2'];
        $C2 = $row['crteo2']; 

        $lote3 = $row['lote3'];
        $ativ3 = $row['ativ3'];
        $volu3 = $row['volu3'];
        $dtreceb3 = $row['dtreceb3'];
        $dtcalib3 = $row['dtcalib3'];
        $vlmedida3 = $row['vlmedida3'];
        $dtmedida3 = $row['dtmedida3'];
        $C3 = $row['crteo3']; 

        $TAr1 = $vlmedida1;
        $TAr2 = $vlmedida2;
        $TAr3 = $vlmedida3;
        $TAr4 = $TAr1 + $TAr2 + $TAr3;


    }


?>



<script>
    
function calcula1(){
	if (document.getElementById('txtMedDtProg1').value==''){
		document.getElementById('txtMedDtProg1').value='0'
	}
	
	if (document.getElementById('txtVolume1').value==''){
		document.getElementById('txtVolume1').value='0'
	}

	atv1 = document.getElementById('txtMedDtProg1').value
	vol1 = document.getElementById('txtVolume1').value
	
	vol1 = vol1.replace(',','.')

	document.getElementById('Ar1').innerHTML = atv1
	document.getElementById('Vl1').innerHTML = vol1
	
	if (atv1!='0' && vol1!='0'){
		document.getElementById('Conc1').innerHTML = (atv1/vol1).toFixed(2)
	}
	else{
		document.getElementById('Conc1').innerHTML='0'
	}
	document.getElementById('TAr1').innerText = document.getElementById('Ar1').innerText
	calculaTotal()

}

function calcula2(){
	if (document.getElementById('txtMedDtProg2').value==''){
		document.getElementById('txtMedDtProg2').value='0'
	}
	
	if (document.getElementById('txtVolume2').value==''){
		document.getElementById('txtVolume2').value='0'
	}


    //alert(document.getElementById('txtMedDtProg2').value)

	atv2 = document.getElementById('txtMedDtProg2').value
	vol2 = document.getElementById('txtVolume2').value
	
	vol2 = vol2.replace(',','.')

	document.getElementById('Ar2').innerHTML = atv2
	document.getElementById('Vl2').innerHTML = vol2
	
	if (atv2!='0' && vol2!='0'){
		document.getElementById('Conc2').innerHTML = (atv2/vol2).toFixed(2)
	}
	else{
		document.getElementById('Conc2').innerHTML='0'
	}
	document.getElementById('TAr2').innerText = document.getElementById('Ar2').innerText
	calculaTotal()
}

function calcula3(){
	if (document.getElementById('txtMedDtProg3').value==''){
		document.getElementById('txtMedDtProg3').value='0'
	}
	
	if (document.getElementById('txtVolume3').value==''){
		document.getElementById('txtVolume3').value='0'
	}

	atv3 = document.getElementById('txtMedDtProg3').value
	vol3 = document.getElementById('txtVolume3').value
	
	vol3 = vol3.replace(',','.')

	document.getElementById('Ar3').innerHTML = atv3
	document.getElementById('Vl3').innerHTML = vol3
	
	if (atv3!='0' && vol3!='0'){
		document.getElementById('Conc3').innerHTML = (atv3/vol3).toFixed(2)
	}
	else{
		document.getElementById('Conc3').innerHTML='0'
	}
	document.getElementById('TAr3').innerText = document.getElementById('Ar3').innerText
	calculaTotal()
}

function calculaTotal(){
	Tatv1 = document.getElementById('TAr1').innerText
	Tatv2 = document.getElementById('TAr2').innerText
	Tatv3 = document.getElementById('TAr3').innerText

    if (Tatv1==''){Tatv1=0;}
	if (Tatv2==''){Tatv2=0;}
	if (Tatv3==''){Tatv3=0;}




	TatvT = eval(Tatv1)+eval(Tatv2)+eval(Tatv3)
	document.getElementById('TAr4').innerHTML= (TatvT)
}


function AfterCloseModal(){
		setTimeout(function(){
    		location.href = location.href;
		}, 1000);
}

function IncluiInfRadio(){
    pst = '1'
    _txtsenha = 'teste'
	$.ajax({ url: '../functions.php',
        data: {gravaNovoInfRadio: pst,
				m_txtSenha: _txtSenha
			   },
       	type: 'post',
         		success: function(output) {
					toastApp(3000,'Informações de Radioisótopo Gravado com Sucesso','OK')
                    AfterCloseModal()
                }
		});	
		
	AfterCloseModal()
}

function excluiIR(id){
    if(document.getElementById("txtSenha").value == ''){
        toastApp(3000,'Informe a Senha ','ERRO')
    }
    else{
        document.getElementById("nr_id").value = id
        document.getElementById("acao").value ='excluiInfRadio'
        document.forms[1].method="POST";
        document.forms[1].target="_top";
        document.forms[1].submit();
        toastApp(3000,'Informações de Radio Excluido','OK')
    }
}


function alteraIR(nr_ID, nome_lote, ativ, volu, dtreceb, dtcalib, vlmedida, dtmedida, crteo){

    ano1 = dtreceb.substr(0,4)
    mes1 = dtreceb.substr(5,2)
    dia1 = dtreceb.substr(8,2)
    hor1 = dtreceb.substr(11,5)
    dta1 = ano1+'-'+mes1+'-'+dia1+' '+hor1
    
    ano2 = dtcalib.substr(0,4)
    mes2 = dtcalib.substr(5,2)
    dia2 = dtcalib.substr(8,2)
    hor2 = dtcalib.substr(11,5)
    dta2 = ano2+'-'+mes2+'-'+dia2+' '+hor2
    
    ano3 = dtmedida.substr(0,4)
    mes3 = dtmedida.substr(5,2)
    dia3 = dtmedida.substr(8,2)
    hor3 = dtmedida.substr(11,5)
    dta3 = ano3+'-'+mes3+'-'+dia3+' '+hor3


    nome_lote = nome_lote.split("¬").join(" ");
    document.getElementById('txtNomeFornecedor1').value = nome_lote
    document.getElementById('txtAtvTotImp1').value = ativ
    document.getElementById('txtVolume1').value = volu
    document.getElementById('txtDtReceb1').value = dta1
    document.getElementById('txtDtCalib1').value = dta2
    document.getElementById('txtMedDtProg1').value = vlmedida
    document.getElementById('txtDtProg1').value = dta3
    document.getElementById('tnr_ID').value = nr_ID
    document.getElementById('Ar1').innerHTML = vlmedida
    document.getElementById('Vl1').innerHTML = volu
    document.getElementById('Conc1').innerHTML = crteo

    $('#IncluiInfRadio').modal({backdrop: 'static', keyboard: false})  
    $('#IncluiInfRadio').modal('show'); 
    //$("#tblistaMat>tbody>tr:first").trigger('click');
}

</script>

<form name='formInfRadio' id='formInfRadio'>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            Técnico: <?php echo CarregaTecnico();  ?>
                        </div>
                        <div class="col-md-4">
                            Senha: <input type="password" name="txtSenha" id="txtSenha" class="form-control form-control-sm" maxlength="6" size="7" required />
                        </div>

                        <div class="col-md-4">
                            <br><button type="button"  class="btn btn-primary btn-sm"  data-toggle="modal"  data-target="#IncluiInfRadio" data-backdrop="static" data-keyboard="false">Incluir</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    
                        <input type='hidden' name='nr_id' id='nr_id' />
                        <input type='hidden' name='acao' id='acao' />

                        <table id="tblista" class="display compact table-striped table-bordered nowrap" style="width:100%; font-size:12px; font-family: Verdana">
                            <thead style="background-color:#556295; color:#f2f3f7">
                                <tr>
                                    <th>Ação</th>
                                    <th>Frasco / Lote</th>
                                    <th>Atividade (mCi)</th>
                                    <th>Volume (mL)</th>
                                    <th>Recebimento</th>
                                    <th>Calibração</th>
                                    <th>Volume Medido (mL)</th>
                                    <th>Medido em</th>
                                    <th>CR Teórico (mCi / mL)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo RetornaInfRadio($_GET['pst_numero'], 'N'); ?>
                            </tbody>
                        </table>

                </div>
            </div>
        </div>    
    </div>
</form>


<!-- modal -->
<div class="modal fade " id="IncluiInfRadio" tabindex="-1" role="dialog" aria-labelledby="eqpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eqpModalLabel">Incluir Radioisótopo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color:#e8eff9;">
			<form action=<?php echo $_SG['rf'] .'functions.php';?>  target="processarIR" method="POST" name="formNewInfRad" id="formNewInfRad" enctype="multipart/form-data">

                <input type='hidden' name='tpst_numero' id='tpst_numero' value="<?php echo $pst_numero; ?>" />
                <input type='hidden' name='tnr_ID'  id='tnr_ID' value="" />
                <div class="row">
                    <div class="col-md-12 border btn-info">
                        Frasco / Lote
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 xborder xbtn-trans">
                            Nome:<br><input type='text' class="form-control" name='txtNomeFornecedor1' id='txtNomeFornecedor1'  value="<?php echo $fornec1; ?>" />
                    </div>
                    <div class="col-md-4 xborder xbtn-trans ">
                            Atividade Total Importada (mCi):<br><input type='number' class="form-control" name='txtAtvTotImp1' id='txtAtvTotImp1' step='0.01' placeholder='0.00'  value="<?php echo $ativ1; ?>" />
                    </div>
                    <div class="col-md-4 xborder xbtn-trans">
                            Volume (mL):<br><input type='number' name='txtVolume1' class="form-control" step='0.01' placeholder='0.00' id='txtVolume1'   onkeyup="calcula1()"  value="<?php echo $volu1; ?>"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 xborder xbtn-trans">
                            Data de Recebimento:<br><input type='datetime-local' class="form-control" name='txtDtReceb1' id='txtDtReceb1'  value="<?php echo $dtreceb1; ?>" />
                    </div>
                    <div class="col-md-3 xborder xbtn-trans ">
                            Data de calibração Informada:<br><input type='datetime-local' class="form-control" name='txtDtCalib1' id='txtDtCalib1'  value="<?php echo $dtcalib1; ?>"  />
                    </div>
                </div>
            

                <div class="row">
                    <div class="col-md-4 xborder xbtn-trans ">
                        Medida na Data da Programação (mCi):<br><input type='number' class="form-control" name='txtMedDtProg1' id='txtMedDtProg1' step='0.01' placeholder='0.00'  onkeyup="calcula1()"  value="<?php echo $vlmedida1; ?>"  />
                    </div>

                    <div class="col-md-4 xborder xbtn-trans ">
                    (Ativ real)<br><input type='datetime-local' class="form-control" name='txtDtProg1' id='txtDtProg1' value="<?php echo $dtmedida1; ?>"/> 
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 xborder xbtn-trans  bg-gradient-primary ">
                        <sup>CR</sup><sub>Teórico</sub> = <sup>A</sup><sub>Real</sub> <i class="fas fa-divide"></i> <sup>V</sup><sub>Total</sub> = 
                        <label id='Ar1'><?php echo $vlmedida1; ?></label> <i class="fas fa-divide"></i> <label id='Vl1'><?php echo $volu1; ?></label> = <label id='Conc1'><?php echo $C1; ?></label> mCi/mL
                    </div>
                </div>


<hr>



				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="m_txtAtivEspec" class="form-label">Técnico</label>
							<div class="input-group">
								<?php echo CarregaTecnico();  ?>
							</div>
						</div>
					</div>
				
					<div class="col-md-6">
						<div class="form-group">
							&nbsp;<label for="m_txtSenha" class="form-label">Senha</label>
							<div class="input-group">
								&nbsp;<input type="password" class="form-control form-control-sm" name="m_txtSenha" id="m_txtSenha" required />
							</div>
						</div>
					</div>
				</div>





			</div>
		</form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id='btnClose' onclick="AfterCloseModal()" data-dismiss="modal">Fechar</button>
        <button type="submit" name="gravaNovoInfRadio" id="gravaNovoInfRadio" onclick="IncluiInfRadio();"  class="btn btn-primary" form="formNewInfRad" >Salvar</button>
      </div>
    </div>
  </div>
</div>
<!-- fim modal -->






<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formInfRadio' id='formInfRadio' action="..\functions.php" method="POST" target="processarIR">

                    <div class="row">
                        <div class="col-md-12 xborder xbtn-trans  xbg-gradient-primary h5">
                            Atividade Total = ∑ <sup>A</sup><sub>imp</sub> <i class="fas fa-plus"></i> <sub>estoque</sub> = 
                            <span id="TAr1" style="width:50px; zborder-bottom: 2px solid grey; z-index: 1; text-align: center;">
                            <?php echo RetornaInfRadio($_GET['pst_numero'], 'S'); ?>
                            </span> 
                        </div>
                    </div>



                </form>
                <!-- fim do conteúdo -->

                <iframe id="processarIR" name="processarIR"  src="" width='100%' height='300px' style="display:none" > </iframe>

            </div>
        </div>
    </div>
</div>

