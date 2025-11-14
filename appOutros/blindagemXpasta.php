<?php 

include("../functionsOutros.php");
session_start();
$_SESSION['nome_da_tela'] = 'Consultas / Blindagem X Pasta';

include("../header.php");
?>


<form  name='formBlindPst' id='formBlindPst' method="POST">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- inicio do conteúdo -->
                    <div class="col-md-2">
                        <label for="txtlote">Lote</label>
                        <input type="number" id="txtlote" name="txtlote" class="form-control form-control-sm" value="<?php echo $_REQUEST["txtlote"] ?>" />
                    </div>
                    <div class="col-md-2">
                        <label for="txtlote">Série</label>
                        <input type='text' id='txserie' name='txserie' class="form-control form-control-sm" value="<?php echo $_REQUEST["txserie"] ?>" />
                    </div>
                    <div class="col-md-2">
                        <br>
                        <input type='submit' id='btnpesq' name='btnpesq' class="btn-sm btn-primary" value="Pesquisar"  />
                    </div>
                    <div class="col-md-2">
                        <label for="txtlote">Divergências</label>
                        <input type='text' id='txcontagem' name='txcontagem' class="form-control form-control-sm" value="" readonly />
                    </div>
                    <div class="col-md-2">
                        <br>
                        
                           
<button type="button" class="btn-sm btn-primary" data-toggle="modal" data-target="#ModalAc" data-backdrop="static" data-keyboard="false">
  Acompanhamento
</button>
                    </div>
                </div>
            </div>
        </div>
    
</form>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <table id="tblista" class="display compact table-striped table-bordered nowrap" style="width:100%; font-size:12px; font-family: Tahoma">
					<thead style="background-color:#556295; color:#f2f3f7">
						<tr>
							<th>Lote</th>
                            <th>Nro Blindagem</th>
                            <th>Nro Blindagem (PASTA)</th>
                            <th>Série</th>
                            <th>Transp</th>
                            <th>Razão Social</th>
                            <th>Médico Responsável</th>
							
						</tr>
					</thead>
					<tbody>
						<?php echo carregaBlindagemXpasta($_REQUEST["txtlote"] ,$_REQUEST["txserie"]); ?>
					</tbody>
				</table>
            </div>
        </div>
    </div>
   
    
</div>

<?php include("../footer.php");?>
<iframe name="processar" id="processar" style="display:inline"></iframe>

<!-- Modal -->
<div class="modal fade" id="ModalAc" tabindex="-1" role="dialog" aria-labelledby="ModalAcLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document" xstyle="overflow-y: scroll; max-height:45%;  margin-top: 50px; margin-bottom:50px;" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalAcLabel">Acompanhamento de Lotes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmAcomp"  name="frmAcomp"  method="POST"  enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4">
                    <label for="txtAcomp">Informe o nº lote</label>
                    <input type="text" id="txtAcomp" name="txtAcomp" class="form-control form-control-sm" />
                    
                </div>
                <div class="col-md-6">
                    <br>
                    <input type="submit" class="btn btn-primary btn-sm custom-btn"   name="btnIncAcomp"  id="btnIncAcomp" value="Inserir" />
                    <input type="submit" class="btn btn-danger btn-sm custom-btn"    name="btnDelAcomp"  id="btnDelAcomp" value="Excluir" />
                </div>
            </div>
        </form>
        <div id="resposta"></div>
        <hr>
        <div class="row">
                <div class="col-md-12">
                    <table id="tblistaAC" class="display compact table-striped table-bordered " style="width:100%; font-size:12px; font-family: Tahoma">
                        <thead style="background-color:#556295; color:#f2f3f7; width:100px">
                            <th>ID</th>
                            <th>LOTE</th>
                        </thead>

                            <?php echo carregaAcompanhamento(); ?>

                    </table>
                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="AfterCloseModal()" data-dismiss="modal">Fechar</button>
        
      </div>
    </div>
  </div>
</div>




<script type="text/javascript">

function AfterCloseModal(){
    window.location.href = window.location.href.split('?')[0] + '?nocache=' + new Date().getTime();

}


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
        pageLength: 5,
        lengthMenu: [[5, 10, 50, 100, 250, 500, -1], [5, 10, 50, 100, 250, 500, "Todos"]],
        //buttons: [ 'copyHtml5', 'copy', 'excel', 'pdf', 'colvis' ],
        //buttons: [{ extend: 'copy', attr: { id: 'allan' } }, 'csv', 'excel', 'pdf'],
        //buttons: ['copyHtml5', 'excelHtml5','csvHtml5','pdfHtml5'],
        buttons: [
            //{ extend: 'print', exportOptions:
            //    { columns: ':visible' }
            //},
            { extend: 'copy', exportOptions:
                { columns: ':visible' }
            },

			{ extend: 'excel', exportOptions:
                 { columns: ':visible' }
            },
            { extend: 'pdf',
				orientation: 'landscape',
				exportOptions:
                  { columns: [ 1,2,3,4,5,6,7,8,9 ] }
            },
            { extend: 'colvis',   postfixButtons: [ 'colvisRestore' ] }
           ],




        });


    //table.buttons().container().appendTo( '#tblista .col-md-6:eq(0)' );
    //table.buttons().container().appendTo( $('.col-md-2:eq(0)', table.table().container()) );

});


//modal
$('#ModalAc').on('shown.bs.modal', function () {
    $('#tblistaAC').DataTable({
        "language": {
                "url": "<?php  echo $_SG['rf']; ?>dist/js/pt-BR.php"
        },
    }).columns.adjust().responsive.recalc();
});

$(document).ready(function () {
    $('#tblistaAC1').DataTable({
		"language": {
                "url": "<?php  echo $_SG['rf']; ?>dist/js/pt-BR.php"
        },

        //"dom": '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',   //solução boa para a parte de cima do grid
        //dom: 'lbfrtip',
		scrollX: true,
        fixedHeader: true,
        responsive : true,
        lengthChange: true,
        autoWidth: false,
        pageLength: 5,
        lengthMenu: [[5, 10, 50, 100, 250, 500, -1], [5, 10, 50, 100, 250, 500, "Todos"]],

        });
});




$(document).ready(function() {
    $('#frmAcomp').on('submit', function(event) {
        //event.preventDefault(); // Impede o envio padrão do formulário
        // Captura os dados do formulário
        var dadosFormulario = $(this).serialize();
        
        // Envia os dados via AJAX
        $.ajax({
            url: '../functionsOutros.php', // Altere para o endpoint correto do seu servidor
            type: 'POST',
            data: dadosFormulario,
            success: function(resposta) {
                // Manipula a resposta em caso de sucesso
                $('#resposta').html('<p>Formulário enviado com sucesso!</p>');
            },
            error: function(xhr, status, error) {
                // Manipula erros
                $('#resposta').html('<p>Ocorreu um erro: ' + error + '</p>');
            }
        });
        AfterCloseModal()
    });
});


$(document).ready(function () {
    $('#ModalAc').on('hide.bs.modal', function () {
        console.log('O modal está sendo fechado.');
        AfterCloseModal()
    });

    $('#ModalAc').on('hidden.bs.modal', function () {
        console.log('O modal foi completamente fechado.');
        AfterCloseModal()
    });
});

</script>


