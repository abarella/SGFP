<?php include ('../functions.php')?>


<?php
    //var_dump($_GET);
    //echo $_REQUEST["pst_numero"];
?>




<script>
    
    function fu_abre(id){

        const windowFeatures = "left=0,top=0,width=940px,height=620";
        //window.open(<?php echo $_SG['report_site']; ?>+ "?report=repo1&id="+id,"_report", windowFeatures)
        window.open("<?php echo $_SESSION['PATH_RELATORIO']; ?>" +"FM-DIRF-0901-04?p600_checklist_id="+id+"&rs:Command=Render", "vcd")
    }

    function fu_abreVol(id){
        pstnumero = '<?php echo $_GET['pst_numero']; ?>'
        produto =  '<?php echo $_GET['produto']; ?>'
        const windowFeatures = "left=0,top=0,width=940px,height=620";
        if (produto=="rd_i131"){
            window.open(<?php echo $_SG['report_site']; ?>+ "?report=IODO131&pst_numero="+pstnumero+"","_report", windowFeatures)
            
        }
        if (produto=="rd_tl"){
            window.open(<?php echo $_SG['report_site']; ?>+ "?report=ACPT272T&pst_numero="+pstnumero+"","_report", windowFeatures)
        }

        //window.open(<?php echo $_SG['report_site']; ?>+ "?report=IODO131&pst_numero="+pstnumero+"","_report", windowFeatures)

    }

    function fu_abreVCD(){
        $('#EdtVCD').modal({
                backdrop: 'static',
                keyboard: true,
                show: true
            });

    }


