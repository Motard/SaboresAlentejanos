// JavaScript Document

//var prdt = document.getElementsByClassName("prdt");
var prdt = $(".prdt");
var numPrdts = prdt.length;
var frame;
           

for (i=0 ; i<numPrdts ; i++){
	var li = prdt[i];
	
	li.onclick= function() {
		var v = this.getAttribute("produto");
			//frame = document.getElementById ("center").contentWindow.document.body;
		 	//frame.innerHTML = v;
			frame = document.getElementById("center");
			frame.location = "xpto.php";
		}
	}


function carrega(xpto) {
		
		$("#center").load(xpto+".html");
		
	}

/*function GetUrlValue(VarSearch){
    var SearchString = window.location.search.substring(1);
    var VariableArray = SearchString.split('&');
    for(var i = 0; i < VariableArray.length; i++){
        var KeyValuePair = VariableArray[i].split('=');
        if(KeyValuePair[0] == VarSearch){
            return KeyValuePair[1];
        }
    }
}

alert (GetUrlValue('xx'));*/

//<iframe id="iframeId" name="iframeId">...</iframe>

var xpto = window.location.search.substring(1);
  
alert(xpto);

