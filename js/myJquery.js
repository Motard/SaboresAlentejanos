// JavaScript Document

$(document).ready(function(e) {
	//*-*-*-*-*-*		FUNÇÃO DROP DOWN MENU CONTA		-*-*-*-*-*-*-*-*-*-	
	$('li').hover(function (){
		$(this).find('ul').stop().fadeToggle(500);	
	})
  	//*-*-*-*-*-*		FUNÇÃO ADD CESTO COMPRAS		-*-*-*-*-*-*-*-*-*-	
 	$('#adicionarPrdt').click(function() {
    	var prdtId = $('#adicionarPrdt').attr('produto');
		var quant = $('#nPrdts').val();
		$.post('php/addCarrinhoCompras.php',{
		produto:prdtId,
		quantidade:quant	
		},
		function(data){
			window.location.href = "carrinhoCompras.php";
		}) 	 	  
    });
	//*-*-*-*-*-*-*-*		FUNÇÃO AMPLIA PRODUTO		-*-*-*-*-*-*-*-*-*-
	$('#fotoPrdt').mouseenter(function(){
		$('#imgPrdt').css('height','auto');
		$('#fotoPrdt').css('cursor','move');
		$('#zoom').css('display','none');
	})
		
	$('#fotoPrdt').mouseleave(function(){
		$('#imgPrdt').css({'height':'100%','margin':'0 auto'});
		$('#zoom').css('display','inline');	
	})
	
	$('#fotoPrdt').mousemove(function(e){
		var x = e.pageX-this.offsetLeft;
		var y = e.pageY-this.offsetTop;
		var w = $('#imgPrdt').width();
		var h = $('#imgPrdt').height();
		var margem = (h - w)/2;
		var mTop = y;
		var mLeft = x-margem;
		$('#imgPrdt').css({'margin-top':-mTop,'margin-left':-mLeft});
	})
 
	//*-*-*-*-*			FUNÇÃO PARA PROCURAR ITENS			-*-*-*-*-*-*-*-
	$("#formBusca").submit (function(event) {
		event.preventDefault();
		var stringProcura = $("#busca").val();	
		var primeiroChar = stringProcura.charAt(0);
		while ( primeiroChar == " "){
			stringProcura = stringProcura.substring(1);
			primeiroChar = stringProcura.charAt(0);	
		};
		if (primeiroChar.length == 0) {
			return;	
		}
		window.location.href = "procura.php?produto="+stringProcura;
		
	})
	
	//*-*-*-*-*			FUNÇÃO PARA MUDAR COR DA SETA		-*-*-*-*-*-*-*-
	$("#btSetaDir").mouseover(function(){
		$("#setaDir").attr("src","imagens/seta_dir_black_icon.png");	
	})
	
	$("#btSetaDir").mouseleave(function(){
		$("#setaDir").attr("src","imagens/seta_dir_white_icon.png");	
	})
	
	$("#btSetaEsq").mouseover(function(){
		$("#setaEsq").attr("src","imagens/seta_esq_black_icon.png");	
	})
	
	$("#btSetaEsq").mouseleave(function(){
		$("#setaEsq").attr("src","imagens/seta_esq_white_icon.png");	
	})
		
  	//*-*-*--*-*-*-*		FIM DO DOCUMENT READY		-*-*-*-*-*-*-*-*-*- 
	//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*  
});

	//*-*-*--*-*-*-*		FUNÇÃO VALIDAR LOGIN		-*-*-*-*-*-*-*-*-*-
	//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-* 
function validarLog() {
    
	var mail = $('#user').val();
	if (validaEmail(mail)) {
		$("#user").css("border","1px solid grey");
	}
	else {
		aviso("Por favor introduza um endereço de e-mail válido.");
		$("#user").css("border","1px solid red");
		return false;
	}
	
	var password = $('#password').val();
	if ($.trim(password).length == 0){
		aviso("Por favor introduza a sua palavra passe.");
		$("#password").css("border","1px solid red");
		$("#password").focus();
		return false;
	}else if ($.trim(password).length <6){
		aviso("A palavra passe tem de ter no minimo 6 caracteres.");
		$("#password").css("border","1px solid red");
		$("#password").val("");
		$("#password").focus();
		return false;	
	}else{
		$("#password").css("border","1px solid grey");	
	}
};
	//*-*-*--*-*-*-*		FUNÇÃO VALIDAR REGISTO		-*-*-*-*-*-*-*-*-*-
	//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-* 
