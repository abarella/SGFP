<?php include ('../functions.php')?>

<script>
$('select').selectpicker();
    function fu_calcDecaimento(fator){
        oper = document.getElementById('txtOperacao').value;
        if (oper = '1')
        {
            document.getElementById('Fator1').value = fator
            fu_calcula1()
        }

        $('#modDecaimento').modal('hide');

    }
    
    function fu_calcula1(){
        v1 = document.getElementById('ConcRadio1').value
        v2 = document.getElementById('Fator1').value
        v3 = document.getElementById('Ativ1').value
        v4 = document.getElementById('Volume1').value
        document.getElementById('CR1').value = v1*37*v2
        document.getElementById('Volume1').value = (v3/(v1*37*v2)).toFixed(2)
    }

    function fu_calcula2(){
        v1 = document.getElementById('ConcRadio2').value
        v2 = document.getElementById('Fator2').value
        v3 = document.getElementById('Ativ2').value
        v4 = document.getElementById('Volume2').value
        document.getElementById('CR2').value = v1*37*v2
        document.getElementById('Volume2').value = (v3/(v1*37*v2)).toFixed(2)
    }

    function fu_calcula3(){
        v1 = document.getElementById('ConcRadio3').value
        v2 = document.getElementById('Fator3').value
        v3 = document.getElementById('Ativ3').value
        v4 = document.getElementById('Volume3').value
        document.getElementById('CR3').value = v1*37*v2
        document.getElementById('Volume3').value = (v3/(v1*37*v2)).toFixed(2)
    }

    function fu_calcula4(){
        v1 = document.getElementById('ConcRadio4').value
        v2 = document.getElementById('Fator4').value
        v3 = document.getElementById('Ativ4').value
        v4 = document.getElementById('Volume4').value
        document.getElementById('CR4').value = v1*37*v2
        document.getElementById('Volume4').value = (v3/(v1*37*v2)).toFixed(2)
    }





    function fu_SelDecaimento(){
        alert()

    }



    function somaFornec(){
        
        


        for (let y = 0; y <= 3; y++) {
            g=y+1
            let Fcalcq = 0
            let passoq = 0

            let Fcalcv = 0
            let passov = 0.00

            for (let i = 0; i <= 50; i++) {
                v = i+1
                nomeq = 'txtSolPrinQto'+v+'_'+g
                nomev = 'txtSolPrinVol'+v+'_'+g
                if (document.getElementById(nomeq) === null){
                    passoq = 0
                }
                else{
                    passoq = ~~document.getElementById(nomeq).value
                    //console.log(passoq)
                }
                Fcalcq += parseFloat(passoq)

                //----------------------------------------------------------------

                if (document.getElementById(nomev) === null){
                    passov = 0.00
                    //console.log('passov zero = '+passov)
                }
                else{
                    passov = document.getElementById(nomev).value
                    console.log('passov = '+passov)
                }
                Fcalcv += parseFloat(passov)
            }
            document.getElementById('txtSolPrinQto'+g).value = Fcalcq
            document.getElementById('txtSolPrinVol'+g).value = Fcalcv.toFixed(2)

        }




    }





    function fu_detfornsel(dilu){
            // carrada após o load page
            _sel = 'txtSolPrinForn'+dilu +'[]'
            var selected = [];
            var selectedval = [];
            for (var option of document.getElementById(_sel).options)
            {
                if (option.selected) {
                    selected.push(option.value);
                    selectedval.push(option.innerHTML);
                }
            }
            document.getElementById('divqtsol'+dilu).innerHTML=""
            document.getElementById('divqtvol'+dilu).innerHTML=""
            document.getElementById('divqtnom'+dilu).innerHTML=""


            for (x=1;x<=selected.length;x++){
                document.getElementById('divqtsol'+dilu).innerHTML += "<input type='number'         class='form-control form-control-sm'                               name='txtSolPrinQto"+x+"_"+dilu+"' id='txtSolPrinQto"+x+"_"+dilu+"' step='1' onchange='somaFornec()' value='0' /> mCi"    
                document.getElementById('divqtvol'+dilu).innerHTML += "<input type='number'         class='form-control form-control-sm'                               name='txtSolPrinVol"+x+"_"+dilu+"' id='txtSolPrinVol"+x+"_"+dilu+"' step='0.01' onchange='somaFornec()' value='0.00' /> mL"
                document.getElementById('divqtnom'+dilu).innerHTML += "<input type='text'  readonly class='form-control form-control-sm bg-info' style='direction:rtl' name='txtNomeForn"+x+"_"+dilu+"'   id='txtNomeForn"+x+"_"+dilu+"' value='"+selectedval[x-1] +"' />&nbsp;"
            }
            
            fu_popforn(dilu)

    }



    function fu_popforn(dilu){
        let tq =  document.getElementById('ttxtfornQtoARR'+dilu).value
        let tv =  document.getElementById('ttxtfornVolARR'+dilu).value
        var tqA = tq.split('|')
        var tvA = tv.split('|')

        for (var x=1; x<= tqA.length; x++){
            document.getElementById('txtSolPrinQto'+x+'_'+dilu).value = tqA[x-1]
            document.getElementById('txtSolPrinVol'+x+'_'+dilu).value = tvA[x-1]
        }


    }




</script>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formDiluicoes' id='formDiluicoes' action='../functions.php' method='post' target='processarDILU' novalidate>
                    <div class="row">
                        <div class="col-md-12">
                            <input type='hidden' name='txtOperacao' id='txtOperacao' />
                            <input type='hidden' name='txtFatorDec' id='txtFatorDec' />
                            <div id="accordion"  role="tablist" aria-multiselectable="true">

<!-- Importado -->
                                <div class="card d-none">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapseImportado">
                                        <b>Importado</b>
                                        </a>
                                    </div>
                                    <div id="collapseImportado" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <fieldset class="form-group border p-2">
                                                    <legend class="w-auto px-2 h6">Importado</legend>

                                                    <input type='hidden' id='tot_atv_imp' name='tot_atv_imp' />
                                                    <input type='hidden' id='tot_vol_imp' name='tot_vol_imp' />
                                                    <input type='hidden' id='tot_atvc_imp' name='tot_atvc_imp' />
                                                    <table class="grid table-bordered" style="width:100%" >
                                                        <tr class='bg-blue'>
                                                            <td class="text-center">Funções</td>
                                                            <td class="text-center">Identificação</td>
                                                            <td class="text-center">Atividade (GBq)</td>
                                                            <td class="text-center">Volume (mL)</td>
                                                            <td class="text-center">Calibração para</td>
                                                            <td class="text-center">Ativ. Corrigida p/ dt. calibração (mCi)</td>
                                                        </tr>
                                                        <?php echo CarregaCalculosImportado(0,2); ?>
                                                    </table><br>
                                                        <div class="row">
                                                            <div class="col-md-4"><div class="card">Atividade Total:<label class="text-center" id='IMPtotatv'  name='IMPtotatv'></label></div></div>
                                                            <div class="col-md-4"><div class="card">Volume Total:<label class="text-center" id='IMPtotvol'  name='IMPtotvol'></label></div></div>
                                                            <div class="col-md-4"><div class="card">Atividade Corrigida:<label class="text-center" id='IMPtotatvc' name='IMPtotatvc'></label></div></div>
                                                            <script>
                                                                document.getElementById('IMPtotatv').innerHTML = document.getElementById('tot_atv_imp').value
                                                                document.getElementById('IMPtotvol').innerHTML = document.getElementById('tot_vol_imp').value
                                                                document.getElementById('IMPtotatvc').innerHTML = document.getElementById('tot_atvc_imp').value
                                                            </script>
                                                        </div>
                                                    </table>
                                                    </fieldset>
                                                </div>

                                                <div class="col-md-6">
                                                    <fieldset class="form-group border p-2">
                                                    <legend class="w-auto px-2 h6">Medido</legend>

                                                    <input type='hidden' id='tot_atv_med' name='tot_atv_med' />
                                                    <input type='hidden' id='tot_vol_med' name='tot_vol_med' />
                                                    <input type='hidden' id='tot_atvc_med' name='tot_atvc_med' />
                                                    <table class="grid table-bordered" style="width:100%" >
                                                        <tr class='bg-blue'>
                                                            <td class="text-center">Funções</td>
                                                            <td class="text-center">Identificação</td>
                                                            <td class="text-center">Atividade (mCi)</td>
                                                            <td class="text-center">Volume (mL)</td>
                                                            <td class="text-center">Calibração para</td>
                                                            <td class="text-center">Ativ. Corrigida p/ dt. calibração (mCi)</td>
                                                        </tr>
                                                        <?php echo CarregaCalculosImportado(0,3); ?>
                                                    </table><br>
                                                        <div class="row">
                                                            <div class="col-md-4"><div class="card">Atividade Total:<label class="text-center" id='MEDtotatv'  name='MEDtotatv'></label></div></div>
                                                            <div class="col-md-4"><div class="card">Volume Total:<label class="text-center" id='MEDtotvol'  name='MEDtotvol'></label></div></div>
                                                            <div class="col-md-4"><div class="card">Atividade Corrigida:<label class="text-center" id='MEDtotatvc' name='MEDtotatvc'></label></div></div>
                                                            <script>
                                                                document.getElementById('MEDtotatv').innerHTML = document.getElementById('tot_atv_med').value
                                                                document.getElementById('MEDtotvol').innerHTML = document.getElementById('tot_vol_med').value
                                                                document.getElementById('MEDtotatvc').innerHTML = document.getElementById('tot_atvc_med').value
                                                            </script>
                                                        </div>
                                                    </table>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<!-- Importado FIM -->

