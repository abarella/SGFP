<?php include("../header.php"); ?>

<?php  
    $_lote = $_REQUEST['lote'];  
    $lote = substr($_lote,0,3);
    $serie= substr($_lote,4,1);
    $ano = $_REQUEST['ano'];
    $prod = $_REQUEST['produto'];
?>


<section id="main-content">
    <?php
        include("../lib/DB.php");
        $query = "exec crsa.uspPPST_PRODUCAO_LISTA ".$ano.",'" . $prod. "','". $lote."', '".$serie."'";
        $stmt = $conn->query($query);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $fabricacao = $row[GQ_data];
            $calibracao = $row[calibracao];
            $validade = $row[validade];
            $pst_numero = $row[pst_numero];
            $nome_comercial = $row[nome_comercial];

        }
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 card bg-primary text-white bg-gradient">Lote:<br><?php echo $_lote; ?></div>
                        <div class="col-md-2 card bg-primary text-white bg-gradient">Pasta:<br><?php echo $pst_numero; ?></div>
                        <div class="col-md-2 card bg-primary text-white bg-gradient">Produto:<br><?php echo $nome_comercial; ?></div>
                        <div class="col-md-2 card bg-primary text-white">Fabricação:<br><?php echo $fabricacao; ?></div>
                        <div class="col-md-2 card bg-primary text-white">Calibração:<br><?php echo $calibracao; ?></div>
                        <div class="col-md-2 card bg-primary text-white">Validade:<br><?php echo $validade; ?></div>
                    </div>
                    <!-- Nav tabs -->
                    <div class="btn-group btn-block btn-flat ">
                        <button type="button" id="f01" class="btn btn-info btn-xs">Limpeza da Cela</button>
                        <button type="button" id="f02" class="btn btn-outline-info btn-xs">Liber. Área de Trabalho</button>
                        <button type="button" id="f03" class="btn btn-outline-info btn-xs">Embalagem Primária</button>
                        <button type="button" id="f04" class="btn btn-outline-info btn-xs">Equipamentos</button>
                        <button type="button" id="f05" class="btn btn-outline-info btn-xs">Materiais</button>
                        <button type="button" id="f06" class="btn btn-outline-info btn-xs">Inf. Radioisótopos</button>
                        <button type="button" id="f07" class="btn btn-outline-info btn-xs">Pedido Interno</button>
                        <button type="button" id="f08" class="btn btn-outline-info btn-xs">Diluições</button>
    				</div>
	    			<div class="btn-group btn-block btn-flat">
                        <button type="button" id="f09" class="btn btn-outline-info btn-xs">Reconciliação Materiais</button>
                        <button type="button" id="f10" class="btn btn-outline-info btn-xs">Rendimento do Processo</button>
                        <button type="button" id="f11" class="btn btn-outline-info btn-xs">Operadores Participantes</button>
                        <button type="button" id="f12" class="btn btn-outline-info btn-xs">Observações</button>
                        <button type="button" id="f13" class="btn btn-outline-info btn-xs">Fracionamento Cliente</button>
                        <button type="button" id="f14" class="btn btn-outline-info btn-xs">Solicitadas</button>
                        <button type="button" id="f15" class="btn btn-outline-info btn-xs">R. D.</button>
                        <button type="button" id="f16" class="btn btn-outline-info btn-xs">G. Q.</button>
				    </div>
                    
                    <div id="contents"></div>
                    
                    <?php require("../footer.php"); ?>
                </div>
                    
            </div>

        </div>
        <!--<iframe id="processar" name="processar" width="100%" style="display:none;" ></iframe>-->
    </div>

                                      
</section>



<?php include("../include/script.php"); ?>

<script>
    $(document).ready(function(){
        $("#f01").click(function(){
            $("#contents").load('Equipamentos.php?pst_numero=26971');
        });
    });
</script>
