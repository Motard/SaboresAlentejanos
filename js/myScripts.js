// JavaScript Document
 
$("#topoCenter").html("");

function carrega(page){
	//var xpto = window.parent.document.getElementById("center");
	$("#center").load(page+".html");
	//xpto.innerHTML = page;
	//xpto.window.location ="registar.html"
	$("#erro").html("")
}

function apagar(id) {
	$.post("php/apagarItem.php",{
		id:id		
	},
	function(dados){
		$("#artigos").html(dados);
	})
	.done (function (data){
		$("#center").load("php/carrinhoCompras.php");	
	})		
};

function apagarFinal(id) {
	$.post("php/apagarItem.php",{
		id:id		
	},
	function(dados){
		$("#artigos").html(dados);
	})
	.done (function (data){
		$("#center").load("php/comprar2.php");	
	})		
};

function alteraQt(cestoComprasId,inputNum){
	var input = document.getElementsByClassName("inputQt");
	var valor = input[inputNum].value;
	var divAlteraQ = document.getElementById(inputNum);
	divAlteraQ.innerHTML = "<div class='btAlteraQuant' id='mais' title='Aumentar'>+</div><div class='btAlteraQuant' id='menos' title='Diminuir'>-</div>";
	var mais = document.getElementById('mais');
	mais.id += inputNum;
	var menos = document.getElementById('menos');
	menos.id += inputNum;
	var btGravar = document.getElementById("btGravar"+inputNum);
	btGravar.innerHTML = " <div style='border:1px solid grey;border-radius:5px;padding:3px;	background-color: #c6a178;'>GRAVAR</div>";
	
	mais.onclick = function () {
		valor++;	
		input[inputNum].value = valor;
	}
	
	menos.onclick = function () {
		if (valor == 1) {
			return	
		}else {
			valor--;	
			input[inputNum].value = valor;
		}
	}
	
	btGravar.onclick = function () {
		$.post("php/alteraQt.php",{
		  id:cestoComprasId,
		  qt:valor
	  	})
	  	.done (function (data){
		  $("#center").load("php/carrinhoCompras.php");	
	  	});	
	}	
};


function alteraQtFinal(cestoComprasId,inputNum){
	var input = document.getElementsByClassName("inputQt");
	var valor = input[inputNum].value;
	if (valor > 0  && valor < 99) {
	  $.post("php/alteraQt.php",{
		  id:cestoComprasId,
		  qt:valor
	  })
	  .done (function (data){
		  $("#center").load("php/comprar2.php");	
	  });
	}else{
		$("#center").load("php/comprar2.php");
	}
};

function comprar(pag) {
	if (pag == 1){
		$("#center").load("php/comprar.php");
	}else if (pag == 2){
		$("#center").load("php/comprar2.php");	
	}else if (pag == 3){
		$("#center").load("php/comprar3.php");	
	}else if (pag == 4){
		$("#center").load("php/fimCompra.php");	
	}
};

function alteraMor() {
	$("#center").load("php/alteraMor.php");
};
 
function criarMor() {
	$("#center").load("php/criarMor.php")	
}

function formPagamento() {
	var valor = ( $('input[name="formPag"]:checked').val());
	if (valor == "" || valor == null) {
		return false;
	}
};