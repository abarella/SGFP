<?php
	//$serverName = "colibri\gds_2";
    //$serverName = "uirapuru";
    //$serverName = "10.0.10.170\gds_2";
    $serverName = "EMA";
    $databaseName = "sgcr";
    $uid = "crsa";
    $pwd = "cr9537";
    //$conn = new PDO("sqlsrv:server = $serverName;  Encrypt=No;   Database=$databaseName;", $uid, $pwd,  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $conn = new PDO("sqlsrv:server = $serverName;  Encrypt=No;   Database=$databaseName;", $uid, $pwd);


?>
