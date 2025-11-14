<?php include ('../functions.php')?>

<script>
    function fu_edtAmostra(id1, id2, id3, id4, id5){
        //alert(id1 + " - " + id2 + " - " + id3 + " - " + id4 + " - " + id5)
        //$("#IncluiFrascoAmostra").modal()
        
        var modal = $("#IncluiFrascoAmostra").modal();
        modal.find('.modal-title').text('Alterar Frasco');

        document.getElementById("id1").value = id1
        document.getElementById("id2").value = id2
        document.getElementById("txtIdent").value = id3
        document.getElementById("txtAtividade").value = id4
        document.getElementById("txtVolume").value = id5
        


    }

    function fu_relatorio(){
        p1 =document.getElementById('p551_cq_id').value
        p2 = document.getElementById('p612_transferenciaid').value
        window.open("<?php echo $_SESSION['PATH_RELATORIO']; ?>" +"fmcrc0601v6?p551_cq_id="+p1+"&p612_transferenciaid="+p2+"&rs:Command=Render", "vcd")
    }
</script>



<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formAmostras' id='formAmostras' >

                <input type="hidden" name="p551_cq_id" id="p551_cq_id" />
                <input type="hidden" name="p612_transferenciaid" id="p612_transferenciaid" />
                <input type="hidden" name="pst_numero" id="pst_numero" value="<?php echo $_GET['pst_numero'] ?>" />
                <input type="hidden" name="versenha" id="versenha" value="<?php echo $_SESSION['usuarioSenha'] ?>" />

                    <div class="row">
                        <div class="col-md-2">
                            Leitura pH<br><input type="number" id=p551_ph name=p551_ph />
                        </div>
                        <div class="col-md-2">
                            Hora da Amostragem<br><input type="time" id=p551_horaamostragem name=p551_horaamostragem />
                        </div>

                        <div class="col-md-2">
                            Aspecto <?php echo carregaAspecto(); ?>
                        </div>

                        <div class="col-md-4">
                            Observação  <textarea class="form-control" id="p551_obs" rows="2"></textarea>
                        </div>


                    </div>

                    <br>

                    <?php echo CarregaAmostras(); ?>

                    <div class="row">
                        <div class="col-md-3">
                        <table id="tblista" class="display compact table-striped table-bordered responsive nowrap" style="width:100%; font-size:12px; font-family: Tahoma">
                                <thead style="background-color:#556295; color:#f2f3f7">
                                    <tr>
                                        <th>Funções</th>
                                        <th>Nº Frasco</th>
                                        <th>Atividade</th>
                                        <th>Volume</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo RetornaAmostras(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-2"><button class="btn btn-primary btn-sm"  data-toggle="modal" onclick="carregaModalInsert()" data-target="#IncluiFrascoAmostra" data-backdrop="static" data-keyboard="false" ><i class="fa-solid fa-flask"></i> | Incluir Frasco</button></div>
                        <div class="col-md-1"><button class="btn btn-primary btn-sm" onclick="javascript:fu_relatorio();return false;"><i class="fa fa-folder"></i> | Relatório de Amostras</button></div>
                         
                    </div>

                    <br>

                    <div class="row">
                        
                        <div class="col-md-4">
                            Técnico: <?php echo CarregaTecnico();  ?>
                        </div>
                        <div class="col-md-2">
                            Senha: <input type="password" name="txtSenha" id="txtSenha" class="form-control form-control-sm" maxlength="6" size="7" required />
                        </div>
                        <div class="col-md-2">
                        <br><button type="button"  class="btn btn-primary btn-sm"  data-toggle="modal"  data-target="#ver" onclick="GravarAmostraCAB()" data-backdrop="static" data-keyboard="false">Gravar</button>
                        </div>
                    </div>
                </form>
                <!-- fim do conteúdo -->
            </div>
        </div>
    </div>
</div>






<!-- modal -->
<div class="modal fade " id="IncluiFrascoAmostra" tabindex="-1" role="dialog" aria-labelledby="matModalLabel" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eqpModalLabel">Incluir Frasco</h5> 
        <button type="button" class="close" onclick="AfterCloseModal(1)" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color:#e8eff9;">
			<form action=<?php echo $_SG['rf'] .'functions.php';?>  target="processarMAT" method="POST" name="formIncluirFrascoAmostra" id="formIncluirFrascoAmostra" enctype="multipart/form-data">

                <input type="hidden" name="id1" id="id1" />
                <input type="hidden" name="id2" id="id2" />
                <br>

                <label for="txtIdent" class="form-label">Frasco</label>
                <input type="text"   class="form-control form-control-sm" name="txtIdent" id="txtIdent" />
                <br>
                <label for="txtAtividade" class="form-label">Atividade</label>
                <input type="number" class="form-control form-control-sm" name="txtAtividade" id="txtAtividade" step="0.01" />


                <label for="txtVolume" class="form-label">Volume</label>
                <input type="number" class="form-control form-control-sm" name="txtVolume" id="txtVolume" step="0.01" />
<hr>
            </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id='btnClose' onclick="AfterCloseModal(4)" data-dismiss="modal">Fechar</button>
        <button type="submit" name="gravaAmostra" id="gravaAmostra"  onclick="IncluiFrascoAmostra();" class="btn btn-primary" form="formNewMat" >Salvar</button>
      </div>
    </div>
  </div>
</div>





<script>


function AfterCloseModal(p){
    
    setTimeout(function(){
        location.href = location.href;
    }, 1000);
}

function carregaModalInsert(){
    var modal = $("#IncluiFrascoAmostra").modal();
        modal.find('.modal-title').text('Incluir Frasco');
        document.getElementById("id1").value ="0"
        document.getElementById("id2").value = document.getElementById('p551_cq_id').value
        document.getElementById("txtIdent").value =""
        document.getElementById("txtAtividade").value ="0.00"
        document.getElementById("txtVolume").value ="0.00"
        
}


function IncluiFrascoAmostra(){

//_versernha = document.getElementById("m_txtSenha").value
//if (_versernha==""){return;}

_txtIdent = document.getElementById('txtIdent').value
_id1      = document.getElementById('id1').value
_id2      = document.getElementById('id2').value
_txtAtividade = document.getElementById('txtAtividade').value
_txtVolume = document.getElementById('txtVolume').value



var param = '1'
$.ajax({ url: '../functions.php',
        data: {gravaFrascoAmostra:param,
              txtIdent : _txtIdent,
              id1      : _id1,
              id2      : _id2,
              txtAtividade : _txtAtividade,
              txtVolume    : _txtVolume
            },
           type: 'post',
            success: function() {
            
            $('#IncluiFrascoAmostra').modal('hide');
            toastApp(3000,'Registro Gravado com Sucesso','OK')
            AfterCloseModal(1)
        },
        error: function() {
            toastApp(3000,'Erro ao gravar o registro','ERRO')
        }

});	

}


function ExcluiFrascoAmostra(_id1, _id2){
    if (confirm("Deseja excluir este registro ?"))
    {

    var param = '1'
    $.ajax({ url: '../functions.php',
        data: {ExcluiFrascoAmostra:param,
              id1      : _id1,
              id2      : _id2,
            },
           type: 'post',
            success: function() {
            
            $('#IncluiFrascoAmostra').modal('hide');
            toastApp(3000,'Registro Excluído com Sucesso','OK')
            AfterCloseModal(1)
        },
        error: function() {
            toastApp(3000,'Erro ao gravar o registro','ERRO')
        }

    });	
}
}


function GravarAmostraCAB(){
    //alert('GravarAmostraCAB')

    if (document.getElementById("txtSenha").value ==""){
        toastApp(3000,'Informe a SENHA','ERRO')
        return
    }

    if (document.getElementById("txtSenha").value != document.getElementById("versenha").value){
        toastApp(3000,'SENHA inválida','ERRO')
        return
    }



    _p1 = document.getElementById("p551_cq_id").value
    _p2 = document.getElementById("p551_horaamostragem").value
    _p3 = document.getElementById("p551_ph").value
    _p4 = document.getElementById("p551_obs").value
    _p5 = document.getElementById("pst_numero").value
    _p6 = document.getElementById("cmbTecnico").value
    _p7 = document.getElementById("txtSenha").value
    _p8 = document.getElementById("cmbAspecto").value

    //exec crsa.P0551_FRASCOSCAB_IA 102928,'0931','7.0','teste',27458,0,default,3523,'0103',2,@p11 output,@p12 output,@p13 output

    var param = '1'
    $.ajax({ url: '../functions.php',
        data: {GravaAmostraCab:param,
              p1      : _p1,
              p2      : _p2,
              p3      : _p3,
              p4      : _p4,
              p5      : _p5,
              p6      : _p6,
              p7      : _p7,
              p8      : _p8,
            },
           type: 'post',
            success: function() {
            toastApp(3000,'Registro Gravado com Sucesso','OK')
            AfterCloseModal(1)
        },
        error: function() {
            toastApp(3000,'Erro ao gravar o registro','ERRO')
        }

    });	



}


function fu_delAmostra(id1, id2){
    ExcluiFrascoAmostra(id1, id2)

}


</script>