function validarReg(){
	
	var nome=$("#nome").val();	
	if ($.trim(nome).length == 0){
		aviso("Por favor introduza o seu nome.");
		$("#nome").css("border","1px solid red");
		$("#nome").focus();
		return false;	
	}else{
		$("#nome").css("border","1px solid grey");	
	}	
	
	var apelido=$("#apelido").val();
	if ($.trim(apelido).length == 0){
		aviso("Por favor introduza o seu apelido.");
		$("#apelido").css("border","1px solid red");
		$("#apelido").focus();
		return false;	
	}else{
		$("#apelido").css("border","1px solid grey");	
	}
	
	var mail = $('#mail').val();
	if (validaEmail(mail)) {
		$("#mail").css("border","1px solid grey");
	}
	else {
		aviso("Por favor introduza um endereço de e-mail válido.");
		$("#mail").css("border","1px solid red");
		return false;
	}
	
	var password = $('#password').val();
	if ($.trim(password).length == 0){
		aviso("Por favor introduza a sua palavra passe.");
		$("#password").css("border","1px solid red");
		$("#password").focus();
		return false;
	}else if ($.trim(password).length <6){
		aviso("A palavra passe tem de ter no minimo 6 caracteres.");
		$("#password").css("border","1px solid red");
		$("#password").val("");
		$("#password").focus();
		return false;	
	}else{
		$("#password").css("border","1px solid grey");	
	}
	
	var passwordCheck = $("#passwordCheck").val();
	if ($.trim(passwordCheck).length == 0){
		aviso("Por favor re-introduza a sua palavra passe.");
		$("#passwordCheck").css("border","1px solid red");
		$("#passwordCheck").focus();
		return false;
	}else if (password != passwordCheck){
		aviso("Palavras passe diferentes.Por favor introduza outra vez.");
		$("#password").css("border","1px solid red");
		$("#password").val("");
		$("#passwordCheck").val("");
		$("#passwordCheck").css("border","1px solid grey");	
		$("#password").focus();
		return false;
	}else{
		$("#passwordCheck").css("border","1px solid grey");	
	}	
}
	//*-*-*--*		FUNÇÃO VALIDAR ALTERA PASSWORD		*-*-*-*-*-*-*-*-*-*
	//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-* 
function validarPass(){
	var password = $('#password').val();
	if ($.trim(password).length == 0){
		aviso("Por favor introduza a sua palavra passe.");
		$("#password").css("border","1px solid red");
		$("#password").focus();
		return false;
	}else if ($.trim(password).length <6){
		aviso("A palavra passe tem de ter no minimo 6 caracteres.");
		$("#password").css("border","1px solid red");
		$("#password").val("");
		$("#password").focus();
		return false;	
	}else{
		$("#password").css("border","1px solid grey");	
	}
	var novaPassword = $('#novaPassword').val();
	if ($.trim(novaPassword).length == 0){
		aviso("Por favor introduza a sua nova palavra passe.");
		$("#novaPassword").css("border","1px solid red");
		$("#novaPassword").focus();
		return false;
	}else if ($.trim(novaPassword).length <6){
		aviso("A nova palavra passe tem de ter no minimo 6 caracteres.");
		$("#novaPassword").css("border","1px solid red");
		$("#novaPassword").val("");
		$("#novaPassword").focus();
		return false;	
	}else{
		$("#password").css("border","1px solid grey");	
	}
	var novaPasswordCheck = $("#novaPasswordCheck").val();
	if ($.trim(novaPasswordCheck).length == 0){
		aviso("Por favor re-introduza a sua nova palavra passe.");
		$("#novaPasswordCheck").css("border","1px solid red");
		$("#novaPasswordCheck").focus();
		return false;
	}else if (novaPassword != novaPasswordCheck){
		aviso("Palavras passe diferentes.Por favor introduza outra vez.");
		$("#novaPassword").css("border","1px solid red");
		$("#novaPassword").val("");
		$("#novaPasswordCheck").val("");
		$("#novaPasswordCheck").css("border","1px solid grey");	
		$("#novaPassword").focus();
		return false;
	}else{
		$("#novaPasswordCheck").css("border","1px solid grey");	
	}		
	
}
	//*-*-*--*		FUNÇÃO VALIDAR PEDIDO CONTACTO		*-*-*-*-*-*-*-*-*-*
	//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-* 
function validarPedContact(){
	var nome=$("#nome").val();	
	if ($.trim(nome).length == 0){
		aviso("Por favor introduza o seu nome.");
		$("#nome").css("border","1px solid red");
		$("#nome").focus();
		return false;	
	}else{
		$("#nome").css("border","1px solid grey");	
	}
	var mail = $('#mail').val();
	if (validaEmail(mail)) {
		$("#mail").css("border","1px solid grey");
	}
	else {
		aviso("Por favor introduza um endereço de e-mail válido.");
		$("#mail").css("border","1px solid red");
		return false;
	}
	var mensagem = $("#mensagem").val();
	if ($.trim(mensagem).length == 0){
		aviso("Por favor introduza a sua mensagem.");
		$("#mensagem").css("border","1px solid red");
		$("#mensagem").focus();
		return false;	
	}else{
		$("#mensagem").css("border","1px solid grey");		
	}
}	
	//*-*-*--*		FUNÇÃO VALIDAR RECUPERA PASSWORD	*-*-*-*-*-*-*-*-*-*
	//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-* 
