<?php
	$mail = $_POST["mail"];
	$mail = mysql_real_escape_string($mail);
	include "db.php";
	ligarBD();
	$cmd = "SELECT nome,apelido,time FROM users WHERE mail='$mail'";
	$recurso = mysql_query($cmd);
	$numLinhas = mysql_num_rows($recurso);
	if ($numLinhas == 0){
	header("location:../recuperaPass?aviso=7");
		/*?>
		<script>
			window.location = "../index.php?recuperaPass&errRecuperaPass";
		</script>
        <?php*/
	}else{
		$alfanum = "a b c d e f g h i j k l m n o p q r s t u v w x y z ";
		$alfanum .= "A B C D E F G H I J K L M N O P Q R S T U V W X Y Z ";
		$alfanum .= "0 1 2 3 4 5 6 7 8 9";
		$password = "";
		$alfanumArr = explode(" ",$alfanum);
		for ($i=0; $i<10; $i++){
			$index = rand(0,61);
			$password .= $alfanumArr[$index];	
		}
		while ($row = mysql_fetch_array($recurso)){
			$nome = $row["nome"];
			$apelido = $row["apelido"];
			$time = $row["time"];	
		}
		$passwordHash = crypt ($password,$time);
		$cmd ="UPDATE users SET password='$passwordHash' WHERE mail='$mail'";
		mysql_query($cmd);
		$assunto = "Sabores Alentejanos - Nova password";
		$body = <<<XPTO
		Exmo.(a) Senhor(a) $nome $apelido<br>
		<br><br>
		Junto enviamos novo codigo de acesso. <br><br>
		Password: $password <br><br><br>
		Continuação de boas compras. <br>
		<br> <br>
		Paulo Martins <br>
		Sabores Alentejanos
XPTO;
		$mailde = "pmotard@sapo.pt";
		$headers = "From: $mailde\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8 . \r\n";

		mail($mail, $assunto, $body, $headers);
		header("location:../mainLogin.php?aviso=8");
		/*?>
		<script>
			window.location = "../index.php?login&okRecuperaPass";
		</script>
        <?php*/
	}
?>