<!-- Produção Ipen -->
                                <div class="card  d-none">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapseProdIpen">
                                        <b>Produção IPEN</b>
                                        </a>
                                    </div>
                                    <div id="collapseProdIpen" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <table class="grid table-bordered" style="width:500px" >
                                                <tr class='bg-blue'>
                                                    <td class="text-center">Atividade</td>
                                                    <td class="text-center">Volume</td>
                                                    <td class="text-center">Calibração</td>
                                                    <td class="text-center">Ativ. Corrigida</td>
                                                </tr>
                                                <?php echo CarregaProducaoIpen(); ?>
                                            </table><br>
                                        </div>
                                    </div>
                                </div>


                                <div class="card  d-none">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapseSobras">
                                        <b>Sobras</b>
                                        </a>
                                    </div>
                                    <div id="collapseSobras" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                        <table class="grid table-bordered" style="width:100%" >
                                            <tr class='bg-blue'>
                                                <td class="text-center">Funções</td>
                                                <td class="text-center">Lote e Série</td>
                                                <td class="text-center">Atividade Medida (mCi)</td>
                                                <td class="text-center">Volume (mL)</td>
                                                <td class="text-center">CR (mCi / mL)</td>
                                                <td class="text-center">Data</td>
                                                <td class="text-center">Ativ. Corrigida p/ dt. calibração (mCi)</td>
                                            </tr>
                                            <?php echo CarregaSobras(); ?>
                                        </table><br>
                                            
                                        </div>
                                    </div>
                                </div>
<!-- Produção Ipen FIM -->

<!-- Calculos -->
                                <div class="card  d-none"> 
                                        <div class="card-header">
                                            <a class="collapsed card-link" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne" href="#collapseCalculos">
                                            <b>Cálculos</b>
                                            </a>
                                        </div>
                                        <div id="collapseCalculos" class="collapse show"  data-parent="#accordion">
                                            <div class="card-body">
                                                <input type='hidden' id='p641_PincaRsp' name='p641_PincaRsp'/>
                                                <input type='hidden' id='p641_CalculoRsp' name='p641_CalculoRsp'/>
                                                <input type='hidden' id='p641_sasRsp' name='p641_sasRsp'/>
                                                <input type='hidden' id='p641_lacracaoRsp' name='p641_lacracaoRsp'/>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label for="txtCalcDtProducao">Data Produção</label>
                                                        <input type="datetime-local" id="txtCalcDtProducao" name="txtCalcDtProducao" class="form-control form-control-sm" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtCalcDtCalibracao">Data Calibração</label>
                                                        <input type="datetime-local" id="txtCalcDtCalibracao" name="txtCalcDtCalibracao" class="form-control form-control-sm" />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="txtCalcDistribPart">Distribuição (partidas)</label>
                                                        <input type="text" id="txtCalcDistribPart" name="txtCalcDistribPart" class="form-control form-control-sm" readonly/>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="txtCalcDistribAtvTot">Distribuição (atividade total) mCi</label>
                                                        <input type="text" id="txtCalcDistribAtvTot" name="txtCalcDistribAtvTot" class="form-control form-control-sm" readonly/>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <br>
                                                        <table class="grid table-bordered" style="width:100%" >
                                                            <tr class='bg-blue'>
                                                                <td class="text-center">MEDIDO</td>
                                                                <td class="text-center">Atividade Total (mCi)</td>
                                                                <td class="text-center">Volume Total (mL)</td>
                                                                <td class="text-center">Data</td>
                                                                <td class="text-center">Fator</td>
                                                                <td class="text-center">Atividade Corrigida (mCi)</td>
                                                            </tr>
                                                            <tr class='bg-blue'>
                                                                <td>Importado</td>
                                                                <td class='bg-white text-right '><label id="p641_imp_atvm">0,00</label></td>
                                                                <td class='bg-white text-right '><label id="p641_imp_volm">0,00</label></td>
                                                                <td class='bg-white text-center'><label id="p641_imp_datam">&nbsp;</label></td>
                                                                <td class='bg-white text-right '><label id="p641_imp_fatorm">0,0000</label></td>
                                                                <td class='bg-white text-right '><label id="imp_corrigido">0,00</label></td>
                                                            </tr>
                                                            <tr class='bg-blue'>
                                                                <td>Produção Ipen</td>
                                                                <td class='bg-white text-right '><label id="p641_ipen_atvm">0,00</label></td>
                                                                <td class='bg-white text-right '><label id="p641_ipen_volm">0,00</label></td>
                                                                <td class='bg-white text-center'><label id="p641_ipen_datam">&nbsp;</label></td>
                                                                <td class='bg-white text-right '><label id="p641_ipen_fatorm">0,0000</label></td>
                                                                <td class='bg-white text-right '><label id="ipen_corrigido">0,00</label></td>
                                                            </tr>
                                                            <tr class='bg-blue'>
                                                                <td>Sobras</td>
                                                                <td class='bg-white text-right '><label id="p641_Sb_atvm">0,00</label></td>
                                                                <td class='bg-white text-right '><label id="p641_Sb_Volm">0,00</label></td>
                                                                <td class='bg-white text-center'><label id="p641_sb_datam">&nbsp;</label></td>
                                                                <td class='bg-white text-right '><label id="p641_Sb_Fatorm">0,0000</label></td>
                                                                <td class='bg-white text-right '><label id="sobras_corrigido">0,00</label></td>
                                                            </tr>
                                                            <?php echo CarregaCalculos(); ?>

                                                        </table>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-3"><b>Responsável Pinça</b>
                                                        <?php echo CarregaTecnicoResponsavel(1); ?>
                                                    </div>
                                                    <div class="col-md-3"><b>Responsável Cálculo</b>
                                                        <?php echo CarregaTecnicoResponsavel(2); ?>
                                                    </div>
                                                    <div class="col-md-3"><b>Responsável SAS</b>
                                                        <?php echo CarregaTecnicoResponsavel(3); ?>
                                                    </div>
                                                    <div class="col-md-3"><b>Responsável Lacração</b>
                                                        <?php echo CarregaTecnicoResponsavel(4); ?>
                                                    </div>
                                                </div>
                                                    <script>
                                                        document.getElementById("cmbPinca").value = document.getElementById("p641_PincaRsp").value
                                                        document.getElementById("cmbCalculo").value = document.getElementById("p641_CalculoRsp").value
                                                        document.getElementById("cmbSAS").value = document.getElementById("p641_sasRsp").value
                                                        document.getElementById("cmbLacracao").value = document.getElementById("p641_lacracaoRsp").value
                                                        
                                                        
                                                    </script>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="cmbTecnicoCalc">Técnico Operador</label>
                                                        <?php echo CarregaTecnicoResponsavel(5);  ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="txtSenhaCalc">Senha</label>
                                                        <input type="password" name="txtSenhaCalc" id="txtSenhaCalc" class="form-control form-control-sm" maxlength="6" size="7" novalidate  />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <br><button type="submit" id='gravaCalc' name='gravaCalc' class="btn btn-primary btn-sm" >&nbsp;&nbsp;OK&nbsp;&nbsp;</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

<!-- Calculos FIM -->

<!-- campos comuns para diluições -->
    <input type='hidden' name='ttxtPst_Numero' id='ttxtPst_Numero' value='<?php echo $_GET['pst_numero'] ?>' />
    <input type='hidden' name='ttxt_Produto' id='ttxt_Produto' value='<?php echo $_GET['produto'] ?>' />
    <input type='hidden' name='ttxtLote' id='ttxtLote' value='<?php echo $_GET['lote'] ?>' />
<!-- campos comuns para diluições FIM -->