function validarRecuperaPass(){
	var mail = $('#mail').val();
	if (validaEmail(mail)) {
		$("#mail").css("border","1px solid grey");
	}
	else {
		aviso("Por favor introduza um endereço de e-mail válido.");
		$("#mail").css("border","1px solid red");
		return false;
	}
}
	//*-*-*--*-*-*-*		FUNÇÃO VALIDAR MORADA		-*-*-*-*-*-*-*-*-*-
	//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-* 
function validarMor(){
	var rua = $("#rua").val();
	if ($.trim(rua).length == 0){
		aviso("Por favor introduza a sua rua.");
		$("#rua").css("border","1px solid red");
		$("#rua").focus();
		return false;	
	}else{
		$("#rua").css("border","1px solid grey");		
	}
	var localidade = $("#localidade").val();
	if ($.trim(localidade).length == 0){
		aviso("Por favor introduza a sua localidade.");
		$("#localidade").css("border","1px solid red");
		$("#localidade").focus();
		return false;	
	}else{
		$("#localidade").css("border","1px solid grey");		
	}
	var cp = $("#cp").val();
	if ($.trim(cp).length == 0){
		aviso("Por favor introduza o seu código postal e cidade.");
		$("#cp").css("border","1px solid red");
		$("#cp").focus();
		return false;	
	}else{
		$("#cp").css("border","1px solid grey");		
	}
	var pais = $("#pais").val();
	if (pais == 0){
		aviso("Por favor escolha o seu pais.");
		$("#pais").css("border","1px solid red");
		$("#pais").focus();
		return false;	
	}else{
		$("#pais").css("border","1px solid grey");		
	}
	var telefone = $("#telefone").val();
	if ($.trim(telefone).length == 0){
		aviso("Por favor introduza o seu telefone.");
		$("#telefone").css("border","1px solid red");
		$("#telefone").focus();
		return false;	
	}else{
		$("#telefone").css("border","1px solid grey");		
	}								
}	
	
	//*-*-*-*-*			FUNÇÃO AVISO EM CASO DE ERRO		-*-*-*-*-*-*-*-
	//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-* 
function aviso(msg){
	$("#topoCenter").html('<p id="aviso">' + msg + '</p>');
	//$("#aviso").css({"background-color":"#302117","padding-top":"3px","padding-bottom":"3px"});	
}
	//*-*-*--*-*-*-*-*			FUNÇÃO VALIDAR MAIL		-*-*-*-*-*-*-*-*-*-
	//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*  
function validaEmail(mail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(mail)) {
        return true;
    }
    else {
        return false;
    }
}
	//*-*-*			FUNÇÃO APAGAR ITEM CARRINHO COMPRAS		-*-*-*-*-*-*-*-
	//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
function apagar(id) {
	$.post("php/apagarItem.php",{
		id:id		
	})
	.done (function (data){
		window.location.href = "carrinhoCompras.php";	
	})		
};
	//*-*-*-*-*-*-*		FUNÇÃO DEFINE QUANTIDADE DO PRODUTO		-*-*-*-*-*-
	//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
function quantidade(){
	var valor = $('#nPrdts').val();
	$('#alteraQuan').html("<div class='btAlteraQuant' id='mais' title='Aumentar'>+</div><div class='btAlteraQuant' id='menos' title='Diminuir'>-</div>");
	
	$(mais).click(function(){
		if (valor < 99){
			valor++;
			$('#nPrdts').val(valor);
		}else{
			return;	
		}
	}) 
	
	$(menos).click(function(){
		if (valor > 1){
			valor--;
			$('#nPrdts').val(valor);
		}else{
			return;	
		}
	}) 
}
	//*-*-*		FUNÇÃO ALTERA QUANTIDADE NO CARRINHO COMPRAS		-*-*-*-
	//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
function alteraQt(cestoComprasId,inputNum){
	var input = $('.inputQt');
	var valor = $(input[inputNum]).val();
	var divAlteraQ = $('#'+inputNum);
	divAlteraQ.html("<div class='btAlteraQuant' id='mais' title='Aumentar'>+</div><div class='btAlteraQuant' id='menos' title='Diminuir'>-</div>");
	var mais = $('#mais').attr('id','mais' + inputNum);
	var menos = $('#menos').attr('id','menos' + inputNum);
	var btGravar = $("#btGravar" + inputNum);
	btGravar.html(" <div><img src='imagens/update-icon.png' width='25' height='25' title='Actualizar quantidade'> </div>");

	$(mais).click(function(){
		if (valor < 99){
			valor++;
			$(input[inputNum]).val(valor);	
		}else{
			return;
		}
	}) 
	
	$(menos).click(function(){
		if (valor > 1){
			valor--;
			$(input[inputNum]).val(valor);
		}else{
			return;	
		}
	}) 
	
	$(btGravar).click(function(){
		$.post("php/alteraQt.php",{
		  id:cestoComprasId,
		  qt:valor
	  	})
	  	.done (function (data){
		  window.location.href = "carrinhoCompras.php";	
	  	});		
	})
}
	//*-*-*-*-*-*-*		FUNÇÃO MUDA IMAGENS NO BANNER		-*-*-*-*-*-*-*-
	//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
