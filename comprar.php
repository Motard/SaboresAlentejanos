<?php
	include "_header.php";
	if (isset ($_SESSION['compras'])){
		unset ($_SESSION['compras']);	
	}
?> 
	<div id="main">
    <br>
    <br>
<?php
	//********************************************************************************
	//****************************VER SE FOI FEITO LOGIN******************************
	//********************************************************************************
	if (!isset ($_SESSION['login']) || ($_SESSION['login']) == "") {
		$_SESSION['compras'] = "1";
		?> 
        <p>Necessário fazer LOGIN ou CRIAR CONTA</p>
        <table style="width:100%">
        	<tr>
            	<td style="text-align:center">
                	<a href="mainLogin.php" style="text-decoration:none">
						<input class="bt" type="button" value="LOGIN">
                  	</a>
        		</td>
                <td style="text-align:center">
                	<a href="mainRegisto.php" style="text-decoration:none">
        				<input class="bt" type="button" value="CRIAR CONTA">
                  	</a>
        		</td>
        	</tr>
        </table>
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
        <h3>A morada para entrega é a abaixo indicada:</h3>
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
        	<br>
            <br>
        	<table style="width:100%">
            	<tr>
                	<td style="text-align:center">
                    	<a href="alteraMor.php?comprar=1" style="text-decoration:none">
        					<input id="btAlteraMorada" class="bt" type="button" value="ALTERAR MORADA">
                       	</a>
       				</td>
                    <td style="text-align:center">
                    	<a href="comprar2.php" style="text-decoration:none">
        					<input id="btContinuar" class="bt" type="button" value="CONTINUAR">
                       	</a>
            		</td>
            	</tr>	
      		</table>
		<?php	
	}
	};
?> 
	</div>
<?php
	include "_footer.php";	
?>