<!-- diluição 1  -->
    <!--<form name='formDiluicoes1' id='formDiluicoes1' action='../functions.php' method='POST' target='processarDILU'>-->
                                <div class="card">
                                    <div class="card-header collapsed">
                                        <a class="card-link " data-toggle="collapse" href="#collapse1"><b>Diluição #1 Previsto de 50 a 200 mCi (1850 a 7400 MBq)</b></a>
                                    </div>
                                    <div id="collapse1" class="show" data-parent="#accordion">
                                            <input type='hidden' name='calcDilu1' id='calcDilu1' value='1' />
                                            <input type='hidden' name='ttxtp642_ID1' id='ttxtp642_ID1' value='' />
                                            <input type='hidden' name='ttxtp641_ID1' id='ttxtp641_ID1' value='' />
                                            <input type='hidden' name='ttxtfornSel1' id='ttxtfornSel1' value='' />
                                            
                                            <input type='hidden' name='ttxtfornQtoARR1' id='ttxtfornQtoARR1' value='' />
                                            <input type='hidden' name='ttxtfornVolARR1' id='ttxtfornVolARR1' value='' />
                                            

                                            <div class="card-body">
                                                <div class="row" style="background-color:#e5e5f6;border-radius: 10px">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="ConcRadio1">Conc. Rad. mCi/mL</label>
                                                            <input type="number" class="form-control form-control-sm minZero2"  step='0.01'  id="ConcRadio1" name="ConcRadio1" placeholder="0,00" onchange="fu_calcula1()">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Fator1">Fator <i class="fa fa-search" aria-hidden="true" style="cursor:pointer;" onclick='javascript: document.getElementById("txtOperacao").value=1'  data-toggle="modal" data-target="#modDecaimento" data-backdrop="static" data-keyboard="false"></i></label>
                                                            <input type="number" class="form-control form-control-sm"  step='0.0001'  id="Fator1" name="Fator1" placeholder="0,0000" onchange="fu_calcula1()">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="CR1">CR MBq/mL</label>
                                                            <input type="number" class="form-control form-control-sm"  step='0.01'  id="CR1" name="CR1" placeholder="0,00" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Ativ1">Atividade MBq</label>
                                                            <input type="number" class="form-control form-control-sm"  step='0.01'  id="Ativ1" name="Ativ1" placeholder="0,00" onchange="fu_calcula1()">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Origem1">Origem</label>
                                                            <select  class="form-control form-control-sm" id="Origem1" name="Origem1">
                                                                <option value="I">Importado</option>
                                                                <option value="N">Nacional</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Volume1">Volume mL</label>
                                                            <input type="number" class="form-control form-control-sm" id="Volume1" name="Volume1" step='0.01' placeholder="0.0" readonly>
                                                        </div>
                                                    </div>

                                                </div><br>

                                                <div class="row" style="background-color:#cfcfd1;border-radius: 10px">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="PedAtvIni1">Pedidos Atidade (inicial)</label>
                                                            <input type="number" class="form-control form-control-sm" id="PedAtvIni1" name="PedAtvIni1" style="width:50%" step='1' placeholder="0" onchange='fuCalcPartidas(1)'>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="PedAtvIni1">Pedidos Atidade (final)</label>
                                                            <input type="number" class="form-control form-control-sm" id="PedAtvFim1" name="PedAtvFim1" style="width:50%" step='1' placeholder="0" onchange='fuCalcPartidas(1)'>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label for="partidas1">Partidas</label>
                                                        <input type='text' class="form-control form-control-sm"  id='partidas1' name='partidas1' readonly />
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label for="totatv1">Tot. mCi</label>
                                                        <input type='text' class="form-control form-control-sm"  id='totatv1' name='totatv1' readonly />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="pedatend1">Pedidos Atendidos</label>
                                                        <input type='text' class="form-control form-control-sm"  id='pedatend1' name='pedatend1' readonly />

                                                    </div>

                                                </div><br>


                                                <div class="row" style="background-color:#e5e5f6;border-radius: 10px 10px 10px 10px;">
                                                    <div class="col-md-4">
                                                        <br><div class="h6">Menor que <span id="menorque1" name="menorque1" xclass='text-white bg-navy' 
                                                        style="color:#0b42b8;background-color:#b6c2f2;border-radius: 5px; padding:5px"></span> mCi</div></div>
                                                    <div class="col-md-3">
                                                        <label for="partidasmenor1">Partidas</label>
                                                        <input type=text name='partidasmenor1' id='partidasmenor1' class="form-control form-control-sm" readonly/>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="totatvmenor1">Atividade mCi</label>
                                                        <input type=text name='totatvmenor1' id='totatvmenor1' class="form-control form-control-sm" readonly/>&nbsp;
                                                    </div>
                                                </div><br>
    
                                                <div class="row" style="background-color:#cfcfd1;border-radius:10px;">
                                                    <div class="col-md-2">
                                                        <label for="sol_estoque">Utiliza Sol. Estoque?</label><br>
                                                        <input type="radio"  name="sol_estoque1" id="sol_estoqueS1" checked value='S' /> SIM <br>
                                                        <input type="radio"  name="sol_estoque1" id="sol_estoqueN1" value = 'N' /> NÃO
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEstLote">Lote</label><br>
                                                        <input type="text" class="form-control form-control-sm" name="txtSolEstLote1" id="txtSolEstLote1" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEstQto">Quanto?</label><br>
                                                        <input type=number name='totatvremanec1' id='totatvremanec1' class="form-control form-control-sm" step ="0.01" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEstVol">Volume</label><br>
                                                        <input type=number name='totsobravol1' id='totsobravol1' class="form-control form-control-sm"  step ="0.01" />
                                                    </div>
                                                    <div class="col-md-2  d-none" >
                                                        <label for="totsobraatv1">Atividade mCi</label>
                                                        <input type=number name='totsobraatv1' id='totsobraatv1' class="form-control form-control-sm" step="0.01" />
                                                    </div>

                                                </div><br>
    
                                                <div class="row" style="background-color:#e5e5f6;border-radius: 10px;">
                                                    <div class="col-md-2">
                                                        <label for="sol_principal">Utiliza Sol. Principal?</label><br>
                                                        <input type="radio" name="sol_principal1"checked id="sol_principal1S1" value='S' /> SIM <br>
                                                        <input type="radio" name="sol_principal1" id="sol_principal1N1" value='N' /> NÃO
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="txtSolPrinForn">Fornecedor</label><br>
                                                        <select name="txtSolPrinForn1[]" 
                                                                id="txtSolPrinForn1[]" 
                                                                class="selectpicker selforn1 form-control form-control-sm"  
                                                                data-style="bg-white" 
                                                                title="Selecione Fornecedor(es)"
                                                                multiple 
                                                                data-live-search="true" 
                                                                onchange="fu_detfornsel(1)">
                                                            <?php echo RetornaFornDilu($_GET["pst_numero"]) ?>
                                                        </select>
                                                        
                                                        <br>&nbsp;
                                                        <div id='divqtnom1' name='divqtnom1'></div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEst">Quanto?</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtSolPrinQto1" id="txtSolPrinQto1" step="1" readonly />mCi
                                                        <div id='divqtsol1' name='divqtsol1'></div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEstVol">Volume</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtSolPrinVol1" id="txtSolPrinVol1"  step="0.01" readonly />mL
                                                        <div id='divqtvol1' name='divqtvol1'></div>
                                                    </div>

                                                </div><br>

<!-- nova linha não aparece na 1 diluição -->
                                                <div class="row" style="display:none; background-color:#afcfd1;border-radius: 10px;">
                                                    <div class="col-md-3">
                                                        <label for="txtnro_util_sol_dilu1">Utilizada Solução da Diluição ?</label><br>
                                                        <input type="number" class="form-control form-control-sm w-50" min="0" max="2"   name="txtnro_util_sol_dilu1" id="txtnro_util_sol_dilu1" step="1" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="flg_util_sol_dilu1">&nbsp;</label><br>
                                                        <input type="radio" name="flg_util_sol_dilu1"  id="flg_util_sol_diluS1"  value='S' /> SIM <br>
                                                        <input type="radio" name="flg_util_sol_dilu1"  id="flg_util_sol_diluN1"  value='N' /> NÃO

                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="txtatv_util_sol_dilu1">Quanto</label><br>
                                                        <input type="number" class="form-control form-control-sm w-50" min="0"    name="txtatv_util_sol_dilu1" id="txtatv_util_sol_dilu1" step="1" />mCi
                                                    </div>
                                                    
                                                    <div class="col-md-3">
                                                        <label for="txtatv_util_sol_dilu1">Volume</label><br>
                                                        <input type="number" class="form-control form-control-sm w-50" min="0"    name="txtvol_util_sol_dilu1" id="txtvol_util_sol_dilu1" step="1" />mL
                                                        
                                                    </div>
                                                </div><br>