function imagemRandom(){
	var produtoId = 0;
	$.post("php/imagemRandom.php",{
		id:	produtoId
		},
		function(data){
			$('#produto').html(data.imagem);
			$('#descricao').html(data.desc);
			$('.imgPrdt').css("display","none");
			$('.descPrd').css("display","none");
			$('.imgPrdt').fadeIn(800);
			$('.descPrd').fadeIn(800);
			setTimeout(function(){
				$('.imgPrdt').fadeOut(600);
				$('.descPrd').fadeOut(600);
			},8600);
			produtoId = (data.id);		
		},"json");
	setInterval(function(){
		$.post("php/imagemRandom.php",{
		id:	produtoId
		},
		function(data){
			$('#produto').html(data.imagem);
			$('#descricao').html(data.desc);
			$('.imgPrdt').css("display","none");
			$('.descPrd').css("display","none");
			$('.imgPrdt').fadeIn(800);
			$('.descPrd').fadeIn(800);
			setTimeout(function(){
				$('.imgPrdt').fadeOut(600);
				$('.descPrd').fadeOut(600);
			},8600);
			produtoId = (data.id);		
		},"json");
	},10000);
}
	//*-*-*-*-*-		FUNÇÃO ACTUALIZA CUSTO/PAIS ENTREGA		-*-*-*-*-*-
	//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
function actualizaEntrega() {
	var pais = ($('#paisEntrega').val());
	$.post('php/actualizaCusto.php',{
	paisId:pais	
	})
	.done (function (data){
		window.location.href = "carrinhoCompras.php";	
	})	
}
	//*-*-*-*-*-*-*-*		FUNÇÃO VALIDAR FORMA PAGAMENTO		-*-*-*-*-*-
	//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*

function formPagamento(){
	
	var selectedVal = 0;
	var selected = $("input[type='radio'][name='formPag']:checked");
	if(selected.length > 0){
		selectedVal = selected.val();
	}
	if (selectedVal == 0){
	aviso("Por favor escolha uma forma de pagamento.");
	return false;	
	}
}

	//*-*-*		FUNÇÃO ALTERA QUANTIDADE NO COMPRAR3.PHP		-*-*-*-*-*-
	//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
	
function alteraQtFinal(cestoComprasId,quantidade,inputNum){
	
	$('#t'+ inputNum).html('<div class="quantFinal"><div class="alteraQuanFinal" id="' + inputNum +'"></div><input id="input'+ inputNum +'" class="inputQ" size="1" maxlength="2" readonly value=' + quantidade +'><div class="gravarAlteraQuanFinal" id="btGravar' + inputNum +'"></div></div>');
	var divAlteraQ = $('#'+inputNum);
	divAlteraQ.html("<div class='btAlteraQuantFinal' id='mais' title='Aumentar'>+</div><div class='btAlteraQuantFinal' id='menos' title='Diminuir'>-</div>");
	var btGravar = $("#btGravar" + inputNum);
	btGravar.html(" <div><img src='imagens/update-icon.png' width='25' height='25' title='Actualizar quantidade'> </div>");
	var mais = $('#mais').attr('id','mais' + inputNum);
	var menos = $('#menos').attr('id','menos' + inputNum);
	var valor = $('#input' + inputNum).val();

	$(mais).click(function(){
		if (valor < 99){
			valor++;
			$('#input' + inputNum).val(valor);	
		}else{
			return;
		}
	}) 
	
	$(menos).click(function(){
		if (valor > 1){
			valor--;
			$('#input' + inputNum).val(valor);
		}else{
			return;	
		}
	}) 
	
	$(btGravar).click(function(){
		$.post("php/alteraQt.php?recalcular",{
		  id:cestoComprasId,
		  qt:valor
	  	})
	  	.done (function (data){
		  window.location.href = "comprar3.php";	
	  	});		
	})
}

	//*-*-*			FUNÇÃO APAGAR ITEM COMPRAR3.PHP			-*-*-*-*-*-*-*-
	//*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
function apagarFinal(id) {
	$.post("php/apagarItem.php?recalcular",{
		id:id		
	})
	.done (function (data){
		window.location.href = "comprar3.php";	
	})		
};

	