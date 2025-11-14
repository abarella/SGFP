<?php 

include("../functions.php");
session_start();
$_SESSION['nome_da_tela'] = 'Outros / Verificação de Cela';

include("../header.php");
?>

<style>
    iframe.clsVerCela {  width: 100%;  height: 500px; } 
    .custom-btn {  font-family: Arial; font-size:13px; background-color:#0d6efd; padding:10 14 0 0}
    .selforn1{  font-size: 10px !important;}
    .filter-option {    font-size: 12px;}
    .bs-searchbox > input {  font-size: 10px;}

    .bootstrap-select.show-tick .dropdown-menu li a span.text {
    margin-right: 34px;
    color: blue;
    font-size: 10px;
    padding: 0 0 0 0;
    line-height: normal;
    display: flow;
}

</style>    


<script>
    function fu_editVerCela(param){
        par = param.split(',')
        //alert(par[1])

        document.getElementById('tpst_numero').value = par[2]
        document.getElementById('tId_Limpeza').value = par[0]
        document.getElementById('tnum_lote').value = par[1]
        

        $('#IncluiVerCela').modal({backdrop: 'static', keyboard: false})  
        $('#IncluiVerCela').modal('show'); 

        document.getElementById('ifrVerCela').src="../app/teste.php?id="+par[0]+"&pst_numero="+par[2]

    }

    function fu_gravaLimpCela(){
        document.getElementById('pst_to_add').value = ""
        pass = document.getElementById('txtSenha').value
        data = document.getElementById('datlimpeza').value
        tabe = document.getElementById('tblIncLimpCela')
        //alert(tabe)

        var table = document.getElementById("tblIncLimpCela");

        $('#tblIncLimpCela tbody tr  input:checkbox').each(function() {
            if (this.checked) {
                document.getElementById('pst_to_add').value += this.value + ","
            }
        });

        document.getElementById('pst_to_add').value = document.getElementById('pst_to_add').value.slice(0, -1);



    }

    
    function fu_gravaSolucaoLimpCela(){
        //alert('fu_gravaSolucaoLimpCela')
        var param = "1";
        var IDlimp = parent.document.getElementById('tId_Limpeza').value
        var IDpast = parent.document.getElementById('tpst_numero').value
        var lote   = parent.document.getElementById('tnum_lote').value
        var senha = document.getElementById('txtSenhaSol').value
        var soluc = ""

        if ('<?php echo $_SESSION['usuarioSenha']; ?>' != document.getElementById('txtSenhaSol').value){
            parent.toastApp(3000,'***   SENHA INVÁLIDA   ***','ERRO')
            return;
        }




            _sel = 'txtSolPrin[]'
            var selected = [];
            var selectedval = [];
            for (var option of document.getElementById(_sel).options)
            {
                if (option.selected) {
                    selected.push(option.value);
                    selectedval.push(option.innerHTML);
                }
            }

            for (x=1;x<=selected.length;x++){
                soluc += selected[x-1] + "|"
            }


        

        $(document).ready(function(){
            $.ajax({ 
                url: '../functions.php',
                data: {gravalimpcelaSolucoes: param,
                       p01: IDlimp, 
                       p02: IDpast,
                       p03: lote,
                       p04: senha,
                       p05: soluc,
                      },
                type: 'post',
            });	
        });

        parent.toastApp(3000,'REGISTRO GRAVADO','OK')

    }


    function fu_populaSoluc(){
        $('.selforn1').selectpicker('val', parent.document.getElementById('ttxtfornSel1').value.split('|'))
    }


</script>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formVerCela' id='formVerCela'>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="txtlote">Lote:</label>
                            <input type="number" id="txtlote" name="txtlote" value="<?php echo $_GET["txtlote"] ?>" />
                        </div>
                        <div class="col-md-2">
                            <input type="submit" class="btn btn-primary" value="Pesquisar">
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-9">
                            <table id="tblista" class="display compact table-striped table-bordered responsive nowrap" style="width:100%; font-size:12px; font-family: Tahoma">
                                <thead style="background-color:#556295; color:#f2f3f7">
                                <tr>
                                    <th style="width:1px">&nbsp;</th>
                                    <th>ID</th>
                                    <th>Produto</th>
                                    <th>Pasta</th>
                                    <th>Lote</th>
                                    <th>Produção</th>
                                    <th>Limpeza</th>
                                    <th>Responsável</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php echo carregaLimpezaCelaGlove(); ?>
                                </tbody>
                            </table>
                        </div>        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<form  name='formAddCela' id='formAddCela' action=<?php echo $_SG['rf'] .'functions.php';?>  method="POST" target="processar">
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <input type="hidden" name="pst_to_add" id="pst_to_add" />
                Data da Limpeza: <input type="date" name='datlimpeza' id='datlimpeza' /><hr>
                <?php echo carregaLimpezaCelaGloveFantante(); ?>
                <hr>
                Senha: <input type="password" name="txtSenha" id="txtSenha" />
                <input type="submit" class="btn btn-primary" onclick="fu_gravaLimpCela()" name="bntGravaLimpCela" id="bntGravaLimpCela" value="Gravar" />
            </div>
        </div>
    </div>
</div>
</form>

<iframe name="processar" id="processar" style="display:none"></iframe>


<?php include("../footer.php");?>

<script type="text/javascript">



$(document).ready(function () {
    $('#tblista').DataTable({
        //"language": {
        //        "url": "https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json"
        //},

        "language": {
                "url": "<?php  echo $_SG['rf']; ?>dist/js/pt-BR.php"
        },

        "dom": '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',   //solução boa para a parte de cima do grid
        //dom: 'lBfrtip',
		scrollX: true,
        fixedHeader: true,
        responsive : true,
        lengthChange: true,
        pageLength: 50,
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
                  { columns: ':visible'  }
            },

           ],
                    
        });
});



   