<!-- nova linha fim -->




                                                <div class="row" style="background-color:#cfcfd1;border-radius: 10px;">
                                                    <div class="col-md-2">
                                                        <label for="txtVolHidSod1N">Vol. Hidróxido de Sódio 0,01N</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtVolHidSod1N1" id="txtVolHidSod1N1"  step="0.01"/>mL
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtVolTotalHidSod1N">Vol. Total da Solução (Aprox)</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtVolTotalHidSod1N1" id="txtVolTotalHidSod1N1" step="0.01" />mL
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="txtTempoHomeg">Tempo de Homogeneização</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtTempoHomeg1" id="txtTempoHomeg1" step="1" />min (15 +- 5)
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="txtTempoHomeg">Pressão do<br>Gás Oxigênio</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtPresGazOx1" id="txtPresGazOx1" step="1" />mL
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="txtVazOxi">Vazão do<br>Gás Oxigênio</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtVazOxi1" id="txtVazOxi1" step="1"/>NmL/min
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="totatvmenor1">PH<br>&nbsp;</label>
                                                        <input type=number name='totphremanec1' id='totphremanec1' class="form-control form-control-sm"  step ="0.01" />
                                                    </div>

                                                </div><br>

                                                <div class="row" style="background-color:#e5e5f6;border-radius: 10px;">
                                                    <div class="col-md-2">
                                                        <label for="txtConcRad80a100_1">Conc. Radioativa</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtConcRad80a100_1" id="txtConcRad80a100_1"  step="0.01"/> (80 a 100) mCi/mL
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="txtAtvTotSoluc_1">Ativ. Total da Solução</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtAtvTotSoluc_1" id="txtAtvTotSoluc_1"  step="0.01"/>mCi
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="vol_apreendil1">Vol. Apr. Envas. Dilu. Até 2,5mL</label><br>
                                                        <input type="radio" name="vol_apreendil1"checked id="vol_apreendil1S1"  value='S' /> SIM <br>
                                                        <input type="radio" name="vol_apreendil1"        id="vol_apreendil1N1"  value='N' /> NÃO
                                                    </div>

                                                    <div class="col-md-1">
                                                        <label for="txtsobra_atv1">Sobra Atv.</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtsobra_atv1" id="txtsobra_atv1"  step="1"/>mCi
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label for="txtsobra_vol1">Sobra Vol.</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtsobra_vol1" id="txtsobra_vol1"  step="0.01"/>mL
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="sbr_Descarta1">Descarta</label><br>
                                                        <input type="radio" name="sbr_Descarta1"checked id="sbr_Descarta1S1"  value='S' /> SIM <br>
                                                        <input type="radio" name="sbr_Descarta1"        id="sbr_Descarta1N1"  value='N' /> NÃO
                                                    </div>


                                                </div><br>
    
                                                <div class="row" style="background-color:#fdf9b1;border-radius: 10px; height:80px">
                                                    <div class="col-md-4">
                                                        <label for="cmbTecnico1">Técnico Operador</label>
                                                        <?php echo CarregaTecnicoDilu(1);  ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="txtSenha1">Senha</label>
                                                        <input type="password" name="txtSenha1" id="txtSenha1" class="form-control form-control-sm" maxlength="6" size="7" required  novalidate/>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <br><button type="submit" id='gravadilu1' name='gravadilu1' class="btn btn-primary btn-sm"  >&nbsp;&nbsp;Gravar&nbsp;&nbsp;</button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php carregaDiluicao(1) ?>



    <!--</form>-->
<!-- diluição 1 FIM -->

<!-- diluição 2  -->
    <!--<form name='formDiluicoes2' id='formDiluicoes2' action='../functions.php' method='POST' target='processarDILU'>-->
    <div class="card">
                                    <div class="card-header collapsed">
                                        <a class="card-link " data-toggle="collapse" href="#collapse2"><b>Diluição #2 Previsto de 10 a 45 mCi (370 a 1665 MBq)</b></a>
                                    </div>
                                    <div id="collapse2" class="collapse" data-parent="#accordion">
                                            <input type='hidden' name='calcDilu2' id='calcDilu2' value='2' />
                                            <input type='hidden' name='ttxtp642_ID2' id='ttxtp642_ID2' value='' />
                                            <input type='hidden' name='ttxtp641_ID2' id='ttxtp641_ID2' value='' />
                                            <input type='hidden' name='ttxtfornSel2' id='ttxtfornSel2' value='' />
                                            
                                            <input type='hidden' name='ttxtfornQtoARR2' id='ttxtfornQtoARR2' value='' />
                                            <input type='hidden' name='ttxtfornVolARR2' id='ttxtfornVolARR2' value='' />

                                            <div class="card-body">
                                                <div class="row" style="background-color:#e5e5f6;border-radius: 10px">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="ConcRadio2">Conc. Rad. mCi/mL</label>
                                                            <input type="number" class="form-control form-control-sm"  step='0.01'  id="ConcRadio2" name="ConcRadio2" placeholder="0,00" onchange="fu_calcula2()">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Fator2">Fator <i class="fa fa-search" aria-hidden="true" style="cursor:pointer;" onclick='javascript: document.getElementById("txtOperacao").value=1'  data-toggle="modal" data-target="#modDecaimento" data-backdrop="static" data-keyboard="false"></i></label>
                                                            <input type="number" class="form-control form-control-sm"  step='0.0001'  id="Fator2" name="Fator2" placeholder="0,0000" onchange="fu_calcula2()">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="CR2">CR MBq/mL</label>
                                                            <input type="number" class="form-control form-control-sm"  step='0.01'  id="CR2" name="CR2" placeholder="0,00" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Ativ2">Atividade MBq</label>
                                                            <input type="number" class="form-control form-control-sm"  step='0.01'  id="Ativ2" name="Ativ2" placeholder="0,00" onchange="fu_calcula2()">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Origem2">Origem</label>
                                                            <select  class="form-control form-control-sm" id="Origem2" name="Origem2">
                                                                <option value="I">Importado</option>
                                                                <option value="N">Nacional</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Volume2">Volume mL</label>
                                                            <input type="number" class="form-control form-control-sm" id="Volume2" name="Volume2" step='0.01' placeholder="0.0" readonly>
                                                        </div>
                                                    </div>

                                                </div><br>

                                                <div class="row" style="background-color:#cfcfd1;border-radius: 10px">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="PedAtvIni2">Pedidos Atidade (inicial)</label>
                                                            <input type="number" class="form-control form-control-sm" id="PedAtvIni2" name="PedAtvIni2" style="width:50%" step='1' placeholder="0" onchange='fuCalcPartidas(2)'>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="PedAtvIni2">Pedidos Atidade (final)</label>
                                                            <input type="number" class="form-control form-control-sm" id="PedAtvFim2" name="PedAtvFim2" style="width:50%" step='1' placeholder="0" onchange='fuCalcPartidas(2)'>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label for="partidas2">Partidas</label>
                                                        <input type='text' class="form-control form-control-sm"  id='partidas2' name='partidas2' readonly />
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label for="totatv2">Tot. mCi</label>
                                                        <input type='text' class="form-control form-control-sm"  id='totatv2' name='totatv2' readonly />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="pedatend2">Pedidos Atendidos</label>
                                                        <input type='text' class="form-control form-control-sm"  id='pedatend2' name='pedatend2' readonly />

                                                    </div>

                                                </div><br>


                                                <div class="row" style="background-color:#e5e5f6;border-radius: 10px 10px 10px 10px;">
                                                    <div class="col-md-4">
                                                        <br><div class="h6">Menor que <span id="menorque2" name="menorque2" xclass='text-white bg-navy' 
                                                        style="color:#0b42b8;background-color:#b6c2f2;border-radius: 5px; padding:5px"></span> mCi</div></div>
                                                    <div class="col-md-3">
                                                        <label for="partidasmenor2">Partidas</label>
                                                        <input type=text name='partidasmenor2' id='partidasmenor2' class="form-control form-control-sm" readonly/>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="totatvmenor2">Atividade mCi</label>
                                                        <input type=text name='totatvmenor2' id='totatvmenor2' class="form-control form-control-sm" readonly/>&nbsp;
                                                    </div>
                                                </div><br>
    
                                                <div class="row" style="background-color:#cfcfd1;border-radius:10px;">
                                                    <div class="col-md-2">
                                                        <label for="sol_estoque">Utiliza Sol. Estoque?</label><br>
                                                        <input type="radio"  name="sol_estoque2" id="sol_estoqueS2" checked value='S' /> SIM <br>
                                                        <input type="radio"  name="sol_estoque2" id="sol_estoqueN2" value = 'N' /> NÃO
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEstLote">Lote</label><br>
                                                        <input type="text" class="form-control form-control-sm" name="txtSolEstLote2" id="txtSolEstLote2" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEstQto">Quanto?</label><br>
                                                        <input type=number name='totatvremanec2' id='totatvremanec2' class="form-control form-control-sm" step ="0.01" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEstVol">Volume</label><br>
                                                        <input type=number name='totsobravol2' id='totsobravol2' class="form-control form-control-sm"  step ="0.01" />
                                                    </div>
                                                    <div class="col-md-2  d-none" >
                                                        <label for="totsobraatv2">Atividade mCi</label>
                                                        <input type=number name='totsobraatv2' id='totsobraatv2' class="form-control form-control-sm" step="0.01" />
                                                    </div>

                                                </div><br>
    
                                                <div class="row" style="background-color:#e5e5f6;border-radius: 10px;">
                                                    <div class="col-md-2">
                                                        <label for="sol_principal">Utiliza Sol. Principal?</label><br>
                                                        <input type="radio" name="sol_principal2"checked id="sol_principal1S2" value='S' /> SIM <br>
                                                        <input type="radio" name="sol_principal2" id="sol_principal1N2" value='N' /> NÃO
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="txtSolPrinForn">Fornecedor</label><br>
                                                        <select name="txtSolPrinForn2[]" 
                                                                id="txtSolPrinForn2[]" 
                                                                class="selectpicker form-control form-control-sm selforn2" 
                                                                data-style="bg-white" 
                                                                title="Selecione Fornecedor(es)"
                                                                multiple 
                                                                data-live-search="true" 
                                                                onchange="fu_detfornsel(2)"
                                                                >
                                                            <?php echo RetornaFornDilu($_GET["pst_numero"]) ?>
                                                        </select>
                                                        <br>&nbsp;
                                                        <div id='divqtnom2' name='divqtnom2'></div>                                                                          
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEst">Quanto?</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtSolPrinQto2" id="txtSolPrinQto2" step="1" readonly /> mCi
                                                        <div id='divqtsol2' name='divqtsol2'></div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEstVol">Volume</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtSolPrinVol2" id="txtSolPrinVol2"  step="0.01" readonly /> mL
                                                        <div id='divqtvol2' name='divqtvol2'></div>
                                                    </div>

                                                </div><br>

