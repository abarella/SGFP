<?php include '../functions.php'?>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formDiluicaoGalio' id='formDiluicaoGalio' action='../functions.php' method='post' target='processarDILUGalio' novalidate>

                    <input type="hidden" name = "txtGalioId" id="txtGalioId" placeholder="txtGalioId" >
                    <input type="hidden" name = "txtpst_numero" id="txtpst_numero" placeholder="txtpst_numero" value='<?php echo $_GET['pst_numero'] ?>' >


                    <div class="bg-blue text-center h6">REAÇÃO</div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="txtAquecLig">Aquecimento</label>
                                    <br>Aquecedor: Ligou às <input type="time" class="form-control form-control-sm" id="txtAquecLig" name="txtAquecLig"  >
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="txtAquecDesLig">&nbsp;</label>
                                    <br>Desligou às <input type="time" class="form-control form-control-sm" id="txtAquecDesLig" name="txtAquecDesLig"  >
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group"><br>
                                    <label for="txtTemperatura">Temperatura (80 &plusmn; 10,0 ºC)</label>
                                    <br><input type="number" class="form-control form-control-sm" id="txtTemperatura" name="txtTemperatura" step="0.01" >
                                </div>
                            </div>
                        </div>

                        <hr class="btn-primary">

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="txtDuluIni">Diluição</label>
                                    <br>Início <input type="time" class="form-control form-control-sm" id="txtDuluIni" name="txtDuluIni"  >
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="txtDuluFim">&nbsp;</label>
                                    <br>Término <input type="time" class="form-control form-control-sm" id="txtDuluFim" name="txtDuluFim"  >
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="txtVolGalioBal">&nbsp;</label>
                                    <br>Volume de GAL-IPEN no balão (mL) <input type="number" class="form-control form-control-sm" id="txtVolGalioBal" name="txtVolGalioBal" step="0.01" >
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="txtVolCitratoBal">&nbsp;</label>
                                    <br>Volume de Citrato no balão (mL) <input type="number" class="form-control form-control-sm" id="txtVolCitratoBal" name="txtVolCitratoBal" step="0.01" >
                                </div>
                            </div>

                        </div>


                    

                    <div class="bg-blue text-center h6">Fracionamento</div>
                    <div class="row">

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="txtAtivInic">Atividade Inicial (mCi)</label>
                                <input type="number" class="form-control form-control-sm" id="txtAtivInic" name="txtAtivInic" style="width:50%" step="0.01" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="txtAtivFinal">Atividade Final (mCi)</label>
                                <input type="number" class="form-control form-control-sm" id="txtAtivFinal" name="txtAtivFinal" style="width:50%" step="0.01" readonly>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtPedAtendidos">Pedidos Atendidos</label>
                                <input type="text" class="form-control form-control-sm" id="txtPedAtendidos" name="txtPedAtendidos" style="width:50%" readonly >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="txtTotalPartidas">Total de Partidas</label>
                                <input type="text" class="form-control form-control-sm" id="txtTotalPartidas" name="txtTotalPartidas" style="width:50%" readonly> 
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtTotalDistrib">Atividade Total Distribuída (mCi)</label>
                                <input type="text" class="form-control form-control-sm" id="txtTotalDistrib" name="txtTotalDistrib" style="width:50%" readonly>
                            </div>
                        </div>
                    </div>

                    <hr class="btn-primary">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtcrmedida">Concentração Radioativa na Calibração (3,0 a 20,0) (mCi / mL)</label>
                                <input type="number" class="form-control form-control-sm" id="txtcrmedida" name="txtcrmedida" style="width:15%;" value="0.00" step="0.01" >
                            </div>
                        </div>
                    </div>

                    <hr class="btn-primary">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtVolNessaDilu">Volumes de apresentação envasadas nessa diluição até 6,70 mL</label>
                                <br>
                                <input type="radio"  name="txtVolNessaDilu" id="txtVolNessaDiluS" checked value = 'S' /> SIM <br>
                                <input type="radio"  name="txtVolNessaDilu" id="txtVolNessaDiluN"         value = 'N' /> NÃO
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="txtSobraVal0">Quanto? (mCi)</label>
                                <input type="number" class="form-control form-control-sm" id="txtSobraVal0" name="txtSobraVal0" style="width:30%;" value="0.00" step="0.01"  >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="txtSobraVol0">Volume (mL)</label>
                                <input type="number" class="form-control form-control-sm" id="txtSobraVol0" name="txtSobraVol0" style="width:30%;" value="0.00" step="0.01" >
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="txtDescarta">Descartada?</label>
                                <br>
                                <input type="radio"  name="txtDescarta" id="txtDescartaS" checked value = 'S' /> SIM <br>
                                <input type="radio"  name="txtDescarta" id="txtDescartaN"         value = 'N' /> NÃO
                            </div>
                        </div>


                    </div>

                    <hr class="btn-primary">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtVolumeFinal">Volume Final (mL)</label>
                                <input type="number" class="form-control form-control-sm" id="txtVolumeFinal" name="txtVolumeFinal" style="width:50%" value="0.00" step="0.01" readonly  >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtAtvTotSol">Atividade Total da Solução (mCi)</label>
                                <input type="number" class="form-control form-control-sm" id="txtAtvTotSol" name="txtAtvTotSol" style="width:50%" value="0.00" step="0.01" readonly >
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtDtCrMedida">Data da Medida</label>
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
                                <label for="crvoldtcal">CR Data Calibração (mCi/mL)</label>
                                <input type="number" class="form-control form-control-sm" id="crvoldtcal" name="crvoldtcal"  readonly  > 
                            </div>
                        </div>


                    </div>

                    <hr class="btn-primary">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtSobra">Houve Sobra?</label>
                                <br>
                                <input type="radio"  name="txtSobra" id="txtSobraS" checked value = 'S' /> SIM <br>
                                <input type="radio"  name="txtSobra" id="txtSobraN"         value = 'N' /> NÃO
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="txtSobraValQtd">Quanto? (mCi)</label>
                                <input type="number" class="form-control form-control-sm" id="txtSobraValQtd" name="txtSobraValQtd" style="width:30%;" value="0.00" step="0.01"  >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="txtSobraVol">Volume (mL)</label>
                                <input type="number" class="form-control form-control-sm" id="txtSobraVol" name="txtSobraVol" style="width:30%;" value="0.00" step="0.01" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtDatCalib">Calibração</label>
                                <input type="datetime-local" class="form-control form-control-sm" id="txtDatCalib" name="txtDatCalib" style="width:210px;" readonly> 
                            </div>
                        </div>

                    </div>

                    <div class="bg-blue text-center h6">Esterilização</div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="txtIniAutoClav">Início da autoclavação</label>
                                <input type="time" class="form-control form-control-sm" id="txtIniAutoClav" name="txtIniAutoClav" > 
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtTempIniAutoClav">Temperatura (ºC) (121 à 125ºC)</label>
                                <input type="number" class="form-control form-control-sm" id="txtTempIniAutoClav" name="txtTempIniAutoClav" > 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtFimAutoClav">Término da autoclavação (&ge; 30min)</label>
                                <input type="time" class="form-control form-control-sm" id="txtFimAutoClav" name="txtFimAutoClav" > 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtTempFimAutoClav">Temperatura (ºC) (121 à 125ºC)</label>
                                <input type="number" class="form-control form-control-sm" id="txtTempFimAutoClav" name="txtTempFimAutoClav" > 
                            </div>
                        </div>
                    </div>

                    <hr class="btn-primary">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                    <label for="txtPressIni">Pressão Inicial (atm) (&ge; 1,0 atm)</label>
                                    <input type="number" class="form-control form-control-sm" id="txtPressIni" name="txtPressIni" value="0.00" step="0.01" > 
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                        <label for="txtPressFim">Pressão Final (atm) (&ge; 1,0 atm)</label>
                                        <input type="number" class="form-control form-control-sm" id="txtPressFim" name="txtPressFim" value="0.00" step="0.01" > 
                                    </div>
                                </div>
                        </div>

                    <hr class="btn-primary">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="txtImpAutClav">Registro do Processo de autoclavação impresso?</label>
                                <br>
                                <input type="radio"  name="txtImpAutClav" id="txtImpAutClavS" checked value = 'S' /> SIM <br>
                                <input type="radio"  name="txtImpAutClav" id="txtImpAutClavN"         value = 'N' /> NÃO
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="txtOcorrAutClav">Alguma ocorência durante a esterilização</label>
                                    <br>
                                    <input type="radio"  name="txtOcorrAutClav" id="txtOcorrAutClavS" checked value = 'S' /> SIM <br>
                                    <input type="radio"  name="txtOcorrAutClav" id="txtOcorrAutClavN"         value = 'N' /> NÃO
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="txtOcorrencia">Qual?</label>
                                    <input type="text"   class="form-control form-control-sm" id="txtOcorrencia" name="txtOcorrencia" > 
                                </div>
                            </div>


                    </div>

                    <hr class="btn-primary">

                    <div class="row">
                        <div class="col-md-6">
                            Técnico: <?php echo CarregaTecnico();  ?>
                        </div>
                        <div class="col-md-4">
                            Senha: <input type="password" name="txtSenha" id="txtSenha" class="form-control form-control-sm" maxlength="6" size="7" required />
                        </div>
                        <div class="col-md-2">
                        <br><button type="submit" id='gravadiluGalio' name='gravadiluGalio'  class="btn btn-primary btn-sm"  data-toggle="modal"  data-target="#ver" data-backdrop="static" data-keyboard="false">Gravar</button>
                        </div>
                    </div>

                </form>
                <iframe id='processarDILUGalio' name='processarDILUGalio' style='display:none'></iframe>
                <?php carregaLotesAtendidos(); ?>
                <?php carregaCalcFolhaGalio($_GET['pst_numero']); ?>
                
                
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
    prd = 'ga-67'
    _data1 = document.formDiluicaoGalio.txtDtCrMedida.value
    _data2 = document.formDiluicaoGalio.txtDatCalib.value

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

