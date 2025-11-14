

<?php
    $ano = $_GET["cmbAno"];
    $lote = $_GET["txtLote"];
    $produto = $_GET["produto"];
    if ($ano == ""){$ano = date("Y");}
    if ($lote == ""){$lote = "0";}

	$prod_amigavel="";
	if ($produto == "rd_i131"){
		$prod_amigavel="IODETO DE SÓDIO I-131";
	}

	if ($produto == "rd_ga67"){
		$prod_amigavel="CITRATO DE GÁLIO GA-67";
	}

	if ($produto == "RD_CR51"){
		$prod_amigavel="Cromato de Sódio";
	}

	if ($produto == "RD_S35"){
		$prod_amigavel="Enxofre";
	}

	if ($produto == "rd_p32"){
		$prod_amigavel="Fósforo";
	}


	if ($produto == "rd_mo"){
		$prod_amigavel="GERADOR DE TECNÉCIO";
	}


	if ($produto == "rd_caps"){
		$prod_amigavel="IODETO DE SÓDIO EM CÁPSULA I-131";
	}

	if ($produto == "rd_tl"){
		$prod_amigavel="CLORETO DE TÁLIO TL-201";
	}


	session_start();
	$_SESSION['nome_da_tela'] = 'Distribuição R.P. / ' . $prod_amigavel;
	include("../header.php"); 
	
	
?>



<script>
function myFunction1(_atv, _cal, _val, _con, _vol, _atx){
	document.getElementById('m_txtAtividade').value = _atv;
	document.getElementById('m_txtCalibracao').value = _cal;
	document.getElementById('m_txtValidade').value = _val;
	document.getElementById('m_txtConcentracao').value = _con;
	document.getElementById('m_txtVolume').value = _vol;
	document.getElementById('m_txtAtivEspec').value = _atx;
}

function fuAbre(nlote, ntipo,produto, ano, pst_numero){
	//alert(nlote + ' | ' + pst_numero + ' | ' + produto);
	//ED = Editar
	const windowFeatures = "left=10,top=10,width=940px,height=620,menubar=no,location=no,resizable=no,scrollbars=no,status=no,toolbar=no";
	if(ntipo == 'ED'){
		window.open("LimpezaCela.php?lote="+nlote+"&produto="+produto+"&ano="+ano+"&pst_numero="+pst_numero, target="_self");
	}

	if(ntipo == 'I1'){
		if(produto=='rd_i131') {
			window.open("<?php echo $_SESSION['PATH_RELATORIO']; ?>" +"/0300-RADIOFARMACIA/01-SGCR/01-FOLHADEPRODUCAO/02-IODO/fm-cr-p03.11-01v7&pst_numero="+pst_numero+"&tipo=1&rs:Command=Render", "vcd")
		}
		if(produto=='rd_ga67') {
			window.open("<?php echo $_SESSION['PATH_RELATORIO']; ?>" +"/0300-RADIOFARMACIA/01-SGCR/01-FOLHADEPRODUCAO/01-GALIO/FMCRP031201V7&pst_numero="+pst_numero+"&rs:Command=Render", "vcd")
		}

		if(produto=='rd_tl') {
			window.open("<?php echo $_SESSION['PATH_RELATORIO']; ?>" +"/0300-RADIOFARMACIA/01-SGCR/01-FOLHADEPRODUCAO/03-TALIO/RelatProducaoTALIO&pst_numero="+pst_numero+"&rs:Command=Render", "vcd")
		}
	}

	if(ntipo == 'I2'){
		if(produto=='rd_i131') {
			window.open("<?php echo $_SESSION['PATH_RELATORIO']; ?>" +"/0300-RADIOFARMACIA/01-SGCR/01-FOLHADEPRODUCAO/02-IODO/RelatProducaoIODO&pst_numero="+pst_numero+"&rs:Command=Render", "vcd")
		}
		if(produto=='rd_ga67') {
			window.open("<?php echo $_SESSION['PATH_RELATORIO']; ?>" +"/0300-RADIOFARMACIA/01-SGCR/01-FOLHADEPRODUCAO/01-GALIO/RelatProducaoGALIO&pst_numero="+pst_numero+"&rs:Command=Render", "vcd")
		}

		if(produto=='rd_tl') {
			window.open("<?php echo $_SESSION['PATH_RELATORIO']; ?>" +"/0300-RADIOFARMACIA/01-SGCR/01-FOLHADEPRODUCAO/03-TALIO/RelatProducaoTALIO&pst_numero="+pst_numero+"&rs:Command=Render", "vcd")
		}
		
		
	}



}

	$('#splash').hide();
	function myFunction(param, msg, tipo){
		document.getElementById("splash-content").innerHTML = msg;
		if (tipo==1){_class = "btn btn-secondary"}
		if (tipo==2){_class = "btn btn-primary"}

		$('#splash-content').addClass(_class);
		$('#splash').show();
		var time = param;
  		setTimeout(function() {
    		$('#splash').hide();
  		}, time);
		  $('#splash').removeClass(_class);
	}
