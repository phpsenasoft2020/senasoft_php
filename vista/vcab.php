<?php
	require_once('modelo/conexion.php');
	require_once('modelo/mconf.php'); 
	$obj = new mconf();
	$dtconf = $obj->selconf();
	cabezote($hoy);
//Esto es lo que nos imprimira la cabecera
function cabezote($hoy){
	date_default_timezone_set('America/Bogota');
	$dia = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
	$mes = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
	$fecha = $dia[date("w")].", ".date("d")." de ".$mes[date("n")-1]." ".date("Y");
	$txt ="";
	$txt .="<div id='Header'>";
		$txt .= $fecha;
		//$txt .= $hoy;
	$txt .="</div>";
	echo $txt;
}

?>