function fu_abreLPZ(){
    $('#EdtLPZ').modal({
                backdrop: 'static',
                keyboard: true,
                show: true
            });
}

    function fu_imprimeVCD(){
        pstnumero = '<?php echo $_GET['pst_numero']; ?>'

        window.open("<?php echo $_SESSION['PATH_RELATORIO']; ?>" +"fm-dirf-0901.02-01v3?pst_numero="+pstnumero+"&rs:Command=Render", "vcd")

    }

    function fu_ficha(categoria){
        if (categoria==9){
            //$('#EdtLimpCela').modal('show');
            $('#EdtLimpCela').modal({
                backdrop: 'static',
                keyboard: true,
                show: true
            });

        }
        else {
            alert('abre glove')
        }

    }


    function soma(obj){	

        var name = obj.name;
        //name = name.substr(2, 3);
        name = name.substr(2, 99);
        //alert(name)
        
        for(i=0;i<=300;i++){
            var na = document.getElementById(i);
            if(na){
                if(na.name == name){
                    if(na.checked == true){
                        na.checked = false;
                        idNA = '';
                        na = '';
                    }
                }
            }
        }
        
        qtdeNaoConforme = parseInt(qtdeNaoConforme);
        
        if(obj.checked == true){
            qtdeNaoConforme = qtdeNaoConforme + 1;
        }else{
            qtdeNaoConforme = qtdeNaoConforme - 1;
        }
        spnConforme.innerText = qtdeNaoConforme;
        spnNaoConforme.innerText = qtdeNaoConforme;
        if(qtdeNaoConforme == 0){
            var tipoArea = document.getElementById("ckTipoArea");
            var tipoCorr = document.getElementById("ckTipoCorr");
            tipoArea.disabled = true;
            tipoCorr.disabled = true;
        }

        if(qtdeNaoConforme > 0){
            var tipoArea = document.getElementById("ckTipoArea");
            var tipoCorr = document.getElementById("ckTipoCorr");
            tipoArea.disabled = false;
            tipoCorr.disabled = false;
        }

    }

    function selecionaNA(obj)
    {	
        //var id = obj.id; 
        //var ckID = "ck" + id;
        var id = 0;
        var ckID = "ck0";
        var name = obj.name;
        var ckName = "ck" + name;

        for(i=0;i<=300;i++){
            var ck = document.getElementById(ckID);
            if(ck){
                if(ck.checked == true && ck.name == ckName){
                    ck.checked = false;
                    qtdeNaoConforme = qtdeNaoConforme - 1;
                    spnConforme.innerText = qtdeNaoConforme;
                    spnNaoConforme.innerText = qtdeNaoConforme;
                                                           
                    if(qtdeNaoConforme == 0){
                        var tipoArea = document.getElementById("ckTipoArea");
                        var tipoCorr = document.getElementById("ckTipoCorr");
                        tipoArea.disabled = true;
                        tipoCorr.disabled = true;
                    }
                    if(qtdeNaoConforme > 0){
                        var tipoArea = document.getElementById("ckTipoArea");
                        var tipoCorr = document.getElementById("ckTipoCorr");
                        tipoArea.disabled = false;
                        tipoCorr.disabled = false;
                    }
                
                    
                }
            }
            
            id = parseInt(id) + 1;
            var ckID = "ck" + id;
        }

    }



    function txtObservacao_onKeyPress(obj){
        var codigo = window.event.keyCode;
        if (obj.value.length == 255){
            window.event.returnValue = false;
        }
    }


    function fu_grava(){

        if (txt83.value == 0 || txt83.value ==''){
            txt83.focus()
            toastApp(4500,'CAMPO OBRIGATÓRIO NECESSÁRIO','ERRO')
            return
        }


        toastApp(4500,'AGUARDE O FINAL DO PROCESSO','OK')
        for(i=1; i < tbDados.rows.length; i++){
            //verificação
            if (i<1000) {
                //parametros p600_checklist_id1, p600_itensid, p600_tipo
                var param0 = tbDados.rows[i].cells[3].innerText
                var param  = param0.split('|')
                p600_checklist_id1 = param[0]
                p600_itensid       = param[1]
                p600_tipo          = param[2]
                p600_itemtela      = param[3]
                p600_checklist_id  = param[4]
                
                //    0     1 2 3   4
                //  451741|92|3|1|76240
                //     |   |  | |   |--------------- p600_checklist_id
                //     |   |  | *------------------- p600_itemtela   
                //     |   |   *-------------------- p600_tipo
                //     |   *------------------------ p600_itensid
                //     *---------------------------- p600_checklist_id1       

                //nome do campo
                //alert(tbDados.rows[i].cells[0].innerText) 
                
                //checkbox ou radio
                conforme = 0
                conforme = tbDados.rows[i].cells[1].children[0].checked 

                if (conforme==false){conforme=0} 
                if (conforme==true){conforme=1} 
                

                // se tiver texto agregado
                valor=""
                if (p600_tipo==4){
                    valor = tbDados.rows[i].cells[1].children[1].value
                }

                /*
                *----------------------------------------*
                * grava os dados da verificação da cela  *
                *----------------------------------------*
                --                                  (p600_itemtela)
                -------------------------------------------------------* 
                --                   (p600_conforme)                   |
                -------------------------------------------------*     | 
                --                                               |     |
                --          (p600_itensid)                       |     |
                -----------------------------------------*       |     |
                --                                       |       |     |
                execute  crsa.P0600_CK_GRAVA_CELA 76240, 92, '', 1, 0, 1,  @resulta output , @mensa output 
                --      (valor quando houver)                 | 
                ----------------------------------------------*
                */

               qs = "exec crsa.P0600_CK_GRAVA_CELA "
               qs += p600_checklist_id + ","
               qs += p600_itensid + ","
               qs += "'" + valor + "',"
               qs += conforme + ","
               qs += '0' + ","  //verificar
               qs += p600_itemtela 
               qs += ",'',''"

               //qs += "<br>"

               //processar.srcdoc = qs
               //var s = document.getElementById('processar');
               //s.contentDocument.write(qs);

               IncluiLimpCela(qs)

                

            }
        }


        _ckTipoCorr = ckTipoCorr.checked
        _ckTipoArea = ckTipoArea.checked

        if (_ckTipoCorr==false){_ckTipoCorr=0}else{_ckTipoCorr=1}
        if (_ckTipoArea==false){_ckTipoArea=0}else{_ckTipoArea=1}

        _data =m_datverfic.value
        _data = _data.replaceAll('-','')
        _data = _data.replaceAll('T',' ')

        var strQS = "exec crsa.P0600_CK_GRAVA0 ";
		strQS += "@p600_checklist_id='" + txtIdCelaRep.value+"',";
		strQS += "@p1500_eqptoid='" + cmbCela.value+"',";
		strQS += "@p600_tecnicorsp='" + cmbTecnico.value+"',";
		strQS += "@p600_tecnicodata=" +"'" + _data + "',";
		strQS += "@p600_qtde_naoconforme='" + spnConforme.innerText+"',";
		strQS += "@p600_obs=" + "'" + txtObservacao.value+ "'," ;
		strQS += "@cdusuario='" + cmbTecnico.value+"',";
		strQS += "@senha='" + m_txtSenha.value+"',";
		strQS += "@corretiva='" + _ckTipoCorr+"',";
		strQS += "@area_restrita='" + _ckTipoArea+"',";
        strQS += "@resulta='',"
        strQS += "@mensa='',"
        strQS += "@p1520_corretivaid='',"
        strQS += "@p1600_arearestritaid=''"
        IncluiLimpCela(strQS)

        $('#EdtLimpCela').modal('hide');
    }


    function somaCVD(){

        valLeitura = 0
        itensvalidos = 0
        for(let x=0; x <= 9; x++){
            _x1 = x+1
            _x = '0' + _x1
            _x = _x.slice(-2);
            _v = document.getElementById('m_repro'+_x+'VCD').value
            if (_v==''){_v=0} 
            if (_v != 0){itensvalidos++}
            valLeitura = valLeitura + parseFloat(_v)
        }
        
        

        document.getElementById('m_reproSOMAVCD').value = valLeitura
        //document.getElementById('m_reproUNMedVCD').value = itensvalidos

        media=parseFloat(valLeitura / itensvalidos).toFixed(2);
        mediaINF=parseFloat((valLeitura / itensvalidos) * 0.95).toFixed(2);
        mediaSUP=parseFloat((valLeitura / itensvalidos) * 1.05).toFixed(2);


        document.getElementById('m_avg01VCD').value = media //parseFloat(valLeitura / itensvalidos)
        document.getElementById('m_avg02VCD').value = mediaINF //parseFloat(valLeitura / itensvalidos)
        document.getElementById('m_avg03VCD').value = mediaSUP //parseFloat(valLeitura / itensvalidos)

    }


    function calcdesvioCVD(){
        var fonte = document.getElementById('m_medidafonteVCD').value
        var esper = document.getElementById('m_valesperadoVCD').value
        
        var result = 0
        
        if (esper==0 || esper == ""){
            result = 0
        }
        else {
            v1 = parseFloat(fonte)
            v2 = parseFloat(esper)
            
            result = ((fonte - esper) * 100) / esper
            
        }


        document.getElementById('m_desvioVCD').value = result.toFixed(2);

    }


    function fu_gravaVCD(){
        var fonte = 1
        var pst_numero = document.getElementById('pst_numero').value
        var p_datverficVCD = document.getElementById('m_datverficVCD').value.replace("T", " ")
        var p_calibCRVCD = document.getElementById('m_calibCRVCD').value
        var p_modeloVCD = document.getElementById('m_modeloVCD').value
        var p_unidPrinVCD = document.getElementById('m_unidPrinVCD').value
        var p_localVCD = document.getElementById('m_localVCD').value
        var p_produtoVCD = document.getElementById('m_produtoVCD').value
        var p_loteVCD = document.getElementById('m_loteVCD').value
        var p_zeroVCD = document.getElementById('m_zeroVCD').value
        var p_testesisVCD = document.getElementById('m_testesisVCD').value
        var p_backgroundVCD = document.getElementById('m_backgroundVCD').value
        var p_confdadosVCD = document.getElementById('m_confdadosVCD').value
        var p_radiofonteVCD = document.getElementById('m_radiofonteVCD').value
        var p_idfonteVCD = document.getElementById('m_idfonteVCD').value
        var p_medidafonteVCD = document.getElementById('m_medidafonteVCD').value
        var p_valesperadoVCD = document.getElementById('m_valesperadoVCD').value
        var p_desvioVCD = document.getElementById('m_desvioVCD').value
        var p_repro01VCD = document.getElementById('m_repro01VCD').value
        var p_repro02VCD = document.getElementById('m_repro02VCD').value
        var p_repro03VCD = document.getElementById('m_repro03VCD').value
        var p_repro04VCD = document.getElementById('m_repro04VCD').value
        var p_repro05VCD = document.getElementById('m_repro05VCD').value
        var p_repro06VCD = document.getElementById('m_repro06VCD').value
        var p_repro07VCD = document.getElementById('m_repro07VCD').value
        var p_repro08VCD = document.getElementById('m_repro08VCD').value
        var p_repro09VCD = document.getElementById('m_repro09VCD').value
        var p_repro10VCD = document.getElementById('m_repro10VCD').value
        var p_reproSOMAVCD = document.getElementById('m_reproSOMAVCD').value
        var p_reproUNMedVCD = document.getElementById('m_reproUNMedVCD').value
        var p_avg01VCD = document.getElementById('m_avg01VCD').value
        var p_avg02VCD = document.getElementById('m_avg02VCD').value
        var p_avg03VCD = document.getElementById('m_avg03VCD').value
        var p_obsVCD = document.getElementById('m_obsVCD').value
        var p_cmbTecnico = document.getElementById('cmbTecnicoVCD').value
        var p_txtSenhaVCD = document.getElementById('m_txtSenhaVCD').value


        $.ajax({ url: '../functions.php',
         data: {gravaVCD: fonte,
		        pst_numero: pst_numero,
                m_datverficVCD: p_datverficVCD,
                m_calibCRVCD: p_calibCRVCD,
                m_modeloVCD: p_modeloVCD,
                m_unidPrinVCD: p_unidPrinVCD,
                m_localVCD: p_localVCD,
                m_produtoVCD: p_produtoVCD,
                m_loteVCD: p_loteVCD,
                m_zeroVCD: p_zeroVCD,
                m_testesisVCD: p_testesisVCD,
                m_backgroundVCD: p_backgroundVCD,
                m_confdadosVCD: p_confdadosVCD,
                m_radiofonteVCD: p_radiofonteVCD,
                m_idfonteVCD: p_idfonteVCD,
                m_medidafonteVCD: p_medidafonteVCD,
                m_valesperadoVCD: p_valesperadoVCD,
                m_desvioVCD: p_desvioVCD,
                m_repro01VCD: p_repro01VCD,
                m_repro02VCD: p_repro02VCD,
                m_repro03VCD: p_repro03VCD,
                m_repro04VCD: p_repro04VCD,
                m_repro05VCD: p_repro05VCD,
                m_repro06VCD: p_repro06VCD,
                m_repro07VCD: p_repro07VCD,
                m_repro08VCD: p_repro08VCD,
                m_repro09VCD: p_repro09VCD,
                m_repro10VCD: p_repro10VCD,
                m_reproSOMAVCD: p_reproSOMAVCD,
                m_reproUNMedVCD: p_reproUNMedVCD,
                m_avg01VCD: p_avg01VCD,
                m_avg02VCD: p_avg02VCD,
                m_avg03VCD: p_avg03VCD,
                m_obsVCD: p_obsVCD,
                m_cmbTecnico: p_cmbTecnico,
                m_txtSenhaVCD: p_txtSenhaVCD
			   },
         		type: 'post',
         		success: function(output) {
					toastApp(3000,'Calibrador de Doses Gravado','OK')
					//location.href = location.href;
                    $('#EdtVCD').modal('hide');
                },
                error: function(xhr, status, error) {
					toastApp(3000,"Senha inválida",'ERRO')
					//location.href = location.href;
                    $('#EdtVCD').modal('hide');
                }

			}
		);
    }


    function fu_gravaLPZ(){
        var fonte = 1
        var p_pst_numero = document.getElementById("m_pstLPZ").value 
        var p_txtLoteLPZ = document.getElementById('m_loteLPZ').value
        var p_nomeMat = document.getElementById("txtNomeMat").value 
        var p_loteIpen = document.getElementById("txtLoteIpen").value
        var p_validade = document.getElementById("txtValidade").value
        var p_IdSolu = document.getElementById("txtIdSolu").value
        var p_cmbTecnico = document.getElementById('cmbTecnicoLPZ').value
        var p_txtSenhaLPZ = document.getElementById('m_txtSenhaLPZ').value
        
        
        


        $.ajax({ url: '../functions.php',
         data: {gravaLPZ: fonte,
		        pst_numero: p_pst_numero,
                lote_LPZ: p_txtLoteLPZ,
                nome_mat: p_nomeMat,
                loteIpen: p_loteIpen,
                validade: p_validade,
                IdSolu: p_IdSolu,
                cmbTecnico: p_cmbTecnico,
                txtSenhaLPZ: p_txtSenhaLPZ

			   },
         		type: 'post',
         		success: function(output) {
					toastApp(3000,'Limpeza de Cela Gravado','OK')
					location.href = location.href;
                    $('#EdtLPZ').modal('hide');
                },
                error: function(xhr, status, error) {
					toastApp(3000,"Senha inválida",'ERRO')
					location.href = location.href;
                    $('#EdtLPZ').modal('hide');
                }

			}
		);
        
    }