</script>


<div id="splash"  style="display:none;">
   <div id="splash-content"  >Mardi Gras Parade!!!!!!</div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body text-center">


				<!--<h2 class="mb-30">Listagem de Folhas de Produção - <?php echo $prod_amigavel; ?></h2>-->
				<form name="frmCabec" id="frmCabec">
					<div class="row">
				    <div class="col-sm-12 col-md-12">
				        <div class="row">
				            <div class="col-sm-3 col-md-3" xstyle="background-color:red">
								Lote: <input  type="number" min="0" step="1" id="txtLote"  name="txtLote" class="form-control form-control-sm" value="<?php echo $lote; ?>"></input>
							</div>
				            <div class="col-sm-3 col-md-3" xstyle="background-color:yellow">
								Ano: <select name="cmbAno" id="cmbAno" onchange="javascript:submit();" class="form-control form-control-sm">
									<?php
										for($i=date("Y")+1;$i>=2000;$i--){
											echo "<option value=". $i .">" . $i . "</option>";
										}
									?>
								</select>
							</div>
							<div class="col-sm-6 col-md-6" xstyle="background-color:red">
									<br><button type="button" class="btn btn-primary swalDefaultSuccess" data-toggle="modal" data-target="#pedidoExtra" data-backdrop="static" data-keyboard="false">Pedido Extra</button>
							</div>
				        </div>
				    </div>
               
					</div>
        </div>            
    </div>
</div>       
					</div>
					<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div xclass="card-body text-center">					
						<input type="hidden" name="produto" id="produto" value="<?php echo($produto) ?>" />
								<?php  echo "<script>document.frmCabec.cmbAno.value = '".$ano."'</script>";?>
						</form>
							<br>
							<table id="tblista" class="display compact table-striped table-bordered nowrap" style="width:100%; font-size:12px; font-family: Tahoma">
								<thead style="background-color:#556295; color:#f2f3f7">
									<tr>
										<th>Funções</th>
										<th>Lote</th>
										<th>Produto</th>
										<th>Produção</th>
										<th>Calibração</th>
										<th>Técnico Responsável</th>
										<th>Controle da Qualidade</th>
										<th>Garantia da Qualidade</th>
										<th>Status</th>
										<th>Observação</th>
									</tr>
								</thead>
								<tbody>

								<?php
								include("../lib/DB.php");
								$query = "exec crsa.uspPPST_PRODUCAO_LISTA ".$ano.",'" . $produto. "',". $lote . ", '" . $serie . "'";
								$stmt = $conn->query($query);
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									echo "<tr>";
									echo "<td>";
									echo "<button data-toggle='tooltip' data-placement='top' title='Editar Folha'          type='submit' class='btn btn-sm btn-outline-primary'  onclick='fuAbre(\"".$row['Lote']."\", \"ED\",\"$produto\",\"$ano\",\"".$row['pst_numero']."\")'><i class='fas fa-edit'></i></button>";
									echo "<button data-toggle='tooltip' data-placement='top' title='Folha de Produção'     type='submit' class='btn btn-sm btn-outline-primary'  onclick='fuAbre(\"".$row['Lote']."\", \"I1\",\"$produto\",\"$ano\",\"".$row['pst_numero']."\")'><i class='fas fa-print'></i></button>";
									echo "<button data-toggle='tooltip' data-placement='top' title='Relatório de Produção' type='submit' class='btn btn-sm btn-outline-primary'  onclick='fuAbre(\"".$row['Lote']."\", \"I2\",\"$produto\",\"$ano\",\"".$row['pst_numero']."\")'><i class='fas fa-clock'></i></button>";
									//echo "<button data-toggle='tooltip' data-placement='top' title='TBA'                type='submit' class='btn btn-sm btn-outline-primary'  onclick='fuAbre(\"".$row[Lote]."\", \"LO\",\"$produto\",\"$ano\",\"".$row[pst_numero]."\")'><i class='fas fa-plug'></i></button>";
									
									

									echo "</td>";
									echo "<td>" . $row['Lote'] . "</td>";
									echo "<td>" . $row['nome_comercial'] ."</td>";
									echo "<td>" . $row['producao'] ."</td>";
									echo "<td>" . $row['calibracao'] ."</td>";
									echo "<td>" . $row['tecnico'] ."</td>";
									echo "<td>" . $row['CQ_resultado'] . "&nbsp;" . $row['CQ_nome'] . "&nbsp;" . $row['CQ_data'] ."</td>";
									echo "<td>" . $row['GQ_resultado'] . "&nbsp;" . $row['GQ_nome'] . "&nbsp;" . $row['GQ_data'] ."</td>";
									echo "<td>" . $row['status'] ."</td>";
									echo "<td>" . $row['pst_observacao'] ."</td>";
									echo "</tr>";
								}
								
							?>

								</tbody>
								<tfoot style="background-color:#556295; color:#f2f3f7">
									<tr>
									<th>Funções</th>
										<th>Lote</th>
										<th>Produto</th>
										<th>Produção</th>
										<th>Calibração</th>
										<th>Técnico Responsável</th>
										<th>Controle da Qualidade</th>
										<th>Garantia da Qualidade</th>
										<th>Status</th>
										<th>Observação</th>
									</tr>
								</tfoot>
							</table>
							
	

					
			
		</div>
		</div>            
    </div>
