<?php
	session_name("sabores");
	session_start();
	unset($_SESSION['login']);
	unset($_SESSION['nome']);
	unset($_SESSION['apelido']);
	unset($_SESSION['mail']);
	if (isset($_SESSION['pais'])){
		unset($_SESSION['pais']);
	}
	if (isset($_SESSION['pesoTotal'])){
		unset($_SESSION['pesoTotal']);	
	}
	if (isset($_SESSION['portes'])){
		unset($_SESSION['portes']);
	}
	include "php/db.php";
	ligarBD();
	$cookie = $_COOKIE['cookies'];
	$cmd = "UPDATE cookies SET userId=' ' WHERE cookie='$cookie'";
	mysql_query($cmd);
	header ('location:index');
?>