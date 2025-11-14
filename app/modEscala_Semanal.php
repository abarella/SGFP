<style>
thead input {
        width: 100%;
    }
table.dataTable tbody td {
  vertical-align: top;
}
</style>

<script>
const lote = sessionStorage.getItem('lote');
const produto = sessionStorage.getItem('produto');
const dtini = sessionStorage.getItem('dtini');
const dtate = sessionStorage.getItem('dtate');


    function fu_add5dias(date, days){
        var result = new Date(date);
        result.setDate(result.getDate() + days)
        ano = result.getFullYear()
        mes = result.getMonth()+1
        dia = result.getDate()
        if (dia < 10) dia = '0' + dia;
        if (mes < 10) mes = '0' + mes;
        document.getElementById('txPeriodoATE').value = ano+'-'+mes+'-'+dia
    }

    function fuEditaEscala(p1, p2, p3, p4, p5, p6, p7,p8,p9){
        

        p2 = p2.split("¬").join(" ");
        p3 = p3.split("¬").join(" ");
        p4 = p4.split("¬").join(" ");
        p5 = p5.substr(6,10) + "-" + p5.substr(3,2)  + "-" + p5.substr(0,2)
        p6 = p6.substr(6,10) + "-" + p6.substr(3,2)  + "-" + p6.substr(0,2)
        //p7 = p7.split("¬").join(" ");
        //p7 = p7.split("¢").join("\n");
        p8 = p8.split("¬").join(" ");
        p8 = p8.substr(6,4) + "-" + p8.substr(3,2)  + "-" + p8.substr(0,2) + p8.substr(10,6)
        

        document.getElementById('nr_ID').value = p1
        document.getElementById('txtLotes').value = p2
        document.getElementById('selTarefas').value = p3
        document.getElementById('cmbprod').value = p4
        document.getElementById('txPeriodoINI').value = p5
        document.getElementById('txPeriodoATE').value = p6
        //document.getElementById('txtResponsaveis').value = p7
        document.getElementById('txDataExecucao').value = p8

        document.getElementById('txtLotes').readOnly = true;
        document.getElementById('cmbprod').disabled = true;
        document.getElementById('selTarefas').disabled = true;
        document.getElementById('txPeriodoINI').readOnly = true;
        document.getElementById('txPeriodoATE').readOnly = true;
        document.getElementById('selTipProc').value = p9


        atualizaCombos()        
        
        var element = document.getElementById("CancelaUpdate");
            element.classList.remove("d-none");

    }

    function fu_cancelaUpdate(){
        var element = document.getElementById("CancelaUpdate");
            element.classList.add("d-none");
            document.getElementById("nr_ID").value = "";
            document.getElementById("txtLotes").removeAttribute('readonly');
            document.getElementById("txPeriodoINI").removeAttribute('readonly');
            document.getElementById("txPeriodoATE").removeAttribute('readonly');
            document.getElementById('cmbprod').disabled = false;
            document.getElementById('selTarefas').disabled = false;
    }


    function AfterCloseModal(){
        setTimeout(function(){
            sessionStorage.setItem('lote',document.getElementById('txtLotes').value);
            sessionStorage.setItem('produto',document.getElementById('cmbprod').value);
            sessionStorage.setItem('dtini',document.getElementById('txPeriodoINI').value);
            sessionStorage.setItem('dtate',document.getElementById('txPeriodoATE').value);
    		location.href = location.href;
		}, 1500);
    }

    function fuAbre(p1,p2){
        p1 = p1.substring(6,10) +'-' + p1.substring(3,5) + '-' +p1.substring(0,2)
        p2 = p2.substring(6,10) +'-' + p2.substring(3,5) + '-' +p2.substring(0,2)
        const windowFeatures = "left=10,top=10,width=940px,height=620,menubar=no,location=no,resizable=no,scrollbars=no,status=no,toolbar=no";
        window.open(<?php echo $_SG['report_site']; ?>+ "?report=EscalaSemanal&dat_inicial="+p1+"&dat_final="+ p2 ,"_Report", windowFeatures)
    }


    function fuDeleta(id){
        
        document.getElementById("nr_ID").value = id
        document.getElementById("acaodel").value ='excluiEscSemanal'
        document.forms['formEscalaSemanal'].method="POST";
        document.forms['formEscalaSemanal'].target="processar";
        document.forms['formEscalaSemanal'].submit();
        AfterCloseModal()
    }

    function fu_popDisp(){

        document.getElementById('txtLotes').readOnly = false;
        document.getElementById('cmbprod').disabled = false;
        document.getElementById('selTarefas').disabled = false;
        document.getElementById('txPeriodoINI').readOnly = false;
        document.getElementById('txPeriodoATE').readOnly = false;




        document.getElementById('txtdisponiveis').value=""
        Array.from(document.querySelector("#assoc").options).forEach(function(option_element) {
        let option_text = option_element.text;
        let option_value = option_element.value;
        let is_option_selected = option_element.selected;
        //alert(option_value)
        document.getElementById('txtdisponiveis').value +=option_value+","
        });
        document.getElementById('txtdisponiveis').value = document.getElementById('txtdisponiveis').value.slice(0,-1)

    }

    function fu_duplicar(){
        let text = "Confima a duplicação do Último lote?"
        if (confirm(text) == true){
            document.getElementById("acaodel").value ='duplicaEscSemanal'
            document.forms['formEscalaSemanal'].method="POST";
            document.forms['formEscalaSemanal'].target="processar";
            document.forms['formEscalaSemanal'].submit();
            AfterCloseModal()
        }


    }


