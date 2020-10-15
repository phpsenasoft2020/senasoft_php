<?php 
	require_once('controlador/cpag.php');
?>
<center>
<div>
	<h1>Registro Y Listado De Paginas</h1>
</div>
<hr width="100%">

<?php seleccionar($pagid, $pg); ?>

<br><br>
<div>
	<?php cargar($conp,$nreg,$pg,$bo,$filtro,$arc); ?>
</div></center>