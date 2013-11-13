<?php
	include "_header.php";
	include "_leftBar.php"
?>
	<div id="center" class="content">
        <form action="php/checkLogin.php" id="formLogin"  method="post" name="login" onsubmit="return validarLog()">
        <p>INICIAR SESSÃO</p>
        <fieldset><legend>DADOS DO UTILIZADOR</legend>
            <table>
                <tr>
                    <td style="width:190px;"><label for="user">E-MAIL:</label></td>
                    <td><input class="input" id="user" name="user" type="text" size="25" maxlength="50"></td>
                </tr>
                <tr>
                    <td><label for="password">PALAVRA PASSE:</label></td>
                    <td><input class="input" id="password" name="password" type="password" size="25" maxlength="30"></td>
                </tr>
            </table>
        </fieldset>
        <table style="width:100%">
            <tr style="height:20px;">
                <td style="width:50%"></td>
                <td style="text-align:center"><input id="btSubmeter" class="bt" name="submeter" type="submit" value="Login"></td>
            </tr>
        </table>
        </form>
        <br>
      	<a href="recuperaPass.php" style="color:#473323;font-family:Verdana, Geneva, sans-serif;font-size:12px;">Esqueceu-se da sua palavra passe?</a>
        <br><br><br>
    </div>
<?php
	include "_footer.php";
?>
