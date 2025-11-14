<?php include ('../functions.php')?>





<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formLibAreaTrab' action=<?php echo $_SG['rf'] .'functions.php';?>  target="processar" method="POST">
                    <input type='hidden' id="tpst_numero" name="tpst_numero" value="<?php echo $_GET['pst_numero']; ?>" />
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tblista" class="table compact table-striped table-bordered nowrap" style="width:100%; font-size:12px; font-family: Tahoma">
                                <?php echo RetornaEmbalagemPrimaria($pst_numero); ?>
                            </table>
                        </div>
                    </div>

                    <br><br>

                    <div class="row">
                        <div class="col-md-5">&nbsp;</div>
                        <div class="col-md-1">
                            Senha: <input type="password" name="txtSenha" id="txtSenha" class="form-control form-control-sm" maxlength="6" size="7" required />
                        </div>
                        <div class="col-md-1">
                            <br><button type="submit" name='GravaEmbPrimaria' id='GravaEmbPrimaria'  class="btn btn-primary btn-sm"  >Atualizar</button>
                                
                        </div>
                        <div class="col-md-5">&nbsp;
                        </div>
                    </div>
                </form>
                <!-- fim do conteúdo -->
            </div>
        </div>
    </div>
</div>

<iframe id='processar' name='processar' style='display:none'></iframe>



