<?php
	session_name("sabores");
	session_start();
	include "db.php";
	ligarBD();	
	$user = $_POST["user"];
	$password = $_POST["password"];
	$cookie = $_COOKIE["cookies"];
	$user = mysql_real_escape_string($user);
	$cmd = "SELECT * FROM users WHERE mail='$user'";
	$recurso = mysql_query($cmd);
	$numLinhas = mysql_num_rows($recurso);
	if ($numLinhas == 1){
		while ($row = mysql_fetch_array($recurso)){
			$userId = $row["id"];
			$userNome = $row['nome'];
			$userApelido = $row['apelido'];
			$userMail = $row['mail'];
			$passwordHash = $row["password"];
			$time = $row["time"];				
		}
		if ($passwordHash == crypt($password,$time)){
			//if (session_status()== PHP_SESSION_NONE) {
			/*if (session_id() === ""){
				session_name("sabores");
				session_start();	
			}*/
			$_SESSION['login'] = $userId;
			$_SESSION['nome'] = ucfirst($userNome);
			$_SESSION['apelido'] = ucfirst($userApelido);
			$_SESSION['mail'] = $userMail;
			$cmd = "UPDATE cookies SET userId='$userId' WHERE cookie='$cookie'";
			mysql_query($cmd);
			//VER SE O USER TEM MORADA CRIADA. SE TIVER CRIAR VARIAVEL SESSÃO COM O ID DO PAIS
			$cmd = "SELECT paisId FROM adresses WHERE userId = '$userId'";
			$recurso = mysql_query($cmd);
			$numLinhas = mysql_num_rows($recurso);
			if ($numLinhas > 0){
				$row = mysql_fetch_array($recurso);
				$_SESSION['pais'] = $row['paisId'];	
			}
			if (isset($_SESSION['compras'])) {
				header("location:../comprar.php");
			}else{
				header("location:../index.php");
			}
		}else{
			header("location:../mainLogin.php?aviso=1");
		}	
	}else {	
		header("location:../mainLogin.php?aviso=1");
	}
?>

	
	