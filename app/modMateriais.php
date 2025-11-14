<?php include ('../functions.php');

?>





<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formMateriais' id='formMateriais' >
                    <input type="hidden" name="p600_id" id="p600_id" />
                    <input type="hidden" name="acao" id="acao" />
                    <div class="row">
                        <div class="col-md-4">
                            Técnico: <?php echo CarregaTecnico();  ?>
                        </div>
                        <div class="col-md-4">
                            Senha: <input type="password" name="txtSenha" id="txtSenha" class="form-control form-control-sm" maxlength="6" size="7" required />
                        </div>

                        <div class="col-md-4">
                            <br><button type="button"  class="btn btn-primary btn-sm"  data-toggle="modal"  data-target="#IncluiMaterial" data-backdrop="static" data-keyboard="false">Inclui Material</button><br>
                        </div>
                    </div>
<br>
                    <div class="row">
                        <div class="col-md-12">

                            <table id="tblista" class="display compact table-striped table-bordered responsive nowrap" style="width:100%; font-size:12px; font-family: Tahoma">
                                <thead style="background-color:#556295; color:#f2f3f7">
                                    <tr>
                                        <th>Funções</th>
                                        <th>Nº</th>
                                        <th>Descrição</th>
                                        <th>Lote</th>
                                        <th>Marca</th>
                                        <th>Validade</th>
                                        <th>Quantidade </th>
                                        <th>Unidade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo RetornaMateriais(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
                <!-- fim do conteúdo -->
            </div>
        </div>
        <iframe name="processarMAT" id="processarMAT" style="display:none"></iframe>
    </div>
</div>

<?php include("../footer.php");?>

<script type="text/javascript">

function AfterCloseModal(p){
    
    setTimeout(function(){
        location.href = location.href;
    }, 1000);
}



function IncluiMaterial(){

    _versernha = document.getElementById("m_txtSenha").value
    if (_versernha==""){return;}

    //if($("formNewMat").invalid()){
    //  e.preventDefault();
    //}
    var param = '1'
	$.ajax({ url: '../functions.php',
            data: {gravaNovoMaterial:param},
       		type: 'post',
            success: function() {
                
                $('#IncluiMaterial').modal('hide');
                toastApp(3000,'Registro Gravado com Sucesso','OK')
                AfterCloseModal(1)
            },
            error: function() {
                toastApp(3000,'Erro ao gravar o registro','ERRO')
            }

	});	
    
}





$(document).ready(function () {
    var table = $('#tblistaMat').DataTable({
		"language": {
                "url": "<?php  echo $_SG['rf']; ?>dist/js/pt-BR.php"
        },

        "domxxx": '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',   //solução boa para a parte de cima do grid
        pageLength: 5,
        lengthMenu: [[5, 10, 50, 100, 250, 500, -1], [5, 10, 50, 100, 250, 500, "Todos"]],
        autoWidth: false,
        responsive: false,
        columnDefs: [
            { targets: [9],  visible: true, sortable:false, searchable: true,  width: 0, },
            { targets: [10], visible: true, sortable:false, searchable: false, width: 0, },
            { targets: [11], visible: true, sortable:false, searchable: false, width: 0, }
        
        ],
        });

        

        $('#sOrig').on('change', function(){
        table.columns(9).search(this.value).draw();   
    });




    $('#tblistaMat tbody').on('click', 'tr', function () {
    if ($(this).hasClass('selected')) {
        $(this).removeClass('selected');
        document.getElementById("txtNomeMat").value  = ""
        document.getElementById("txtLoteFab").value  = ""
        document.getElementById("txtValidade").value = ""
        document.getElementById("txtUnidade").value  = ""
        document.getElementById("txtQtde1").value  = ""
        document.getElementById("txtQtde2").value  = ""
        document.getElementById("txtLoteIPEN").value  = ""
        document.getElementById("txtLoteCR").value  = ""
        document.getElementById("matMarca").selectedIndex  = "0"
        document.getElementById("matMaterial").selectedIndex   = "0"
        document.getElementById("txtCodigoMat").value = ""



    }
    else {
        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        dia = ($(this)[0].cells[6].innerText.substring(0,2)) 
        mes = ($(this)[0].cells[6].innerText.substring(3,5)) 
        ano = ($(this)[0].cells[6].innerText.substring(6,10)) 

        

        document.getElementById("txtNomeMat").value  = $(this)[0].cells[2].innerText
        document.getElementById("txtLoteFab").value  = $(this)[0].cells[4].innerText    
        document.getElementById("txtLoteIPEN").value  = $(this)[0].cells[3].innerText    
        document.getElementById("txtLoteCR").value  = $(this)[0].cells[5].innerText    

        document.getElementById("txtValidade").value = ano+'-'+mes+'-'+dia
        document.getElementById("txtUnidade").value  = $(this)[0].cells[8].innerText    
        document.getElementById("sOrig").value = $(this)[0].cells[9].innerText
        document.getElementById("txtQtde1").value = $(this)[0].cells[7].innerText
        document.getElementById("matMarca").value = $(this)[0].cells[10].innerText
        document.getElementById("matMaterial").value = $(this)[0].cells[11].innerText
        document.getElementById("txtCodigoMat").value = $(this)[0].cells[1].innerText

        if ($(this)[0].cells[9].innerText=="Frascos & Soluções"){
            document.getElementById("matMarca").value = 4
        }
        
    }
    });

});


function limpamodal(){
    document.getElementById("txtNomeMat").value  = ""
    document.getElementById("txtLoteFab").value  = ""
    document.getElementById("txtValidade").value = ""
    document.getElementById("txtUnidade").value  = ""
    document.getElementById("txtQtde1").value  = ""
    document.getElementById("txtQtde2").value  = ""
    document.getElementById("txtLoteIPEN").value  = ""
    document.getElementById("txtLoteCR").value  = ""
    document.getElementById("matMarca").selectedIndex  = "0"
    document.getElementById("matMaterial").selectedIndex   = "0"
    document.getElementById("txtCodigoMat").value =""

}

function fu_delMaterial(id){
    if(document.getElementById("txtSenha").value == ''){
        toastApp(3000,'Informe a Senha ','ERRO')
    }
    else{
        document.getElementById("p600_id").value = id
        document.getElementById("acao").value ='excluirmat'
        document.forms[1].method="POST";
        document.forms[1].target="_top";
        document.forms[1].submit();
    }
}

function fu_edtMaterial(id,sistema, cod, lote, lotefor, marca, material, validade, tpcorcr, loteester, unid, nomematerial, qtde, posicao, ltipen, ltfor){
    //alert(id + " - " + cod + " - " + lote + " - " + marca)
    //alert(sistema)
    let comboBox = document.getElementById("sOrig")
    comboBox.selectedIndex =sistema

    lote = lote.split("¬").join(" ");
    document.getElementById("txtLoteCR").value = lote

    var table = $('#tblistaMat').DataTable();
    table.search( lote ).draw();
    
    $('#IncluiMaterial').modal({backdrop: 'static', keyboard: false})  
    $('#IncluiMaterial').modal('show'); 
    //$("#tblistaMat>tbody>tr:first").trigger('click');

    document.getElementById("txtCodigoList").value = id
    document.getElementById("txtCodigoMat").value = cod
    
    document.getElementById("txtLoteList").value = lote
    document.getElementById("txtLoteFab").value = lotefor
    document.getElementById("matMarca").value = marca
    document.getElementById("matMaterial").value = material
    document.getElementById("txtValidade").value = validade
    tpcorcr = tpcorcr.split("¬").join(" ");
    document.getElementById("txtTipoCorCR").value = tpcorcr
    loteester = loteester.split("¬").join(" ");
    document.getElementById("txtLoteEsterCQ").value = loteester
    document.getElementById("txtUnidade").value = unid
    nomematerial = nomematerial.split("¬").join(" ");
    document.getElementById("txtNomeMat").value=nomematerial
    document.getElementById("txtQtde1").value=qtde
    document.getElementById("txtPosicao").value=posicao
    document.getElementById("txtLoteIPEN").value=ltipen
    ltfor = ltfor.split("¬").join(" ");
    document.getElementById("txtLoteFab").value=ltfor

}


</script>



<!-- modal -->
<div class="modal fade " id="IncluiMaterial" tabindex="-1" role="dialog" aria-labelledby="matModalLabel" aria-hidden="true">
  <div class="modal-dialog full_modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eqpModalLabel">Incluir Material</h5> 
        <button type="button" class="close" onclick="AfterCloseModal(1)" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color:#e8eff9;">
			<form action=<?php echo $_SG['rf'] .'functions.php';?>  target="processarMAT" method="POST" name="formNewMat" id="formNewMat" enctype="multipart/form-data">

            <div class="row" id="gridBuscaLote" name="gridBuscaLote">
                    <div class="col-md-3">
						<div class="form-group">
							<label for="m_categoria" class="form-label">Origem</label>
							<div class="input-group">
								<select id="sOrig" name="sOrig" class="form-control form-control-sm" onchange="limpamodal();trataOrigem();"  >
                                    <option value='Selecione'>Selecione</option>
                                    <option value='Almoxarifado'>Almoxarifado</option>
                                    <option value='Frascos & Soluções'>Frascos & Soluções</option>
                                    <option value='Outros'>Outros</option>
                                </select>
                                <input type="hidden" name="txtCodigoMat" id="txtCodigoMat" />
                                <input type="hidden" name="txtCodigoList" id="txtCodigoList" />
                                <input type="hidden" name="txtLoteList" id="txtLoteList" />
                                <input type="hidden" name="LoteList" id="LoteList" value="<?php echo $_GET['lote'] ?>" />
							</div>
						</div>
					</div>

                    <div class="col-md-12" >
                        <table id="tblistaMat" class="display compact table-striped table-bordered responsive nowrap" style="width:100%; font-size:12px; font-family: Tahoma">
                            <thead style="background-color:#556295; color:#f2f3f7">
                                <tr>
                                    <th>Função</th>
                                    <th>Código</th>
                                    <th>Material</th>
                                    <th>Lote IPEN</th>
                                    <th>Lote FORNEC</th>
                                    <th>Lote CR</th>
                                    <th>Validade</th>
                                    <th>Quantidade</th>
                                    <th>Unidade</th>
                                    <th>Origem</th>
                                    <th>Marca</th>
                                    <th>Material</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo MontaGridMateriais(); ?>
                            </tbody>
                        </table>
                        
                    </div>
                </div>



                <div class="row">
					<input type='hidden' id='pst_numero' name='pst_numero' value='<?php echo $_GET['pst_numero']; ?>' />
					
					<div class="col-md-2">
						<div class="form-group">
							&nbsp;<label for="m_txtLoteFab" class="form-label">Lote Fornecedor</label>
							<div class="form-group">
                                <div class="input-group-prepend mb-3">
                                    <input type="text" class="form-control form-control-sm" id="txtLoteFab" name="txtLoteFab"  />
                                </div>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							&nbsp;<label for="m_txtLoteCR" class="form-label">Lote CR</label>
							<div class="form-group">
                                <div class="input-group-prepend mb-3">
                                    <input type="text" class="form-control form-control-sm" id="txtLoteCR" name="txtLoteCR"  />
                                </div>
							</div>
						</div>
					</div>

					<div class="col-md-7">
						<div class="form-group">
							&nbsp;<label for="m_txtNomeMat" class="form-label">Nome do Material</label>
							<div class="input-group">
								<input type="text" class="form-control form-control-sm" id="txtNomeMat" name="txtNomeMat"  />
							</div>
						</div>
					</div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
							&nbsp;<label for="m_txtLoteIPEN" class="form-label">Lote IPEN</label>
							<div class="input-group">
								<input type="text" class="form-control form-control-sm" id="txtLoteIPEN" name="txtLoteIPEN" />
							</div>
						</div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
							&nbsp;<label for="m_txtValidade" class="form-label">Validade</label>
							<div class="input-group">
								<input type="date" class="form-control form-control-sm" id="txtValidade" name="txtValidade" value="20230101" />
							</div>
						</div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
							&nbsp;<label for="m_txtMarca" class="form-label">Marca</label>
							<div class="input-group">
                                <?php echo MarcaMateriais(); ?>
							</div>
						</div>
                    </div>                    
                    <div class="col-md-5">
                        <div class="form-group">
							&nbsp;<label for="m_txtMaterial" class="form-label">Material</label>
							<div class="input-group">
                                <?php echo MaterialMateriais(); ?>
							</div>
						</div>
                    </div>                    
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
							&nbsp;<label for="m_txtTipoCorCR" class="form-label">Tipo Cor CR</label>
							<div class="input-group">
								<input type="text" class="form-control form-control-sm" id="txtTipoCorCR" name="txtTipoCorCR" />
							</div>
						</div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
							&nbsp;<label for="m_txtLoteEsterCQ" class="form-label">Lote Esteril. C.Q.</label>
							<div class="input-group">
								<input type="text" class="form-control form-control-sm" id="txtLoteEsterCQ" name="txtLoteEsterCQ" />
							</div>
						</div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
							&nbsp;<label for="m_txtUnidade" class="form-label">Unidade</label>
							<div class="input-group">
								<input type="text" class="form-control form-control-sm" id="txtUnidade" name="txtUnidade" />
							</div>
						</div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
							&nbsp;<label for="m_txtQtde1" class="form-label">Qtde</label>
							<div class="input-group">
								<input type="number" class="form-control form-control-sm" id="txtQtde1" name="txtQtde1" step="0.01" />
							</div>
						</div>
                    </div>

                    <div class="col-md-2 d-none">
                        <div class="form-group">
							&nbsp;<label for="m_txtQtde2" class="form-label">Qtde(2)</label>
							<div class="input-group">
								<input type="number" class="form-control form-control-sm" id="txtQtde2" name="txtQtde2" step="0.01" />
							</div>
						</div>
                    </div>



                    <div class="col-md-1">
                        <div class="form-group">
							&nbsp;<label for="m_txtPosicao" class="form-label">Posição</label>
							<div class="input-group">
								<input type="number" class="form-control form-control-sm" id="txtPosicao" name="txtPosicao" />
							</div>
						</div>
                    </div>



                </div>




				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="m_txtAtivEspec" class="form-label">Técnico</label>
							<div class="input-group">
								<?php echo CarregaTecnico();  ?>
							</div>
						</div>
					</div>
				
					<div class="col-md-1">
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
        <button type="button" class="btn btn-secondary" id='btnClose' onclick="AfterCloseModal(4)" data-dismiss="modal">Fechar</button>
        <button type="submit" name="gravaNovoMaterial" id="gravaNovoMaterial"  onclick="IncluiMaterial();" class="btn btn-primary" form="formNewMat" >Salvar</button>
      </div>
    </div>
  </div>
</div>

