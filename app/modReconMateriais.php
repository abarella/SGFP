<?php include ('../functions.php')?>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formReconMat' id='formReconMat'>

                    <div class="row" style="background-color:#afcfd1; border-radius: 10px;">
                        <div class="col-md-4 ">
                            <label id='nome1'>teste</label>
                        </div>
                        <div class="col-md-4 ">
                            <label id='valor1'>123</label>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="background-color:#afcfd1; border-radius: 10px;">
                        <div class="col-md-4 ">
                            <label id='nome2'>teste</label>
                        </div>
                        <div class="col-md-4">
                            <label id='valor2'>123</label>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="background-color:#afcfd1; border-radius: 10px;">
                        <div class="col-md-4">
                            <label id='nome3'>teste</label>
                        </div>
                        <div class="col-md-4">
                            <label id='valor3'>123</label>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="background-color:#afcfd1; border-radius: 10px;">
                        <div class="col-md-4 ">
                            <label id='nome4'>teste</label>
                        </div>
                        <div class="col-md-4 ">
                            <label id='valor4'>123</label>
                        </div>
                    </div>

                    <?php echo CarregaReconMat(); ?>

                    <br><br>
                    <div class="row">
                        <div class="col-md-4">
                            Técnico Recon Materiais: <?php echo CarregaTecnico();  ?>
                        </div>
                        <div class="col-md-4">
                            Senha: <input type="password" name="txtSenha" id="txtSenha" class="form-control form-control-sm" maxlength="6" size="7" required />
                        </div>
                        <div class="col-md-3">
                        <br><button type="button"  class="btn btn-primary btn-sm"  data-toggle="modal"  data-target="#ver" data-backdrop="static" data-keyboard="false">Gravar</button>
                        </div>
                    </div>
                </form>
                <!-- fim do conteúdo -->
            </div>
        </div>
    </div>
</div>