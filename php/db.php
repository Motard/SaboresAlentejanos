<?php
	function ligarBD(){
		$user = "paulo";
		$password = "paulopw";
		$db = "sabores_alentejanos";
		$conn = mysql_connect("localhost",$user,$password)
		or die ("Erro de coneção ao servidor");
		mysql_set_charset("utf8",$conn);
		mysql_select_db($db,$conn)
		or die ("Erro de coneção á base de dados");		
	}
?>