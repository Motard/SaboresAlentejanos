<?php
	session_name("sabores");
	session_start();
	include "db.php";
	$paisId = $_POST["paisId"];
	$pesoTotal = $_SESSION['pesoTotal'];
	ligarBD();
	$cmd = "SELECT preco FROM portes WHERE paisId = '$paisId' AND peso >= '$pesoTotal' LIMIT 1";
	$recurso = mysql_query($cmd);
	$row = mysql_fetch_array($recurso);
	$_SESSION['portes'] = $row['preco'];
	$_SESSION['pais'] = $paisId;
?>