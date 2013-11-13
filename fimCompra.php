<?php
	include "_header.php";
	if (!isset($_SESSION['compraFinal']))
		header('location:comprar3.php');
	$pagamento = $_SESSION['pagamento'];
	$userId = $_SESSION['login'];
	$nome = $_SESSION['nome'];
	$apelido = $_SESSION['apelido'];
	$data = date("Y-m-d");
	$precoTotal = $_SESSION['portes'] + $_SESSION['precoTotal'];
	$ref = $_SESSION['refCompra'];
	if ($_SESSION['pais']=='1'){
		$conta = 'NIB';	
	}else{
		$conta ='IBAN';	
	}//end if 
	//****************************************************************************************************
	//*****************		QUANDO A OPÇAO DE PAGAMENTO É CONTRA REEMBOLSO		**************************
	//****************************************************************************************************
	if ($pagamento == 1) {
		ligarBD();
		$cmd = "INSERT INTO users_shop (userId,data,forma_pagamento,estado,referencia,valor)
		VALUES ('$userId','$data','$pagamento','0','$ref','$precoTotal')";
		mysql_query($cmd);
		$lastId = mysql_insert_id();
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
		Referencia - $ref <br>
		$compras
XPTO;
		$mail = "pabm71@gmail.com";
		$mailde = "pmotard@sapo.pt";
		$headers = "From: $mailde\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8 . \r\n";
		mail($mail, $assunto, $body, $headers);
		ligarBD();
		//****************************************************************************************************
		//*************************		CORPO DO MAIL A ENVIAR PARA O CLIENTE		**************************
		//****************************************************************************************************
		$compras = "";
		$precoTotal = $_SESSION['precoTotal'] + $_SESSION['portes'];
		$compras = "<table style='width:500px;border-top:1px dashed black;'>
						<tr style='border-bottom:1px solid grey;color:grey;border-left:1px dashed black;border-right:1px dashed black;'>
							<td colspan='2' style='text-align:center;padding:5px 0'>Produto</td>
							<td style='text-align:center'>Preço</td>
							<td style='text-align:center'>Quantidade</td>
							<td style='text-align:center'>Sub-Total</dt>
						</tr>";
						
		for ($i=0; $i<$numLinhas; $i++){
			$cmd = "SELECT * FROM produts WHERE id='$produtoId[$i]'";
			$recurso = mysql_query($cmd);
			$row = mysql_fetch_array($recurso);
			$compras .=" <tr style='border-left:1px dashed black;border-right:1px dashed black;border-top:1px dotted #CCC'>
							<td style='width:50px;height:50px;padding:3px 0;'><img class='imgPrdt' src='imagens/produtos/". $row['foto']."'></td>
							<td>". $row['nome']."</td>
							<td style='text-align:center'>". $row['preco']."</td>
							<td style='text-align:center'>". $quantidade[$i]."</td>
							<td style='text-align:center'>". $row['preco'] * $quantidade[$i]."</td>
						</tr>";
		}
		$compras.="	<tr style='border-top:1px dashed black;'>
						<td></td>
						<td></td>
						<td></td>
						<td style='text-align:center;color:grey;padding:5px 0'>Sub-Total</td>
						<td style='text-align:center'>".$_SESSION['precoTotal']."</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td style='text-align:center;color:grey;padding:5px 0'>Portes</td>
						<td style='text-align:center'>".$_SESSION['portes']."</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td style='text-align:center;font-weight:bold;border-top:1px solid black;color:grey;padding:5px 0'>Total</td>
						<td style='text-align:center;font-weight:bold;border-top:1px solid black'>".$precoTotal."</td>
					</tr>
					</table>";
		$assunto = "Sabores Alentejanos - A sua Encomenda";		
		$body = <<<XPTO
		<br>
		Exmo(a). Sr(a) $nome $apelido
		<br><br>
		Acusamos a receção do vosso pedido com muito prazer. <br>
		E informaremos quando os produtos forem enviados.
		<br><br><br>
		$compras
		
		
XPTO;
		$mail = $_SESSION['mail'];
		$mailde = "pmotard@sapo.pt";
		$headers = "From: $mailde\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8 . \r\n";
		mail($mail, $assunto, $body, $headers);
	}else{
	//****************************************************************************************************
	//*****************		QUANDO A OPÇAO DE PAGAMENTO É POR TRANSFERENCIA		**************************
	//****************************************************************************************************
		ligarBD();
		$cmd = "INSERT INTO users_shop (userId,data,forma_pagamento,estado,referencia,valor)
		VALUES ('$userId','$data','$pagamento','0','$ref','$precoTotal')";
		mysql_query($cmd);
		$lastId = mysql_insert_id();
		//$ref_compra = $_SESSION['refCompra'];
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
		Referencia - $ref <br>
		$compras
XPTO;
		echo "<br> $body";
		$mail = "pabm71@gmail.com";
		$mailde = "pmotard@sapo.pt";
		$headers = "From: $mailde\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8 . \r\n";
		mail($mail, $assunto, $body, $headers);
		//****************************************************************************************************
		//*************************		CORPO DO MAIL A ENVIAR PARA O CLIENTE		**************************
		//****************************************************************************************************
		$compras = "";
		$precoTotal = $_SESSION['precoTotal'] + $_SESSION['portes'];
		$compras = "<table style='width:500px;border-top:1px dashed black;'>
						<tr style='border-bottom:1px solid grey;color:grey;border-left:1px dashed black;border-right:1px dashed black;'>
							<td colspan='2' style='text-align:center;padding:5px 0'>Produto</td>
							<td style='text-align:center'>Preço</td>
							<td style='text-align:center'>Quantidade</td>
							<td style='text-align:center'>Sub-Total</dt>
						</tr>";
						
		for ($i=0; $i<$numLinhas; $i++){
			$cmd = "SELECT * FROM produts WHERE id='$produtoId[$i]'";
			$recurso = mysql_query($cmd);
			$row = mysql_fetch_array($recurso);
			$compras .=" <tr style='border-left:1px dashed black;border-right:1px dashed black;border-top:1px dotted #CCC'>
							<td style='width:50px;height:50px;padding:3px 0;'><img class='imgPrdt' src='imagens/produtos/". $row['foto']."'></td>
							<td>". $row['nome']."</td>
							<td style='text-align:center'>". $row['preco']."</td>
							<td style='text-align:center'>". $quantidade[$i]."</td>
							<td style='text-align:center'>". $row['preco'] * $quantidade[$i]."</td>
						</tr>";
		}
		$compras.="	<tr style='border-top:1px dashed black;'>
						<td></td>
						<td></td>
						<td></td>
						<td style='text-align:center;color:grey;padding:5px 0'>Sub-Total</td>
						<td style='text-align:center'>".$_SESSION['precoTotal']."</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td style='text-align:center;color:grey;padding:5px 0'>Portes</td>
						<td style='text-align:center'>".$_SESSION['portes']."</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td style='text-align:center;font-weight:bold;border-top:1px solid black;color:grey;padding:5px 0'>Total</td>
						<td style='text-align:center;font-weight:bold;border-top:1px solid black'>".$precoTotal."</td>
					</tr>
					</table>";
		$assunto = "Sabores Alentejanos - A sua Encomenda";		
		$body = <<<XPTO
		<br>
		Exmo(a). Sr(a) $nome $apelido
		<br><br>
		Acusamos a receção do vosso pedido com muito prazer. <br>
		Para considerarmos esta encomenda é necesário fazer o pagamento por transferencia para a conta abaixo indicada:<br>
		Conta - $conta<br>
		Referencia - $ref <br><br>
		Após a transferencia efetuada é favor enviar o comprovativo por mail para o endereço sa@saboresalentejanos.pt<br><br>
		Depois da boa receção da transferencia por vós efetuada, procederemos ao envio da encomenda. 
		<br><br><br>
		$compras
		
		
XPTO;
		$mail = $_SESSION['mail'];
		$mailde = "pmotard@sapo.pt";
		$headers = "From: $mailde\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8 . \r\n";
		mail($mail, $assunto, $body, $headers);
	}
	header('location:compraFeita.php');
	unset($_SESSION['compraFinal']);
	include "_footer.php";
?>
