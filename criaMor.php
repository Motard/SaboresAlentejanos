<?php
	include "_header.php";
	if (!isset ($_SESSION['login'])){
		header ('location:index.php?aviso=3');
	}
?>
	<div id="center" class="content">
		<form action="php/saveMor.php" method="post" name="morada" onsubmit="return validarMor()">
        	<p>CRIAR MORADA</p>
        	<fieldset><legend>MORADA</legend>
            <table>
            	<tr>
            		<td style="width:190px;vertical-align:top"><label for="rua">RUA:</label></td>
                    <td><textarea type="text" id="rua" name="rua" maxlength="100" style="border:1px solid grey;"></textarea></td>
            	</tr>
                
                <tr>
            		<td><label for="localidade">LOCALIDADE:</label></td>
                    <td><input type="text" id="localidade" class="input" name="localidade" size="50" maxlength="50"></td>
            	</tr>
                <tr>
            		<td><label for="cp">CP E CIDADE:</label></td>
                    <td><input type="text" id="cp" class="input" name="cp" size="50" maxlength="50"></td>
            	</tr>
                <tr>
            		<td><label for="pais">PAIS:</label></td>
                    <td><select name="pais" id="pais">
                    	<option value="0">--------------</option>
                    	<?php
							$cmd = "SELECT * FROM countries ORDER by pais";
							$recurso = mysql_query($cmd);
							while ($row = mysql_fetch_array($recurso)){
								?>
                                <option value="<?php echo $row['id']?>"><?php echo $row['pais']?></option>
                                <?php	
							}
						?>
                    </select></td>
            	</tr>
                <tr>
            		<td><label for="telefone">TELEFONE:</label></td>
                    <td><input type="text" id="telefone" class="input" name="telefone" size="50" maxlength="20"></td>
            	</tr>
            </table>
            </fieldset>
            <p id="aviso">Todos os campos são de preenchimento obrigatório.</p>
            <table style="width:100%">
            	<tr>
                  <td style="text-align:center"><input class="bt" name="submeter" type="submit" value="Enviar"></td>
                  <td style="text-align:center"><input class="bt" name="limpar" type="reset" value="Limpar"></td>
           		</tr>
            </table>
        </form>
	</div>	
<?php		
	include "_footer.php";
?>

