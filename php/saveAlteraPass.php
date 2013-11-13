<?php
	session_name("sabores");
	session_start();
	include "db.php";
	$password = $_POST['password'];
	$novaPassword = $_POST['novaPassword'];
	$userId = $_SESSION['login'];
	ligarBD ();
	$cmd = "SELECT * FROM users WHERE id = '$userId'";
	$recurso = mysql_query($cmd);
	while ($row = mysql_fetch_array($recurso)){
		$passwordHash = $row["password"];
		$time = $row["time"];	
	}
	if ($passwordHash == crypt($password,$time)){
		$passwordHash = crypt($novaPassword,$time);	
		$cmd = "UPDATE users SET password = '$passwordHash' WHERE id = '$userId'";
		mysql_query($cmd);
		header ('location:../index.php?aviso=4');
	}else{
		header ('location:../index.php?aviso=5');
	}
?>