</script>


<!-- modal -->
<div class="modal fade " id="IncluiVerCela" tabindex="-1" role="dialog" aria-labelledby="eqpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eqpModalLabel">Materiais & Responsáveis</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color:#e8eff9;">
			<form action=<?php echo $_SG['rf'] .'functions.php';?>  target="processarIR" method="POST" name="formNewInfRad" id="formNewInfRad" enctype="multipart/form-data">

                <input type='hidden' name='tId_Limpeza' id='tId_Limpeza' value="<?php echo $pst_numero; ?>" />
                <input type='hidden' name='tpst_numero' id='tpst_numero' value="<?php echo $pst_numero; ?>" />
                <input type='hidden' name='tnum_lote'   id='tnum_lote' value="<?php echo $pst_numero; ?>" />
                <input type='hidden' name='ttxtfornSel1' id='ttxtfornSel1' value='' />
                
                <div class="row">
                    <div class="col-md-12 border btn-info">
                        Materiais
                    </div>
                </div>

                <div class="row bg-white">
                    <div class="col-md-11">

                        <select class="selectpicker selforn1 form-control form-control-sm " 
                            data-size="15" 
                            multiple  
                            data-live-search="true" 
                            title="Selecione Soluções" 
                            data-header="Selecione um ou mais ítens"
                            name="txtSolPrin[]"  
                            id="txtSolPrin[]">
                                <?php echo RetornaSolucaoLimpCela(); ?>
                        </select>
                        

                        <script>$('.selforn1').selectpicker('val', document.getElementById("ttxtfornSel1").value.split('|'));</script>

                    </div>
                </div>
                <div class="row  bg-white">
                    <div class="col-md-10 ">
                        <br>
                                Senha: <input type="password" name="txtSenhaSol" id="txtSenhaSol" />
                                <input type="button" class="btn btn-primary btn-sm custom-btn"  onclick="fu_gravaSolucaoLimpCela()" name="bntGravaSolucaoLimpCela" id="bntGravaSolucaoLimpCela" value="Gravar" />
                    </div>
                    
                </div>








                <div class="row">
                    <div class="col-md-12 border btn-info">
                        Responsáveis
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblistaResp" class="display compact table-striped table-bordered responsive nowrap" style="width:100%; font-size:12px; font-family: Tahoma">
                            <iframe name="ifrVerCela" id="ifrVerCela" class="clsVerCela" frameBorder="0" src="" ></iframe>
                        </table>
                    </div>
                </div>





			
    		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id='btnClose' xonclick="AfterCloseModal()" data-dismiss="modal">Fechar</button>
        
      </div>
    </div>
  </div>
</div>
<!-- fim modal -->