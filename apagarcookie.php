<?php
	if (isset($_COOKIE['cookies'])){
		$user = $_COOKIE['cookies'];
		
		$durCookie= time()-365*24*60*60;
		setcookie("cookies",$user,$durCookie);		
		
	}else {
	echo "sem cookie";	
		
	}



?>