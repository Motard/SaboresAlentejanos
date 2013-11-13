<meta charset="utf-8">
<?php
	echo "COMPRAR 3 .PHP<br>";
	echo "ESCOLHER FORMA DE PAGAMENTO <br>";
?>
	<br>
	<hr>
    <form name="" action="php/formPag.php" method="post" onsubmit="return formPagamento()">
    	<label for="formPag" >Pagamento contra Reembolso</label>
    	<input name="formPag" type="radio" value="1">
    	<br>
    	<label for="formPag" >Pagamento por Transferencia Bancária</label>
    	<input name="formPag" type="radio" value="2">
        <input name="bt" type="submit" value="CONTINUAR">
	</form>