<!-- nova linha -->
                                                <div class="row" style="background-color:#afcfd1;border-radius: 10px;">
                                                    <div class="col-md-3">
                                                        <label for="txtnro_util_sol_dilu2">Utilizada Solução da Diluição ?</label><br>
                                                        <input type="number" class="form-control form-control-sm w-50" min="0" max="2"   name="txtnro_util_sol_dilu2" id="txtnro_util_sol_dilu2" step="1" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="flg_util_sol_dilu2">&nbsp;</label><br>
                                                        <input type="radio" name="flg_util_sol_dilu2"  id="flg_util_sol_diluS2"  value='S' /> SIM <br>
                                                        <input type="radio" name="flg_util_sol_dilu2"  id="flg_util_sol_diluN2"  value='N' /> NÃO

                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="txtatv_util_sol_dilu2">Quanto</label><br>
                                                        <input type="number" class="form-control form-control-sm w-50" min="0"    name="txtatv_util_sol_dilu2" id="txtatv_util_sol_dilu2" step="1" />mCi
                                                    </div>
                                                    
                                                    <div class="col-md-3">
                                                        <label for="txtatv_util_sol_dilu2">Volume</label><br>
                                                        <input type="number" class="form-control form-control-sm w-50" min="0"    name="txtvol_util_sol_dilu2" id="txtvol_util_sol_dilu2" step="1" />mL
                                                        
                                                    </div>
                                                </div><br>
<!-- nova linha fim -->

                                                <div class="row" style="background-color:#cfcfd1;border-radius: 10px;">
                                                    <div class="col-md-2">
                                                        <label for="txtVolHidSod1N">Vol. Hidróxido de Sódio 0,01N</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtVolHidSod1N2" id="txtVolHidSod1N2"  step="0.01"/>mL
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtVolTotalHidSod1N">Vol. Total da Solução (Aprox)</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtVolTotalHidSod1N2" id="txtVolTotalHidSod1N2" step="0.01" />mL
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="txtTempoHomeg">Tempo de Homogeneização</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtTempoHomeg2" id="txtTempoHomeg2" step="1" />min (15 +- 5)
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="txtTempoHomeg">Pressão do<br>Gás Oxigênio</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtPresGazOx2" id="txtPresGazOx2" step="1" />mL
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="txtVazOxi">Vazão do<br>Gás Oxigênio</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtVazOxi2" id="txtVazOxi2" step="1"/>NmL/min
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="totatvmenor2">PH<br>&nbsp;</label>
                                                        <input type=number name='totphremanec2' id='totphremanec2' class="form-control form-control-sm"  step ="0.01" />
                                                    </div>

                                                </div><br>

                                                <div class="row" style="background-color:#e5e5f6;border-radius: 10px;">
                                                    <div class="col-md-2">
                                                        <label for="txtConcRad80a100_1">Conc. Radioativa</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtConcRad80a100_2" id="txtConcRad80a100_2"  step="0.01"/> (80 a 100) mCi/mL
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="txtAtvTotSoluc_2">Ativ. Total da Solução</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtAtvTotSoluc_2" id="txtAtvTotSoluc_2"  step="0.01"/>mCi
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="vol_apreendil2">Vol. Apr. Envas. Dilu. Até 2,5mL</label><br>
                                                        <input type="radio" name="vol_apreendil2"checked id="vol_apreendil1S2"  value='S' /> SIM <br>
                                                        <input type="radio" name="vol_apreendil2"        id="vol_apreendil1N2"  value='N' /> NÃO
                                                    </div>

                                                    <div class="col-md-1">
                                                        <label for="txtsobra_atv2">Sobra Atv.</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtsobra_atv2" id="txtsobra_atv2"  step="1"/>mCi
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label for="txtsobra_vol2">Sobra Vol.</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtsobra_vol2" id="txtsobra_vol2"  step="0.01"/>mL
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="sbr_Descarta2">Descarta</label><br>
                                                        <input type="radio" name="sbr_Descarta2"checked id="sbr_Descarta1S2"  value='S' /> SIM <br>
                                                        <input type="radio" name="sbr_Descarta2"        id="sbr_Descarta1N2"  value='N' /> NÃO
                                                    </div>


                                                </div><br>
    
                                                <div class="row" style="background-color:#fdf9b1;border-radius: 10px; height:80px">
                                                    <div class="col-md-4">
                                                        <label for="cmbTecnico2">Técnico Operador</label>
                                                        <?php echo CarregaTecnicoDilu(2);  ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="txtSenha2">Senha</label>
                                                        <input type="password" name="txtSenha2" id="txtSenha2" class="form-control form-control-sm" maxlength="6" size="7" required  novalidate/>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <br><button type="submit" id='gravadilu2' name='gravadilu2' class="btn btn-primary btn-sm"  >&nbsp;&nbsp;Gravar&nbsp;&nbsp;</button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php carregaDiluicao(2) ?>



    <!--</form>-->
<!-- diluição 2 FIM -->