</script>





<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formEscalaSemanal' action=<?php echo $_SG['rf'] .'functions.php';?>  target="processar" method="POST">
                    <input type='hidden' name='nr_ID'  id='nr_ID' value="" />
                    <input type='hidden' name='acaodel'  id='acaodel' value="" />
                    <input type='hidden' name='txtdisponiveis'  id='txtdisponiveis' value="" />
                    <div class="row">
                        <div class="col-md-2">
                        Lote: 
                            <input type='text' class='form-control' id='txtLotes' name='txtLotes' onchange="atualizaCombos()"  required  />
                        </div>
                        <div class="col-md-3">
                            Produto: <?php  echo RetornaCMBProdutos(); ?>
                        </div>

                        <div class="col-md-3">
                            Tipo de Processo: 
                            <select name="selTipProc" id="selTipProc" class="form-control" onchange="atualizaCombos()">
                                <?php echo RetornaEscalaTipoProcesso(); ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            De: <input type="date" name="txPeriodoINI" id="txPeriodoINI" class="form-control form-control" onchange="fu_add5dias(this.value,5)"  required />
                        </div>

                        <div class="col-md-2">
                            Até: <input type="date" name="txPeriodoATE" id="txPeriodoATE" class="form-control form-control"  required />
                        </div>


                        
                    </div>

                    <br>

                    <div class="row">
                        
                        <div class="col-md-5">
                            Tarefas: 
                            <select name="selTarefas" id="selTarefas" class="form-control" onchange="atualizaCombos()">
                                <?php echo RetornaEscalaTarefasSenanal(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            Data de Execução: <input type="datetime-local" name="txDataExecucao" id="txDataExecucao" class="form-control"  required />
                        </div>


                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-5">
                            Disponíveis: 
                            <select name="dispon" id="dispon"  size="10" style="height: 100%;" multiple class="form-control">
                               <?php echo RetornaListaUsuariosCMB(); ?>
                            </select>
                        </div>

                        <div class="col-md-0 d-flex align-items-center">
                            <!--
                           <input type="button" id="doSnd" name="doSnd"  value=">>" />&nbsp;
                           <input type="button" id="doRst" name="doRst"  value="<<" />
                            -->
                            <button type="button"  id="doSnd" name="doSnd" class="btn btn-primary" aria-label="Left Align">
                                <span class="fa fa-arrow-right fa-lg" aria-hidden="true"></span>
                            </button>
                            &nbsp;
                            <button type="button"  id="doRst" name="doRst" class="btn btn-primary" aria-label="Left Align">
                                <span class="fa fa-arrow-left fa-lg" aria-hidden="true"></span>
                            </button>

                        </div>
                        <div class="col-md-5">
                            Associados: 
                            <select name="assoc" id="assoc"  size="10" style="height: 100%;" multiple class="form-control">
                            
                            </select>
                        </div>


                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-3">
                        Senha: <input type="password" name="txtSenha" id="txtSenha" class="form-control" maxlength="6" size="7" required />
                        </div>    
                        <div class="col-md-4">
                           <br> <input type=submit class='btn btn-primary' id="InserirEscalaSenanal" name="InserirEscalaSenanal" onclick="fu_popDisp()" value='Gravar' required />
                                <input type=button class='btn btn-danger d-none' id="CancelaUpdate" name="CancelaUpdate" onclick="fu_cancelaUpdate()" value='Cancela Atualização' />
                        </div>
                        <div class="col-md-5 text-right">
                            <br>
                            <input type=button class='btn btn-danger' id="DuplicarEscala" name="DuplicarEscala" onclick="fu_duplicar()" value='Duplicar Escala' />
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-md-12">
                            <br><hr>
                            <input type='hidden' name='id' id='id' />
                            <input type='hidden' name='acao' id='acao' />

                            <table id="tblista" class="display  compact table-striped table-bordered " style="width:100%; font-size:12px; font-family: Tahoma">
                                <thead style="background-color:#556295; color:#f2f3f7">
                                    <tr>
                                        <th style="width:70px"></th>
                                        <th style="text-align:center;width:25px;">Item</th>
                                        <th>Lote</th>
                                        <th>Produto</th>
                                        <th>Tipo Processo</th>
                                        <th>Data Inc.</th>
                                        <th>Data Fin.</th>
                                        <th>Data Exec.</th>
                                        <th>Tarefa</th>
                                        <th>Responsáveis</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo RetornaEscalaSemanal(); ?>
                                </tbody>
                            </table>                            
                        </div>
                    </div>

                    <br><br>

                    
                </form>
                <!-- fim do conteúdo -->
            </div>
        </div>
    </div>
</div>

<iframe id="processar" name="processar" style="display:none" ></iframe>

<?php 
include("../footer.php");
?>



<script type="text/javascript">

function sortOptions2() {
         var allOptions = $("#dispon option");
         allOptions.sort(function (op1, op2) {
            var text1 = $(op1).text().toLowerCase();
            var text2 = $(op2).text().toLowerCase();
            return (text1 < text2) ? -1 : 1;
         });
         allOptions.appendTo("#dispon");
}

function sortOptions1() {
         var allOptions = $("#assoc option");
         allOptions.sort(function (op1, op2) {
            var text1 = $(op1).text().toLowerCase();
            var text2 = $(op2).text().toLowerCase();
            return (text1 < text2) ? -1 : 1;
         });
         allOptions.appendTo("#assoc");
}


$('#doSnd').click(function () {
    $('#dispon option:selected').each(function () {
        $("<option/>").
        val($(this).val()).
        text($(this).text()).
        appendTo("#assoc");
        $(this).remove();
        sortOptions1();
    });
});


$('#doRst').click(function () {
    $('#assoc option:selected').each(function () {
        $("<option/>").
        val($(this).val()).
        text($(this).text()).
        appendTo("#dispon");
        $(this).remove();
        sortOptions2();
    });
});



/*
$(document).ready(function () {
    $('#tblista').DataTable({
        "language": {
                "url": "<?php  echo $_SG['rf']; ?>dist/js/pt-BR.php"
        },

        "dom": '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',   //solução boa para a parte de cima do grid
		scrollX: true,
        fixedHeader: true,
        responsive : true,
        lengthChange: true,
        pageLength: 10,
        lengthMenu: [[5, 10, 50, 100, 250, 500, -1], [5, 10, 50, 100, 250, 500, "Todos"]],
        buttons: [
            { extend: 'copy', exportOptions:
                { columns: ':visible' }
            },

			{ extend: 'excel', exportOptions:
                 { columns: ':visible' }
            },
            { extend: 'pdf',
				orientation: 'landscape',
				exportOptions:
                  { columns:':visible'}
            },

           ],
                    
    });
});
*/

//if ($(api.column(colIdx).header()).index() >= 0) {
//     $(cell).html('<input type="text" placeholder="' + title + '"/>');
//}


$(document).ready(function () {
    // Setup - add a text input to each footer cell
    $('#tblista thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#tblista thead');
 
    var table = $('#tblista').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        "language": {
                "url": "<?php  echo $_SG['rf']; ?>dist/js/pt-BR.php"
        },
        initComplete: function () {
            var api = this.api();
 
            // For each column
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" placeholder="' + title + '" />');
 
                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('change', function (e) {
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
 
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
                        })
                        .on('keyup', function (e) {
                            e.stopPropagation();
 
                            $(this).trigger('change');
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
        },
    });
});






function getreturnassoc(par){
    var dados = par.split(',')

    $('#assoc').empty()
    $('#dispon').empty()

    for (let i = 0; i < dados.length; i++) {
        optionText =  dados[i+2];
        optionValue = dados[i+1];
        if (dados[i] == 'assoc'){
            $('#assoc').append(new Option(optionText, optionValue)); 
        }
        else{
            $('#dispon').append(new Option(optionText, optionValue)); 
        }
        i=i+2;
    }
}


function atualizaCombos(){
    _l = document.getElementById('txtLotes').value
    _t = document.getElementById('selTarefas').value
    $.ajax({
        url:"../functions.php",    //the page containing php script
        type: "POST",              //request type,
        data: {RetornaUsuariosAssocCMB: "success", 
            lote:   _l, 
            tarefa: _t},
        success:function(result){
            getreturnassoc(result)
        }
    });
    


}

document.getElementById('txtLotes').value = lote
document.getElementById('cmbprod').value = produto
document.getElementById('txPeriodoINI').value = dtini
document.getElementById('txPeriodoATE').value = dtate

</script>