<?php include ('../functions.php')?>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tblista" class="display compact table-striped table-bordered nowrap" style="width:100%; font-size:12px; font-family: Tahoma">
                                <thead style="background-color:#556295; color:#f2f3f7">
                                    <tr>
                                        <th>Frasco<br>Nº</th>
                                        <th>Nome do<br>Cliente</th>
                                        <th>Atvividade<br>Solicitada (mCi)</th>
                                        <th>Atvividade<br>Solicitada (MBq)</th>
                                        <th>Atvividade<br>Enviada (MBq)</th>
                                        <th>Volume<br>Enviado (mL)</th>
                                        <th>Volume</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo RetornaFracCliente($_GET['pst_numero']); ?>
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
           columnDefs:
            [
                {
                    targets: 6,
                    render: $.fn.dataTable.render.number(',', '.', 2, '')
                },
            ],           
        });
});

</script>