<!-- diluição 3  -->
    <!--<form name='formDiluicoes3' id='formDiluicoes3' action='../functions.php' method='POST' target='processarDILU'>-->
    <div class="card">
                                    <div class="card-header collapsed">
                                        <a class="card-link " data-toggle="collapse" href="#collapse3"><b>Diluição #3 Previsto de 1 a 5 mCi (37 a 185 MBq)</b></a>
                                    </div>
                                    <div id="collapse3" class="collapse" data-parent="#accordion">
                                            <input type='hidden' name='calcDilu3' id='calcDilu3' value='3' />
                                            <input type='hidden' name='ttxtp642_ID3' id='ttxtp642_ID3' value='' />
                                            <input type='hidden' name='ttxtp641_ID3' id='ttxtp641_ID3' value='' />
                                            <input type='hidden' name='ttxtfornSel3' id='ttxtfornSel3' value='' />
                                            
                                            <input type='hidden' name='ttxtfornQtoARR3' id='ttxtfornQtoARR3' value='' />
                                            <input type='hidden' name='ttxtfornVolARR3' id='ttxtfornVolARR3' value='' />


                                            <div class="card-body">
                                                <div class="row" style="background-color:#e5e5f6;border-radius: 10px">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="ConcRadio3">Conc. Rad. mCi/mL</label>
                                                            <input type="number" class="form-control form-control-sm"  step='0.01'  id="ConcRadio3" name="ConcRadio3" placeholder="0,00" onchange="fu_calcula3()">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Fator3">Fator <i class="fa fa-search" aria-hidden="true" style="cursor:pointer;" onclick='javascript: document.getElementById("txtOperacao").value=1'  data-toggle="modal" data-target="#modDecaimento" data-backdrop="static" data-keyboard="false"></i></label>
                                                            <input type="number" class="form-control form-control-sm"  step='0.0001'  id="Fator3" name="Fator3" placeholder="0,0000" onchange="fu_calcula3()">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="CR3">CR MBq/mL</label>
                                                            <input type="number" class="form-control form-control-sm"  step='0.01'  id="CR3" name="CR3" placeholder="0,00" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Ativ3">Atividade MBq</label>
                                                            <input type="number" class="form-control form-control-sm"  step='0.01'  id="Ativ3" name="Ativ3" placeholder="0,00" onchange="fu_calcula3()">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Origem3">Origem</label>
                                                            <select  class="form-control form-control-sm" id="Origem3" name="Origem3">
                                                                <option value="I">Importado</option>
                                                                <option value="N">Nacional</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Volume3">Volume mL</label>
                                                            <input type="number" class="form-control form-control-sm" id="Volume3" name="Volume3" step='0.01' placeholder="0.0" readonly>
                                                        </div>
                                                    </div>

                                                </div><br>

                                                <div class="row" style="background-color:#cfcfd1;border-radius: 10px">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="PedAtvIni3">Pedidos Atidade (inicial)</label>
                                                            <input type="number" class="form-control form-control-sm" id="PedAtvIni3" name="PedAtvIni3" style="width:50%" step='1' placeholder="0" onchange='fuCalcPartidas(3)'>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="PedAtvIni3">Pedidos Atidade (final)</label>
                                                            <input type="number" class="form-control form-control-sm" id="PedAtvFim3" name="PedAtvFim3" style="width:50%" step='1' placeholder="0" onchange='fuCalcPartidas(3)'>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label for="partidas3">Partidas</label>
                                                        <input type='text' class="form-control form-control-sm"  id='partidas3' name='partidas3' readonly />
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label for="totatv3">Tot. mCi</label>
                                                        <input type='text' class="form-control form-control-sm"  id='totatv3' name='totatv3' readonly />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="pedatend3">Pedidos Atendidos</label>
                                                        <input type='text' class="form-control form-control-sm"  id='pedatend3' name='pedatend3' readonly />

                                                    </div>

                                                </div><br>


                                                <div class="row" style="background-color:#e5e5f6;border-radius: 10px 10px 10px 10px;">
                                                    <div class="col-md-4">
                                                        <br><div class="h6">Menor que <span id="menorque3" name="menorque3" xclass='text-white bg-navy' 
                                                        style="color:#0b42b8;background-color:#b6c2f2;border-radius: 5px; padding:5px"></span> mCi</div></div>
                                                    <div class="col-md-3">
                                                        <label for="partidasmenor2">Partidas</label>
                                                        <input type=text name='partidasmenor3' id='partidasmenor3' class="form-control form-control-sm" readonly/>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="totatvmenor3">Atividade mCi</label>
                                                        <input type=text name='totatvmenor3' id='totatvmenor3' class="form-control form-control-sm" readonly/>&nbsp;
                                                    </div>
                                                </div><br>
    
                                                <div class="row" style="background-color:#cfcfd1;border-radius:10px;">
                                                    <div class="col-md-2">
                                                        <label for="sol_estoque">Utiliza Sol. Estoque?</label><br>
                                                        <input type="radio"  name="sol_estoque3" id="sol_estoqueS3" checked value='S' /> SIM <br>
                                                        <input type="radio"  name="sol_estoque3" id="sol_estoqueN3" value = 'N' /> NÃO
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEstLote">Lote</label><br>
                                                        <input type="text" class="form-control form-control-sm" name="txtSolEstLote3" id="txtSolEstLote3" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEstQto">Quanto?</label><br>
                                                        <input type=number name='totatvremanec3' id='totatvremanec3' class="form-control form-control-sm" step ="0.01" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEstVol">Volume</label><br>
                                                        <input type=number name='totsobravol3' id='totsobravol3' class="form-control form-control-sm"  step ="0.01" />
                                                    </div>
                                                    <div class="col-md-2  d-none" >
                                                        <label for="totsobraatv3">Atividade mCi</label>
                                                        <input type=number name='totsobraatv3' id='totsobraatv3' class="form-control form-control-sm" step="0.01" />
                                                    </div>

                                                </div><br>
    
                                                <div class="row" style="background-color:#e5e5f6;border-radius: 10px;">
                                                    <div class="col-md-2">
                                                        <label for="sol_principal">Utiliza Sol. Principal?</label><br>
                                                        <input type="radio" name="sol_principal3"checked id="sol_principal1S3" value='S' /> SIM <br>
                                                        <input type="radio" name="sol_principal3" id="sol_principal1N3" value='N' /> NÃO
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="txtSolPrinForn">Fornecedor</label><br>
                                                        <select name="txtSolPrinForn3[]" 
                                                                id="txtSolPrinForn3[]" 
                                                                class="selectpicker form-control form-control-sm selforn3" 
                                                                data-style="bg-white" 
                                                                title="Selecione Fornecedor(es)"
                                                                multiple 
                                                                data-live-search="true" 
                                                                onchange="fu_detfornsel(3)">
                                                            <?php echo RetornaFornDilu($_GET["pst_numero"]) ?>
                                                        </select>
                                                        <br>&nbsp;
                                                        <div id='divqtnom3' name='divqtnom3' ></div>                                                                          

                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEst">Quanto?</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtSolPrinQto3" id="txtSolPrinQto3" step="1" readonly /> mCi
                                                        <div id='divqtsol3' name='divqtsol3'></div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEstVol">Volume</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtSolPrinVol3" id="txtSolPrinVol3"  step="0.01" readonly /> mL
                                                        <div id='divqtvol3' name='divqtvol3'></div>
                                                    </div>

                                                </div><br>

<!-- nova linha -->
                                                <div class="row" style="background-color:#afcfd1;border-radius: 10px;">
                                                    <div class="col-md-3">
                                                        <label for="txtnro_util_sol_dilu3">Utilizada Solução da Diluição ?</label><br>
                                                        <input type="number" class="form-control form-control-sm w-50" min="0" max="2"   name="txtnro_util_sol_dilu3" id="txtnro_util_sol_dilu3" step="1" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="flg_util_sol_dilu3">&nbsp;</label><br>
                                                        <input type="radio" name="flg_util_sol_dilu3"  id="flg_util_sol_diluS3"  value='S' /> SIM <br>
                                                        <input type="radio" name="flg_util_sol_dilu3"  id="flg_util_sol_diluN3"  value='N' /> NÃO

                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="txtatv_util_sol_dilu3">Quanto</label><br>
                                                        <input type="number" class="form-control form-control-sm w-50" min="0"    name="txtatv_util_sol_dilu3" id="txtatv_util_sol_dilu3" step="1" />mCi
                                                    </div>
                                                    
                                                    <div class="col-md-3">
                                                        <label for="txtatv_util_sol_dilu3">Volume</label><br>
                                                        <input type="number" class="form-control form-control-sm w-50" min="0"    name="txtvol_util_sol_dilu3" id="txtvol_util_sol_dilu3" step="1" />mL
                                                        
                                                    </div>
                                                </div><br>
<!-- nova linha fim -->


                                                <div class="row" style="background-color:#cfcfd1;border-radius: 10px;">
                                                    <div class="col-md-2">
                                                        <label for="txtVolHidSod1N">Vol. Hidróxido de Sódio 0,01N</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtVolHidSod1N3" id="txtVolHidSod1N3"  step="0.01"/>mL
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtVolTotalHidSod1N">Vol. Total da Solução (Aprox)</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtVolTotalHidSod1N3" id="txtVolTotalHidSod1N3" step="0.01" />mL
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="txtTempoHomeg">Tempo de Homogeneização</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtTempoHomeg3" id="txtTempoHomeg3" step="1" />min (15 +- 5)
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="txtTempoHomeg">Pressão do<br>Gás Oxigênio</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtPresGazOx3" id="txtPresGazOx3" step="1" />mL
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="txtVazOxi">Vazão do<br>Gás Oxigênio</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtVazOxi3" id="txtVazOxi3" step="1"/>NmL/min
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="totatvmenor3">PH<br>&nbsp;</label>
                                                        <input type=number name='totphremanec3' id='totphremanec3' class="form-control form-control-sm"  step ="0.01" />
                                                    </div>

                                                </div><br>

                                                <div class="row" style="background-color:#e5e5f6;border-radius: 10px;">
                                                    <div class="col-md-2">
                                                        <label for="txtConcRad80a100_1">Conc. Radioativa</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtConcRad80a100_3" id="txtConcRad80a100_3"  step="0.01"/> (80 a 100) mCi/mL
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="txtAtvTotSoluc_3">Ativ. Total da Solução</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtAtvTotSoluc_3" id="txtAtvTotSoluc_3"  step="0.01"/>mCi
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="vol_apreendil3">Vol. Apr. Envas. Dilu. Até 2,5mL</label><br>
                                                        <input type="radio" name="vol_apreendil3"checked id="vol_apreendil1S3"  value='S' /> SIM <br>
                                                        <input type="radio" name="vol_apreendil3"        id="vol_apreendil1N3"  value='N' /> NÃO
                                                    </div>

                                                    <div class="col-md-1">
                                                        <label for="txtsobra_atv3">Sobra Atv.</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtsobra_atv3" id="txtsobra_atv3"  step="1"/>mCi
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label for="txtsobra_vol3">Sobra Vol.</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtsobra_vol3" id="txtsobra_vol3"  step="0.01"/>mL
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="sbr_Descarta3">Descarta</label><br>
                                                        <input type="radio" name="sbr_Descarta3"checked id="sbr_Descarta1S3"  value='S' /> SIM <br>
                                                        <input type="radio" name="sbr_Descarta3"        id="sbr_Descarta1N3"  value='N' /> NÃO
                                                    </div>


                                                </div><br>
    
                                                <div class="row" style="background-color:#fdf9b1;border-radius: 10px; height:80px">
                                                    <div class="col-md-4">
                                                        <label for="cmbTecnico3">Técnico Operador</label>
                                                        <?php echo CarregaTecnicoDilu(3);  ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="txtSenha3">Senha</label>
                                                        <input type="password" name="txtSenha3" id="txtSenha3" class="form-control form-control-sm" maxlength="6" size="7" required  novalidate/>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <br><button type="submit" id='gravadilu3' name='gravadilu3' class="btn btn-primary btn-sm"  >&nbsp;&nbsp;Gravar&nbsp;&nbsp;</button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php carregaDiluicao(3) ?>



    <!--</form>-->
