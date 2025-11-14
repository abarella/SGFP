<?php 
include("../header.php");
include("CabecFolha.php");
if ($_GET['produto'] == 'rd_i131')
{
   include("modReconMateriais.php");
}

if ($_GET['produto'] == 'rd_ga67')
{
   include("modReconMateriaisGALIO.php");
}

if ($_GET['produto'] == 'rd_tl')
{
   include("modReconMateriaisTALIO.php");
}

?>
<?php include("../footer.php");?>
<script>
   $('#f09').removeClass('btn-outline-info').addClass('btn-info')
   $('#f21').removeClass('btn-outline-info').addClass('btn-info')
</script>

