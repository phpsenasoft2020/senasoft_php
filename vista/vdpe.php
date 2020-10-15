<?php

	//1.2. Incluimos nuestro controlador (cusu.php)
	include ("controlador/cempresa.php");
	$pefedi = isset($_SESSION["pefedi"]) ? $_SESSION["pefedi"]:NULL;
	$pefeli = isset($_SESSION["pefeli"]) ? $_SESSION["pefeli"]:NULL;
	?>
	<center>
	<h1>Empresa</h1>
	<hr width="100%"><!--Linea inferior-->
	<!--Lamamdo nuestra funcion de la vista que tiene el form-->
	<?php

		form_registro($emp_nit);
	?>
	</center>
