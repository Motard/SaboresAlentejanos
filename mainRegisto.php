<?php
	include "_header.php";
	include "_leftBar.php"
?>
	<div id="center" class="content">
        <form id="formRegistar" name="registar" action="php/saveRegisto.php" method="post" onsubmit="return validarReg()" >
        <p>CRIAR CONTA</p>
        <fieldset><legend>DADOS PESSOAIS</legend>
            <table>
                <tr>
                    <td style="width:190px;"><label for="nome">NOME PRÓPRIO:</label></td>
                    <td><input class="input" id="nome" name="nome" type="text" size="25" maxlength="30"></td>
                </tr>
                <tr>
                    <td><label for="apelido">APELIDO:</label></td>
                    <td><input class="input" id="apelido" name="apelido" type="text" size="25" maxlength="30"></td>
                </tr>
                <tr>
                    <td><label for="mail">E-MAIL:</label></td>
                    <td><input class="input" id="mail" name="mail" type="text" size="25" maxlength="50"></td>
                </tr>
            </table>
        </fieldset>
        <fieldset><legend>ESCOLHA A PALAVRA PASSE</legend>
            <table>
                <tr>
                    <td style="width:190px;"><label for="password">PALAVRA PASSE:</label></td>
                    <td><input class="input" id="password" name="password" type="password" size="25" maxlength="30"></td>
                </tr>
                <tr>
                    <td><label for="passwordCheck">REPITA A PALAVRA PASSE:</label></td>
                    <td><input class="input" id="passwordCheck" name="passwordCheck" type="password" size="25" maxlength="30"></td>
                </tr>
            </table>
        </fieldset>
        <p id="aviso" style="border-radius:1px;">Todos os campos são de preenchimento obrigatório.</p>
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
