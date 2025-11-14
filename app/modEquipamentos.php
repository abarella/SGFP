
<?php
    
    //include("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
	//protegePagina(); // Chama a função que protege a página
    include("../functions.php");
    $pst_numero = $_GET["pst_numero"];
	//echo $pst_numero;
    //var_dump($_GET);
    //var_dump($_POST);
	$produto = $_GET["produto"];
	$prod_amigavel="";
	if ($produto == "rd_i131"){
		$prod_amigavel="Iodo 131";
	}

	if ($produto == "rd_ga67"){
		$prod_amigavel="Citrato de Gálio";
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
		$prod_amigavel="Gerador de Tecnécio";
	}


	if ($produto == "rd_caps"){
		$prod_amigavel="Iodo Cápsulas";
	}

	if ($produto == "rd_tl"){
		$prod_amigavel="Tálio";
	}




?>



<script>


    function excluiEqp(eqp, cont){
        if (document.getElementById('txtSenha').value == ""){
			toastApp(3000,'***   Informe a Senha   ***','ERRO')
            return
        }

		//alert(eqp)
		//alert(cont)
		document.getElementById("idcateg").value = document.getElementById("row600"+cont).value
		document.getElementById("ideqp").value = eqp;
		document.getElementById("ideqpAlt").value = eqp;
		document.getElementById("acao").value ='excluireqp'
		document.forms[1].method="POST";
		document.forms[1].target="_top";
		document.forms[1].submit();
    }

    function alteraEqp(eqp, cont){
        if (document.getElementById('txtSenha').value == ""){
			toastApp(3000,'***   Informe a Senha   ***','ERRO')
			var cmbtroc = 'cmbEquipamento'+cont
			var datorow = 'row1500'+cont
			document.getElementById(cmbtroc).value = document.getElementById(datorow).value
            return
        }

        document.getElementById("acao").value ='alterareqp'
        var table = document.getElementById('tblista');
        for (var r=1, n=table.rows.length; r<n; r++) {
            d1 = document.getElementById("row1500"+r).value
            d2 = document.getElementById("cmbEquipamento"+r).value
            d3 = document.getElementById("row600"+r).value
            if (d1 != d2){
                document.getElementById("ideqp").value =d1
                document.getElementById("idcateg").value =d3
            }
        }
        document.getElementById("ideqpAlt").value = eqp;
        document.forms[1].method="POST";
        document.forms[1].target = "_top";
        document.forms[1].submit();
		
    }

	function myFunction1(_atv, _cal, _val, _con, _vol, _atx){
		document.getElementById('m_txtAtividade').value = _atv;
		document.getElementById('m_txtCalibracao').value = _cal;
		document.getElementById('m_txtValidade').value = _val;
		document.getElementById('m_txtConcentracao').value = _con;
		document.getElementById('m_txtVolume').value = _vol;
		document.getElementById('m_txtAtivEspec').value = _atx;
	}


	function TrocaCategoria(idcateg){
		select = document.getElementById('sncr');
		$('#sncr option').remove();
		var obj = JSON.parse(nameList);
		var filteredValue = obj.filter(function (item) {
			return item.id == idcateg ;
		});

		for(var i=0; i<filteredValue.length; i++){
			//alert(JSON.stringify(filteredValue[i])
			var opt = document.createElement('option');
			const myObj = JSON.parse(JSON.stringify(filteredValue[i]));
			//alert(myObj["id"] + ' | ' + myObj["descr"]);
			opt.value = myObj["idsel"];
    		opt.innerHTML = myObj["descr"];
    		select.appendChild(opt);
		}
		
	}


	function AfterCloseModal(){
		setTimeout(function(){
    		location.href = location.href;
		}, 1000);
	}

	function AtualizaFontCalib(fonte){
		var tec = document.getElementById("cmbTecnico").options[document.getElementById("cmbTecnico").selectedIndex].innerText;
		$.ajax({ url: '../functions.php',
         data: {fonteCalib: fonte,
		        pst_numero:document.getElementById("pst_numero").value,
				tecnico: tec
			   },
         		type: 'post',
         		success: function(output) {
					toastApp(3000,'Fonte de Calibração Gravado','OK')
					location.href = location.href;
                }
			}
		);
	}


