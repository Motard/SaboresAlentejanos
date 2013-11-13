<?php
	include "_header.php";
?>
<div id="center" class="content">
	<form action="php/saveRecuperaPass.php" method="post" name="recuperaPass" onsubmit="return validarRecuperaPass()">
    <p>RECUPERAR PASSWORD</p>
    <fieldset><legend>INTRODUZA O SEU MAIL</legend>
    	<table>
        <tr>
        	<td style="width:190px;"><label for="mail">E-MAIL</label></td>
    		<td><input name="mail" id="mail" class="input" type="text" size="25" maxlength="50"></td>
      	</tr>
        </table>
    </fieldset>
     <table style="width:100%">
    		<tr>
            	<td style="text-align:center"><input class="bt" name="submeter" type="submit" value="Enviar"></td>
        		<td style="text-align:center"><input class="bt" name="limpar" type="reset" value="Limpar"></td>
           	</tr>
        </table>
    </form>
    <br>
    <span style="color:grey">Introduza o endereço de email que identifica a sua conta e será enviado de imediato um mail com uma password nova.</span>
</div>
<?php
	include "_footer.php"
?>