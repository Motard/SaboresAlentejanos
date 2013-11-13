<?php
	//echo "CONT ALTERA MOR .PHP <br> <hr>";
	if (session_id() === ""){
		session_name("sabores");
		session_start();	
	}
	if (isset ($_SESSION['compras'])){
		unset ($_SESSION['compras']);	
	};
	if (isset ($_SESSION['contaAlteraPass'])){
		unset ($_SESSION['contaAlteraPass']);	
	};
	if (!isset ($_SESSION['login']) || $_SESSION['login'] == "") {
		$_SESSION['contaAlteraMor'] = "1";
		?> 
        <p>Necessário fazer LOGIN ou CRIAR CONTA</p>
		<input type="button" value="LOGIN" onclick="carrega('login')">
        <input type="button" value="CRIAR CONTA" onclick="carrega('registar')">
		<?php
	}else{
		require_once "db.php";
		$userId = $_SESSION['login'];
		ligarBD("users");		
		$cmd = "SELECT * FROM adresses WHERE userId = '$userId'";
		$recurso = mysql_query($cmd);	
		$numLinhas = mysql_num_rows($recurso);
		if ($numLinhas == 0){
			echo "Esta conta ainda não tem morada criada<br>";
			?> 
				<input class="bt" type="button" value="CRIAR AGORA" onclick="criarMor()">
                <input class="br" type="button" value="VOLTAR" onclick="carrega('index')">	
			<?php	
		}else{
			?> 
			<script>
            	$("#center").load("php/alteraMor.php");
            </script>
			<?php	
		}
	}	
?>