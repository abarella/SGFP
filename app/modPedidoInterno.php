<?php include ('../functions.php')?>



<script>
        MDc = document.getElementById("MasterDatCalibracao").value
        ano = MDc.substring(6,10)+'-'
        mes = MDc.substring(3,5)+'-'
        dia = MDc.substring(0,2)+' '
        hor = MDc.substring(11,16)

        


    function carregaDtaCalib(ln){
        
        document.getElementById("txtDat"+ln).value = ano+mes+dia+hor
        document.getElementById("txtDatTotal").value = ano+mes+dia+hor
        
        
        if  (
            (document.getElementById("txtAtv"+ln).value=='' || document.getElementById("txtAtv"+ln).value=='0') &&
            (document.getElementById("txtVol"+ln).value=='' || document.getElementById("txtVol"+ln).value=='0.00')
            )
        {
            document.getElementById("txtDat"+ln).value =''
        }
        



        calculaTotal()
    }

    function roundToTwo(num) {
        return +(Math.round(num + "e+2")  + "e-2");
    }
    function calculaTotal(){

        aMM = parseFloat('0')
        aCP = parseFloat('0')
        aPQ = parseFloat('0')
        vMM = parseFloat('0')
        vCP = parseFloat('0')
        vPQ = parseFloat('0')
        aMM = parseFloat(document.getElementById("txtAtvMM").value)
        aCP = parseFloat(document.getElementById("txtAtvCAPS").value)
        aPQ = parseFloat(document.getElementById("txtAtvPesq").value)
        aTT = aMM+aCP+aPQ
        document.getElementById("txtAtvTotal").value = aTT

        vMM = parseFloat(document.getElementById("txtVolMM").value)
        vCP = parseFloat(document.getElementById("txtVolCAPS").value)
        vPQ = parseFloat(document.getElementById("txtVolPesq").value)
        vTT = roundToTwo(vMM+vCP+vPQ)
        document.getElementById("txtVolTotal").value = vTT





    }

</script>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formPedidoInterno' id='formPedidoInterno' action='..\functions.php' method="POST" target='processaPI'>
                    <input type='hidden' name='tpstnumero' id='tpstnumero' value="<?php echo $_GET['pst_numero']; ?>" />
                    <div class="row">
                        <div class="col-md-3 form-control form-control-sm bg-primary">Destino</div>
                        <div class="col-md-3 form-control form-control-sm bg-primary">Atividade (mCi)</div>
                        <div class="col-md-3 form-control form-control-sm bg-primary">Volume (mL)</div>
                        <div class="col-md-3 form-control form-control-sm bg-primary">Data</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 form-control form-control-sm bg-primary">Moléculas Marcadas</div>
                        <div class="col-md-3 "><input type='number' class='form-control form-control-sm minZero'  id='txtAtvMM' name='txtAtvMM'  onchange="carregaDtaCalib('MM')" value="0"    step="1"    min=0   /></div>
                        <div class="col-md-3 "><input type='number' class='form-control form-control-sm minZero2' id='txtVolMM' name='txtVolMM'  onchange="carregaDtaCalib('MM')" value="0.00" step="0.01" min=0 /></div>
                        <div class="col-md-3 "><input type='datetime-local' class='form-control form-control-sm'  id='txtDatMM' name='txtDatMM' readonly /></div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 form-control form-control-sm bg-primary">CAPS-IPEN</div>
                        <div class="col-md-3 "><input type='number' class='form-control form-control-sm minZero' id='txtAtvCAPS' name='txtAtvCAPS' onmouseup="carregaDtaCalib('CAPS')" onkeyup="carregaDtaCalib('CAPS')" value="0" step="1" /></div>
                        <div class="col-md-3 "><input type='number' class='form-control form-control-sm minZero2' id='txtVolCAPS' name='txtVolCAPS' onmouseup="carregaDtaCalib('CAPS')" onkeyup="carregaDtaCalib('CAPS')" value="0.00" step="0.01" /></div>
                        <div class="col-md-3 "><input type='datetime-local' class='form-control form-control-sm'  id='txtDatCAPS' name='txtDatCAPS'  readonly/></div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 form-control form-control-sm bg-primary">Pequisa</div>
                        <div class="col-md-3 "><input type='number' class='form-control form-control-sm minZero' id='txtAtvPesq' name='txtAtvPesq' onmouseup="carregaDtaCalib('Pesq')" onkeyup="carregaDtaCalib('Pesq')" value="0" step="1"   /></div>
                        <div class="col-md-3 "><input type='number' class='form-control form-control-sm minZero2' id='txtVolPesq' name='txtVolPesq' onmouseup="carregaDtaCalib('Pesq')" onkeyup="carregaDtaCalib('Pesq')" value="0.00" step="0.01" /></div>
                        <div class="col-md-3 "><input type='datetime-local' class='form-control form-control-sm'  id='txtDatPesq' name='txtDatPesq'  readonly/></div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 form-control form-control-sm bg-primary">Total Enviado</div>
                        <div class="col-md-3 "><input type='number' class='form-control form-control-sm minZero' id='txtAtvTotal' name='txtAtvTotal' value="0" step="1"  readonly /></div>
                        <div class="col-md-3 "><input type='number' class='form-control form-control-sm minZero2' id='txtVolTotal' name='txtVolTotal' value="0.00" step="0.01"  readonly /></div>
                        <div class="col-md-3 "><input type='datetime-local' class='form-control form-control-sm' id='txtDatTotal' name='txtDatTotal'  readonly/></div>
                    </div>




                    <br><br>
                    <div class="row">
                        <div class="col-md-4">
                            Técnico: <?php echo CarregaTecnico();  ?>
                        </div>
                        <div class="col-md-4">
                            Senha: <input type="password" name="txtSenha" id="txtSenha" class="form-control form-control-sm" maxlength="6" size="7" required />
                        </div>
                        <div class="col-md-3">
                        <br><button type="submit"  class="btn btn-primary btn-sm" name='gravaPedidoInterno' id='gravaPedidoInterno' >Salvar</button>
                        </div>
                    </div>
                </form>
                <?php echo CarregaPedidoInterno($_GET['pst_numero']);  ?>
                <!-- fim do conteúdo -->
                
                <iframe id='processaPI' name='processaPI' style="display:none"></iframe>
                <?php include("../footer.php");?>
            </div>
        </div>
    </div>
</div>

<script>
        $(".minZero").blur(function () {
            if ($(this).val() == "") {
                $(this).val(0);
            } 
        })

        $(".minZero2").blur(function () {
            if ($(this).val() == "") {
                $(this).val('0.00');
            } 
        })

</script>