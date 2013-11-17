<?php
	include "_header.php";
	$cookie = $_COOKIE['cookies'];
	//****************************************************************//
	//**************LIGAR BD USERS E VER SE O COOKIE TEM USER*********//
	//****************************************************************//
	?>
    <!--<input type="button" class="bt" value="Continuar a Comprar"></a>-->
    <a href="index.php" style="text-decoration:none"><div id="btSetaEsq" class="bt" style="float:left;height:15px;width:165px;"><img id="setaEsq" style="vertical-align:middle;" src="imagens/seta_esq_white_icon.png" width="12" height="12"><span style="vertical-align:middle;"> Continuar a Comprar</span></div></a>
    <br>
    <br>
    <br>
    <table style="width:100%;background-color:#F7B27B;border-top-left-radius:5px;border-top-right-radius:5px">
        <tr style="text-align:center;color:rgba(71,51,35,0.7);font-family:Arial, Helvetica, sans-serif;font-size:13px;font-weight:bold;">
            <td style="width:450px;padding:5px 0;">Descrição do produto</td>
            <td style="width:150px;padding:5px 0;">Preço</td>
            <td style="width:150px;padding:5px 0;">Quantidade</td>
            <td style="width:150px;padding:5px 0;">Sub-total</td>
        </tr>
   	</table>
    <div style="border:1px solid #F7B27B;border-bottom-left-radius:5px;">
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
                        <td class="tableCestoCompras" style="width:325px;vertical-align:middle">
                          	<span class="nomPrdt"><?php echo $row['nome'];?></span>
                      	</td>
                        <td class="tableCestoCompras" style="width:50px;vertical-align:middle;">
                        	<img class="apagarPrdt" src="imagens/trash-icon.png" width="30" height="30" title="Apagar produto" onclick="apagar(<?php echo $cestoComprasId[$i];?>)">
                        </td>
                        <td style="width:150px;text-align:center;border-left:1px solid #F7B27B;vertical-align:middle">
                        	<div class="precoUni">
                            	<?php echo "€ ".$row['preco'];?>
                         	</div>
                        </td>
                        <td style="width:150px;text-align:center;border-left:1px solid #F7B27B;vertical-align:middle">
                        	<div class="alteraQuan" id="<?php echo $i;?>"></div>
                        	<div class="quant">
                            	<input class="input inputQt" type="text" size="2" maxlength="2" readonly value="<?php echo $quantidade[$i]?>" onclick="alteraQt(<?php echo $cestoComprasId[$i];?>,<?php echo $i;?>)" title="Alterar Quantidade">
                         	</div>
                         	
                         	<div class="gravarAlteraQuan" id="btGravar<?php echo $i;?>"></div>
                         </td>
                         <td style="width:150px;text-align:center;border-left:1px solid #F7B27B;vertical-align:middle">
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
    <table style="width:100%;">
    	<tr style="height:24px;">
        	<td colspan="2" style="width:600px;"></td>
            <td style="width:106px;text-align:right;padding-right:45px;color:rgba(71,51,35,0.7);font-family:Arial, Helvetica, sans-serif;font-size:13px;font-weight:bold;border-left:1px solid #F7B27B;">Sub-total</td>
            <td style="width:101px;text-align:left;padding-left:49px;color:#473323;font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;border-right:1px solid #F7B27B;"><?php echo "€ ".$precoTotal;?></td>
      	</tr>
        <tr>
        	<td style="width:400px;"></td>
            <td style="width:200px;">
            	<select style="width:150px;" name="paisEntrega" id="paisEntrega" onchange="actualizaEntrega()" title="Escolher país de destino">
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
            <td style="text-align:right;padding-right:45px;color:rgba(71,51,35,0.7);font-family:Arial, Helvetica, sans-serif;font-size:13px;font-weight:bold;border-left:1px solid #F7B27B;">Portes</td>
            <td style="text-align:left;padding-left:49px;color:#473323;font-family:Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;border-right:1px solid #F7B27B;">
			<?php 
				if (isset($_SESSION['portes'])){
					echo "€ ".$_SESSION['portes']; 
				}else{
					echo '--------';	
				}
			?>
            </td>
        </tr>
        <tr style="height:24px;">
        	<td colspan="2" style="width:600px;"></td>
            <td style="text-align:right;padding-right:45px;padding-top:10px;padding-bottom:5px;color:rgba(71,51,35,0.7);font-family:Arial, Helvetica, sans-serif;font-size:15px;font-weight:bold;text-decoration:underline;border-left:1px solid #F7B27B;border-bottom:1px solid #F7B27B;border-bottom-left-radius:5px;">Total</td>
            <?php
				if (isset($_SESSION['portes'])){ 
					$precoTotalComPortes = $precoTotal + $_SESSION['portes'];
				}else{
					$precoTotalComPortes = $precoTotal;
				}
			?>
            <td style="text-align:left;padding-left:49px;padding-bottom:5px;color:#473323;font-family:Arial, Helvetica, sans-serif;font-size:16px;font-weight:bold;text-decoration:underline;border-right:1px solid #F7B27B;border-bottom:1px solid #F7B27B;border-bottom-right-radius:5px;-webkit-border-bottom-right-radius:5px;-moz-border-bottom-right-radius:5px;"><?php echo "€ ".$precoTotalComPortes;?></td>
      	</tr>
   	</table>
    <br>
    <br>
    <!--<input style="float:right" type="button" class="bt" value="Finalizar Compra">-->
    <a href="comprar.php" style="text-decoration:none"><div id="btSetaDir" class="bt" style="float:right;height:24px;width:149px;"><span style="vertical-align:middle;">Finalizar Compra </span><img id="setaDir" style="vertical-align:middle;" src="imagens/seta_dir_white_icon.png" width="25" height="25"></div></a>
    
	<?php		
	include"_footer.php";
?>