<!-- diluição 3 FIM -->

<!-- diluição 4  -->
    <!--<form name='formDiluicoes4' id='formDiluicoes4' action='../functions.php' method='POST' target='processarDILU'>-->
    <div class="card">
                                    <div class="card-header collapsed">
                                        <a class="card-link " data-toggle="collapse" href="#collapse4"><b>Diluição EXTRA</b></a>
                                    </div>
                                    <div id="collapse4" class="collapse" data-parent="#accordion">
                                            <input type='hidden' name='calcDilu4' id='calcDilu4' value='4' />
                                            <input type='hidden' name='ttxtp642_ID4' id='ttxtp642_ID4' value='' />
                                            <input type='hidden' name='ttxtp641_ID4' id='ttxtp641_ID4' value='' />
                                            <input type='hidden' name='ttxtfornSel4' id='ttxtfornSel4' value='' />
                                            
                                            <input type='hidden' name='ttxtfornQtoARR4' id='ttxtfornQtoARR4' value='' />
                                            <input type='hidden' name='ttxtfornVolARR4' id='ttxtfornVolARR4' value='' />


                                            <div class="card-body">
                                                <div class="row" style="background-color:#e5e5f6;border-radius: 10px">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="ConcRadio4">Conc. Rad. mCi/mL</label>
                                                            <input type="number" class="form-control form-control-sm"  step='0.01'  id="ConcRadio4" name="ConcRadio4" placeholder="0,00" onchange="fu_calcula4()">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Fator4">Fator <i class="fa fa-search" aria-hidden="true" style="cursor:pointer;" onclick='javascript: document.getElementById("txtOperacao").value=1'  data-toggle="modal" data-target="#modDecaimento" data-backdrop="static" data-keyboard="false"></i></label>
                                                            <input type="number" class="form-control form-control-sm"  step='0.0001'  id="Fator4" name="Fator4" placeholder="0,0000" onchange="fu_calcula4()">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="CR4">CR MBq/mL</label>
                                                            <input type="number" class="form-control form-control-sm"  step='0.01'  id="CR4" name="CR4" placeholder="0,00" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Ativ4">Atividade MBq</label>
                                                            <input type="number" class="form-control form-control-sm"  step='0.01'  id="Ativ4" name="Ativ4" placeholder="0,00" onchange="fu_calcula4()">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Origem4">Origem</label>
                                                            <select  class="form-control form-control-sm" id="Origem4" name="Origem4">
                                                                <option value="I">Importado</option>
                                                                <option value="N">Nacional</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Volume4">Volume mL</label>
                                                            <input type="number" class="form-control form-control-sm" id="Volume4" name="Volume4" step='0.01' placeholder="0.0" readonly>
                                                        </div>
                                                    </div>

                                                </div><br>

                                                <div class="row" style="background-color:#cfcfd1;border-radius: 10px">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="PedAtvIni4">Pedidos Atidade (inicial)</label>
                                                            <input type="number" class="form-control form-control-sm" id="PedAtvIni4" name="PedAtvIni4" style="width:50%" step='1' placeholder="0" onchange='fuCalcPartidas(4)'>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="PedAtvIni4">Pedidos Atidade (final)</label>
                                                            <input type="number" class="form-control form-control-sm" id="PedAtvFim4" name="PedAtvFim4" style="width:50%" step='1' placeholder="0" onchange='fuCalcPartidas(4)'>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label for="partidas4">Partidas</label>
                                                        <input type='text' class="form-control form-control-sm"  id='partidas4' name='partidas4' readonly />
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label for="totatv4">Tot. mCi</label>
                                                        <input type='text' class="form-control form-control-sm"  id='totatv4' name='totatv4' readonly />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="pedatend4">Pedidos Atendidos</label>
                                                        <input type='text' class="form-control form-control-sm"  id='pedatend4' name='pedatend4' readonly />

                                                    </div>

                                                </div><br>


                                                <div class="row" style="background-color:#e5e5f6;border-radius: 10px 10px 10px 10px;">
                                                    <div class="col-md-4">
                                                        <br><div class="h6">Menor que <span id="menorque4" name="menorque4" xclass='text-white bg-navy' 
                                                        style="color:#0b42b8;background-color:#b6c2f2;border-radius: 5px; padding:5px"></span> mCi</div></div>
                                                    <div class="col-md-3">
                                                        <label for="partidasmenor2">Partidas</label>
                                                        <input type=text name='partidasmenor4' id='partidasmenor4' class="form-control form-control-sm" readonly/>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="totatvmenor4">Atividade mCi</label>
                                                        <input type=text name='totatvmenor4' id='totatvmenor4' class="form-control form-control-sm" readonly/>&nbsp;
                                                    </div>
                                                </div><br>
    
                                                <div class="row" style="background-color:#cfcfd1;border-radius:10px;">
                                                    <div class="col-md-2">
                                                        <label for="sol_estoque">Utiliza Sol. Estoque?</label><br>
                                                        <input type="radio"  name="sol_estoque4" id="sol_estoqueS4" checked value='S' /> SIM <br>
                                                        <input type="radio"  name="sol_estoque4" id="sol_estoqueN4" value = 'N' /> NÃO
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEstLote">Lote</label><br>
                                                        <input type="text" class="form-control form-control-sm" name="txtSolEstLote4" id="txtSolEstLote4" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEstQto">Quanto?</label><br>
                                                        <input type=number name='totatvremanec4' id='totatvremanec4' class="form-control form-control-sm" step ="0.01" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEstVol">Volume</label><br>
                                                        <input type=number name='totsobravol4' id='totsobravol4' class="form-control form-control-sm"  step ="0.01" />
                                                    </div>
                                                    <div class="col-md-2  d-none" >
                                                        <label for="totsobraatv4">Atividade mCi</label>
                                                        <input type=number name='totsobraatv4' id='totsobraatv4' class="form-control form-control-sm" step="0.01" />
                                                    </div>

                                                </div><br>
    
                                                <div class="row" style="background-color:#e5e5f6;border-radius: 10px;">
                                                    <div class="col-md-2">
                                                        <label for="sol_principal">Utiliza Sol. Principal?</label><br>
                                                        <input type="radio" name="sol_principal4"checked id="sol_principal1S4" value='S' /> SIM <br>
                                                        <input type="radio" name="sol_principal4" id="sol_principal1N4" value='N' /> NÃO
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="txtSolPrinForn">Fornecedor</label><br>
                                                        <select name="txtSolPrinForn4[]" 
                                                                id="txtSolPrinForn4[]" 
                                                                class="selectpicker form-control form-control-sm selforn4" 
                                                                data-style="bg-white" 
                                                                title="Selecione Fornecedor(es)"
                                                                multiple 
                                                                data-live-search="true" 
                                                                onchange="fu_detfornsel(4)">
                                                            <?php echo RetornaFornDilu($_GET["pst_numero"]) ?>
                                                        </select>
                                                        <br>&nbsp;
                                                        <div id='divqtnom4' name='divqtnom4' ></div>                                                                          

                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEst">Quanto?</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtSolPrinQto4" id="txtSolPrinQto4" step="1" readonly /> mCi
                                                        <div id='divqtsol4' name='divqtsol4'></div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtSolEstVol">Volume</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtSolPrinVol4" id="txtSolPrinVol4"  step="0.01" readonly /> mL
                                                        <div id='divqtvol4' name='divqtvol4'></div>
                                                    </div>

                                                </div><br>

