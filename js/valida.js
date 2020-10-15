function solonum(e){
	key=e.keyCode || e.which;
	teclado=String.fromCharCode(key);
	numeros="0123456789";
	especiales="8-37-38-46";
	teclado_especial=false;
	for(var i in especiales){
		if(key==especiales[i]){
			teclado_especial=true;
		}
	}
	if(numeros.indexOf(teclado)==-1 && !teclado_especial ){
		return false;
	}
}

function sololet(f){
	key=f.keyCode || f.which;
	teclado=String.fromCharCode(key);
	letras=" abcdefghijklmnñopqrstuvwxyzáéíóú"+" ABCDEFGHIJKLMNÑOPQRSTUVWXYZÁÉÍÓÚ";
	especiales="8-37-38-46";
	teclado_especial=false;
	for(var u in especiales){
		if(key==especiales[u]){
			teclado_especial=true;break;
		}
	}
	if(letras.indexOf(teclado)==-1 && !teclado_especial ){
		return false;
	}
}

function validadat(){
	p1= document.getElementById("pas1").value;
	p2= document.getElementById("pas2").value;
	if(p1!=p2){
		alert("La contraseña no coincide.");
		return false;
	}
}

function recargarCiudades(value){
	//alert("Si llega acá..."+value);
	var parametros = {
		"valor" : value
	};
	$.ajax({
		data: parametros,
		url: 'selmun.php',
		type: 'post',
		success: function(response) {
			$("#reloadMun").html(response)
		}
	});
}

function recval(value){
	//alert("si llega aca"+value);
	var parametros = {
		"valor" : value
	};
	$.ajax({
		data: parametros,
		url: 'selval.php',
		type:'post',
		success: function(response){
			$("#reloadVal").html(response);
		}
	});
} 