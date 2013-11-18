<?php
	include "_header.php";
	if (isset($_POST['formPag'])){
		$pagamento = $_POST['formPag'];
		$_SESSION['pagamento'] = $pagamento;
		header("location:comprar3.php");
	}
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
?> 
    <div id="navegador">
            <ul>
                <a href="comprar.php"><li><img src="imagens/1-icon.png">&nbsp;<span>LOCAL ENTREGA</span></li></a>
                <li><img src="imagens/2-icon.png">&nbsp;<span>FORMA PAGAMENTO</span></li>
                <li><img src="imagens/3-iconPB.png">&nbsp;<span>REVER ORDEM</span></li>
            </ul>
    </div>
	<br>
    <br style="clear:both">
    <br>
    <br>
    <h3 style="text-align:left;font-family:Verdana, Geneva, sans-serif;font-size:14px">Escolher forma de pagamento:</h3>
    <br>
    <form style="border:none" name="" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" onsubmit="return formPagamento()">
   		<div id="formPag">
        	<table style="with:100%">
            	<tr style="height:30px">
            		<td><label for="formPag" >Pagamento contra Reembolso</label></td>
            		<td><input class="formpag" name="formPag" type="radio" value="1"></td>
            	</tr>
                <tr style="height:30px">
                    <td><label for="formPag" >Pagamento por Transferencia Bancária</label></td>
                    <td><input class="formpag" name="formPag" type="radio" value="2"></td>
              	</tr>
         	</table>
            
    	</div>
      	<button id="btSetaDir" class="bt" name="bt" type="submit" style="float:right;"><span style="vertical-align:middle;">Continuar</span> <img id="setaDir" src="imagens/seta_dir_white_icon.png" style="vertical-align:middle;"></button>
  	</form>
<?php
	}
	include "_footer.php";
?>