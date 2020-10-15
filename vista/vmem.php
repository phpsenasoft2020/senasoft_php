<?php 
	$pg = "602";
	require_once('controlador/crad.php');
?>
<div class="dtit">
	<h1>Memorandos</h1>
</div>
<hr class="section-divider">
<?php 
	mformm($norad, $pg, "home.php");
?>

<br><br>
<center><div>
	<?php mdatose($conp,$nreg,$pg,$bo,$filtro,$filtro2,$filtro3,$filtro4,$filtro5,$filtro6,$filtro7,$arc); ?>
</div></center>