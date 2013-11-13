<?php
	echo "COMPRA FINAL . PHP<br>";
	echo $_SESSION['pagamento'];
	
	$userId = $_SESSION['login'];
	require_once "db.php";
	ligarBD("users");
	$cmd = "SELECT nome,apelido FROM users WHERE id = '$userId#'";
	$recurso = mysql_query($cmd);
	while ($row = mysql_fetch_array($recurso)){
		$nome = $row['nome'];
		$apelido = $row['apelido'];
	}
	$cmd = "SELECT * FROM adresses WHERE userId = '$userId'";
	$recurso = mysql_query($cmd);
	?>
    <p>Morada para entrega:</p>
    <div id="morada">
        <?php
        while ($row = mysql_fetch_array($recurso)){
			echo $nome."".$apelido."<br>";
            echo $row['rua']."<br>";
            echo $row['local']."<br>";
            echo $row['cp']."<br>";
            echo $row['pais']."<br>";	
        }
        ?> 
    </div>
    
	<?php
	ligarBD('produts');
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
    <br> 
    <div id="produtos">
        <table border="1">
        	   
        <?php
		$precoTotal = 0;
		$precoPortes = 0;
        for ($i=0; $i<$numLinhas; $i++){
            $cmd = "SELECT * FROM produts WHERE id = '$produtoId[$i]'";
            $recurso = mysql_query($cmd);
            while ($row = mysql_fetch_array($recurso)){
                ?>
            <tr>
                <td>				
                    <?php 
                        echo $row['nome']."<br>";
                        $precoTotalItem = $row['preco']*$quantidade[$i];
                        echo $precoTotalItem." €";
                        echo "<br>Quantidade : ". $quantidade[$i];
						$precoTotal += $precoTotalItem;
                    ?>
                   
                </td>
                <td>
                    <img class="imgPrdt" width="50" height="50" src="imagens/produtos/<?php echo $row['foto'];?>">	
                </td>
            </tr>
                <?php
            };	
        };?>
        </table>
 	</div>
    <div id="preco">
    	<?php $precoTotalPortes = $precoTotal + $precoPortes?>
    	<table>
        	<tr>
            	<td><?php echo "Preço encomenda : "?></td>
                <td><?php echo $precoTotal. "€";?></td>
           	</tr>
            <tr>
            	<td><?php echo "Preço Portes : "?></td>
                <td><?php echo $precoPortes. "€";?></td>
           	</tr>
            <tr>
            	<td><?php echo "Preço total com Portes : "?></td>
                <td><?php echo $precoTotalPortes. "€";?></td>
           	</tr>
		</table>
    </div>
    <div id="infEncomenda">
	<?php
		if ($_SESSION['pagamento'] == 1){
			echo "Os itens acima serão enviados para a morada indicada via CTT.<br>";	
			echo "A forma de pagamento escolhida foi contra-reembolso.<br>";
			echo "Será enviado de imediato um email com esta informação.";
			echo "Quando se proceder ao envio da encomenda enviaremos um mail a confirmar o envio da mesma.";
		}else{
			ligarBD('users');
			$cmd = "SELECT userId FROM users_shop WHERE userId = '$userId'";
			$recurso = mysql_query($cmd);
			$numLinhas = mysql_num_rows($recurso);
			$numLinhas ++;
			$_SESSION['refCompra'] = $numLinhas;
			$ref = "USER ".$userId." COMPRA ".$numLinhas; 
			echo "A forma de pagamento escolhida foi transferencia bancária.<br>";
			echo "Deve efectuar a transferencia do valor indicado para a conta:<br>";
			echo "0033 0000 00054658767 56<br>";
			echo "Indicando a referencia <strong>".$ref."</strong><br>";
			echo "Necessário envio por email de comprovativo da transferencia efetuada<br>";
			echo "Após receção de comprovativo de transferencia efetuada procederemos ao envio dos produtos<br>";
			echo "Será enviado de imediato um email com esta informação.";
		}
?>
	</div>
    <input type="button" value="EFETUAR COMPRA" onclick="comprar(4)">
    <input type="button" value="CORRIGIR" onclick="comprar(1)">

<script src="js/myScripts.js"> </script>