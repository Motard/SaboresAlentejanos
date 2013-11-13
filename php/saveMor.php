<?php
	session_name("sabores");
	session_start();
	include "db.php";
	ligarBD();
	$rua = $_POST['rua'];
	$localidade = $_POST['localidade'];
	$cp = $_POST['cp'];
	$pais = $_POST['pais'];
	$telefone = $_POST['telefone'];
	$userId = $_SESSION['login'];
	$rua = mysql_real_escape_string($rua);
	$localidade = mysql_real_escape_string($localidade);
	$cp = mysql_real_escape_string($cp);
	$telefone = mysql_real_escape_string($telefone);
	$cmd = "SELECT id FROM adresses where userId = '$userId'";
	$recurso = mysql_query($cmd);
	$numLinhas = mysql_num_rows($recurso);
	if ($numLinhas == 0){
		$cmd = "INSERT INTO adresses (userId,rua,local,cp,paisId,telefone) VALUES
		('$userId','$rua','$localidade','$cp','$pais','$telefone')";
		mysql_query($cmd);
		if (isset ($_SESSION['compras'])){
			header ('location:../comprar.php?aviso=9');
		}else{
			header('location:../index.php?aviso=9');
		}
	}else{
		$cmd = "UPDATE adresses
		SET rua = '$rua',
		local = '$localidade',
		cp = '$cp',
		paisId = '$pais',
		telefone = '$telefone'
		WHERE userId = '$userId'";
		mysql_query($cmd);
		if (isset ($_SESSION['compras'])){
			$returnURL = $_SESSION['compras'];
			switch($returnURL){
				case 1:
					header ('location:../comprar.php?aviso=10');	
					break;
				case 2:
					header ('location:../comprar3.php?aviso=10');	
					break;
			} //end switch
		}else{
			header('location:../index.php?aviso=10');
		}
	}
?>