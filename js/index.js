// JavaScript Document

var prdt = $(".prdt");
var numPrdts = prdt.length;

for (i=0 ; i<numPrdts ; i++){
	var li = prdt[i];
	
	li.onclick= function() {
			var prdtId = this.getAttribute("produto");
			$("#center").load("php/galeriaPrdts.php?pId="+prdtId);
	}
}

var url = window.location.search.substring(1);

if (url.length != 0) {
	if (url.search("&")== -1) {
		$("#center").load(url+".html");
	}else{
		var urlArr=url.split("&");
		
		if (urlArr[1] == "errLog") {
			$("#center").load(urlArr[0]+".html");
			$("#erro").html("<p>Email ou Password introduzidos estão incorrectos<br>Introduza outra vez.</p>");
		}else if (urlArr[1] == "errRecuperaPass"){
			$("#center").load(urlArr[0]+".html");
			$("#erro").html("<p>Email introduzido esta incorrecto<br>Introduza outra vez.</p>");
		}else if (urlArr[1] == "okRecuperaPass") {
			$("#center").load(urlArr[0]+".html");
			$("#erro").html("<p>Email enviado.</p>");
		}else if (urlArr[1] == "comprar") {
			$("#center").load("php/"+urlArr[0]+".php")	
		}else if(urlArr[1] == "errPass"){
			$("#center").load("php/"+urlArr[0]+".php");
			$("#erro").html("<p>Password introduzida esta errada.</p>");	
		}else if(urlArr[1] == "okPass"){
			$("#erro").html("<p>Password alterada com exito.</p>");	
		}/*else{
			$("#center").load("php/"+urlArr[0]+".php");
		}*/
	}	
};

//******************************************************************************
//***************FUNÇÃO PARA QUANDO SE CARREGA NO CESTO DE COMPRAS**************
//******************************************************************************

var cart = document.getElementById("cartLogo");	

cart.onclick = function () {
	//alert ("carregaste no cart");
	$("#center").load("php/carrinhoCompras.php");	
};

//*********FIM DA FUNÇÃO PARA QUANDO SE CARREGA NO CESTO DE COMPRAS**************

function contaAlteraMor() {
	$("#center").load("php/contaAlteraMor.php");	
}

function contaAlteraPass() {
	$("#center").load("php/contaAlteraPass.php");	
}
function contaCompras() {
	$("#center").load("php/contaCompras.php");		
}
function carrega(page) {
	$("#center").load(page+".html");	
}
	
$("#formBusca").submit (function(event) {
	event.preventDefault();
	var stringProcura = document.getElementById("busca").value;	
	var primeiroChar = stringProcura.charAt(0);
	while ( primeiroChar == " "){
		stringProcura = stringProcura.substring(1);
		primeiroChar = stringProcura.charAt(0);	
	};
	if (primeiroChar.length == 0) {
		return;	
	}
	$("#center").load("php/procura.php?xx="+stringProcura);
})