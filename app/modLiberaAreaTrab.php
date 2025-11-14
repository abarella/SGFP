<?php include ('../functions.php')?>

<script>
    function fu_detdoc(n){
        if (n==1){
            doc1.style="display:inline"
            doc2.style="display:none"
        }
        if (n==2){
            doc1.style="display:none"
            doc2.style="display:inline"
        }
    }
</script>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formLibAreaTrab' action=<?php echo $_SG['rf'] .'functions.php';?>  target="processar" method="POST">
                    <input type='hidden' id="tpst_numero" name="tpst_numero" value="<?php echo $_GET['pst_numero']; ?>" />
                    <input type='hidden' id="produto" name="produto" value="<?php echo $_GET['produto']; ?>" />
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tblista" class="table compact table-striped table-bordered nowrap" style="width:100%; font-size:12px; font-family: Tahoma">
                                <?php echo RetornaLiberaArea($pst_numero); ?>
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
                            <br><button type="submit" name='GravaLiberaArea' id='GravaLiberaArea'  class="btn btn-primary btn-sm"  >Atualizar</button>
                                
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



<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formEmbPrim' action=<?php echo $_SG['rf'] .'functions.php';?>  target="processar" method="POST">
                    <input type='hidden' id="tpst_numero" name="tpst_numero" value="<?php echo $_GET['pst_numero']; ?>" />
                    <input type='hidden' id="produto" name="produto" value="<?php echo $_GET['produto']; ?>" />
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


<!-- modal -->
<div class="modal fade " id="modalDoc" tabindex="-1" role="dialog" aria-labelledby="1ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eqpModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color:#e8eff9;">
        <embed src="..\\Docs\\FM-DIRF-0901-04.pdf"    frameborder="0" width="100%" height="600px" id="doc1">
        <embed src="..\\Docs\\FM-DIRF-0901.02-01.pdf" frameborder="0" width="100%" height="600px" id="doc2">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id='btnClose'  data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>