</script>



<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formLimpCela' id='formLimpCela'>
                    <div class="row">
                        <div class="col-md-4">
                          <h5>Verificação de Cela </h5>
                            <input type='hidden' id='txtIdCelaRep' name='txtIdCelaRep' />
                            <input type='hidden' id='txtCategoria' name='txtCategoria' />
                            <?php echo RetornaVerifCela($_REQUEST["pst_numero"]);  ?>
                            <br>
                            <input type="button" class="btn btn-primary" value="Imprimir" onclick="fu_abre(document.getElementById('txtIdCelaRep').value)">
                            <input type="button" class="btn btn-primary" value="Editar Verificação" onclick="fu_ficha(document.getElementById('txtCategoria').value)">
                        </div>
                        <div class="col-md-4">
                        <h5>Limpeza de Cela </h5>
                            <?php echo RetornaLimpCela($_REQUEST["pst_numero"]);  ?> <br>
                            <input type="button" class="btn btn-primary" id="EditarLPZ"   value="Editar" onclick="fu_abreLPZ(document.getElementById('txtIdCelaRep').value)"><br>
                        </div>

                        <div class="col-md-4">
                        <h5>Verificação do Calibrador de Doses </h5>
                            <input type="button" class="btn btn-primary" id="EditarVCD"   value="Editar" onclick="fu_abreVCD(document.getElementById('txtIdCelaRep').value)">
                            <input type="button" class="btn btn-primary" id="ImprimirVCD" value="Imprimir" onclick="fu_imprimeVCD()">
                        </div>


                    </div>
                </form>
                <!-- fim do conteúdo -->
            </div>
        </div>
    </div>
