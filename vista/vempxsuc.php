<?php
	//1.2. Incluimos nuestro controlador (cusu.php)
include ("controlador/cempxsuc.php");

$pefedi = isset($_SESSION["pefedi"]) ? $_SESSION["pefedi"]:NULL;
$pefeli = isset($_SESSION["pefeli"]) ? $_SESSION["pefeli"]:NULL;

?>
<center>
	<h1>Asignacion De Empleados A Sucursales</h1>
<hr width="100%"><!--Linea inferior-->
<!--Lamamdo nuestra funcion de la vista que tiene el form-->
<?php
	form_registro($idsuc);
?>
<br><br><!--Salto de Linea-->
<?php
	form_mostrar($conp,$nreg,$pg,$bo,$filtro,$arc,$pefedi,$pefeli);
?>
</center>