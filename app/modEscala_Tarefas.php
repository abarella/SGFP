
<script>
	function AfterCloseModal(){
        //alert(location.href)
		setTimeout(function(){
            location.href = location.href;
		}, 4000);
	}


    function excluiEscTar(id){
        if(document.getElementById("txtSenha").value == ''){
            toastApp(3000,'Informe a Senha ','ERRO')
        }
        else{
            document.getElementById("id").value = id
            document.getElementById("acao").value ='excluiEscTarefa'
            document.forms[1].method="POST";
            document.forms[1].target="processar";
            document.forms[1].submit();
            //toastApp(3000,'Registro Excluido','OK')
            AfterCloseModal()
        }

    }


    function fu_edtEscTarrefa(id,nome){
        nome = nome.split("¬").join(" ");
        document.getElementById('m_txtNome').value = nome

        document.getElementById("nr_ID").value = id
        $('#IncluiInfRadio').modal({backdrop: 'static', keyboard: false})  
        $('#IncluiInfRadio').modal('show'); 
    }

</script>    





<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formEscalaLocal' action=<?php echo $_SG['rf'] .'functions.php';?>  target="processar" method="POST">
                    <div class="row">
                        <div class="col-md-8">
                                    Nome da Tarefa:
                                    <input type='text' class='form-control' id='txtNomeTarefa' name='txtNomeTarefa' />
                        </div>
                        <div class="col-md-2">
                        Senha: <input type="password" name="txtSenha" id="txtSenha" class="form-control form-control" maxlength="6" size="7" required />
                        </div>
                        <div class="col-md-2">
                           <br> <input type=submit class='btn btn-primary' id="InserirTarefa" name="InserirTarefa" value='Inserir' />
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <br><hr>
                            <input type='hidden' name='id' id='id' />
                            <input type='hidden' name='acao' id='acao' />

                            <table id="tblista" class="display compact table-striped table-bordered nowrap" style="width:100%; font-size:12px; font-family: Tahoma">
                                <thead style="background-color:#556295; color:#f2f3f7">
                                    <tr>
                                        <th style="width:5px"></th>
                                        <th style="text-align:center;width:5px">Item</th>
                                        <th>Nome da Tarefa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo RetornaEscalaTarefas(); ?>
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
                  { columns: ':visible'  }
            },

           ],
                    
        });
});

</script>




<!-- modal -->
<div class="modal fade " id="IncluiInfRadio" tabindex="-1" role="dialog" aria-labelledby="eqpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eqpModalLabel">Editar Tarefa da Escala</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color:#e8eff9;">
			<form action=<?php echo $_SG['rf'] .'functions.php';?>  target="processar" method="POST" name="formEscTarefa" id="formEscTarefa" enctype="multipart/form-data">

                <input type='hidden' name='nr_ID'  id='nr_ID' value="" />
                <div class="row">
                    <div class="col-md-12">
                        <input type=text name="m_txtNome" id="m_txtNome" class='form-control form-control-sm' />
                    </div>
                </div>
                <hr>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							&nbsp;<label for="m_txtSenha" class="form-label">Senha</label>
							<div class="input-group">
								&nbsp;<input type="password" class="form-control form-control-sm" name="m_txtSenha" id="m_txtSenha" required />
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id='btnClose' onclick="AfterCloseModal()" data-dismiss="modal">Fechar</button>
        <button type="submit" name="InserirTarefa" id="InserirTarefa" onclick="InserirTarefa();"  class="btn btn-primary" form="formEscTarefa" >Salvar</button>
      </div>
    </div>
  </div>
</div>
<!-- fim modal -->