</div>





<!-- modal -->
<div class="modal fade " id="EdtLimpCela" tabindex="-1" role="dialog" aria-labelledby="limpcelaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header " >
          <h4> Lista de Verificação </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
			<form action=<?php echo $_SG['rf'] .'functions.php';?>  target="processarEQ" method="POST" name="formLimpCela" id="formLimpCela" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4">
                        <span id=spnProduto class='form-control-sm'></span>
                        <span id=spnLoteValor class='form-control-sm'></span>
                    </div>
                    <div class="col-md-8">
                        <?php echo RetornaEqpCelaCMB(); ?>
                    </div>
                </div>

                <br>

                <div class="row">
					<input type='hidden' id='pst_numero' name='pst_numero' value='<?php echo $_GET['pst_numero']; ?>' />
                    
					<div class="col-md-12">
						<div class="form-group">
                            <?php echo RetornaListaLimpCela(''); ?>
						</div>
					</div>
				</div>

                <div class="row">
                    <div class="col-md-12">
                        Observação:
                        <textarea class="form-control" onkeypress="javascript:txtObservacao_onKeyPress(this);" id=txtObservacao rows=5 cols=70><?php echo RetornaListaLimpCelaOBS(''); ?></textarea>
                    </div>
                </div>
                <br>

                <div class="row border border-primary">
                    <div class="col-md-10" >
                        Itens Não Conforme:
                        <strong>
                        <span class="bg-danger" id=spnConforme>0</span>
                        <span style="display:none" class="btn-danger" id=spnNaoConforme>0</span>
                        </strong>
                    </div>

                    <div class="col-md-2" >
                        
                        <input xonclick=javascript:valorCorretiva(this); disabled id=ckTipoCorr type=checkbox value="" name=ckTipo>
                        <span  xonclick=javascript:chamarCorretiva();             id=spnMC>Manutenção Corretiva</span>
                            <br>
                        <input xonclick=javascript:valorRestrita(this); disabled  id=ckTipoArea type=checkbox value="" name=ckTipo>
                        <span  xonclick=javascript:chamarAreaRestrita(0);         id=spnAR>Área Restrita</span>
                    </div>
                </div>

                <br>

				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label for="m_txtAtivEspec" class="form-label">Técnico</label>
							<div class="input-group">
								<?php echo CarregaTecnico();  ?>
							</div>
						</div>
					</div>

                    				
					<div class="col-md-3">
						<div class="form-group">
							&nbsp;<label for="m_txtSenha" class="form-label">Data Verificação</label>
							<div class="input-group">
								&nbsp;<input type="datetime-local" class="form-control form-control-sm" name="m_datverfic" id="m_datverfic" required />
							</div>
						</div>
					</div>



					<div class="col-md-3">
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
        <button type="button" class="btn btn-secondary" id='btnClose' xonclick="AfterCloseModal()" data-dismiss="modal">Fechar</button>
        <button type="button" name="gravaLimpCela" id="gravaLimpCela" onclick="fu_grava()"  class="btn btn-primary" form="formLimpCela" >Salvar</button>
      </div>
    </div>
  </div>
