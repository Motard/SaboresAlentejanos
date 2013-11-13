<?php
	echo "CONTA COMPRAS .PHP<br>";
	
	if (isset ($_SESSION['compras'])){
		unset ($_SESSION['compras']);	
	};
	if (isset ($_SESSION['contaAlteraPass'])){
		unset ($_SESSION['contaAlteraPass']);	
	};
	if (isset ($_SESSION['contaAlteraMor'])){
		unset ($_SESSION['contaAlteraMor']);	
	};
	if (!isset ($_SESSION['login']) || $_SESSION['login'] == "") {
		$_SESSION['contaCompras'] = "1";
		?> 
        <p>Necessário fazer LOGIN</p>
		<input type="button" value="LOGIN" onclick="carrega('login')">
     	<?php
	}else{
		require_once "db.php";
		ligarBD('users');
		$userId = $_SESSION['login'];
		$cmd = "SELECT * FROM users_shop WHERE userId = '$userId' ORDER BY id DESC";
		$recurso = mysql_query($cmd);
		$numLinhas = mysql_num_rows($recurso);
		if ($numLinhas == 0){
			echo "SEM REGISTOS DE COMPRAS";	
		}else{
			$i = 0;
			while ($row = mysql_fetch_array($recurso)){
				$userShopId[$i] = $row['id'];
				$dataFinal[$i] = $row['data'];
				$formaPagamento[$i] = $row['forma_pagamento'];
				$estado[$i] = $row['estado'];
				$i++;			
			};
			for ($i=0 ; $i<$numLinhas ; $i++) {
				echo "<br>USER SHOP ID ".$userShopId[$i];
				echo "<br>DATA ".$dataFinal[$i];
				echo "<br>FORMA DE PAGAMENTO ".$formaPagamento[$i];
				echo "<br>ESTADO ".$estado[$i];	
			}
			echo "<br><hr>";
			ligarBD("produts");
			for ($i=0 ; $i<$numLinhas ; $i++) {
				if ($formaPagamento[$i] == 1) {
					$cmd = "SELECT * FROM old_shop_basket where users_shopId = '$userShopId[$i]'";
					$recurso = mysql_query($cmd);
					$numProdutos = mysql_num_rows($recurso);
					$j = 0;
					while ($row = mysql_fetch_array($recurso)) {
						$produtoId[$j] = $row['produtoId'];
						$quantidade[$j] = $row['quantidade'];
						$data[$j] = $row['data'];
						$j++;		
					};
					switch ($estado[$i]){
						case 0:
							$estadoString = "A enviar em  breve.";
							break;
						case 1:
							$estadoString = "Encomenda enviada.";
							break;
						case 2:
							$estadoString = "Encomenda paga.";
							break;	
					};
					echo "<br>DATA DE COMPRA ".$dataFinal[$i]." - ".$estadoString."<br><hr><hr>";
					for ($j=0 ; $j<$numProdutos ; $j++){
						$cmd = "SELECT * FROM produts where id = '$produtoId[$j]'";
						$recurso = mysql_query($cmd);
						while ($row = mysql_fetch_array($recurso)){
							echo $row['nome']." quantidade =".$quantidade[$j]."<br>";	
						};	
					};
				}else if ($formaPagamento[$i] == 2 && $estado[$i] == 0){
					$cmd = "SELECT * FROM temp_shop_basket where users_shopId = '$userShopId[$i]'";
					$recurso = mysql_query($cmd);
					$numProdutos = mysql_num_rows($recurso);
					$j = 0;
					while ($row = mysql_fetch_array($recurso)) {
						$produtoId[$j] = $row['produtoId'];
						$quantidade[$j] = $row['quantidade'];
						$data[$j] = $row['data'];
						$j++;		
					}
					switch ($estado[$i]){
						case 0:
							$estadoString = "Á espera de pagamento.";
							break;
						case 1:
							$estadoString = "Encomenda paga.";
							break;
						case 2:
							$estadoString = "Encomenda enviada.";
							break;	
					}
					echo "<br>DATA DE COMPRA ".$dataFinal[$i]." - ".$estadoString."<br><hr><hr>";
					for ($j=0 ; $j<$numProdutos ; $j++){
						$cmd = "SELECT * FROM produts where id = '$produtoId[$j]'";
						$recurso = mysql_query($cmd);
						while ($row = mysql_fetch_array($recurso)){
							echo $row['nome']." quantidade =".$quantidade[$j]."<br>";	
						}	
					}
				}else if ($formaPagamento[$i] == 2 && $estado[$i] != 0){
					$cmd = "SELECT * FROM old_shop_basket where users_shopId = '$userShopId[$i]'";
					$recurso = mysql_query($cmd);
					$numProdutos = mysql_num_rows($recurso);
					$j = 0;
					while ($row = mysql_fetch_array($recurso)) {
						$produtoId[$j] = $row['produtoId'];
						$quantidade[$j] = $row['quantidade'];
						$data[$j] = $row['data'];
						$j++;		
					}
					switch ($estado[$i]){
						case 0:
							$estadoString = "Á espera de pagamento.";
							break;
						case 1:
							$estadoString = "Encomenda paga.";
							break;
						case 2:
							$estadoString = "Encomenda enviada.";
							break;	
					}
					echo "<br>DATA DE COMPRA ".$dataFinal[$i]." - ".$estadoString."<br><hr><hr>";
					for ($j=0 ; $j<$numProdutos ; $j++){
						$cmd = "SELECT * FROM produts where id = '$produtoId[$j]'";
						$recurso = mysql_query($cmd);
						while ($row = mysql_fetch_array($recurso)){
							echo $row['nome']." quantidade =".$quantidade[$j]."<br>";	
						}	
					}
				}	
			}
		}
	}

?>