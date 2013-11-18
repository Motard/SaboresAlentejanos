<?php
	include "_header.php";
	if (isset ($_SESSION['compras'])){
		unset ($_SESSION['compras']);	
	}
?> 
	<div id="main">
<?php
	//********************************************************************************
	//****************************VER SE FOI FEITO LOGIN******************************
	//********************************************************************************
	if (!isset ($_SESSION['login']) || ($_SESSION['login']) == "") {
		$_SESSION['compras'] = "1";
		?>
        <div id="semLogin"> 
        	<p>Necessário fazer <a href="mainLogin.php">LOGIN</a> ou <a href="mainRegisto.php" >CRIAR CONTA</a>.</p>
        </div>
		<?php
	}else{
	//********************************************************************************
	//***********************VER SE EXISTE MORADA CRIADA******************************
	//********************************************************************************
	$userId = $_SESSION['login'];
	ligarBD();
	$cmd = "SELECT * FROM adresses WHERE userId = '$userId'";
	$recurso = mysql_query($cmd);
	$numlinhas = mysql_num_rows($recurso);
	if ($numlinhas == 0){
		$_SESSION['compras'] = "1";
	?>	
        <span style="color:grey">Esta conta não tem morada criada.&nbsp;&nbsp;</span>
        <a href="criaMor.php" style="color:grey;">Criar agora.</a>		
	<?php	
	}else{
		?>
        <div id="navegador">
            <ul>
                <li><img src="imagens/1-icon.png"><span>&nbsp;LOCAL ENTREGA</span></li>
                <li><img src="imagens/2-iconPB.png"><span>&nbsp;FORMA PAGAMENTO</span></li>
                <li><img src="imagens/3-iconPB.png"><span>&nbsp;REVER ORDEM</span></li>
            </ul>
        </div>
        <br>
        <br style="clear:both">
        <br>
        <br>
        <h3 style="text-align:left;font-family:Verdana, Geneva, sans-serif;font-size:14px">A morada para entrega é a abaixo indicada:</h3>
    	<br>
        <div id="morada">
        	<?php
			echo $_SESSION['nome'].' '.$_SESSION['apelido'].'<br>';
			$row = mysql_fetch_array($recurso);
				echo $row['rua']."<br>";
				echo $row['local']."<br>";
				echo $row['cp']."<br>";
				$paisId = $row['paisId'];
				$_SESSION['pais'] = $paisId;
				$cmd = "SELECT pais FROM countries WHERE id = '$paisId'";
				$recurso = mysql_query($cmd);
				$row = mysql_fetch_array($recurso);
				echo $row['pais']."<br>";	
			?> 
		</div>
            <a href="alteraMor.php?comprar=1" style="color:#473323;font-family:Verdana, Geneva, sans-serif;font-size:12px;margin-left:-200px">Alterar esta morada?</a>
        	<br><br>
            <a href="comprar2.php" style="text-decoration:none"><div id="btSetaDir" class="bt" style="float:right;height:24px;width:99px;"><span style="vertical-align:middle;">Continuar </span><img id="setaDir" style="vertical-align:middle;" src="imagens/seta_dir_white_icon.png" width="25" height="25"></div></a>		
            <?php	
	}
	};
?> 
	</div>
<?php
	include "_footer.php";	
?>