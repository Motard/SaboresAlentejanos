<?php
	include "_header.php";
	include "_leftBar.php";
?> 
	<div id="center" class="content">
<?php
		$userId = $_SESSION['login'];
		$paisId = $_SESSION['paisId'];
		$preçoTotal = 0;
		$peso = 0;
		$pesoTotal = 0;
		ligarBD();
		$cmd = "SELECT * FROM shop_basket WHERE userId = '$userId' ORDER BY id";
		$recurso = mysql_query($cmd);
		$numLinhas = mysql_num_rows($recurso);
		$i = 0;
		while ($row = mysql_fetch_array($recurso)){
			$cestoComprasId[$i] = $row['id'];
			$produtoId[$i] = $row['produtoId'];
			$quantidade[$i]	= $row['quantidade'];
			$i++;
		}?> 
		<table border="1">
			<tr>
				<td>Produto/Preço</td>
				<td>Quantidade</td>
			</tr>
		<?php
		for ($i=0; $i<$numLinhas; $i++){
			$cmd = "SELECT * FROM produts WHERE id = '$produtoId[$i]'";
			$recurso = mysql_query($cmd);
			while ($row = mysql_fetch_array($recurso)){
				?>
			<tr>
				<td>				
					<?php 
						echo $row['nome']."<br>";
						$precoTotalItem = $row['preco']* $quantidade[$i];
						$peso = $row['peso']* $quantidade[$i];
						$preçoTotal += $precoTotalItem;
						$pesoTotal += $peso;
						echo $precoTotalItem." €";
					?>
					<input class="btApagar" name="" type="button" value="APAGAR" onclick="apagarFinal(<?php echo $cestoComprasId[$i];?>)">
				</td>
				<td>
					<input class="inputQt" type="text" size="2" maxlength="2" value="<?php echo $quantidade[$i]?>" onchange="alteraQtFinal(<?php echo $cestoComprasId[$i];?>,<?php echo $i;?>)">
				</td>
			</tr>
				<?php
			};	
		};?>
		</table>
		<div id="continuar">
			<input id="btContinuar" class="bt" type="button" value="CONTINUAR" onclick="comprar(3)">	
		</div>
        <?php
			$cmd = "SELECT preco FROM portes WHERE paisId = '$paisId' AND peso >= '$pesoTotal' LIMIT 1";
			$recurso = mysql_query($cmd);
			$row = mysql_fetch_array($recurso);
			$preçoPortes = $row['preco'];
			$precoTotalComPortes = $preçoTotal + $preçoPortes;
		?>
        <table>
        	<tr>
            	<td>TOTAL ARTIGOS</td>
                <td><?php echo $preçoTotal?></td>
            </tr>
            <tr>
            	<td>PESO ENCOMENDA</td>
                <td><?php echo $pesoTotal ?></td>
            </tr>
            <tr>
            	<td>PREÇO PORTES</td>
                <td><?php echo $preçoPortes ?></td>
            </tr>
            <tr>
            	<td>TOTAL ENCOMENDA</td>
                <td><?php echo $precoTotalComPortes?></td>
            </tr>
        </table>
	</div>
<?php 
	include "_footer.php";
?>