<?php
	include "_header.php";
	?> 
	<div id="main">
        <br>
        <br>
        <?php
        if (!isset ($_SESSION['login']) || ($_SESSION['login']) == "") {
            $_SESSION['compras'] = "1";
            ?> 
            <p>Necessário fazer LOGIN ou CRIAR CONTA</p>
            <table style="width:100%">
                <tr>
                    <td style="text-align:center">
                        <a href="mainLogin.php" style="text-decoration:none">
                            <input class="bt" type="button" value="LOGIN">
                        </a>
                    </td>
                    <td style="text-align:center">
                        <a href="mainRegisto.php" style="text-decoration:none">
                            <input class="bt" type="button" value="CRIAR CONTA">
                        </a>
                    </td>
                </tr>
            </table>
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
            <p>Reveja a sua encomenda</p>
            <br>
            <br>
            <div id="detalhesOrdem">
                <div id="detalhesEncomenda">
                    <table style="width:100%">
                        <tr style="height:50px;font-weight:600">
                            <td style="width:28%;text-align:left">Morada da Entrega</td>
                            <td style="text-align:left;">Detalhes de Pagamento</td>
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
                                <br>
                                <a href="alteraMor.php?comprar=2"><p>Alterar morada</p></a> 
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
                    <table style="width:198px">
                        <tr>
                            <td colspan="2" style="text-align:center;padding:20px 0;background-color:black"><a href="fimCompra.php"><input type="button" class="bt" value="EFETUAR COMPRA" onclick="comprar(4)"></a></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding:25px 0 60px 0">Resumo da encomenda</td>
                        </tr>
                        <tr>
                            <td style="text-align:left;padding-left:5px;padding-bottom:5px">Preço Encomenda:</td>
                            <td style="text-align:right;padding-right:5px;"><?php echo "€ ".$_SESSION['precoTotal'];?></td>
                        </tr>
                        <tr style="border-bottom:2px solid black">
                            <td style="text-align:left;padding-left:5px;padding-bottom:3px">Preço Portes</td>
                            <td style="text-align:right;padding-right:5px;"><?php echo "€ ".$_SESSION['portes'];?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left;padding-left:5px;padding-top:10px;font-weight:bold">Preço Total</td>
                            <td style="text-align:right;padding-right:5px;padding-top:10px;font-weight:bold"><?php echo "€ ".$precoTotal;?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-top:20px;">O valor indicado inclui IVA.</td>
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
                    <br> 
                    <div id="produtos">
                        <table style="width:100%">
                        <tr>
                        	<td colspan="2">Produto</td>
                            <td>Preço</td>
                            <td style="width=33%">Quantidade</td>
                        </tr> 
                        <?php
                        for ($i=0; $i<$numLinhas; $i++){
                            $cmd = "SELECT * FROM produts WHERE id = '$produtoId[$i]'";
                            $recurso = mysql_query($cmd);
                            while ($row = mysql_fetch_array($recurso)){
                            ?>
                            <tr>
                                <td style="width:50px;height:50px;">
                                    <img class="imgPrdt" src="imagens/produtos/<?php echo $row['foto'];?>">	
                                </td>
                                <td style="font-weight:bold;"><?php echo $row['nome']."<br>";?></td>
                                <td><?php echo $row['preco']." €"; ?></td>
                                <td id="t<?php echo $i;?>">
                                	<div class="quantFinal">	
										<?php echo $quantidade[$i]; ?> 
                                        <br>
                                        <span class="altera" title="Altera Quantidade" onclick="alteraQtFinal(<?php echo $cestoComprasId[$i];?>,<?php echo $quantidade[$i]; ?>,<?php echo $i;?>)">Alterar</span>&nbsp;&nbsp;&nbsp;<span class="apaga" title="Apaga Item" onclick="apagarFinal(<?php echo $cestoComprasId[$i];?>)">Apagar</span>
                                  	</div>
                                </td>
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