</div>

<?php RetornaListaLimpCelaContagem(''); ?>

<?php include("../footer.php");?>


<!-- modal -->
<div class="modal fade " id="EdtVCD" tabindex="-1" role="dialog" aria-labelledby="limpcelaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header " >
          <h4>Verificação do Calibrador de Doses</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
			<form action=<?php echo $_SG['rf'] .'functions.php';?>  target="processarEQ" method="POST" name="formLimpCela" id="formLimpCela" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
							&nbsp;<label for="m_datverficVCD" class="form-label">Data Verificação</label>
							<div class="input-group">
								&nbsp;<input type="datetime-local" class="form-control form-control-sm" name="m_datverficVCD" id="m_datverficVCD" required />
							</div>
						</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
							&nbsp;<label for="m_calibCRVCD" class="form-label">Calibrador de Doses</label>
							<div class="input-group">
								&nbsp;<input type="text" class="form-control form-control-sm" name="m_calibCRVCD" id="m_calibCRVCD" required />
							</div>
						</div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
							&nbsp;<label for="m_modeloVCD" class="form-label">Modelo</label>
							<div class="input-group">
								&nbsp;<input type="text" class="form-control form-control-sm" name="m_modeloVCD" id="m_modeloVCD" required />
							</div>
						</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
							&nbsp;<label for="m_unidPrinVCD" class="form-label">Unidade Principal</label>
							<div class="input-group">
								&nbsp;<input type="text" class="form-control form-control-sm" name="m_unidPrinVCD" id="m_unidPrinVCD" required />
							</div>
						</div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
							&nbsp;<label for="m_localVCD" class="form-label">Local</label>
							<div class="input-group">
								&nbsp;<input type="text" class="form-control form-control-sm" name="m_localVCD" id="m_localVCD" required />
							</div>
						</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
							&nbsp;<label for="m_produtoVCD" class="form-label">Produto</label>
							<div class="input-group">
								&nbsp;<input type="text" class="form-control form-control-sm" name="m_produtoVCD" id="m_produtoVCD" readonly value='
