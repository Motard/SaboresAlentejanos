<?php
	session_name("sabores");
	session_start();	
	
	echo '<!--';
	var_dump($_SESSION);	
	echo'-->';
	include "php/db.php";
	include "php/cookie.php";
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sabores Alentejanos</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/myJquery.js"></script>
</head>

<body>
	<header>
      <div id="login">
          <?php 
          if (isset($_SESSION['login'])){
              echo "OLÁ ".strtoupper ($_SESSION['nome']);
              ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="logoff" href="logoff" style="text-decoration:none">SAIR!</a> 
              
              <?php
          }else{
              ?>
              <a href="mainRegisto.php">CRIAR UMA CONTA</a><span> OU </span>
              <a href="mainLogin.php">INICIAR SESSÃO</a>
              <?php
          }
          ?>
      </div>
      <div id="conta">
          <ul>
              <li><a href="javascript:;">A MINHA CONTA
                  <ul>
                      <li><a href="alteraPass.php">ALTERAR PASSWORD</a></li>
                      <li><a href="alteraMor.php">ALTERAR MORADA</a></li>
                      <li><a href="contaCompras.php">COMPRAS EFETUADAS</a></li>
                  </ul>
              </li>
          </ul>
      </div>
      <div id="nav-bottom">
          <ul>
              <li style="width:72px;"><a class="nav-bottom" href="sobre.php">SOBRE NÓS </a></li>
              <li style="width:72px"><a class="nav-bottom" href="contactos.php">CONTACTOS </a></li>
              <li style="width:150px"><a class="nav-bottom" href="termos.php">TERMOS E CONDIÇÕES </a></li>
          </ul>
      </div>
      <div id="procura">
          <form id="formBusca" method="post" style="padding-bottom:0px;">
              <input id="busca" type="text" name="busca" size="25">
              <div id="buscaIconBox">
                  <input id="buscaIcon" type="image" src="imagens/busca-icon.png" title="Procurar">
              </div>
          </form>
      </div>
      <div id="cart">
        	<a href="carrinhoCompras.php">
        		<img id="cartLogo" src="imagens/cart.png" title="Ver Cesto de Compras">
           	</a>
            <div id="artigos"></div>
            <?php echo $scriptVarCart;?>
        </div>
    </header>
    <article>
    	<div id="topoLeft" class="content"></div>
        <div id="topoCenter" class="content">
        <?php
			if (isset ($_REQUEST['aviso'])){
				$aviso = $_GET['aviso'];
				switch ($aviso){
					case 1:
						echo "<p id='aviso'>Password ou email introduzidos estão incorrectos.</p>";		
						break;
					case 2:
						echo "<p id='aviso'>Email já existe na nossa base de dados.<br>Criar conta com outro endereço de email.</p>";
						break;
					case 3:
						echo "<p id='aviso'>Necessário fazer login.</p>";
						break;
					case 4:
						echo "<p id='aviso'>Password alterada com sucesso.</p>";
						break;
					case 5:
						echo "<p id='aviso'>Password introduzida esta incorreta.</p>";
						break;
					case 6:
						echo "<p id='aviso'>Conta criada com sucesso.</p>";
						break;
					case 7:
						echo "<p id='aviso'>E-mail indicado não existe na nossa base de dados.</p>";
						break;
					case 8:
						echo "<p id='aviso'>Palavra passe alterada com sucesso e enviada por email para o endereço indicado.</p>";
						break;
					case 9:
						echo "<p id='aviso'>Morada criada com sucesso.</p>";
						break;
					case 10:
						echo "<p id='aviso'>Morada alterada com sucesso.</p>";
						break;
					case 11:
						echo "<p id='aviso'>Carrinho compras vazio.</p>";
						break;
					case 12:
						echo "<p id='aviso'>Obrigado pelo seu contacto. Daremos uma resposta em breve.</p>";
						break;
					case 13:
						echo "<p id='aviso'>Sem registo de compras anteriores.</p>";
						break;
				}
			}
		
        ?>
        </div>
        <div style="clear:both;"></div>