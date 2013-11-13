<?php
	include "_header.php";
	if (isset($_POST['formPag'])){
		$pagamento = $_POST['formPag'];
		$_SESSION['pagamento'] = $pagamento;
		header("location:comprar3.php");
	}
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
?> 
    <div id="navegador">
            <ul>
                <a href="comprar.php"><li><img src="imagens/1-icon.png"><span>&nbsp;LOCAL ENTREGA</span></li></a>
                <li><img src="imagens/2-icon.png"><span>&nbsp;FORMA PAGAMENTO</span></li>
                <li><img src="imagens/3-iconPB.png"><span>&nbsp;REVER ORDEM</span></li>
            </ul>
    </div>
<?php




	echo "ESCOLHER FORMA DE PAGAMENTO <br>";
?>
	<br>
	
    <form name="" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" onsubmit="return formPagamento()">
    	<label for="formPag" >Pagamento contra Reembolso</label>
    	<input class="formpag" name="formPag" type="radio" value="1">
    	<br>
    	<label for="formPag" >Pagamento por Transferencia Bancária</label>
    	<input class="formpag" name="formPag" type="radio" value="2">
        <br>
        <br>
        <br>
        <input class="bt" name="bt" type="submit" value="Continuar">
	</form>
<?php
	}
?>