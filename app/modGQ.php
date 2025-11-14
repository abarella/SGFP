<?php include ('../functions.php')?>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formLimpCela' id='formLimpCela'>
                    <div class="row">
                        <div class="col-md-4">
                            Técnico GQ: <?php echo CarregaTecnico();  ?>
                        </div>
                        <div class="col-md-4">
                            Senha: <input type="password" name="txtSenha" id="txtSenha" class="form-control form-control-sm" maxlength="6" size="7" required />
                        </div>
                        <div class="col-md-3">
                        <br><button type="button"  class="btn btn-primary btn-sm"  data-toggle="modal"  data-target="#ver" data-backdrop="static" data-keyboard="false">???</button>
                        </div>
                    </div>
                </form>
                <!-- fim do conteúdo -->
            </div>
        </div>
    </div>
</div>