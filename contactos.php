<?php
	include "_header.php";
	include "_leftBar.php";
	if (isset($_POST['nome'])){
		$nome = $_POST['nome'];
		$mail = $_POST['mail'];
		$telefone = $_POST['telefone'];
		$msg = $_POST['mensagem'];
		$webMaster = "pabm71@gmail.com";
		$mailde ="pmotard@sapo.pt";
		$emailSubject = "Mensagem de cliente";
		$body = <<<EOD
<br><hr><hr>
Nome: $nome<br>
Email: $mail <br>
Telefone: $telefone <br>
Mensagem: $msg <br>
EOD;
		$headers = "From: $mailde\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8 . \r\n";
		mail($webMaster, $emailSubject, $body, $headers);
		header('location:index.php?aviso=12');
	}
?>
	<div id="center" class="content">
        <div id="texto">
        	<div id="contactos">
                <h3>Localização</h3>
                <br>
                <p>Rua Nova do Outeiro nº48</p>
                <p>Vila Verde de Ficalho</p>
                <p>7830-604 SERPA</p>
                <br>
                <br>
                <h3>Telefone</h3>
                <br>
                <p>96 665 0627</p>
                <br>
                <br>
                <h3>E-Mail</h3>
                <br>
                <p>loja@saboresalentejanos.pt</p>
                <br>
            </div>
            <div id="contactosForm">
            	<p>Se preferir pode entrar em contacto conosco atráves do seguinte formulário. Responderemos o mais breve possivel.</p>
                <br>
                <form id="formContacto" name="contacto" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="return validarPedContact()" >
                	<br>
                    <table>
                        <tr>
                            <td style="width:130px;"><label for="nome">NOME:</label></td>
                            <td><input class="input" type="text" id="nome" name="nome" 
							<?php if (isset($_SESSION['login'])){
								$nome = $_SESSION['nome'].' '.$_SESSION['apelido'];
								?>value="<?php echo $nome; ?>" <?php	
							}
							?>><span class="asterisco"> *</span></td>
                        </tr>
                        <tr>
                            <td><label for="mail">E-MAIL:</label></td>
                            <td><input class="input" type="text" id="mail" name="mail"
							<?php if (isset($_SESSION['login'])){
								$mail = $_SESSION['mail'];
								?>value="<?php echo $mail; ?>" <?php	
							}
							?>><span class="asterisco"> *</span></td>
                        </tr>
                        <tr>
                            <td><label for="telefone">TELEFONE:</label></td>
                            <td><input class="input" type="text" id="telefone" name="telefone"></td>
                        </tr>
                        <tr style="height:100px;">
                            <td style="vertical-align:top;padding-top:28px;"><label for="nome">MENSAGEM:</label></td>
                            <td><textarea class="input" id="mensagem" name="mensagem"></textarea><span style="vertical-align:top" class="asterisco"> *</span></td>
                        </tr>
                    </table>
                    <br>
                    <table style="width:100%">
                        <tr style="height:20px;">
                          <td style="text-align:right;padding-right:43px;"><input class="bt" name="submeter" type="submit" value="Enviar"></td>
                        </tr>
                    </table>
                </form>
                <span class="asterisco">*</span> Campos de preenchimento obrigatório.
            </div>
        </div>
    </div>
    <div style="clear:both"></div>
    <br><br><br>
<?php
	include "_footer.php";
?>