function IncluiEqp(){
	//if($("formNewEqp").valid()){
    //	e.preventDefault();
	//}

	var tec = '3523' //document.getElementById("cmbTecnico").options[document.getElementById("cmbTecnico").selectedIndex].innerText;
	var pst = '3523' //document.getElementById("pst_numero").value;
	var sncr = '3523' //document.getElementById("sncr").value;
	var _txtSenha = '3523' //document.getElementById("m_txtSenha").value;
	$.ajax({ url: '../functions.php',
         data: {gravaNovoEquipamento: pst,
				pst_numero: pst,
				sncr: sncr,
				cmbtecnico: tec,
				m_txtSenha: _txtSenha
			   },
       		type: 'post',
         		success: function(output) {
					toastApp(3000,'Equipamento Gravado com Sucesso','OK')

                }
		});	
		
	AfterCloseModal()
}


</script>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->

				<form name='formEqp' id='formEqp'>
				<div class="row">
					<div class="col-md-4">
						Técnico: <?php echo CarregaTecnico();  ?>
					</div>
					<div class="col-md-4">
						Senha: <input type="password" name="txtSenha" id="txtSenha" class="form-control form-control-sm" maxlength="6" size="7" required />
					</div>
					<div class="col-md-3">
					<br><button type="button"  class="btn btn-primary btn-sm"  data-toggle="modal"  data-target="#IncluiEquipamento" data-backdrop="static" data-keyboard="false">Inclui Equipamento</button>
					</div>
				</div>
				<br>
				<table id="tblista" class="display compact table-striped table-bordered nowrap" style="width:100%; font-size:12px; font-family: Tahoma">
					<thead style="background-color:#556295; color:#f2f3f7">
						<tr>
							<th>Função</th>
							<th>Descrição</th>
							<th>Número CR</th>
							<th>Validade</th>
							<th>Manutenção Validade</th>
							<th>Descrição Eqpto</th>
						</tr>
					</thead>
					<tbody>
						<?php echo MontaGridEquipamentos($pst_numero); ?>
					</tbody>
				</table>
				</form>
			</div>
		</div>
		<iframe name="processarEQ" id="processarEQ" style="display:none"></iframe>
	</div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
				<input type='hidden' name='txtfontcalib' id='txtfontcalib' />
				Fonte de Calibração:&nbsp;&nbsp;&nbsp;&nbsp;
								<!--
								<input type="radio" onclick="AtualizaFontCalib(this.value)" name="fontcalib" id="cesio" checked value="Césio 137" > Césio 137&nbsp;&nbsp;
								<input type="radio" onclick="AtualizaFontCalib(this.value)" name="fontcalib" id="cobalto"       value="Cobalto 57"> Cobalto 57&nbsp;&nbsp;
								<input type="radio" onclick="AtualizaFontCalib(this.value)" name="fontcalib" id="bario"         value="Bário 133" > Bário 133&nbsp;&nbsp;
								<input type="radio" onclick="AtualizaFontCalib(this.value)" name="fontcalib" id="iodo"          value="Iodo 131"  > Iodo 131&nbsp;&nbsp;
								-->
								<select id="fontcalib" name="fontcalib" class="form-control w-25 " onchange="AtualizaFontCalib(this.value)">
									<?php CarregaFonteCalibCMB() ?>
								</select>
					<?php CarregaFonteCalib($_GET['pst_numero']) ?>

					<script>
						document.getElementById('fontcalib').value = document.getElementById('txtfontcalib').value
					</script>

				
			</div>
		</div>
	</div>
</div>

<!-- modal -->
<div class="modal fade " id="IncluiEquipamento" tabindex="-1" role="dialog" aria-labelledby="eqpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eqpModalLabel">Incluir Equipamento <?php echo $prod_amigavel; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color:#e8eff9;">
			<form action=<?php echo $_SG['rf'] .'functions.php';?>  target="processarEQ" method="POST" name="formNewEqp" id="formNewEqp" enctype="multipart/form-data">

				<div class="row">
					<input type='hidden' id='pst_numero' name='pst_numero' value='<?php echo $_GET['pst_numero']; ?>' />
					<div class="col-md-6">
						<div class="form-group">
							<label for="m_categoria" class="form-label">Categoria</label>
							<div class="input-group">
								<?php echo CategoriaEquipamentos(); ?>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							&nbsp;<label for="m_txtAtividade" class="form-label">Nº CR</label>
							<div class="input-group">
								<select id="sncr" name="sncr" class="form-control form-control-sm" style="width:100%">
								</select>

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
        <button type="submit" name="gravaNovoEquipamento" id="gravaNovoEquipamento" onclick="IncluiEqp();"  class="btn btn-primary" form="formNewEqp" >Salvar</button>
      </div>
    </div>
  </div>
</div>


