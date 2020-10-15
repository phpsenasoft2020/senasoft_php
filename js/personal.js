function ReCiudad(value){
	//alert ("Si llega acá "+value);
	var parametros = {
		"valor" : value
	};
	$.ajax({
		data:  parametros,
		url:   'selmun.php',
		type:  'post',
		success:  function (response) {
			$("#reloadMun").html(response);
		}
	});
}

function ReTipo(value){
	//alert ("Si llega acá "+value);
	var parametros = {
		"valor" : value
	};
	$.ajax({
		data:  parametros,
		url:   'seltip.php',
		type:  'post',
		success:  function (response) {
			$("#reloadTip").html(response);
		}
	});
}

function solonum(e){
	key=e.keyCode || e.which;
	teclado=String.fromCharCode(key);
	numeros="0123456789";
	var especiales=["8","45"];
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

function ReTipfil(value){
	//alert ("Si llega acá "+value);
	var parametros = {
		"valor" : value
	};
	$.ajax({
		data:  parametros,
		url:   'seltipfil.php',
		type:  'post',
		success:  function (response) {
			$("#reloadTipfil").html(response);
		}
	});
}

function eliminar(){
	var x = confirm('¿Desea eliminar?');
	return x;
}

function restaurar(){
	var x = confirm('¿Desea Restaurar?');
	return x;
}

function ocultar(){
	document.getElementById('m1').style.display = 'none';
	document.getElementById('m2').style.display = 'none';
	document.getElementById('m3').style.display = 'none';
	/*document.getElementById('m4').style.display = 'none';*/
	document.getElementById('m5').style.display = 'none';
	document.getElementById('m6').style.display = 'none';
	document.getElementById('b1').style.display = 'inline-block';
	document.getElementById('b2').style.display = 'none';
}

function mostrar(){
	document.getElementById('m1').style.display = 'inline-block';
	document.getElementById('m2').style.display = 'inline-block';
	document.getElementById('m3').style.display = 'inline-block';
	/*document.getElementById('m4').style.display = 'inline-block';*/
	document.getElementById('m5').style.display = 'inline-block';
	document.getElementById('m6').style.display = 'inline-block';
	document.getElementById('b1').style.display = 'none';
	document.getElementById('b2').style.display = 'inline-block';
}