<!-- nova linha não aparece na 4 diluição -->
                                                <div class="row" style="display:none; background-color:#afcfd1;border-radius: 10px;">
                                                    <div class="col-md-3">
                                                        <label for="txtnro_util_sol_dilu1">Utilizada Solução da Diluição ?</label><br>
                                                        <input type="number" class="form-control form-control-sm w-50" min="0" max="2"   name="txtnro_util_sol_dilu4" id="txtnro_util_sol_dilu4" step="1" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="flg_util_sol_dilu4">&nbsp;</label><br>
                                                        <input type="radio" name="flg_util_sol_dilu4"  id="flg_util_sol_diluS4"         value='S' /> SIM <br>
                                                        <input type="radio" name="flg_util_sol_dilu4"  id="flg_util_sol_diluN4" checked value='N' /> NÃO

                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="txtatv_util_sol_dilu4">Quanto</label><br>
                                                        <input type="number" class="form-control form-control-sm w-50" min="0"    name="txtatv_util_sol_dilu4" id="txtatv_util_sol_dilu4" step="1" />mCi
                                                    </div>
                                                    
                                                    <div class="col-md-3">
                                                        <label for="txtatv_util_sol_dilu4">Volume</label><br>
                                                        <input type="number" class="form-control form-control-sm w-50" min="0"    name="txtvol_util_sol_dilu4" id="txtvol_util_sol_dilu4" step="1" />mL
                                                        
                                                    </div>
                                                </div><br>
<!-- nova linha fim -->

                                                <div class="row" style="background-color:#cfcfd1;border-radius: 10px;">
                                                    <div class="col-md-2">
                                                        <label for="txtVolHidSod1N">Vol. Hidróxido de Sódio 0,01N</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtVolHidSod1N4" id="txtVolHidSod1N4"  step="0.01"/>mL
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="txtVolTotalHidSod1N">Vol. Total da Solução (Aprox)</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtVolTotalHidSod1N4" id="txtVolTotalHidSod1N4" step="0.01" />mL
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="txtTempoHomeg">Tempo de Homogeneização</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtTempoHomeg4" id="txtTempoHomeg4" step="1" />min (15 +- 5)
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="txtTempoHomeg">Pressão do<br>Gás Oxigênio</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtPresGazOx4" id="txtPresGazOx4" step="1" />mL
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="txtVazOxi">Vazão do<br>Gás Oxigênio</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtVazOxi4" id="txtVazOxi4" step="1"/>NmL/min
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="totatvmenor4">PH<br>&nbsp;</label>
                                                        <input type=number name='totphremanec4' id='totphremanec4' class="form-control form-control-sm"  step ="0.01" />
                                                    </div>

                                                </div><br>

                                                <div class="row" style="background-color:#e5e5f6;border-radius: 10px;">
                                                    <div class="col-md-2">
                                                        <label for="txtConcRad80a100_1">Conc. Radioativa</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtConcRad80a100_4" id="txtConcRad80a100_4"  step="0.01"/> (80 a 100) mCi/mL
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="txtAtvTotSoluc_4">Ativ. Total da Solução</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtAtvTotSoluc_4" id="txtAtvTotSoluc_4"  step="0.01"/>mCi
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="vol_apreendil4">Vol. Apr. Envas. Dilu. Até 2,5mL</label><br>
                                                        <input type="radio" name="vol_apreendil4"checked id="vol_apreendil1S4"  value='S' /> SIM <br>
                                                        <input type="radio" name="vol_apreendil4"        id="vol_apreendil1N4"  value='N' /> NÃO
                                                    </div>

                                                    <div class="col-md-1">
                                                        <label for="txtsobra_atv4">Sobra Atv.</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtsobra_atv4" id="txtsobra_atv4"  step="1"/>mCi
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label for="txtsobra_vol4">Sobra Vol.</label><br>
                                                        <input type="number" class="form-control form-control-sm" name="txtsobra_vol4" id="txtsobra_vol4"  step="0.01"/>mL
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="sbr_Descarta4">Descarta</label><br>
                                                        <input type="radio" name="sbr_Descarta4"checked id="sbr_Descarta1S4"  value='S' /> SIM <br>
                                                        <input type="radio" name="sbr_Descarta4"        id="sbr_Descarta1N4"  value='N' /> NÃO
                                                    </div>


                                                </div><br>
    
                                                <div class="row" style="background-color:#fdf9b1;border-radius: 10px; height:80px">
                                                    <div class="col-md-4">
                                                        <label for="cmbTecnico4">Técnico Operador</label>
                                                        <?php echo CarregaTecnicoDilu(4);  ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="txtSenha4">Senha</label>
                                                        <input type="password" name="txtSenha4" id="txtSenha4" class="form-control form-control-sm" maxlength="6" size="7" required  novalidate/>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <br><button type="submit" id='gravadilu4' name='gravadilu4' class="btn btn-primary btn-sm"  >&nbsp;&nbsp;Gravar&nbsp;&nbsp;</button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php carregaDiluicao(4) ?>



    <!--</form>-->
<!-- diluição 4 FIM -->



<!-- Sobra Total -->
                                <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapseSobraFinal">
                                        <b>Sobra Final</b>
                                        </a>
                                    </div>
                                    <div id="collapseSobraFinal" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label for="txtAtvSbrFim">Atividade mCi</label>
                                                    <input type='number' id='txtAtvSbrFim' step="0.01" name='txtAtvSbrFim' class="form-control" value='0,00' />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="txtVolSbrFim">Volume mL</label>
                                                    <input type='number' id='txtVolSbrFim' step="0.01" name='txtVolSbrFim' class="form-control" value='0,00' />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="txtDatSbrFim">Data</label>
                                                    <input type='datetime-local' id='txtDatSbrFim' name='txtDatSbrFim' class="form-control" value='' />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="txtDatSbrFim">Senha</label>
                                                    <input type='password' id='SenhaSobraFinal' name='SenhaSobraFinal' class="form-control" value='' />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="GravaSobraFinal">Gravar</label>
                                                    
                                                    <br><button type="submit" id='GravaSobraFinal' name='GravaSobraFinal' class="btn btn-primary btn-sm" >&nbsp;&nbsp;OK&nbsp;&nbsp;</button>
                                                </div>

                                            </div>
                                        </div>
                                        <?php echo CarregaCalculos(); ?>
                                    </div>
                                </div>
<!-- Sobra Total FIM -->

                                </div>
                            </div>


                </form>


                <iframe id='processarDILU' name='processarDILU' style='display:none'></iframe>

                <!-- fim do conteúdo -->
            </div>
        </div>
    </div>
</div>




<?php include("../footer.php"); ?>


<script>
    $('.selforn1').selectpicker('val', document.getElementById("ttxtfornSel1").value.split('|'));
    $('.selforn2').selectpicker('val', document.getElementById("ttxtfornSel2").value.split('|'));
    $('.selforn3').selectpicker('val', document.getElementById("ttxtfornSel3").value.split('|'));
    $('.selforn4').selectpicker('val', document.getElementById("ttxtfornSel4").value.split('|'));

</script>


<!-- Modal decaimento -->
<div class="modal fade" id="modDecaimento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modDecaimentoLabel">Fator de Decaimento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="display compact table-striped table-bordered nowrap" id="tbFatDecaimento" style="width:100%; font-size:12px; font-family: Tahoma">
            <thead>
                <tr>
                    <th></th>
                    <th>Minutos</th>
                    <th>Horas</th>
                    <th>Dias</th>
                    <th>Fator</th>
                    <th>Total</th>
            </tr>
            </thead>
            <tbody>
                <?php echo carregaFatorDecaimento('I-131'); ?>
            </tbody>

        </table>    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>




<script>

$('#tbFatDecaimento').DataTable({
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json',
    },
    'columnDefs': [
    { "targets": 0, "className": "text-center", "width": "4px" },
    { "targets": 1, "className": "text-right", },
    { "targets": 2, "className": "text-right", },
    { "targets": 3, "className": "text-right", },
    { "targets": 4, "className": "text-right",  render: $.fn.dataTable.render.number(',', '.', 4, '')},
    { "targets": 5, "className": "text-right", },
 ]

});




function fuCalcPartidas(field){
        document.getElementById('menorque'+field).innerHTML = document.getElementById('PedAtvIni'+field).value
        document.formDiluicoes.action="../functions.php";
        document.formDiluicoes.method="POST";
        document.formDiluicoes.target="processarDILU";
        document.formDiluicoes.submit();

    }



    
$(window).on('load', function () {

  fuCalcPartidas(1)
  fuCalcPartidas(2)
  fuCalcPartidas(3)
  fuCalcPartidas(4)
  fu_detfornsel(1)
  fu_detfornsel(2)
  fu_detfornsel(3)
  fu_detfornsel(4)
  fu_popforn(1)
  fu_popforn(2)
  fu_popforn(3)
  fu_popforn(4)

});


/*
$( document ).ready(function() {
    console.log( "ready!" );
    fuCalcPartidas(1)
    fuCalcPartidas(2)
    fuCalcPartidas(3)
    fuCalcPartidas(4)
    fu_detfornsel(1)
    fu_detfornsel(2)
    fu_detfornsel(3)
    fu_detfornsel(4)

    //fu_popforn(1)
});
*/


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