</div>       

	
	<?php include("../footer.php"); ?>	
	<iframe id="processar" name="processar" style="display:none" ></iframe> 

	






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


$(function(){
   $("#txtLote").on("blur",function(){
      $("#frmCabec").submit();
   });

})();





</script>



<!-- modal -->
<div class="modal fade"   id="pedidoExtra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pedido Extra <?php echo $prod_amigavel; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color:#e8eff9;">
			<form action=<?php echo $_SG['rf'] .'functions.php';?>  target="processar" method="POST" name="formPedidoExtra" id="formPedidoExtra" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							&nbsp;<label for="m_txtLote" class="form-label">Lote Nº</label>
							<div class="input-group">
								&nbsp;<input type="text" class="form-control form-control-sm" name="m_txtLote" id="m_txtLote"  placeholder="Lote Nº"  aria-label="XXXX">
								<div class="input-group-append">
									<button type="submit" name="verLoteExiste" id="verLoteExiste"  class="btn btn-sm btn-primary" form="formPedidoExtra">Pesquisa</button>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							&nbsp;<label for="m_txtAtividade" class="form-label">Atividade</label>
							<div class="input-group">
								&nbsp;<input type="text" class="form-control form-control-sm" name="m_txtAtividade" id="m_txtAtividade" />
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							&nbsp;<label for="m_txtCalibracao" class="form-label">Calibração</label>
							<div class="input-group">
								&nbsp;<input type="datetime-local" class="form-control form-control-sm" name="m_txtCalibracao" id="m_txtCalibracao"  placeholder=""  aria-label="XXXX">
							</div>
						</div>
					</div>
				
					<div class="col-md-6">
						<div class="form-group">
							&nbsp;<label for="m_txtValidade" class="form-label">Validade</label>
							<div class="input-group">
								&nbsp;<input type="datetime-local" class="form-control form-control-sm" name="m_txtValidade" id="m_txtValidade" />
							</div>
						</div>
					</div>
				</div>


				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							&nbsp;<label for="m_txtConcentracao" class="form-label">Concentração</label>
							<div class="input-group">
								&nbsp;<input type="text" class="form-control form-control-sm" name="m_txtConcentracao" id="m_txtConcentracao"  placeholder=""  aria-label="XXXX">
							</div>
						</div>
					</div>
				
					<div class="col-md-6">
						<div class="form-group">
							&nbsp;<label for="m_txtVolume" class="form-label">Volume</label>
							<div class="input-group">
								&nbsp;<input type="text" class="form-control form-control-sm" name="m_txtVolume" id="m_txtVolume" />
							</div>
						</div>
					</div>
				</div>


				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							&nbsp;<label for="m_txtAtivEspec" class="form-label">Atividade Especial</label>
							<div class="input-group">
								&nbsp;<input type="text" class="form-control form-control-sm" name="m_txtAtivEspec" id="m_txtAtivEspec"  placeholder=""  aria-label="XXXX">
							</div>
						</div>
					</div>
				
					<div class="col-md-6">
						<div class="form-group">
							&nbsp;<label for="m_txtSenha" class="form-label">Senha</label>
							<div class="input-group">
								&nbsp;<input type="password" class="form-control form-control-sm" name="m_txtSenha" id="m_txtSenha" />
							</div>
						</div>
					</div>
				</div>





			</div>
		</form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" name="gravaPedidoExtra" id="gravaPedidoExtra"  class="btn btn-primary" form="formPedidoExtra">Salvar</button>
      </div>
    </div>
  </div>
</div>



<script>
$('#gravaPedidoExtra').click(function(){
	setTimeout(function() {$('#pedidoExtra').modal('hide');},2000);
});
</script>


