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
            $fabricacao = $row['GQ_data'];
            $calibracao = $row['calibracao'];
            $validade = $row['validade'];
            $pst_numero = $row['pst_numero'];
            $nome_comercial = $row['nome_comercial'];

        }
    ?>

<script>
    function fu_abreVol(){
        pstnumero = '<?php echo $_GET['pst_numero']; ?>'
        produto =  '<?php echo $_GET['produto']; ?>'
        const windowFeatures = "left=0,top=0,width=940px,height=620";

        if (produto=="rd_i131"){
            window.open("<?php echo $_SESSION['PATH_RELATORIO']; ?>" +"/0300-RADIOFARMACIA/01-SGCR/01-FOLHADEPRODUCAO/02-IODO/RelatProducaoIODO&pst_numero="+pstnumero+"&rs:Command=Render", "vcd")
            
        }
        if (produto=="rd_tl"){
            window.open("<?php echo $_SESSION['PATH_RELATORIO']; ?>" +"ACPT272T?pst_numero="+pstnumero+"&rs:Command=Render", "vcd")
        }

    }


    function fu_abreRepProd(){
        pstnumero = '<?php echo $_GET['pst_numero']; ?>'
        produto =  '<?php echo $_GET['produto']; ?>'
        if (produto=="rd_i131"){
            window.open("<?php echo $_SESSION['PATH_RELATORIO']; ?>" +"/0300-RADIOFARMACIA/01-SGCR/01-FOLHADEPRODUCAO/02-IODO/RelatProducaoIODO&pst_numero="+pstnumero+"&rs:Command=Render", "vcd")
        }
        if (produto=="rd_tl"){

            window.open("<?php echo $_SESSION['PATH_RELATORIO']; ?>" +"/0300-RADIOFARMACIA/01-SGCR/01-FOLHADEPRODUCAO/03-TALIO/RelatProducaoTALIO&pst_numero="+pstnumero+"&rs:Command=Render", "vcd")
        }



    }

</script>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <input type='hidden' id='txtIdCela' name='txtIdCela' />
                        <div class="col-md-1 card bg-primary text-white bg-gradient">Lote:<br><?php echo $_lote; ?></div>
                        <div class="col-md-1 card bg-primary text-white bg-gradient">Pasta:<br><?php echo $pst_numero; ?></div>
                        <div class="col-md-2 card bg-primary text-white bg-gradient">Produto:<br><?php echo $nome_comercial; ?></div>
                        <div class="col-md-2 card bg-primary text-white">Fabricação:<br><?php echo $fabricacao; ?></div>
                        <div class="col-md-2 card bg-primary text-white">Calibração:<br><?php echo $calibracao; ?></div>
                        <div class="col-md-2 card bg-primary text-white">Validade:<br><?php echo $validade; ?>
                            <input type="hidden" id="cabecFabric" value="<?php  echo $fabricacao; ?>"> 
                            <input type="hidden" id="cabecCalib" value="<?php  echo $calibracao; ?>"> 
                            <input type="hidden" id="cabecValidade" value="<?php  echo $validade; ?>"> 
                            
                        </div>
                        <div class="col-md-2 card bg-primary text-white ">
                            <input type="button" data-toggle='tooltip' data-placement='top' title='Relatório de Produção' class="fas fa-print fa-2x" style="color:#fff;" value="" onclick="fu_abreRepProd()">
                        </div>
                        <input type='hidden' name='MasterDatCalibracao' id='MasterDatCalibracao' value= "<?php echo $calibracao; ?>" />
                    </div>
                    <?php include("navFolha.php");?>
                </div>
            </div>
        </div>
    </div>
    
</section>