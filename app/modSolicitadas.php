<?php include ('../functions.php')?>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->

                    <div class="row">
                        <div class="col-md-6 bg-primary text-white rounded border text-center ">
                            Sem Fator de Decaimento (A0)
                        </div>
                        <div class="col-md-6 bg-primary text-white rounded border text-center">
                            Com Fator de Decaimento (A0)
                        </div>
                    </div>

                    <?php 
                    
                        $valores = RetornaAtividadeSolicitadas($pst_numero); 
                        //echo $valores;
                        $v1 = explode('-',$valores); 
                    ?>

                    <div class="row">
                        <div class="col-md-3 rounded border text-center h6">
                            <?php echo number_format($v1[0], 0, ',', '.');?> mCi
                        </div>
                        <div class="col-md-3 rounded border text-center h6">
                            <?php echo number_format($v1[1], 0, ',', '.');?> MBq
                        </div>
                        <div class="col-md-3 rounded border text-center h6">
                            <?php echo number_format($v1[0], 0, ',', '.');?> mCi
                        </div>
                        <div class="col-md-3 rounded border text-center h6">
                            <?php echo number_format($v1[1], 0, ',', '.');?> MBq
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 ">&nbsp;</div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tblista" class="display compact table-striped table-bordered nowrap" style="width:100%; font-size:12px; font-family: Tahoma">
                                <thead style="background-color:#556295; color:#f2f3f7">
                                    <tr>
                                        <th>Atividade</th>
                                        <th>Partidas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo RetornaSolicitadasLista($pst_numero); ?>
                                </tbody>
                            </table>

                        </div>
                    </div>



                <!-- fim do conteúdo -->
            </div>
        </div>
    </div>
</div>

<?php include("../footer.php"); ?>

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
                  { columns: [ 1,2,3,4,5,6,7,8,9 ] }
            },

           ],




        });

});

</script>