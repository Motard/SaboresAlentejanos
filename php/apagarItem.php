<?php
	session_name("sabores");
	session_start();	
	include "db.php";
	$id = $_POST["id"];
	ligarBD();
	$cmd = "DELETE FROM shop_basket WHERE id='$id'";
	mysql_query($cmd);
	if (isset($_GET['recalcular'])){
		$_SESSION['recalcular']=1;	
	}
?>