<?php
	include "_header.php";
	
	echo "Muito obrigado, a sua encomenda foi efetuada<br>";
	echo "Enviamos-lhe um mail com os dados da sua encomenda.<br>";
	echo "Qualquer questão relacionada com esta encomenda deve sempre mencionar a seguinte referencia ".$_SESSION['refCompra'];
	
	include "_footer.php";
?>