<?php
	include "_header.php";
	?> 
	<div id="main">
        <?php
        if (!isset ($_SESSION['login']) || ($_SESSION['login']) == "") {
            $_SESSION['compras'] = "1";
            ?> 
            <div id="semLogin"> 
        		<p>Necessário fazer <a href="mainLogin.php">LOGIN</a> ou <a href="mainRegisto.php" >CRIAR CONTA</a>.</p>
        	</div>
            <?php
        }else{
			if (!isset($_SESSION['precoTotal']) || isset($_SESSION['recalcular'])){
				$cmd = "SELECT * FROM shop_basket WHERE userId = '$userId' ORDER BY id DESC";
				$recurso = mysql_query($cmd);
				$numlinhas = mysql_num_rows($recurso);
				if ($numlinhas == 0){
					header ('location:index.php?aviso=11');
				}else{
					$i = 0;
					while ($row = mysql_fetch_array($recurso)){
						$produtoId[$i] = $row['produtoId'];
						$quantidade[$i] = $row['quantidade'];
						$i++;
					} //end while
					$precoTotal = 0;
					$pesoTotal = 0;
					for ($i=0; $i<$numlinhas; $i++){
						$cmd = "SELECT preco,peso FROM produts WHERE id = '$produtoId[$i]'";
						$recurso = mysql_query($cmd);
						$row = mysql_fetch_array($recurso);
						$precoTotalItem = $row['preco']*$quantidade[$i];
						$precoTotal += $precoTotalItem;
						$peso = $row['peso']* $quantidade[$i];
						$pesoTotal += $peso;
					} //end for
				 $_SESSION['precoTotal'] = $precoTotal;
				 $_SESSION['pesoTotal'] = $pesoTotal;
				 }//end if
			} //end if
			if (!isset($_SESSION['portes']) || isset($_SESSION['recalcular'])){
				$paisId = $_SESSION['pais'];
				$pesoTotal = $_SESSION['pesoTotal'];
				$cmd = "SELECT preco FROM portes WHERE paisId = '$paisId' AND peso >= '$pesoTotal' LIMIT 1";
				$recurso = mysql_query($cmd);
				$row = mysql_fetch_array($recurso);
				$_SESSION['portes'] = $row['preco'];  	
			} // end if
			$precoTotal = $_SESSION['portes'] + $_SESSION['precoTotal'];
			?>
            <div id="navegador">
                <ul>
                    <a href="comprar.php"><li><img src="imagens/1-icon.png"><span>&nbsp;LOCAL ENTREGA</span></li></a>
                	<a href="comprar2.php"><li><img src="imagens/2-icon.png"><span>&nbsp;FORMA PAGAMENTO</span></li></a>
                	<li><img src="imagens/3-icon.png"><span>&nbsp;REVER ORDEM</span></li>
                </ul>
       		</div>
            <br>
            <h3 style="text-align:left;font-family:Verdana, Geneva, sans-serif;font-size:14px;">Reveja a sua encomenda:</h3>
            <br>
            <div id="detalhesOrdem">
                <div id="detalhesEncomenda">
                    <table style="width:100%;font-family:Verdana, Geneva, sans-serif;font-size:14px;">
                        <tr style="height:30px;font-weight:600;">
                            <td style="width:28%;text-align:left;padding-bottom:10px;">Morada da Entrega</td>
                            <td style="text-align:left;padding-bottom:10px;">Detalhes de Pagamento</td>
                        </tr>
                        <tr>
                            <td style="text-align:left;vertical-align:top;padding-right:20px;">
                                <?php
                                    $userId = $_SESSION['login'];
                                    ligarBD();
                                    $cmd = "SELECT * FROM adresses WHERE userId = '$userId'";
                                    $recurso = mysql_query($cmd);
                                    $row = mysql_fetch_array($recurso);
                                    echo $_SESSION['nome']." ".$_SESSION['apelido']."<br>";
                                    echo $row['rua']."<br>";
                                    echo $row['local']."<br>";
                                    echo $row['cp']."<br>";
                                    $paisId =  $_SESSION['pais'];
                                    $cmd = "SELECT pais FROM countries WHERE id = $paisId";
                                    $recurso = mysql_query($cmd);	
                                    $row = mysql_fetch_array($recurso);
                                    echo $row['pais'];
                                ?>
                                <br>
                                <br>
                                <a href="alteraMor.php?comprar=2" style="color:#E12519;font-family:Tahoma, Geneva, sans-serif;font-size:14px;"><p>Alterar morada?</p></a> 
                            </td>
                            <td style="text-align:left;vertical-align:top">
                                <?php
									ligarBD();
									$cmd = "SELECT userId FROM users_shop WHERE userId = '$userId'";
									$recurso = mysql_query($cmd);
									$numLinhas = mysql_num_rows($recurso);
									$numLinhas ++;
									$_SESSION['refCompra'] = "U".$userId." C".$numLinhas; 
                                    if ($_SESSION['pagamento'] == 1){
                                        echo "A forma de pagamento escolhida foi contra-reembolso.<br><br>";
                                        echo "Os itens acima serão enviados para a morada indicada e o pagamento devera ser feito no acto de entrega.<br><br>";	
                                        echo "Quando se proceder ao envio da encomenda enviaremos um mail a confirmar o envio da mesma.";
                                    }else{
                                        echo "A forma de pagamento escolhida foi transferência bancária.<br><br>";
                                        echo "Deve efectuar a transferência do valor indicado para a conta:<br>";
                                        echo "<bold>0033 0000 00054658767 56</bold><br>";
                                        echo "Indicando a referencia <bold>".$_SESSION['refCompra']."</bold><br>";
                                        echo "Enviar comprovativo de pagamento para o mail <bold>sa@saboresalentejanos.pt </bold><br><br>";
                                        echo "Após recepção de comprovativo de transferencia efetuada procederemos ao envio dos produtos.<br>";
                                        
                                    }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="custoEncomenda">
                    <table style="width:196px;font-family:Verdana, Geneva, sans-serif;font-size:12px;">
                        <tr>
                            <td colspan="2" style="text-align:center;padding:20px 0;background-color:#473323;border-top-left-radius:5px;border-top-right-radius:5px;"><a href="fimCompra.php"><input type="button" class="bt" value="Efectuar Compra" onclick="comprar(4)"></a></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding:25px 0 60px 0;font-size:14px">Resumo da encomenda</td>
                        </tr>
                        <tr style="height:20px;">
                            <td style="text-align:left;padding-left:5px;">Preço Encomenda:</td>
                            <td style="text-align:right;padding-right:5px;"><?php echo "€ ".$_SESSION['precoTotal'];?></td>
                        </tr>
                        <tr style="height:20px;">
                            <td style="text-align:left;padding-left:5px;padding-bottom:3px">Preço Portes</td>
                            <td style="text-align:right;padding-right:5px;"><?php echo "€ ".$_SESSION['portes'];?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left;padding-left:5px;padding-top:10px;font-weight:bold">Preço Total</td>
                            <td style="text-align:right;padding-right:5px;padding-top:10px;font-weight:bold"><?php echo "€ ".$precoTotal;?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-top:40px;padding-left:5px;text-align:left;font-family:Tahoma, Geneva, sans-serif;">O valor indicado inclui IVA.</td>
                        </tr>
                    </table>
                </div>
                <div id="produtosEncomenda">
                    <?php
                    ligarBD();
                    $cmd = "SELECT * FROM shop_basket WHERE userId = '$userId' ORDER BY id DESC";
                    $recurso = mysql_query($cmd);
                    $numLinhas = mysql_num_rows($recurso);
                    $i = 0;
                    while ($row = mysql_fetch_array($recurso)){
                        $cestoComprasId[$i] = $row['id'];
                        $produtoId[$i] = $row['produtoId'];
                        $quantidade[$i]	= $row['quantidade'];
                        $i++;
                    }?>
                    <div id="produtos">
                        <table style="width:100%;font-family:Verdana, Geneva, sans-serif;font-size:14px;">
                        <tr style="height:30px;font-weight:600;">
                        	<td colspan="2" style="padding-bottom:10px;width:50%">Produto</td>
                            <td style="padding-bottom:10px;width:20%">Preço</td>
                            <td style="padding-bottom:10px;width:22%">Quantidade</td>
                            <td style="padding-bottom:10px;width:8%;"></td>
                        </tr> 
                        <?php
                        for ($i=0; $i<$numLinhas; $i++){
                            $cmd = "SELECT * FROM produts WHERE id = '$produtoId[$i]'";
                            $recurso = mysql_query($cmd);
                            while ($row = mysql_fetch_array($recurso)){
                            ?>
                            <tr>
                                <td style="width:50px;height:50px;">
                                	<div class="imagemPrdt">
                                    	<img style="vertical-align:middle;" class="imgPrdt" src="imagens/produtos/<?php echo $row['foto'];?>">
                                  	</div>	
                                </td>
                                <td style="text-align:left;vertical-align:middle"><?php echo $row['nome']."<br>";?></td>
                                <td style="vertical-align:middle;text-align:left;padding-left:57px;"><?php echo "€ ".$row['preco']; ?></td>
                                <td  style="vertical-align:middle" id="t<?php echo $i;?>">
                                	<div class="quantFinal">	
										<?php echo $quantidade[$i]; ?> 
                                  	</div>
                                </td>
                                <td style="vertical-align:middle;text-align:left;"><span class="altera" title="Alterar quantidade" onclick="alteraQtFinal(<?php echo $cestoComprasId[$i];?>,<?php echo $quantidade[$i]; ?>,<?php echo $i;?>)">Alterar</span><br><span class="apaga" title="Apagar Item" onclick="apagarFinal(<?php echo $cestoComprasId[$i];?>)">Apagar</span></td>
                            </tr>
                            <?php
                            };	
                        };?>
                        </table>
                    </div>
            </div>
    	</div>
	</div>
			
<?php
	}
	if (isset($_SESSION['recalcular']))
		unset($_SESSION['recalcular']);
	$_SESSION['compraFinal']='1';
	include "_footer.php";
?>
