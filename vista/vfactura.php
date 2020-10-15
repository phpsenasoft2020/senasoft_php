<?php
	//1.2. Incluimos nuestro controlador (cusu.php)
include ("controlador/cfactura.php");

$pefedi = isset($_SESSION["pefedi"]) ? $_SESSION["pefedi"]:NULL;
$pefeli = isset($_SESSION["pefeli"]) ? $_SESSION["pefeli"]:NULL;

?>
<center>
	<h1>Listado De Factura</h1>
<hr width="100%"><!--Linea inferior-->
<br><br><!--Salto de Linea-->
<?php
	form_mostrar($conp,$nreg,$pg,$bo,$filtro,$arc,$pefedi,$pefeli);
?>
</center>