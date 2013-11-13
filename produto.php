<?php
	if (!isset ($_REQUEST['produto'])){
		header('location:index.php');	
	}
	include "_header.php";
	include "_leftBar.php";
	$prdtId = $_GET["produto"];
	//********************************************************************
	//*****ACEDER Á BD produts E RETIRAR PRODUTO COM O ID=$prdtId*********
	//********************************************************************
	?> 
	<div id="center" class="content">
		<?php
        ligarBD();
        $cmd = "SELECT * FROM produts WHERE id = '$prdtId'";
        $recurso = mysql_query($cmd);
        $row = mysql_fetch_array($recurso);
        ?>
        <div id="fotoPrdt">
            <img id="zoom" src="imagens/zoom-icon.png" width="20" height="20" >
            <img id="imgPrdt" src="imagens/produtos/<?php echo $row['foto'];?>">
        </div>
        <div id="nomePrdt">
            <h3><?php echo $row['nome'];?></h3>	
        </div>
        <div id="descLngPrdt">
            <?php echo $row['descricaoLng'];?>
        </div>				
        <div class="preco">
            <span>PREÇO </span>
            <span class="valor"><?php echo "€ ".$row['preco'];?></span>
        </div>
        <div id="quantidade">
            <span>QUANTIDADE </span>
            <input id="nPrdts" type="text" maxlength="2" value="1" readonly onclick="quantidade()" title="Alterar Quantidade">
        </div>
        <div id="alteraQuan"></div>
        <div id="btAdd">
            <input id="adicionarPrdt" class="bt" type="button" produto="<?php echo $row['id']?>" value="Adicionar ao Cesto de Compras">
        </div>
	</div>
    <div style="clear:both;"></div>
    <br><br><br><br><br><br>
	<?php
	include "_footer.php";
?>