<?php 
$p = $_GET['produto']; 
if($p=="rd_i131"){$p="IOD-IPEN-131";}                                    
echo $p;
?>
' />
							</div>
						</div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
							&nbsp;<label for="m_loteVCD" class="form-label">Lote</label>
							<div class="input-group">
								&nbsp;<input type="text" class="form-control form-control-sm" name="m_loteVCD" id="m_loteVCD" readonly value='<?php echo $_GET['lote'] ?>' />
							</div>
						</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 h5 bg-navy text-center " >
                            Teste do Equipamento
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
							&nbsp;<label for="m_zeroVCD" class="form-label">Zero</label>
							<div class="input-group">
								&nbsp;<input type="text" class="form-control form-control-sm" name="m_zeroVCD" id="m_zeroVCD" required  />
							</div>
						</div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
							&nbsp;<label for="m_testesisVCD" class="form-label">Teste do Sistema</label>
							<div class="input-group">
								&nbsp;<input type="text" class="form-control form-control-sm" name="m_testesisVCD" id="m_testesisVCD" required  />
							</div>
						</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
							&nbsp;<label for="m_backgroundVCD" class="form-label">Background</label>
							<div class="input-group">
								&nbsp;<input type="text" class="form-control form-control-sm" name="m_backgroundVCD" id="m_backgroundVCD" required  />
							</div>
						</div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
							&nbsp;<label for="m_confdadosVCD" class="form-label">Conferência dos Dados</label>
							<div class="input-group">
								&nbsp;<input type="text" class="form-control form-control-sm" name="m_confdadosVCD" id="m_confdadosVCD" required  />
							</div>
						</div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-12 h5 bg-navy text-center " >
                            Teste de Exatidão
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
							&nbsp;<label for="m_radiofonteVCD" class="form-label">Radioisótopo da Fonte</label>
							<div class="input-group">
								&nbsp;<input type="text" class="form-control form-control-sm" name="m_radiofonteVCD" id="m_radiofonteVCD" required  />
							</div>
						</div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
							&nbsp;<label for="m_idfonteVCD" class="form-label">Identificação da Fonte</label>
							<div class="input-group">
								&nbsp;<input type="text" class="form-control form-control-sm" name="m_idfonteVCD" id="m_idfonteVCD" required  />
							</div>
						</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
							&nbsp;<label for="m_medidafonteVCD" class="form-label">Medida da Fonte (M)</label>
							<div class="input-group">
								&nbsp;<input type="number" class="form-control form-control-sm" name="m_medidafonteVCD" id="m_medidafonteVCD" onkeyup="calcdesvioCVD()" required  />
							</div>
						</div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
							&nbsp;<label for="m_valesperadoVCD" class="form-label">Valor Esperado (S)</label>
							<div class="input-group">
								&nbsp;<input type="number" class="form-control form-control-sm" name="m_valesperadoVCD" id="m_valesperadoVCD" onkeyup="calcdesvioCVD()" required  />
							</div>
						</div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
				            <label for="m_desvioVCD" class="form-label">Desvio = (M-S) * 100<br>
                                <div style="height:2px; background-color:#000; padding:0px 68px 2px">&nbsp;</div>
                                <div style="height:2px; background-color:#000; padding:0px 68px 0px">S</div>
                            </label>
			            </div>
                    </div>

                    <div class="col-md-3">
                        <div class="input-group">
            				&nbsp;<input type="number" class="form-control form-control-sm" name="m_desvioVCD" id="m_desvioVCD" readonly  />
                         </div>
                   </div>
                </div>



                <div class="row">
                    <div class="col-md-12 h5 bg-navy text-center " >
                            Teste de Reprodutibilidade
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <table class="display compact table-striped " >
                            <th>Nº de Leitura</th>
                            <th>Atividade</th>
                            <tr><td>01</td><td><input type="number" step="0.01" class="form-control form-control-sm" name="m_repro01VCD" id="m_repro01VCD" onkeyup="somaCVD()" /></td></tr>
                            <tr><td>02</td><td><input type="number" step="0.01" class="form-control form-control-sm" name="m_repro02VCD" id="m_repro02VCD" onkeyup="somaCVD()" /></td></tr>
                            <tr><td>03</td><td><input type="number" step="0.01" class="form-control form-control-sm" name="m_repro03VCD" id="m_repro03VCD" onkeyup="somaCVD()" /></td></tr>
                            <tr><td>04</td><td><input type="number" step="0.01" class="form-control form-control-sm" name="m_repro04VCD" id="m_repro04VCD" onkeyup="somaCVD()" /></td></tr>
                            <tr><td>05</td><td><input type="number" step="0.01" class="form-control form-control-sm" name="m_repro05VCD" id="m_repro05VCD" onkeyup="somaCVD()" /></td></tr>
                            <tr><td>06</td><td><input type="number" step="0.01" class="form-control form-control-sm" name="m_repro06VCD" id="m_repro06VCD" onkeyup="somaCVD()" /></td></tr>
                            <tr><td>07</td><td><input type="number" step="0.01" class="form-control form-control-sm" name="m_repro07VCD" id="m_repro07VCD" onkeyup="somaCVD()" /></td></tr>
                            <tr><td>08</td><td><input type="number" step="0.01" class="form-control form-control-sm" name="m_repro08VCD" id="m_repro08VCD" onkeyup="somaCVD()" /></td></tr>
                            <tr><td>09</td><td><input type="number" step="0.01" class="form-control form-control-sm" name="m_repro09VCD" id="m_repro09VCD" onkeyup="somaCVD()" /></td></tr>
                            <tr><td>10</td><td><input type="number" step="0.01" class="form-control form-control-sm" name="m_repro10VCD" id="m_repro10VCD" onkeyup="somaCVD()" /></td></tr>
                            <tr><td><b>Somatória</b></td><td><input type="number" step="0.01" class="form-control form-control-sm" name="m_reproSOMAVCD" id="m_reproSOMAVCD" /></td></tr>
                            <tr><td><b>Unidade de Medida</b></td><td><input type="text" class="form-control form-control-sm" name="m_reproUNMedVCD" id="m_reproUNMedVCD" /></td></tr>

                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="display compact table-striped " >
                            <tr>
                                <th colspan=2>Média das Leituras</th>
                            </tr>

                            <tr><td>Somatória das leituras / N = </td><td><input type="number" class="form-control form-control-sm" name="m_avg01VCD" id="m_avg01VCD" readonly /></td></tr>
                            <tr><td>Limite Inferior<br>(-5% = Média x 0,95)</td><td><input type="number" class="form-control form-control-sm" name="m_avg02VCD" id="m_avg02VCD" readonly/></td></tr>
                            <tr><td>Limite Superior<br>(+5% = Média x 1,05)</td><td><input type="number" class="form-control form-control-sm" name="m_avg03VCD" id="m_avg03VCD" readonly/></td></tr>
                        </table>
                    </div>

                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <span class="btn btn-primary">
                            OBS: Caso alguma  das leituras estiver fora do intervalo entre o limite inferior ou superior em relação à média, <br>comunicar a chefia imediata e o grupo de equipamentos.
                        </span>
                    </div>
                </div>
