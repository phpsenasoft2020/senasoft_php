 <?php 
	require_once('controlador/ckar.php');
?>
<center>
<h1>KARDEX E HISTORICO</h1>
<hr width="100%">
<?php 
	seleccionar($idkar, $pg);
?>
<?php 
	cargar($conp,$nreg,$pg,$bo,$filtro,$arc);  
?>
</center>