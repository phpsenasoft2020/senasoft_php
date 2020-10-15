<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Siigo | Inicio De Sesión</title>
  	<link rel="shortcut icon" href="image/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/sb-admin-2.css">
	<script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">
  	<link rel="stylesheet" type="text/css" href="css/background.css">
  	<link rel="stylesheet" type="text/css" href="css/scroll.css">
  	<link rel="stylesheet" type="text/css" href="css/icon.css">
  	<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
  	<link rel="stylesheet" type="text/css" href="css/carini.css">
  	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body class="bg-gradient-primary">
	<div id=contenedor_carga></div>
	<?php
	include_once('vista/vini.php');
	?>
	<script>
		window.onload = function(){
			var contenedor = document.getElementById('contenedor_carga');
			contenedor.style.visibility = 'hidden';
			contenedor.style.opacity = '0';
		}
	</script>
</body>
</html>