<?php
	include "_header.php";
	$cookie = $_COOKIE['cookies'];
	//****************************************************************//
	//**************LIGAR BD USERS E VER SE O COOKIE TEM USER*********//
	//****************************************************************//
	?> 
    <br>
    <table style="width:100%">
    	<tr>
        	<td style="text-align:center">
            	<a href="index.php" style="text-decoration:none"><input type="button" class="bt" value="CONTINUAR A COMPRAR"></a>
          	</td>
            <td style="text-align:center">
            	<a href="comprar.php" style="text-decoration:none"><input type="button" class="bt" value="FINALIZAR COMPRA"></a>
          	</td>
        </tr>
    </table>
    <br>
    <table style="width:100%;">
        <tr style="text-align:center;color:#999;font-family:arial;font-size:13px;font-weight:bold">
            <td style="width:450px;">Descrição do produto</td>
            <td style="width:150px;">Preço</td>
            <td style="width:150px;">Quantidade</td>
            <td style="width:150px;">Sub-total</td>
        </tr>
   	</table>
    <br>
    <div style="border:1px solid grey;border-radius:5px;">
    <table style="width:100%;">
	<?php
		ligarBD();
		$cmd = "SELECT * FROM cookies WHERE cookie = '$cookie'";
		$recurso = mysql_query($cmd);
		$row = mysql_fetch_array($recurso);
		$userId = $row['userId'];		
		if ($userId == NULL || $userId == "0") {
			header ('location:index.php?aviso=11');
		}else{
		//****************************************************************//
		//**COOKIE TEM USER - VER SE USER TEM PRODUTOS NO CESTO COMPRAS***//
		//****************************************************************//
			$cmd = "SELECT * FROM shop_basket WHERE userId = '$userId' ORDER BY id DESC";
			$recurso = mysql_query($cmd);
			$numlinhas = mysql_num_rows($recurso);
			if ($numlinhas == 0){
				header ('location:index.php?aviso=11');
			}else{
			  $i = 0;
			  while ($row = mysql_fetch_array($recurso)){
				  $cestoComprasId[$i] = $row['id'];
				  $produtoId[$i] = $row['produtoId'];
				  $quantidade[$i] = $row['quantidade'];
				  $i++;
			  }
			  $precoTotal = 0;
			  $peso = 0;
			  $pesoTotal = 0;
			  for ($i=0; $i<$numlinhas; $i++){
				  $cmd = "SELECT * FROM produts WHERE id = '$produtoId[$i]'";
				  $recurso = mysql_query($cmd);
				  while ($row = mysql_fetch_array($recurso)){
					 ?>
                     <tr>
                     	<td style="width:75px;">
                        	<div class="imagemPrdt">
                            	<img class="imgPrdt" src="imagens/produtos/<?php echo $row['foto'];?>">
                           	</div>
                      	</td>
                        <td style="width:325px;border-bottom:1px dotted #CCC;vertical-align:middle">
                          	<span class="hPrdt"><?php echo $row['nome'];?></span>
                      	</td>
                        <td style="width:50px;border-bottom:1px dotted #CCC;">
                        	<img class="apagarPrdt" src="imagens/trash-icon.png" width="30" height="30" title="Apagar produto" onclick="apagar(<?php echo $cestoComprasId[$i];?>)">
                        </td>
                        <td style="width:150px;text-align:center;border-left:1px solid grey;vertical-align:middle">
                        	<div class="precoUni">
                            	<?php echo "€ ".$row['preco'];?>
                         	</div>
                        </td>
                        <td style="width:150px;text-align:center;border-left:1px solid grey;">
                        	<div class="alteraQuan" id="<?php echo $i;?>"></div>
                        	<div class="quant">
                            	<input class="input inputQt" type="text" size="2" maxlength="2" readonly value="<?php echo $quantidade[$i]?>" onclick="alteraQt(<?php echo $cestoComprasId[$i];?>,<?php echo $i;?>)">
                         	</div>
                         	
                         	<div class="gravarAlteraQuan" id="btGravar<?php echo $i;?>"></div>
                         </td>
                         <td style="width:150px;text-align:center;border-left:1px solid grey;vertical-align:middle">
                             <div class="precoTotal">
                                <?php 
                                    $precoTotalItem = $row['preco']*$quantidade[$i];
                                    echo "€ ".$precoTotalItem;
                                    $precoTotal += $precoTotalItem;
									$peso = $row['peso']* $quantidade[$i];
									$pesoTotal += $peso;
                                ?>
                             </div>
                         </td>
					 </tr>
				  <?php
				  };
				  $_SESSION['pesoTotal'] = $pesoTotal;
				  $_SESSION['precoTotal'] = $precoTotal;
				  if (isset($_SESSION['pais'])){
					$paisId = $_SESSION['pais'];
					$pesoTotal = $_SESSION['pesoTotal'];
					$cmd = "SELECT preco FROM portes WHERE paisId = '$paisId' AND peso >= '$pesoTotal' LIMIT 1";
					$recurso = mysql_query($cmd);
					$row = mysql_fetch_array($recurso);
					$_SESSION['portes'] = $row['preco'];  
				  }	
			  };
			}
		};
	?>
    </table>
	</div>
    <br>
    <table style="width:100%">
    	<tr>
        	<td style="width:600px"></td>
            <td style="width:150px;text-align:center;color:#999;font-family:arial;font-size:13px;font-weight:bold">Sub-total</td>
            <td style="width:150px;text-align:center;font-size:18px;"><?php echo "€ ".$precoTotal;?></td>
      	</tr>
        <br>
        <tr>
        	<td style="width:600px"></td>
            <td style="width:150px">
            	<select name="paisEntrega" id="paisEntrega" onchange="actualizaEntrega()">
            		<?php 
						if (isset($_SESSION['pais'])){
							$paisId = $_SESSION['pais'];
							$cmd = "SELECT * FROM countries WHERE id = '$paisId'";
							$recurso = mysql_query($cmd);
							$row = mysql_fetch_array($recurso);
							?>
                            <option value="<?php echo $row['id']?>"><?php echo $row['pais']?></option>
                    	<?php
							$cmd = "SELECT * FROM countries WHERE id <> '$paisId' ORDER by pais";
							$recurso = mysql_query($cmd);
							while ($rowPaises = mysql_fetch_array($recurso)){
								?>
                                <option value="<?php echo $rowPaises['id']?>"><?php echo $rowPaises['pais']?></option>
                                <?php	
							}
						}else{
							  ?>
							  <option value="0">Escolha o seu pais.</option>
								  <?php
									  $cmd = "SELECT * FROM countries ORDER by pais";
									  $recurso = mysql_query($cmd);
									  while ($row = mysql_fetch_array($recurso)){
										  ?>
										  <option value="<?php echo $row['id']?>"><?php echo $row['pais']?></option>
										  <?php	
									  }
						}
								  ?>
            	</select>
           	</td>
            <td style="width:150px;text-align:center;font-size:18px;">
			<?php 
				if (isset($_SESSION['portes'])){
					echo $_SESSION['portes']; 
				}else{
					echo '--------';	
				}
			?>
            </td>
        </tr>
        <br>
        <tr>
        	<td style="width:600px"></td>
            <td style="width:150px;text-align:center;color:#999;font-family:arial;font-size:13px;font-weight:bold">Total</td>
            <?php
				if (isset($_SESSION['portes'])){ 
					$precoTotalComPortes = $precoTotal + $_SESSION['portes'];
				}else{
					$precoTotalComPortes = $precoTotal;
				}
			?>
            <td style="width:150px;text-align:center;font-size:18px;"><?php echo "€ ".$precoTotalComPortes;?></td>
      	</tr>
   	</table>
	<?php		
	include"_footer.php";
?>
