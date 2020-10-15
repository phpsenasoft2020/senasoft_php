<?php 
	require_once('controlador/ckar.php');
?>
<?php
	mosenc($idkar);
	if($idkaract==$idkar)
		insdetkar($idkar, '120'); 
?>
<center><div>
	<?php mosdetkar($idkar,'120',$arc); ?>
</div></center>