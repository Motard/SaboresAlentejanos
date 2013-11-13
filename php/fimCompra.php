<?php
	echo "FIM COMPRA .PHP<br>";
	
	require_once "db.php";
	$pagamento = $_SESSION['pagamento'];
	$userId = $_SESSION['login'];
	$data = date("Y-m-d");
	//****************************************************************************************************
	//*****************		QUANDO A OPÇAO DE PAGAMENTO É CONTRA REEMBOLSO		**************************
	//****************************************************************************************************
	if ($pagamento == 1) {
		ligarBD('users');
		$cmd = "INSERT INTO users_shop (userId,data,forma_pagamento,estado)
		VALUES ('$userId','$data','$pagamento','0')";
		mysql_query($cmd);
		$lastId = mysql_insert_id();
		ligarBD('produts');
		$cmd = "SELECT * FROM shop_basket WHERE userId = '$userId'";
		$recurso = mysql_query($cmd);
		$numLinhas = mysql_num_rows($recurso);
		$i=0;
		while ($row = mysql_fetch_array($recurso)){
			$id[$i] = $row['id'];
			$produtoId[$i] = $row['produtoId'];
			$quantidade[$i] = $row['quantidade'];
			$i++;
		};				
		for ($i=0; $i<$numLinhas; $i++){
			$cmd = "INSERT INTO old_shop_basket (produtoId,userId,quantidade,users_shopId,data)
			VALUES ('$produtoId[$i]','$userId','$quantidade[$i]','$lastId','$data')";
			mysql_query($cmd);	
		}
		for ($i=0; $i<$numLinhas; $i++){
			$cmd = "DELETE FROM shop_basket where id = '$id[$i]'";
			mysql_query($cmd);	
		}
		$compras = "";
		for ($i=0; $i<$numLinhas; $i++){
			$compras .= "PRODUTO -".$produtoId[$i]." QUANTIDADE -".$quantidade[$i]."<br>";	
		}
		$assunto = "Sabores Alentejanos - Compra - User ".$userId;
		$body = <<<XPTO
		Compra efetuada pelo utilizador - $userId <br>
		Pagamento contra reembolso <br>
		Data - $data <br>
		$compras
XPTO;
		$mail = "pabm71@gmail.com";
		$mailde = "pmotard@sapo.pt";
		$headers = "From: $mailde\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8 . \r\n";
		
		//mail($mail, $assunto, $body, $headers);
		echo "<br>COMPRA EFETUADA.";
		echo "<br>Foi enviado um mail com dados da compra.";
		echo "<br>Os artigos serão enviados em breve via CTT.";
		?>
		<script>
			var artigos = document.getElementById("artigos");
			artigos.innerHTML = "0";
		</script>
        <?php
	}else{
	//****************************************************************************************************
	//*****************		QUANDO A OPÇAO DE PAGAMENTO É POR TRANSFERENCIA		**************************
	//****************************************************************************************************
		ligarBD('users');
		$cmd = "INSERT INTO users_shop (userId,data,forma_pagamento,estado)
		VALUES ('$userId','$data','$pagamento','0')";
		mysql_query($cmd);
		$lastId = mysql_insert_id();
		$ref_compra = $_SESSION['refCompra'];
		ligarBD('produts');
		$cmd = "SELECT * FROM shop_basket WHERE userId = '$userId'";
		$recurso = mysql_query($cmd);
		$numLinhas = mysql_num_rows($recurso);
		$i=0;
		while ($row = mysql_fetch_array($recurso)){
			$id[$i] = $row['id'];
			$produtoId[$i] = $row['produtoId'];
			$quantidade[$i] = $row['quantidade'];
			$i++;
		};				
		for ($i=0; $i<$numLinhas; $i++){
			$cmd = "INSERT INTO temp_shop_basket (produtoId,userId,quantidade,ref_compra,users_shopId,data)
			VALUES ('$produtoId[$i]','$userId','$quantidade[$i]','$ref_compra','$lastId','$data')";
			mysql_query($cmd);	
		}
		for ($i=0; $i<$numLinhas; $i++){
			$cmd = "DELETE FROM shop_basket where id = '$id[$i]'";
			mysql_query($cmd);	
		}
		$compras = "";
		for ($i=0; $i<$numLinhas; $i++){
			$compras .= "PRODUTO -".$produtoId[$i]." QUANTIDADE -".$quantidade[$i]."<br>";	
		}
		$assunto = "Sabores Alentejanos - Compra - User ".$userId;
		$body = <<<XPTO
		Compra efetuada pelo utilizador - $userId <br>
		Pagamento por transferencia <br>
		Data - $data <br>
		Referencia - $ref_compra <br>
		$compras
XPTO;
		echo "<br> $body";
		$mail = "pabm71@gmail.com";
		$mailde = "pmotard@sapo.pt";
		$headers = "From: $mailde\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8 . \r\n";
		
		//mail($mail, $assunto, $body, $headers);
		echo "<br>COMPRA EFETUADA.";
		echo "<br>Foi enviado um mail com dados da compra.";
		echo "<br>Os artigos serão enviados após receção do comprovativo de transferencia efetuada.";
		?>
		<script>
			var artigos = document.getElementById("artigos");
			artigos.innerHTML = "0";
		</script>
        <?php
	}
?>