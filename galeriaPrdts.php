<?php
	if (!isset ($_REQUEST['produto'])){
		header('location:index.php');	
	}
	include "_header.php";
	include "_leftBar.php";
	$prdtId = $_GET["produto"];
	//********************************************************************
	//*******ACEDER Á BD produts E RETIRAR TODOS COM O ID=$prdtId*********
	//********************************************************************
	?> 
	<div id="center" class="content">
	<?php
	ligarBD();
	$cmd = "SELECT * FROM produts WHERE produtoCatId = '$prdtId'";
	$recurso = mysql_query($cmd);
	while ($row = mysql_fetch_array($recurso)){
		?>
        <div class="fotoPrdt">
        	<a href="produto.php?produto=<?php echo $row['id'] ?>">
        		<img class="imgPrdt" src="imagens/produtos/<?php echo $row['foto'];?>">
          	<a href="php/produto.php?produto=<?php echo $row['id'] ?>">
       	</div>
        <div class="nomePrdt">
        	<a href="produto.php?produto=<?php echo $row['id'] ?>">
       			<h3 class="hPrdt" style="color:black"><?php echo $row['nome'];?></h3>	
          	</a>
        </div>
        <div class="descPeqPrdt">
			<?php echo $row['descricaoPeq'];?>
       	</div>				
		<div class="preco">
        	<span style="color:#999;font-size:10px">PREÇO</span>
			<?php echo "€ ".$row['preco'];?>
      	</div>
        <div class="btVer">
        	<a href="produto.php?produto=<?php echo $row['id']?>" style="text-decoration:none">
        		<input type="button" class="bt" value="VER PRODUTO">
          	</a>
        </div>
        <div class="separador"></div>
    <?php
    }
	?> 
	</div>
	<?php
	include "_footer.php";
?>

