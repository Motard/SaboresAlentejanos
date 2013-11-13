<?php
	include "db.php";
	ligarBD();
	$ultima = $_POST['id'];
	do {
		$cmd = "SELECT id FROM produts";
		$recurso = mysql_query($cmd);
		$numLinhas = mysql_num_rows($recurso);
		$produtoId = rand(1,$numLinhas);
		while ($ultima == $produtoId){
			$produtoId = rand(1,$numLinhas);
		}
		$cmd = "SELECT foto,descricaoLng FROM produts WHERE id = '$produtoId'";
		$recurso = mysql_query($cmd);
		$numLinhas2 = mysql_num_rows($recurso);
	}while ($numLinhas2 == 0);
	$row = mysql_fetch_array($recurso);
	$foto = $row['foto'];
	$desc = $row['descricaoLng'];
	$imagem = '<a href="produto.php?produto='.$produtoId.'"><img class="imgPrdt" src="imagens/produtos/'.$foto.'"></a>';
	$descricao = '<p class="descPrd">'.$desc.'</p>';
	echo json_encode(array("imagem"=>$imagem,"id"=>$produtoId,"desc"=>$descricao));
?>

