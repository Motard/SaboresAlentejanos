<?php
		$scriptVarCart="";	
		ligarBD();
		if (!isset ($_COOKIE["cookies"])){
			$recurso = mysql_query ("SELECT * FROM cookies");
			$numLinhas = mysql_num_rows($recurso);
			$user = "USER ".$numLinhas;
			$cmd = "INSERT INTO cookies (cookie) values ('$user')";
			mysql_query($cmd)
			or die ("<br>ERROR UPDATING DB!!!!");
			$durCookie= time()+365*24*60*60;
			setcookie("cookies",$user,$durCookie);
		} else {
			$cookie = $_COOKIE['cookies'];	
			$cmd = "SELECT userId FROM cookies WHERE cookie = '$cookie'";
			$recurso = mysql_query($cmd);
			while ($row = mysql_fetch_array($recurso)){
				$userId = $row['userId'];	
			};	
			if ($userId == NULL || $userId == "0"){
				return;
			}else{
				/*ligarBD();*/
				$cmd = "SELECT id FROM shop_basket WHERE userId = '$userId'";
				$recurso = mysql_query($cmd);
				$numLinhas = mysql_num_rows($recurso);
				$scriptVarCart = '<script> 
				$(document).ready(function(e) {
					$("#artigos").html("'.$numLinhas.'")
				})
				</script>';
			};
		};
?>
