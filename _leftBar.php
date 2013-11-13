<nav class="content">
	<ul>
		<p id="menuP">PRODUTOS</p>
		<?php
			ligarBD();
			$cmd = "SELECT * FROM productCat";
			$recurso = mysql_query($cmd);
			while ($row = mysql_fetch_array($recurso)){
				?>
                <li><a href="galeriaPrdts.php?produto=<?php echo $row['id']?>"><?php echo strtoupper ($row['produto'])?></a></li>
                <?php	
			}
		?>
	</ul>
</nav>

