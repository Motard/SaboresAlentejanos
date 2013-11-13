<?php
	function ligarBD(){
		$user = "saboresalentejo";
		$password = "4n3ECRtnjxpc";
		$db = "saboresalentejo";
		$conn = mysql_connect("mysql51-99.perso",$user,$password)
		or die ("Erro de conecao ao servidor - PROBLEMAS");
		mysql_set_charset("utf8",$conn);
		mysql_select_db($db,$conn)
		or die ("Erro de coneção á base de dados");		
	}
?>