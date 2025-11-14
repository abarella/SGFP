<?php include ('../functions.php')?>


<script>
    function calcperc(){
        p1 = document.getElementById("txtTotPedAtend").value
        p2 = document.getElementById("txtTotPedPrev").value
        document.getElementById("txtTotRend").value =  ((p1/p2)*100).toFixed(2)
        
    }


    /*
    function IncluiGQ(){
    var param = '1'
    $.ajax({ url: '../functions.php',
            data: {gravaRendProcesso:param},
            type: 'post',
            success: function() {
                toastApp(3000,'Registro Gravado com Sucesso','OK')
            },
            error: function() {
                toastApp(3000,'Erro ao gravar o registro','ERRO')
            }

    });	
    
}*/


</script>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formRendProcess' id='formRendProcess' action=<?php echo $_SG['rf'] .'functions.php';?>  target="processar" method="POST"  enctype="multipart/form-data" >
                    <input type="hidden" name="nrID" id="nrID" />
                    <div class="row">
                        <div class="col-md-3">
                            Total de Pedidos Atendidos<br>
                            <input type="number" id="txtTotPedAtend" name="txtTotPedAtend" class="form-control formcontrol-sm" step=1 oninput="calcperc()" onkeyup="calcperc()" />
                        </div>

                        <div class="col-md-3">
                            Total de Pedidos Previstos<br>
                            <input type="number" id="txtTotPedPrev" name="txtTotPedPrev" class="form-control formcontrol-sm"  step=1 oninput="calcperc()" onkeyup="calcperc()" />
                        </div>

                        <div class="col-md-4">
                            % Total Calculado<br>
                            <input type="number" id="txtTotRend" name="txtTotRend" class="form-control formcontrol-sm"  step=0.01   readonly/>
                        </div>

                    </div>

                    <?php RetornaRendProcesso(); ?>
                    
                    <br>


                    <div class="row">
                        <div class="col-md-4">
                            Técnico Rend Proc: <?php echo CarregaTecnico();  ?>
                            <?php RetornaRendProcesso(); ?>
                        </div>
                        <div class="col-md-4">
                            Senha: <input type="password" name="txtSenha" id="txtSenha" class="form-control form-control-sm" maxlength="6" size="7" required />
                        </div>
                        <div class="col-md-3">
                        <br><button type="submit"  class="btn btn-primary btn-sm"  name="gravaRendProcesso" name="gravaRendProcesso" >Gravar</button>
                        </div>
                    </div>
                </form>


                <iframe name="processar" id="processar" style="display:none"></iframe>

                <!-- fim do conteúdo -->
            </div>
        </div>
    </div>
</div>