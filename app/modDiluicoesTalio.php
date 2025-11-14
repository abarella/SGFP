<?php include '../functions.php'?>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formDiluicaoTalio' id='formDiluicaoTalio' action='../functions.php' method='post' target='processarDILUTalio' novalidate>

                    <input type="hidden" name = "txtTalioId" id="txtTalioId" placeholder="txtTalioId" >
                    <input type="hidden" name = "txtpst_numero" id="txtpst_numero" placeholder="txtpst_numero" value='<?php echo $_GET['pst_numero'] ?>' >


                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtPedAtendidos">Pedidos Atendidos</label>
                                <input type="text" class="form-control form-control-sm" id="txtPedAtendidos" name="txtPedAtendidos" style="width:50%" readonly >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtTotalPartidas">Total de Partidas</label>
                                <input type="text" class="form-control form-control-sm" id="txtTotalPartidas" name="txtTotalPartidas" style="width:50%" readonly> 
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtTotalDistrib">Atividade Total Distribuida</label>
                                <input type="text" class="form-control form-control-sm" id="txtTotalDistrib" name="txtTotalDistrib" style="width:50%" readonly> mCi
                            </div>
                        </div>

                        


                    </div>

                    <hr class="btn-primary">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtConcRadio">Concentração Radioativa na Calibração (3,0 a 6,0) mCi / mL</label>
                                <input type="number" class="form-control form-control-sm" id="txtConcRadio" name="txtConcRadio" style="width:15%;" value="0.00" step="0.01" > mCi / mL
                            </div>
                        </div>
                    </div>

                    <hr class="btn-primary">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtCloretoSodio">Cloreto de Sódio 0,9% </label>
                                <input type="number" class="form-control form-control-sm" id="txtCloretoSodio" name="txtCloretoSodio" style="width:50%" value="0.00" step="0.01">mL
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtVolumeFinal">Volume Final</label>
                                <input type="number" class="form-control form-control-sm" id="txtVolumeFinal" name="txtVolumeFinal" style="width:50%" value="0.00" step="0.01"  > mL
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtAtvTotSol">Atividade Total da Solução</label>
                                <input type="number" class="form-control form-control-sm" id="txtAtvTotSol" name="txtAtvTotSol" style="width:50%" value="0.00" step="0.01"  > mCi
                            </div>
                        </div>
                       
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtPH">PH (4,5 a 7,5)</label>
                                <input type="number" class="form-control form-control-sm" id="txtPH" name="txtPH" style="width:50%" value="0.00" step="0.01" >
                            </div>
                        </div>                        
                    </div>
                    <hr class="btn-primary">


                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="txtcrmedida">CR Medida</label>
                                <input type="number" class="form-control form-control-sm" id="txtcrmedida" name="txtcrmedida" step="0.01" onchange="calcula_cr()"  > 
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtVolumeFinal">Data da Medida</label>
                                <input type="datetime-local" class="form-control form-control-sm" id="txtDtCrMedida" name="txtDtCrMedida"  onchange="ret_fat_decai()" > 
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fator_decai">Fator de Decaimento</label>
                                <input type="number" class="form-control form-control-sm" id="fator_decai" name="fator_decai" style="width:50%" readonly  > 
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="crvoldtcal">CR Data Calibração</label>
                                <input type="number" class="form-control form-control-sm" id="crvoldtcal" name="crvoldtcal"  readonly  >mCi/mL 
                            </div>
                        </div>



                    </div>

                    <hr class="btn-primary">

                    <div class="row">
                       
                    </div>

                    
                    

                    <hr class="btn-primary">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtSobra">Houve Sobra?</label>
                                <br>
                                                        <input type="radio"  name="txtSobra" id="txtSobraS" checked value = 'S' /> SIM <br>
                                                        <input type="radio"  name="txtSobra" id="txtSobraN"         value = 'N' /> NÃO
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtSobraVal">Quanto?</label>
                                <input type="number" class="form-control form-control-sm" id="txtSobraVal" name="txtSobraVal" style="width:30%;" value="0.00" step="0.01"  > mCi
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtSobraVol">Volume</label>
                                <input type="number" class="form-control form-control-sm" id="txtSobraVol" name="txtSobraVol" style="width:30%;" value="0.00" step="0.01" > mL
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtDatCalib">Calibração</label>
                                <input type="datetime-local" class="form-control form-control-sm" id="txtDatCalib" name="txtDatCalib" style="width:210px;" readonly> 
                            </div>
                        </div>

                    </div>

                    <hr class="btn-primary">

                    <div class="row">
                        <div class="col-md-4">
                            Técnico: <?php echo CarregaTecnico();  ?>
                        </div>
                        <div class="col-md-4">
                            Senha: <input type="password" name="txtSenha" id="txtSenha" class="form-control form-control-sm" maxlength="6" size="7" required />
                        </div>
                        <div class="col-md-3">
                        <br><button type="submit" id='gravadiluTalio' name='gravadiluTalio'  class="btn btn-primary btn-sm"  data-toggle="modal"  data-target="#ver" data-backdrop="static" data-keyboard="false">Gravar</button>
                        </div>
                    </div>
                </form>
                <iframe id='processarDILUTalio' name='processarDILUTalio' style='display:inline'></iframe>
                <?php carregaLotesAtendidos(); ?>
                <?php carregaCalcFolhaTalio($_GET['pst_numero']); ?>
                
                <!-- fim do conteúdo -->

                
            </div>
        </div>
    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', function() {
    ret_fat_decai()
    calcula_cr()
});


defCalib = document.getElementById('cabecCalib').value
document.getElementById('txtDatCalib').value = defCalib.substring(6,10) + "-" + defCalib.substring(3,5)+ "-" + defCalib.substring(0,2) + defCalib.substring(10,17)


function ret_fat_decai(){
    prd = 'tlcl3'
    _data1 = document.formDiluicaoTalio.txtDtCrMedida.value
    _data2 = document.formDiluicaoTalio.txtDatCalib.value

    _data1 = _data1.replaceAll('-','')
    _data1 = _data1.replaceAll('T',' ')
    _data2 = _data2.replaceAll('-','')
    _data2 = _data2.replaceAll('T',' ')
    

	$.ajax({ 
        url: '../functions.php',
        type: 'post',
        data: {retormaFatorDecaimento: prd,
			m_data1: _data1,
            m_data2: _data2,
            m_prod: prd,
		  },
       	success: function(output) {
		    fator_decai.value = output
            calcula_cr()
        }
		});	
		

}


function calcula_cr(){
    if (txtcrmedida.value != "" && fator_decai.value != ""){
        crvoldtcal.value = (txtcrmedida.value * fator_decai.value).toFixed(2)
    }
}




</script>


<?php
include("../footer.php");
?>

