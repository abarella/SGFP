            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->


       

        <!-- Main row -->

      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-light">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  
<!-- Main Footer -->
<footer class="main-footer" xstyle="z-index:2000;">
	    <strong>&copy; 2024 IPEN - Instituto de Pesquisas Energéticas e Nucleares.</strong>
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0 &nbsp; &nbsp; &nbsp;
    </div>
  </footer>

  
</div>


  

<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?php echo $_SG['rf'] ?>plugins/jquery/jquery.js"></script>
<!-- Bootstrap -->
<script src="<?php echo $_SG['rf'] ?>plugins/bootstrap/js/bootstrap.bundle.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo $_SG['rf'] ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $_SG['rf'] ?>dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?php echo $_SG['rf'] ?>plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?php echo $_SG['rf'] ?>plugins/raphael/raphael.js"></script>
<script src="<?php echo $_SG['rf'] ?>plugins/jquery-mapael/jquery.mapael.js"></script>
<script src="<?php echo $_SG['rf'] ?>plugins/jquery-mapael/maps/usa_states.js"></script>
<!-- ChartJS -->
<script src="<?php echo $_SG['rf'] ?>plugins/chart.js/Chart.min.js"></script>

<!-- Toast & Sweet -->
<script src="<?php echo $_SG['rf'] ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo $_SG['rf'] ?>plugins/toastr/toastr.min.js"></script>

<!-- DataTables  & Plugins -->
<script src="<?php echo $_SG['rf'] ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $_SG['rf'] ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $_SG['rf'] ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo $_SG['rf'] ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo $_SG['rf'] ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo $_SG['rf'] ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo $_SG['rf'] ?>plugins/jszip/jszip.min.js"></script>
<script src="<?php echo $_SG['rf'] ?>plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo $_SG['rf'] ?>plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo $_SG['rf'] ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo $_SG['rf'] ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo $_SG['rf'] ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>





<script src="<?php echo $_SG['rf'] ?>scripts.js"></script>





<?php
  function CarregaDashBoard(){
    include("lib/DB.php");
    $sql = "exec crsa.uspDashboardSGFP";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    //$colors[];
    $colors[0] = '#c45850';
    $colors[1] = '#3e95cd';
    $colors[2] = '#aa95cd';
    $colors[3] = '#B47051';
    $colors[4] = '#c45af0';
    $colors[5] = '#F21CCE';
    $colors[6] = '#391CF2';
    $colors[7] = '#79C829';

    $i=0;
    $_retdash = "";
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
      $_retdash .= "{label: '".$row[0]."', backgroundColor: ['".$colors[$i]."', '".$colors[$i]."','".$colors[$i]."','".$colors[$i]."','".$colors[$i]."'],	data: [".$row[1].",".$row[2].",".$row[3].",".$row[4].",".$row[5]."]},";
      $i++;
    }
    return $_retdash;
  }
?>


<script>

const d = new Date()
let year0 = d.getFullYear()
let year1 = year0-1
let year2 = year0-2
let year3 = year0-3
let year4 = year0-4
let year5 = year0-5


// Bar chart
new Chart(document.getElementById("bar-chart"), {
    type: 'bar',
    data: {
      labels: [year0, year1, year2, year3, year4],
      datasets: [
        <?php 
          //include ('functions.php');
          $retdash = CarregaDashBoard(); 
          echo $retdash;
          ?>
      ]
    },
    options: {
	scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    },
	  responsive: true,
      legend: { display: true },
      title: {
        display: true,
        text: 'Produção (Partidas) em 2024'
      }
    }
});




function closeModal(){
$('#exampleModal').modal('toggle')
}

$(document).ready(function () {
    $('#exampleTable').DataTable({
		"language": {
		            "url": "https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json"
		},
		//"language": {
        //        "url": "../dist/js/pt-BR.js"
        //},

        "dom": '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',   //solução boa para a parte de cima do grid
        
		scrollX: true,
        fixedHeader: true,
        responsive : true,
        lengthChange: true,
        pageLength: 5,
        lengthMenu: [[5, 10, 50, 100, 250, 500, -1], [5, 10, 50, 100, 250, 500, "Todos"]],
        buttons: [{ extend: 'print', exportOptions:{ columns: ':visible' }},
                  { extend: 'copy',  exportOptions:{ columns: ':visible' }},
			      { extend: 'excel', exportOptions:{ columns: ':visible' }},
				  { extend: 'pdf',   orientation: 'landscape',exportOptions:{ columns: [ 1,2,3,4,5,6,7,8,9 ] }},
                  { extend: 'colvis', postfixButtons: [ 'colvisRestore' ] }
				 ],
	});
});	
</script>



</body>
</html>
