<?php
	include"_header.php";
	if (!isset ($_SESSION['login'])){
		header ('location:index.php?aviso=3');
	}else{
		ligarBD();
		$userId = $_SESSION['login'];
		$cmd = "SELECT * FROM users_shop WHERE userId = '$userId' ORDER BY id DESC";
		$recurso = mysql_query($cmd);
		$numLinhas = mysql_num_rows($recurso);
		if ($numLinhas == 0){
			header("location:index.php?aviso=13");	
		}else{
			$i = 0;
			while ($row = mysql_fetch_array($recurso)){
				$userShopId[$i] = $row['id'];
				$dataFinal[$i] = $row['data'];
				$formaPagamento[$i] = $row['forma_pagamento'];
				$estado[$i] = $row['estado'];
				$ref[$i] = $row['referencia'];
				$valor[$i] = $row['valor'];
				$i++;			
			};
			/*for ($i=0 ; $i<$numLinhas ; $i++) {
				echo "<br>USER SHOP ID ".$userShopId[$i];
				echo "<br>DATA ".$dataFinal[$i];
				echo "<br>FORMA DE PAGAMENTO ".$formaPagamento[$i];
				echo "<br>ESTADO ".$estado[$i];
				echo "<br>REFERENCIA ".$ref[$i];
			}*/
			//echo "<br><hr>";
			//ligarBD();
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
					?> 
					<div class="historico">
						<div class="detalhesOrdem">
                            <p>Data da compra</p>
                            <p style="font-size:25px"><?php echo $dataFinal[$i];?></p>
                            <br>
                            <p>Referencia - <?php echo $ref[$i];?></p>
                            <br>
                            <p>Valor - <?php echo "€ ".$valor[$i];?></p>
                        </div>
                        <div class="resumoOrdem">
                        	<p> <?php echo $estadoString;?></p>
							<hr>
							<table style="width:100%">
                           
                        <?php
						for ($j=0 ; $j<$numProdutos ; $j++){
							$cmd = "SELECT * FROM produts where id = '$produtoId[$j]'";
							$recurso = mysql_query($cmd);
							while ($row = mysql_fetch_array($recurso)){
								?> 
								<tr>
                                	<td style="width:80px;height:80px;width:25%;padding-bottom:5px;">
                                    	<img class="imgPrdt" src="imagens/produtos/<?php echo $row['foto'];?>">	
                                	</td>
                                	<td style="font-weight:bold;width:50%"><?php echo $row['nome']."<br>";?></td>
									<td><?php echo "Quantidade- ".$quantidade[$j];?></td>
								</tr>
								<?php	
							};//end while	
						};//end for
					?>
                    		</table>
                    	</div> 
					</div>
					<?php
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
					?> 
					<div class="historico">
						<div class="detalhesOrdem">
                            <p>Data da compra</p>
                            <p style="font-size:25px"><?php echo $dataFinal[$i];?></p>
                            <br>
                            <p>Referencia - <?php echo $ref[$i];?></p>
                            <br>
                            <p>Valor - <?php echo "€ ".$valor[$i];?></p>
                        </div>
                        <div class="resumoOrdem">
                        	<p> <?php echo $estadoString;?></p>
							<hr>
							<table style="width:100%">
                           
                        <?php
						for ($j=0 ; $j<$numProdutos ; $j++){
							$cmd = "SELECT * FROM produts where id = '$produtoId[$j]'";
							$recurso = mysql_query($cmd);
							while ($row = mysql_fetch_array($recurso)){
								?> 
								<tr>
                                	<td style="width:80px;height:80px;width:25%;padding-bottom:5px;">
                                    	<img class="imgPrdt" src="imagens/produtos/<?php echo $row['foto'];?>">	
                                	</td>
                                	<td style="font-weight:bold;width:50%"><?php echo $row['nome']."<br>";?></td>
									<td><?php echo "Quantidade- ".$quantidade[$j];?></td>
								</tr>
								<?php	
							};//end while	
						};//end for
					?>
                    		</table>
                    	</div> 
					</div>
					<?php
					/*echo "<br>DATA DE COMPRA ".$dataFinal[$i]." - ".$estadoString."<br><hr><hr>";
					for ($j=0 ; $j<$numProdutos ; $j++){
						$cmd = "SELECT * FROM produts where id = '$produtoId[$j]'";
						$recurso = mysql_query($cmd);
						while ($row = mysql_fetch_array($recurso)){
							echo $row['nome']." quantidade =".$quantidade[$j]."<br>";	
						}	
					}*/
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
						/*case 0:
							$estadoString = "Á espera de pagamento.";
							break;*/
						case 1:
							$estadoString = "Encomenda paga.";
							break;
						case 2:
							$estadoString = "Encomenda enviada.";
							break;	
					}
					?>
					<div class="historico">
						<div class="detalhesOrdem">
                            <p>Data da compra</p>
                            <p style="font-size:25px"><?php echo $dataFinal[$i];?></p>
                            <br>
                            <p>Referencia - <?php echo $ref[$i];?></p>
                            <br>
                            <p>Valor - <?php echo "€ ".$valor[$i];?></p>
                        </div>
                        <div class="resumoOrdem">
                        	<p> <?php echo $estadoString;?></p>
							<hr>
							<table style="width:100%">
                           
                        <?php
						for ($j=0 ; $j<$numProdutos ; $j++){
							$cmd = "SELECT * FROM produts where id = '$produtoId[$j]'";
							$recurso = mysql_query($cmd);
							while ($row = mysql_fetch_array($recurso)){
								?> 
								<tr>
                                	<td style="width:80px;height:80px;width:25%;padding-bottom:5px;">
                                    	<img class="imgPrdt" src="imagens/produtos/<?php echo $row['foto'];?>">	
                                	</td>
                                	<td style="font-weight:bold;width:50%"><?php echo $row['nome']."<br>";?></td>
									<td><?php echo "Quantidade- ".$quantidade[$j];?></td>
								</tr>
								<?php	
							};//end while	
						};//end for
					?>
                    		</table>
                    	</div> 
					</div>
                    <?php
					/*echo "<br>DATA DE COMPRA ".$dataFinal[$i]." - ".$estadoString."<br><hr><hr>";
					for ($j=0 ; $j<$numProdutos ; $j++){
						$cmd = "SELECT * FROM produts where id = '$produtoId[$j]'";
						$recurso = mysql_query($cmd);
						while ($row = mysql_fetch_array($recurso)){
							echo $row['nome']." quantidade =".$quantidade[$j]."<br>";	
						}	
					}*/
				}	
			}//end for
		}
	}
	include"_footer.php";
?>