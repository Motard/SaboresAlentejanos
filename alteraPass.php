<?php
	include "_header.php";
	include "_leftBar.php";
	if (!isset ($_SESSION['login'])){
		header ('location:index.php?aviso=3');
	}
?>
	<div id="center" class="content">
	<form name="alteraPassword" action="php/saveAlteraPass.php" method="post" onsubmit="return validarPass()">
        <p>ALTERAR PALAVRA PASSE</p>
        <fieldset><legend>INTRODUZA A SUA PALAVRA PASSE</legend>
            <table>
                <tr>
                    <td style="width:190px;"><label for="password">PALAVRA PASSE:</label></td>
                    <td><input id="password" class="input" name="password" type="password" size="25" maxlength="30"></td>
                </tr>
            </table>
        </fieldset>
        <fieldset><legend>ESCOLHA A NOVA PALAVRA PASSE</legend>
            <table>
                <tr>
                    <td style="width:190px;"><label for="novaPassword">NOVA PALAVRA PASSE:</label></td>
                    <td><input id="novaPassword" class="input" name="novaPassword" type="password" size="25" maxlength="30"></td>
                </tr>
                <tr>
                    <td><label for="novaPasswordCheck">CONFIRME PALAVRA PASSE:</label></td>
                    <td><input id="novaPasswordCheck" class="input" name="novaPasswordCheck" type="password" size="25" maxlength="30"></td>
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
	include "_footer.php";
?>
