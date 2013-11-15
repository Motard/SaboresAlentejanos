<?php
	include"_header.php";
	include"_leftBar.php";
	$procurar = $_GET['produto'];
	?> 
	<div id="center" class="content">
	<?php
	ligarBD();
	$cmd = "SELECT * FROM produts WHERE nome LIKE ('%$procurar%')";
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
       			<h3><?php echo $row['nome'];?></h3>	
          	</a>
        </div>
        <div class="descPeqPrdt">
			<?php echo $row['descricaoPeq'];?>
       	</div>				
		<div class="preco">
        	<span>PREÇO </span>
			<span class="valor"><?php echo "€ ".$row['preco'];?></span>
      	</div>
        <div class="btVer">
        	<a href="produto.php?produto=<?php echo $row['id']?>" style="text-decoration:none">
        		<input type="button" class="bt" value="Ver Produto">
          	</a>
        </div>
        <div class="separador"></div>
    <?php
    }
	?> 
	</div>
	<?php
	include"_footer.php";
?>