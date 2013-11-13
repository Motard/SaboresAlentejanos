
<?php
	$pagamento = $_POST['formPag'];
	$_SESSION['pagamento'] = $pagamento;
?>	

<script>
	window.location = "../index.php?comprar4&comprar";
</script>