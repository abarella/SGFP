<?php include ('../functions.php')?>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                
                <form name='formObservacoesRP' id='formObservacoesRP'  action=<?php echo $_SG['rf'] .'functions.php';?>  target="processarOBS" method="POST"  enctype="multipart/form-data">
                    <input type="hidden" id="pstnro1" name="pstnro1" value='<?php echo $_GET["pst_numero"] ?>' />
                    <div class="row">
                        <div class="col-md-12 bg-primary">
                            RESPONSÁVEL PELO GRUPO DE RADIOISÓTOPOS PRIMÁRIOS <label id="txtatualizacaoRP" name="txtatualizacaoRP" class="float-sm-right"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="txtObservacaoRP">Observação</label><br>
                                <textarea name='txtObservacaoRP' id='txtObservacaoRP' rows="3" cols="50" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="col-md-3">
                            <label for="cmbProcessoProdRP">Processo da Produção</label><br>
                                <select name='cmbProcessoProdRP' id='cmbProcessoProdRP' class="form-control form-control-sm">
                                    <?php CarregaProcProdRP(); ?>
                                </select>
                        </div>
                        <div class="col-md-3">
                            <label for="cmbResponsavelProdRP">Responsável</label><br>
                                <select name='cmbResponsavelProdRP' id='cmbResponsavelProdRP' class="form-control form-control-sm">
                                    <?php CarregaRespAreaRP(); ?>
                                </select>
                        </div>
                        <div class="col-md-1">
                            <label for="txtSenhaRP">Senha</label><br>
                                <input type="password" name="txtSenhaRP" id="txtSenhaRP" class="form-control form-control-sm" maxlength="6" size="7" required />
                        </div>
                        <div class="col-md-1">
                            <label for="btnGravaRP">&nbsp;</label><br>
                            <button type="submit" name="btnGravaRP" id="btnGravaRP"  class="btn btn-primary btn-sm" onclick="IncluiRP()" >Gravar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formObservacoesGQ' id='formObservacoesGQ' action=<?php echo $_SG['rf'] .'functions.php';?>  target="processarOBS" method="POST"  enctype="multipart/form-data">
                    
                    <input type="hidden" id="pstnro2" name="pstnro2" value='<?php echo $_GET["pst_numero"] ?>' />
                    <div class="row">
                        <div class="col-md-12 bg-primary">
                            RESPONSÁVEL PELO GRUPO DE GARANTIA DA QUALIDADE  <label id="txtatualizacaoGQ" name="txtatualizacaoGQ" class="float-sm-right"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="txtObservacaoGQ">Observação</label><br>
                                <textarea name='txtObservacaoGQ' id='txtObservacaoGQ' rows="3" cols="50" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="col-md-3">
                            <label for="cmbProcessoProdGQ">Liberação do Produto</label><br>
                                <select name='cmbProcessoProdGQ' id='cmbProcessoProdGQ' class="form-control form-control-sm">
                                    <option value="0">Selecione</option>
                                    <option value="1">SIM</option>
                                    <option value="2">NÃO</option>
                                </select>
                                
                        </div>
                        <div class="col-md-3">
                            <label for="cmbResponsavelProdGQ">Responsável</label><br>
                                <select name='cmbResponsavelProdGQ' id='cmbResponsavelProdGQ' class="form-control form-control-sm">
                                <?php CarregaRespAreaCQ(); ?>
                                </select>
                        </div>
                        <div class="col-md-1">
                            <label for="txtSenhaGQ">Senha</label><br>
                                <input type="password" name="txtSenhaGQ" id="txtSenhaGQ" class="form-control form-control-sm" maxlength="6" size="7" required />
                        </div>
                        <div class="col-md-1">
                            <label for="txtSenhaGQ">&nbsp;</label><br>
                            <button type="submit" name="btnGravaGQ" id="btnGravaGQ"  class="btn btn-primary btn-sm" onclick="IncluiGQ()" >Gravar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php CarregaDadosRP($_GET['pst_numero']); ?>
<?php CarregaAtualizacaoRP($_GET['pst_numero']); ?>


<iframe name="processarOBS" id="processarOBS" style="display:none"></iframe>
<script>

function IncluiGQ(){
    var param = '1'
    $.ajax({ url: '../functions.php',
            data: {gravaGQ:param},
            type: 'post',
            success: function() {
                toastApp(3000,'Registro Gravado com Sucesso','OK')
            },
            error: function() {
                toastApp(3000,'Erro ao gravar o registro','ERRO')
            }

    });	
}

function IncluiRP(){
    var param = '1'
    $.ajax({ url: '../functions.php',
            data: {gravaRP:param},
            type: 'post',
            success: function() {
                toastApp(3000,'Registro Gravado com Sucesso','OK')
            },
            error: function() {
                toastApp(3000,'Erro ao gravar o registro','ERRO')
            }

    });	
}


</script>