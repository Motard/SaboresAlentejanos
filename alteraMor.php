<?php
	include "_header.php";
	include "_leftBar.php";
	if (!isset ($_SESSION['login'])){
		header ('location:index.php?aviso=3');
	}
	if (isset ($_REQUEST['comprar'])){
		$returnURL = $_GET['comprar'];
		switch ($returnURL){
			case 1:
				$_SESSION['compras'] = "1";
				break;
			case 2:
				$_SESSION['compras'] = "2";
				break;
		} //end switch	
	}
	$userId = $_SESSION['login'];
	ligarBD();
	$cmd = "SELECT * FROM adresses WHERE userId = '$userId'";
	$recurso = mysql_query($cmd);
	$numLinhas = mysql_num_rows($recurso);
?>
	<div id="center" class="content">
<?php
	if ($numLinhas == 0){
	?>	
   		<span style="color:grey">Esta conta não tem morada criada.&nbsp;&nbsp;</span>
        <a href="criaMor.php" style="color:grey;">Criar agora.</a>	
    <?php
	}else{
	$row = mysql_fetch_array($recurso);
	$telefone = $row['telefone'];
?> 
		<form action="php/saveMor.php" method="post" name="morada" onsubmit="return validarMor()">
        	<p>ALTERAR MORADA</p>
            <fieldset><legend>MORADA</legend>
            <table>
                <tr>
                    <td style="width:190px;vertical-align:top"><label for="rua">RUA:</label></td>
                    <td><textarea type="text" id="rua" name="rua" maxlength="100" ><?php echo $row['rua']?></textarea></td>
                </tr>
                
                <tr>
                    <td><label for="localidade">LOCALIDADE:</label></td>
                    <td><input type="text" id="localidade" class="input" name="localidade" size="50" maxlength="100" value="<?php echo $row['local']?>"></td>
                </tr>
                <tr>
                    <td><label for="cp">CP E CIDADE:</label></td>
                    <td><input type="text" id="cp" name="cp" class="input" size="50" maxlength="100" value="<?php echo $row['cp']?>"></td>
                </tr>
                <tr>
                    <td><label for="pais">PAIS:</label></td>
                    <?php
						$paisId = $row['paisId'];
						$cmd = "SELECT * FROM countries WHERE id = '$paisId'";
						$recurso = mysql_query($cmd);
						$row = mysql_fetch_array($recurso);
					?>
                    <td><select name="pais" id="pais">
                    	<option value="<?php echo $row['id']?>"><?php echo $row['pais']?></option>
                    	<?php
							$cmd = "SELECT * FROM countries WHERE id <> '$paisId' ORDER by pais";
							$recurso = mysql_query($cmd);
							while ($rowPaises = mysql_fetch_array($recurso)){
								?>
                                <option value="<?php echo $rowPaises['id']?>"><?php echo $rowPaises['pais']?></option>
                                <?php	
							}
						?>
                    </select></td>
                </tr>
                <tr>
                    <td><label for="telefone">TELEFONE:</label></td>
                    <td><input type="text" id="telefone" name="telefone" class="input" size="50" maxlength="100" value="<?php echo $telefone?>"></td>
                </tr>
            </table>
            </fieldset>
            <table style="width:100%">
                <tr style="height:20px;">
                  <td style="width:50%"></td>
                  <td style="text-align:center"><input class="bt" name="submeter" type="submit" value="Enviar"></td>
                </tr>
            </table>
        </form>
        <br><br><br>
	</div>	
<?php		
	}
	include "_footer.php";
?>