<br>
                <div class="row">
                    <div class="col-md-12">
                        
                            OBS: <input type="text" class="form-control"  name="m_obsVCD" id="m_obsVCD" />
                        
                    </div>
                </div>

<hr>
                    <?php RetornaCalibDose(); ?>



				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label for="m_txtAtivEspec" class="form-label">Técnico</label>
							<div class="input-group">
								<?php echo CarregaTecnicoVCD();  ?>
							</div>
						</div>
					</div>

                    				
					<div class="col-md-3">
					</div>



					<div class="col-md-3">
						<div class="form-group">
							&nbsp;<label for="m_txtSenha" class="form-label">Senha</label>
							<div class="input-group">
								&nbsp;<input type="password" class="form-control form-control-sm" name="m_txtSenhaVCD" id="m_txtSenhaVCD" required />
                                
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
        
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id='btnClose' xonclick="AfterCloseModal()" data-dismiss="modal">Fechar</button>
        <button type="button" name="gravaLimpCela" id="gravaLimpCela" onclick="fu_gravaVCD()"  class="btn btn-primary" form="formLimpCela" >Salvar</button>
      </div>
    </div>
  </div>
</div>




<!-- modal -->
<div class="modal fade " id="EdtLPZ" tabindex="-1" role="dialog" aria-labelledby="limpcelaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable "  style="max-width: 60%;" role="document">
        <div class="modal-content">
            <div class="modal-header " >
                <h4>Limpeza de Cela</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                    <form action=<?php echo $_SG['rf'] .'functions.php';?>  target="processarEQ" method="POST" name="formLimpCelaC" id="formLimpCelaC" enctype="multipart/form-data">
                        <input type="hidden" class="form-control form-control-sm" name="m_pstLPZ" id="m_pstLPZ" readonly value='<?php echo $_GET['pst_numero'] ?>' />
                        <input type="hidden" class="form-control form-control-sm" name="m_loteLPZ" id="m_loteLPZ" readonly value='<?php echo $_GET['lote'] ?>' />
                        
                        <div class="row">
                            <div class="col-md-2">
                                <input type="text" class="form-control form-control-sm" id="txtIdSolu" name="txtIdSolu"  readonly/>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control form-control-sm" id="txtNomeMat" name="txtNomeMat"  readonly/>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control form-control-sm" id="txtLoteIpen" name="txtLoteIpen"  readonly/>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control form-control-sm" id="txtValidade" name="txtValidade"  readonly/>
                            </div>

                        </div>

