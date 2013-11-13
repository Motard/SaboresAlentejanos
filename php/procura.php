<?php
	echo "PROCURA .PHP <BR>";
	require_once "db.php";
	
	$procurar = $_GET['xx'];
	ligarBD('produts');
	$cmd = "SELECT * FROM produts WHERE nome LIKE ('%$procurar%')";
	$resultado = mysql_query($cmd);
	while ($row = mysql_fetch_array($resultado)){
		echo $row['nome']."<br>";	
	};
?>