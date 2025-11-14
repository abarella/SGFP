<?php
include("lib/DB.php");
$stmt = $conn->prepare("exec sp_who2");
$stmt->execute();
echo "ini<br>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	echo $row['Status'] ."<br>";
	
}


echo "fim<br>";
?>