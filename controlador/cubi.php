<?php
require_once('modelo/conexion.php');
require_once('modelo/mubi.php');
require_once("modelo/mpaginacion.php");
$pg = 1010;
$arc = "home.php";
$mubi = new mubi();
$codubi = isset($_POST['codubi']) ? $_POST['codubi']:NULL;
if(!$codubi)
	$codubi = isset($_GET['codubi']) ? $_GET['codubi']:NULL;
$nomubi = isset($_POST['nomubi']) ? $_POST['nomubi']:NULL;
$depubi = isset($_POST['depubi']) ? $_POST['depubi']:NULL;
$filtro = isset($_GET["filtro"]) ? $_GET["filtro"]:NULL;
$est = isset($_GET["est"]) ? $_GET["est"]:NULL;

$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

//Insertar
//echo $codubi."-".$nomubi."-".$depubi."<br>";
if($opera=="insertar"){
	if ($codubi && $nomubi){
		$result=$mubi->insubi($codubi, $nomubi, $depubi);
		$codubi = "";
	}else{
		echo "<script>alert('FAVOR LLENAR TODOS LOS CAMPOS')</script>";
	}
	$opera = "";
}
//Actualizar
if($opera=="actualizar"){
	if ($codubi && $nomubi){
		$result=$mubi->updubi($codubi,$nomubi, $depubi);
		$codubi = "";
	}else{
		echo "<script>alert('HAY CAMPOS VACIOS')</script>";
	}
	$opera = "";
}

//Eliminar
if($opera=="eliminar"){
	if ($codubi){
		$result=$mubi->eliubi($codubi);
		$codubi = "";
	}else{
		echo "<script>alert('ERROR AL ELIMINAR')</script>";
	}
	$opera = "";
}
//paginacion
$bo="";
$nreg = 10;
$pa = new mpaginacion();
$preg = $pa->mpagin($nreg);
$conp = $mubi->sqlcount($filtro);

	//tabla para el CRUD
function cargar($conp,$nreg,$pg,$bo,$filtro,$arc){
	$mubi=new mubi();
	$pa = new mpaginacion($nreg);
	$txt = '<div align="center" style="padding-bottom: 20px;" >';
		$txt .= '<table>';
			$txt .= '<tr>';
				$txt .= '<td>';
				$txt .= '<form id="formfil" name="frmfil" method="GET" action="'.$arc.'" class="txtbold">';
				$txt .= '<input name="pg" type="hidden" value="'.$pg.'" />';
				$txt .= '<input class="form-control" type="text" name="filtro" value="'.$filtro.'" placeholder="Ubicaci&oacute;n" onChange="this.form.submit();">';
				$txt .= '</form>';
				$txt .= '</td>';
				$txt .= '<td align="right" style="padding-left: 10px;">';
				$bo = "<input type='hidden' name='filtro' value='".$filtro."' />";
				$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
				$result = $mubi->selubi($filtro, $pa->rvalini(), $pa->rvalfin());
				// var_dump($result);
				$txt .= '</td>';
			$txt .= '</tr>';
		$txt .= '</table>';
	$txt .= '</div>';
	
	if ($result){

		$txt .= "<center><table class='table table-hover'>
		<tr>
		<th class='tablefor'>C&oacute;digo</th>
		<th class='tablefor'>Nombre</th>
		<th class='tablefor'></th>
		<th class='tablefor'></th>
		</tr>";
		foreach ($result as $f){
		$txt .= "<tr>";
		$txt .= "<td class='active' align='center'>".$f['codubi']."</td>";
		$txt .= "<td class='active'>".$f['ciu']." - ".$f['dep']."</td>";
		
		$txt .= "<td class='warning' align='center'>";
		$txt .= "<a href='home.php?codubi=".$f['codubi']."&pg=".$pg."'><img src='image/new.png'
			title='Actualizar'></a>";

			$txt .= "</td><td class='warning' align='center'>";

			$txt .= "<a href='home.php?codubi=".$f['codubi']."&opera=eliminar&pg=".$pg."' onclick='return "."eliminar(".'"¿Desea eliminar la ubicacion seleccionada?"'.");'><img src='image/trash.png'
			title='eliminar'></a></td>";
			$txt .= "</tr>";
		}
		$txt .= "</table></center>";
	}else{
		$txt .= "<center><h5>No existen resultados</h5></center><br><br>";
	}
	echo $txt;
}

function seleccionar($codubi, $pg){
	$mubi=new mubi();
	if($codubi){
		$result=$mubi->selubi1($codubi);
	}
	$dtp = $mubi->seldep();
	//$dttipd = $mubi->seltipd();
	$txt = '<div class="container">';
	$txt .= '<form  action="home.php?pg='.$pg.'" method="POST" id="form">';
		$txt .= '<div class="col-md-12 col">';
			$txt .= '<center>';
				$txt .= '<h1>Ubicacion</h1>';
			$txt .= '</center>';
			$txt .= '<hr>';
		$txt .= '</div>';
		$txt .= '<script src="js/eliminar.js"></script>';
		$txt .= '<label>C&oacute;digo</label>';
		$txt .= '<input  min="0" min="999" type="number"  maxlength="50" name="codubi"  value="';
		if($codubi) $txt .= $result[0]['codubi'];
			$txt .= '"';
		if($codubi) $txt .= ' readonly';
		$txt .= ' required class="form-control">';

		$txt .= '<label>Nombre</label>';
		$txt .= '<input type="text" maxlength="50" name="nomubi" value="';
		if($codubi){ $txt .= $result[0]['nomubi']; }
		$txt .= '" required class="form-control">';

		$txt .= '<label>Depende</label>';
		$txt .='<select name="depubi" class="form-control">';
		if($dtp){
			foreach ($dtp as $dtd) {
				$txt .= '<option value="'.$dtd["codubi"].'"';
				if($codubi && $result[0]['depubi']==$dtd["codubi"]){
					$txt .= ' selected ';	
				}
				$txt .= '>'.$dtd["ciu"].'</option>';
			}
		}
		$txt .='</select>';

		$txt .= '<input type="hidden" name="opera" value="';
		if($codubi){ $txt .= "actualizar"; } else { $txt .= "insertar"; }
		$txt .= '"><br>';
		$txt .= '<center>';
			$txt .= '<button type="submit" class="btn btn-outline-primary">';
			if($codubi){ $txt .= "Actualizar"; } else { $txt .= "Registrar"; }
			$txt .= '</button>';
			$txt .= '&nbsp;&nbsp;&nbsp;';
			$txt .= '<input type="reset" class="btn btn-outline-primary" value="';
			if($codubi){ $txt .= "Cancelar"; } else { $txt .= "Limpiar"; }
			$txt .= '"';
			if($codubi) $txt .= " onclick='window.history.back();' ";
			$txt .= ' />';
		$txt .= '</center>';
		$txt .= '<br>';

	$txt.='</form>';
	$txt .= '<BR>';
					$txt .= '<BR>';
					$txt .= '<BR>';
	$txt.='</div>';
	echo $txt;
}
?>