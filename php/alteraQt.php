<?php
	session_name("sabores");
	session_start();	
	include "db.php";
	ligarBD();
	$id = $_POST["id"];
	$qt = $_POST["qt"];
	$cmd = "UPDATE shop_basket SET quantidade='$qt' WHERE id='$id'";
	mysql_query($cmd);
	if (isset($_GET['recalcular'])){
		$_SESSION['recalcular']=1;	
	}
?>