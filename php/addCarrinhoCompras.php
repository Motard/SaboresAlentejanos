<?php
	include "db.php";
	$produtoId = $_POST['produto'];
	$quantidade = $_POST['quantidade'];
	$cookie = $_COOKIE['cookies'];
	$data = date("Y-m-d");
	$numProdutos = 0;
	//****************************************************************//
	//**************LIGAR BD USERS E VER SE O COOKIE TEM USER*********//
	//****************************************************************//
	ligarBD();
	$cmd ="SELECT * FROM cookies WHERE cookie = '$cookie'";
	$recurso = mysql_query($cmd);
	while ($row = mysql_fetch_array($recurso)){
	//**************NESTE CASO O COOKIE TEM USER*********************//
		if ($row['userId'] != NULL) {
			$userId = $row['userId'];
		}else{
	//**************NESTE CASO O COOKIE NÃO TEM USER****************//
			$cmd = "INSERT INTO users (nome) VALUES ('$cookie')";
			mysql_query($cmd);
			$cmd = "SELECT id FROM users where nome = '$cookie'";
			$recurso = mysql_query($cmd);
			$row = mysql_fetch_array($recurso);
			$userId = $row['id'];	
			$cmd = "UPDATE cookies SET userId = '$userId' WHERE cookie = '$cookie'";
			mysql_query($cmd);
		}		
	}
	//****************************************************************//
	//**************LIGAR BD CESTO COMPRAS E CARREGAR PRODUTO*********//
	//****************************************************************//
	//ligarBD("produts");
	$cmd = "INSERT INTO shop_basket (produtoId,userId,quantidade,data)
	VALUES ('$produtoId','$userId','$quantidade','$data')";
	mysql_query($cmd);
?>