<hr>
                        

                        <div class="row">
                            <div class="col-md-12">
                            <table id="tblistaMat" class="display compact table-striped table-bordered responsive nowrap" style="width:100%; font-size:12px; font-family: Tahoma">
                            <thead style="background-color:#556295; color:#f2f3f7">
                                <tr>
                                    <th>Função</th>
                                    <th>Código</th>
                                    <th>Material</th>
                                    <th>Lote IPEN</th>
                                    <th>Validade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo GridMateriais(); ?>
                            </tbody>
                        </table>
                            </div>
                        </div>

                        <?php echo CarregaSolucao(); ?>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="m_txtAtivEspec" class="form-label">Técnico</label>
                                    <div class="input-group">
                                        <?php echo CarregaTecnicoLPZ();  ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    &nbsp;<label for="m_txtSenha" class="form-label">Senha</label>
                                    <div class="input-group">
                                        &nbsp;<input type="password" class="form-control form-control-sm" name="m_txtSenhaLPZ" id="m_txtSenhaLPZ" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id='btnClose' data-dismiss="modal">Fechar</button>
                    <button type="button" name="gravaLimpCela" id="gravaLimpCela" onclick="fu_gravaLPZ()"  class="btn btn-primary" form="formLimpCela" >Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
$(document).ready(function () {
    var table = $('#tblistaMat').DataTable({
		"language": {
                "url": "<?php  echo $_SG['rf']; ?>dist/js/pt-BR.php"
        },

        "domxxx": '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',   //solução boa para a parte de cima do grid
        pageLength: 5,
        lengthMenu: [[5, 10, 50, 100, 250, 500, -1], [5, 10, 50, 100, 250, 500, "Todos"]],
        autoWidth: false,
        responsive: false,
        });




    $('#tblistaMat tbody').on('click', 'tr', function () {
    if ($(this).hasClass('selected')) {
        table.$('tr.selected').removeClass('selected');
        document.getElementById("txtNomeMat").value  = ""
        document.getElementById("txtLoteIpen").value  = ""
        document.getElementById("txtValidade").value  = ""
        document.getElementById("txtIdSolu").value  = ""
    }
    else {
        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        
        //dia = ($(this)[0].cells[6].innerText.substring(0,2)) 
        //mes = ($(this)[0].cells[6].innerText.substring(3,5)) 
        //ano = ($(this)[0].cells[6].innerText.substring(6,10)) 
        document.getElementById("txtIdSolu").value  = $(this)[0].cells[1].innerText
        document.getElementById("txtNomeMat").value  = $(this)[0].cells[2].innerText
        document.getElementById("txtLoteIpen").value  = $(this)[0].cells[3].innerText
        document.getElementById("txtValidade").value  =  $(this)[0].cells[4].innerText
        

    }
    });
});
</script>

<script>
qtdeNaoConforme = document.getElementById('spnConforme').innerText


function IncluiLimpCela(qs){
    var param = qs
    var usuario = document.getElementById('cmbTecnico').value
    var senha   = document.getElementById('m_txtSenha').value
    $.post("../functions.php",
       {gravalimpcela: qs,
        p_usuario: usuario,
        p_senha: senha
       },
       function(response){
           console.log(response);
       }
);

}    




</script>





