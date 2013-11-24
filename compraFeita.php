<?php
	include "_header.php";
?>
	<div id="mainCompra">
    	<br><br>
        <h3>Muito obrigado pela sua encomenda!</h3>
        <br><br>
        <p>Foi enviado um e-mail com os detalhes da compra.</p>
        <p>Qualquer questão relacionada com esta encomenda deverá sempre mencionar a seguinte referência: <bold> <?php echo $_SESSION['refCompra']; ?></bold>.</p>
   	</div>
<?php	
	include "_footer.php";
?>