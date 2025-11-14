<?php include '../functions.php'?>

<style>
.invalid-feedback {
    display: none;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}

.is-invalid {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}

.is-valid {
    border-color: #28a745 !important;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
}

.text-danger {
    color: #dc3545 !important;
}

.form-control:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
</style>


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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtConcRadio">Concentração Radioativa na Calibração (3,0 a 6,0) mCi / mL</label>
                                <input type="number" class="form-control form-control-sm" id="txtConcRadio" name="txtConcRadio" style="width:15%;" value="0.00" step="0.01" > mCi / mL
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtAtvImp">Ativ. Importado</label>
                                <input type="number" class="form-control form-control-sm" id="txtAtvImp" name="txtAtvImp" style="width:25%;" value="0.00" step="0.01" readonly > mCi 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtVolImp">Volume Importado</label>
                                <input type="number" class="form-control form-control-sm" id="txtVolImp" name="txtVolImp" style="width:25%;" value="0.00" step="0.01" readonly > mL 
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
                                <label for="txtPH">PH (4,5 a 7,5) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control form-control-sm" id="txtPH" name="txtPH" style="width:50%" value="" step="0.01" min="4.5" max="7.5" required placeholder="">
                                
                                <div class="invalid-feedback" id="txtPH-error"></div>
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




                <iframe id='processarDILUTalio' name='processarDILUTalio' style='display:none; width:80%'></iframe>
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
    
    // Configurar validação do formulário
    setupFormValidation()
});

// Função para configurar validação do formulário
function setupFormValidation() {
    const form = document.getElementById('formDiluicaoTalio');
    const txtPH = document.getElementById('txtPH');
    
    // Validação em tempo real do campo PH
    txtPH.addEventListener('blur', function() {
        validatePH();
    });
    
    txtPH.addEventListener('input', function() {
        clearPHError();
    });
    
    // Validação antes do envio do formulário
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        }
    });
}

// Função para validar o campo PH
function validatePH() {
    const txtPH = document.getElementById('txtPH');
    const errorDiv = document.getElementById('txtPH-error');
    const value = txtPH.value.trim();
    
    // Limpar classes anteriores
    txtPH.classList.remove('is-invalid', 'is-valid');
    
    // Verificar se está vazio
    if (value === '' || value === null) {
        txtPH.classList.add('is-invalid');
        errorDiv.textContent = 'O campo PH é obrigatório e não pode estar vazio.';
        errorDiv.style.display = 'block';
        return false;
    }
    
    // Converter para número
    const numValue = parseFloat(value);
    
    // Verificar se é um número válido
    if (isNaN(numValue)) {
        txtPH.classList.add('is-invalid');
        errorDiv.textContent = 'O valor do PH deve ser um número válido.';
        errorDiv.style.display = 'block';
        return false;
    }
    
    // Verificar range (4,5 a 7,5)
    if (numValue < 4.5 || numValue > 7.5) {
        txtPH.classList.add('is-invalid');
        errorDiv.textContent = 'O valor do PH deve estar entre 4,5 e 7,5.';
        errorDiv.style.display = 'block';
        return false;
    }
    
    // Se chegou até aqui, está válido
    txtPH.classList.add('is-valid');
    errorDiv.style.display = 'none';
    return true;
}

// Função para limpar erro do PH
function clearPHError() {
    const txtPH = document.getElementById('txtPH');
    const errorDiv = document.getElementById('txtPH-error');
    
    txtPH.classList.remove('is-invalid');
    errorDiv.style.display = 'none';
}

// Função para validar todo o formulário
function validateForm() {
    let isValid = true;
    
    // Validar PH
    if (!validatePH()) {
        isValid = false;
    }
    
    // Aqui você pode adicionar outras validações se necessário
    
    if (!isValid) {
        // Mostrar alerta
        alert('Por favor, corrija os erros no formulário antes de continuar.');
        
        // Focar no primeiro campo com erro
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            firstError.focus();
        }
    }
    
    return isValid;
}


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

