<?php
include ("../lib/DB.php");
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
//var_dump($_POST);
//var_dump($_GET);
/* ------- */
/* POSTS   */
/* ------- */
/*
install python on iis
https://www.youtube.com/watch?v=ma1UvzqF82Q
*/

if(isset($_POST["btnIncAcomp"])){
    
    try {
        include("../lib/DB.php");
        $sql = "INSERT INTO sgcr.crsa.TBacomplote ([lote], [created_at], [status]) 
                VALUES (:lote, GETDATE(), 'A')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':lote', $_POST["txtAcomp"]);
        

        if ($stmt->execute()) {
            //echo "<script>parent.toastApp(3000,'Registro Salvo com Sucesso','OK');  parent.AfterCloseModal()</script>";
            echo "<script>AfterCloseModal()</script>";
        } else {
            //echo "<script>parent.toastApp(3000,'Erro ao salvar registro','ERRO');  parent.AfterCloseModal()</script>";
            echo "<script>AfterCloseModal()</script>";
        }
    } catch (PDOException $e) {
        echo "Erro no banco de dados: " . $e->getMessage();
    }

}



if(isset($_POST["btnDelAcomp"])){
     
    try {
        include("../lib/DB.php");
        $sql = "DELETE sgcr.crsa.TBacomplote where lote = '" . $_POST["txtAcomp"] ."'";

        $stmt = $conn->prepare($sql);
        //$stmt->bindParam(':lote');
        

        if ($stmt->execute()) {
            //echo "<script>parent.toastApp(3000,'Registro Salvo com Sucesso','OK');  parent.AfterCloseModal()</script>";
            echo "<script>AfterCloseModal()</script>";
        } else {
            //echo "<script>parent.toastApp(3000,'Erro ao salvar registro','ERRO');  parent.AfterCloseModal()</script>";
            echo "<script>AfterCloseModal()</script>";
        }
    } catch (PDOException $e) {
        echo "Erro no banco de dados: " . $e->getMessage();
    }
}


function carregaBlindagemXpasta($lote, $serie){

    if($lote==""){
        $lote="0";
    }
    
    include("../lib/DB.php");
    $sql = "set nocount on;exec vendaspelicano.dbo.uspBlindagemXPasta " . $lote . ",'" . $serie . "'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $prep ="";
    $conta = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $consist='';
        if (trim($row["RgSaida_Castelo"]) != trim($row["RgSaida_Pasta"])){
            $consist='background-color:red;';
            $conta = $conta+1;
        }
        
        if (trim($row["RgSaida_Castelo"]) == '' && trim($row["RgSaida_Pasta"]) == '')
        {
            $consist='background-color:red;';
            $conta = $conta+1;
        }



        $prep .= "<tr style='".$consist."'>";
        $prep .= "<td>". $row["Pasta_Lote"] . "</td>";
        $prep .= "<td>". $row["RgSaida_Castelo"] . "</td>";
        $prep .= "<td>". $row["RgSaida_Pasta"] . "</td>";
        $prep .= "<td>". $row["Serie"] . "</td>";
        $prep .= "<td>". $row["Transp"] . "</td>";
        $prep .= "<td>". $row["Razao_Social"] . "</td>";
        $prep .= "<td>". $row["Medico_Responsavel"] . "</td>";
        $prep .= "</tr>";
    }

    echo "<script>document.forms[1].txcontagem.value = '". $conta."'</script>";

    return $prep;


}

function carregaAcompanhamento(){
    include("../lib/DB.php");
    $sql = "select id, lote from  crsa.TBacomplote where status = 'A'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $prep ="";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $prep .= "<tr>";
        $prep .= "<td>". $row["id"] . "</td>";
        $prep .= "<td>". $row["lote"] . "</td>";
        $prep .= "</tr>";
    }
    return $prep;
}