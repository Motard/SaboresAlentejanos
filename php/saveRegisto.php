<?php
	error_reporting(E_ALL);
	include "db.php";
	ligarBD();
	$nome = $_POST["nome"];
	$apelido = $_POST["apelido"];
	$mail = $_POST["mail"];
	$password = $_POST["password"];
	$data = date("Y-m-d");
	$time = time();
	$user = $_COOKIE["cookies"];
	$nome = mysql_real_escape_string($nome);
	$apelido = mysql_real_escape_string($apelido);
	$mail = mysql_real_escape_string($mail);
	$passwordHash = crypt($password,$time);
	$cmd = "SELECT * FROM users WHERE mail='$mail'";
	$recurso = mysql_query($cmd);
	$numlinhas = mysql_num_rows($recurso);
	if ($numlinhas==1){
		header('location:../mainRegisto.php?aviso=2');
	}else {	//ver se já existe userId carregado na table cookies
		$cmd = "SELECT userId FROM cookies WHERE cookie='$user'";
		$recurso = mysql_query($cmd);
		while ($row=mysql_fetch_array($recurso)){
			$userId = $row["userId"];	
		}
		if ($userId == NULL || $userId == 0) { //como não existe userId na table cookies criar user novo na table users
			$cmd = "INSERT INTO users (nome,apelido,mail,password,data,time)
			VALUES ('$nome','$apelido','$mail','$passwordHash','$data','$time')";
			mysql_query($cmd) 
			or die ("Erro no comando #cmd");
			$cmd = "SELECT id FROM users WHERE mail = '$mail'";
			$recurso = mysql_query($cmd);
			while ($row=mysql_fetch_array($recurso)){
				$userId = $row["id"];
			}
			$cmd = "UPDATE cookies
			SET userId='$userId'
			WHERE cookie='$user'";
			mysql_query($cmd)
			or die ("Erro no comando $cmd");
		}else{	//como já existe userId na table cookies ver se tem mail na table users
			$cmd = "SELECT mail FROM users where id='$userId'";
			$recurso = mysql_query($cmd);
			while ($row=mysql_fetch_array($recurso)){
				$userMail = $row["mail"];	
			}
			if ($userMail == NULL) {	//como não tem mail fazer update do user novo na tabela users
				$cmd = "UPDATE users
				SET nome='$nome',apelido='$apelido',mail='$mail',password='$passwordHash',data='$data',time='$time'
				WHERE id='$userId'";
				mysql_query($cmd) 
				or die ("Erro no comando $cmd");
			}else{	//como já tem mail criar um user novo na tabela users
				$cmd = "INSERT INTO users (nome,apelido,mail,password,data,time)
				VALUES ('$nome','$apelido','$mail','$passwordHash','$data','$time')";
				$recurso = mysql_query($cmd); 
				$cmd = "SELECT id FROM users WHERE mail = '$mail'";
				$recurso = mysql_query($cmd);
				while ($row=mysql_fetch_array($recurso)){
					$userId = $row["id"];
				}
				$cmd = "UPDATE cookies
				SET userId='$userId'
				WHERE cookie='$user'";
				mysql_query($cmd)
				or die ("Erro no comando $cmd");
			}
		}
		header ('location:../mainLogin.php?aviso=6');
	};
	 
?>

<!--$cmd =sprintf("SELECT id,nome,password,time FROM users WHERE mail='%s'", mysql_real_escape_string($user));-->
<!--$name_bad = mysql_real_escape_string($name_bad);-->