<?php include ('../functions.php')?>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formOperadores' id='formOperadores'  action=<?php echo $_SG['rf'] .'functions.php';?>  target="processarOPER" method="POST"  enctype="multipart/form-data">
                    <input type="hidden" id="pstnro" name="pstnro" value='<?php echo $_GET["pst_numero"] ?>' />
                    <div class="row">
                        <div class="col-md-3">
                            <span class="bg-blue form-control">Responsável Cálculo</span>
                            <?php echo CarregaTecnicoResponsavelNivel(2, 1); ?>
                            <?php echo CarregaTecnicoResponsavelNivel(2, 2); ?>
                            <?php echo CarregaTecnicoResponsavelNivel(2, 3); ?>
                        </div>
                        <div class="col-md-3">
                            <span class="bg-blue form-control">Responsável Pinça</span>
                            <?php echo CarregaTecnicoResponsavelNivel(1, 1); ?>
                            <?php echo CarregaTecnicoResponsavelNivel(1, 2); ?>
                            <?php echo CarregaTecnicoResponsavelNivel(1, 3); ?>
                        </div>
                        <div class="col-md-3">
                            <span class="bg-blue form-control">Responsável SAS</span>
                            <?php echo CarregaTecnicoResponsavelNivel(3, 1); ?>
                            <?php echo CarregaTecnicoResponsavelNivel(3, 2); ?>
                            <?php echo CarregaTecnicoResponsavelNivel(3, 3); ?>
                        </div>
                        <div class="col-md-3">
                            <span class="bg-blue form-control">Responsável Lacração</span>
                            <?php echo CarregaTecnicoResponsavelNivel(4, 1); ?>
                            <?php echo CarregaTecnicoResponsavelNivel(4, 2); ?>
                            <?php echo CarregaTecnicoResponsavelNivel(4, 3); ?>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            Técnico Operadores: <?php echo CarregaTecnico();  ?>
                        </div>
                        <div class="col-md-4">
                            Senha: <input type="password" name="txtSenha" id="txtSenha" class="form-control form-control-sm" maxlength="6" size="7" required />
                        </div>
                        <div class="col-md-3">
                        <br><button type="submit" name="btnGravaOper" id="btnGravaOper" class="btn btn-primary btn-sm" >GRAVAR</button>
                        </div>
                    </div>
                </form>
                <!-- fim do conteúdo -->
                <?php CarregaOperadores($_GET["pst_numero"]); ?>
                <iframe id="processarOPER" name="processarOPER" width="900px" height="400px" style="display:none"></iframe>
            </div>
        </div>
    </div>
</div>