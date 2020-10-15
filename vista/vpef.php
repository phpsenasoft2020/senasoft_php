<?php 
	require_once('controlador/cpef.php');
?>
<center>
<div>
	<h1>Registro Y Listado De Perfiles</h1>
</div>
<hr width="100%">

<?php seleccionar($pefid, $pg); ?>

<br><br>
<div>
	<?php cargar($conp,$nreg,$pg,$bo,$filtro,$arc); ?>
</div></center>