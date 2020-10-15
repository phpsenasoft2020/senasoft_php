<?php
	require_once('modelo/conexion.php');
	require_once('modelo/mpef.php');
	require_once("modelo/mpaginacion.php");

	$pg=8;
	$arc = "home.php";
	$mtac = new mpef();
	$pefid = isset($_POST['pefid']) ? $_POST['pefid']:NULL;
	if(!$pefid)
		$pefid = isset($_GET['pefid']) ? $_GET['pefid']:NULL;
	$pefnom = isset($_POST['pefnom']) ? $_POST['pefnom']:NULL;
	$pefbus = isset($_POST['pefbus']) ? $_POST['pefbus']:NULL;
	$pefdes = isset($_POST['pefdes']) ? $_POST['pefdes']:NULL;
	$pefedi = isset($_POST['pefedi']) ? $_POST['pefedi']:NULL;
	$pefeli = isset($_POST['pefeli']) ? $_POST['pefeli']:NULL;

	$pbu = isset($_GET['pbu']) ? $_GET['pbu']:NULL;
	$pde = isset($_GET['pde']) ? $_GET['pde']:NULL;
	$ped = isset($_GET['ped']) ? $_GET['ped']:NULL;
	$pel = isset($_GET['pel']) ? $_GET['pel']:NULL;

	$pefcan = isset($_POST['pefcan']) ? $_POST['pefcan']:NULL;

	$filtro = isset($_GET["filtro"]) ? $_GET["filtro"]:NULL;

	$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
	if(!$opera)
		$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

	if($pefbus) $pefbus=1; else $pefbus=0;
	if($pefdes) $pefdes=1; else $pefdes=0;
	if($pefedi) $pefedi=1; else $pefedi=0;
	if($pefeli) $pefeli=1; else $pefeli=0;
	//echo $pefnom."-".$pefbus."-".$pefdes."-".$pefedi."-".$pefeli;

//Actualizar campos especiales
if ($pefid && $pbu){
	$result=$mtac->updpag("pefbus", $pbu, $pefid);
	$pefid = "";
}
if ($pefid && $pde){
	$result=$mtac->updpag("pefdes", $pde, $pefid);
	$pefid = "";
}
if ($pefid && $ped){
	$result=$mtac->updpag("pefedi", $ped, $pefid);
	$pefid = "";
}
if($pefid && $pel){
	$result=$mtac->updpag("pefeli", $pel, $pefid);
	$pefid = "";
} 

//Insertar
	if($opera=="insertar"){
		if ($pefnom){

			$result=$mtac->inspag($pefnom,$pefbus,$pefdes,$pefedi,$pefeli);
			$pefid = "";
		}
		else{
			echo "<script>alert('FAVOR LLENAR TODOS LOS CAMPOS')</script>";
		}
		$opera = "";
	}

//Agregar
	if($opera=="agregar"){
		if ($pefid AND $pefcan){
			$result=$mtac->elipg($pefid);
			for ($i=0; $i < $pefcan; $i++) { 
				$chk = isset($_POST['chk'.$i]) ? $_POST['chk'.$i]:NULL;
				if($chk)
					$result=$mtac->insagre($chk, $pefid);
			}
				
				
			$pefid = "";
		}
		else{
			echo "<script>alert('FAVOR LLENAR TODOS LOS CAMPOS')</script>";
		}
		$opera = "";
	}

//Actualizar
	if($opera=="actualizar"){
		if ($pefid && $pefnom){
			$result=$mtac->updpag("pefnom", $pefnom, $pefid);
			$result=$mtac->updpag("pefbus", $pefbus, $pefid);
			$result=$mtac->updpag("pefdes", $pefdes, $pefid);
			$result=$mtac->updpag("pefedi", $pefedi, $pefid);
			$result=$mtac->updpag("pefeli", $pefeli, $pefid);
			$pefid = "";
		}
		else{
			echo "<script>alert('HAY CAMPOS VACIOS')</script>";
		}
		$opera = "";
	}


//Eliminar
	if($opera=="eliminar"){
		if ($pefid){
			$result=$mtac->elipag($pefid);
			$pefid = "";
		}
		else{
			echo "<script>alert('ERROR AL ELIMINAR')</script>";
		}
		$opera = "";
	}

//Paginacion
	$bo="";
	$nreg = 10; 
	$pa = new mpaginacion();
	$preg = $pa->mpagin($nreg);
	$conp = $mtac->sqlcount($filtro);

	function cargar($conp,$nreg,$pg,$bo,$filtro,$arc){
		$mtac=new mpef();
		$pa = new mpaginacion($nreg);

        $txt = '<table>';
          $txt .= '<tr>';
            $txt .= '<td>';
				$txt .= '<form id="formfil" name="frmfil" method="GET" action="'.$arc.'" class="txtbold">';
				$txt .= '<input name="pg" type="hidden" value="'.$pg.'" />';
			$txt .= '<input class="search-box" type="text" name="filtro" value="'.$filtro.'" placeholder="Nombre de perfil"
					onChange="this.form.submit();">';
					$txt .= '<label for="search-box"><span class="glyphicon fas fa-search search-icon"></span></label>';
				$txt .= '</form>';
			$txt .= '</td>';
            $txt .= '<td align="right" style="padding-left: 10px;">';

            $bo = "<input type='hidden' name='filtro' value='".$filtro."' />";
            $txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc); 
            $result = $mtac->selpag($filtro, $pa->rvalini(), $pa->rvalfin());

            $txt .= '</td>';
            $txt .= '<td>';
            $txt .= '</td>';
          $txt .= '</tr>';
      $txt .= '</table>';

		if ($result){
		$txt .= '<div class="cuad" style="width: 90%;">';
			$txt .= "<table class='table table-hover'>
				<tr>
					<th class='success'>Perfil</th>
					<th class='success texto'><i class='fas fa-search perfiles' title='Permitir Buscar'></i></th>
					<th class='success texto'><i class='fas fa-cloud-download-alt perfiles' title='Permitir Descargar'></i></th>
					<th class='success texto'><i class='fas fa-pencil-alt perfiles' title='Permitir Editar'></i></th>
					<th class='success texto'><i class='fas fa-times perfiles' title='Permitir Eliminar'></i></th>
					<th class='success texto'><i class='fas fa-file perfiles' title='P&aacute;gina'></i></th>
					<th class='success'></th>
				</tr>";
				foreach ($result as $f){	
					$txt .= "<tr>";
						//$txt .= "<td class='active' align='center'>".$f['pefid']."</td>";
						$txt .= "<td class='active centrado'>".$f['pefnom']."</td>";
//----------------------------------------------------------------
						$txt .= "<td class='active centrado alinear' align='center'>";
						if($f['pefbus']==1)
							$txt .= "<a href='home.php?pg=".$pg."&pbu=2&pefid=".$f['pefid']."'><i class='fas fa-check-circle'></i></a>";
						else
							$txt .= "<a href='home.php?pg=".$pg."&pbu=1&pefid=".$f['pefid']."'><i class='fas fa-times-circle'></i></a>";
						$txt .= "</td>";
//----------------------------------------------------------------
						$txt .= "<td class='active centrado alinear' align='center'>";
						if($f['pefdes']==1)
							$txt .= "<a href='home.php?pg=".$pg."&pde=2&pefid=".$f['pefid']."'><i class='fas fa-check-circle'></i></a>";
						else
							$txt .= "<a href='home.php?pg=".$pg."&pde=1&pefid=".$f['pefid']."'><i class='fas fa-times-circle'></i></a>";
						$txt .= "</td>";
//----------------------------------------------------------------
						$txt .= "<td class='active centrado alinear' align='center'>";
						if($f['pefedi']==1)
							$txt .= "<a href='home.php?pg=".$pg."&ped=2&pefid=".$f['pefid']."'><i class='fas fa-check-circle'></i></a>";
						else
							$txt .= "<a href='home.php?pg=".$pg."&ped=1&pefid=".$f['pefid']."'><i class='fas fa-times-circle'></i></a>";
						$txt .= "</td>";
//----------------------------------------------------------------
						$txt .= "<td class='active centrado alinear' align='center'>";
						if($f['pefeli']==1)
							$txt .= "<a href='home.php?pg=".$pg."&pel=2&pefid=".$f['pefid']."'><i class='fas fa-check-circle'></i></a>";
						else
							$txt .= "<a href='home.php?pg=".$pg."&pel=1&pefid=".$f['pefid']."'><i class='fas fa-times-circle'></i></a>";
						$txt .= "</td>";
//----------------------------------------------------------------

						$txt .= "<td class='active centrado alinear' align='center'><button data-toggle='modal' data-target='#myModal".$f['pefid']."'><i class='fas fa-eye' title='Agregar pagina'></i></button>";
						$txt .= modal($f['pefid'],$f['pefnom'], $pg);
						$txt .= "</td>";
						$txt .= "<td class='warning' align='center'>";
						$txt .= "<a href='home.php?pefid=".$f['pefid']."&pg=".$pg."'><ul class='social-icons icon-circle icon-zoom list-unstyled list-inline'><li><i class='fas fa-pen' title='Actualizar'></i></li></ul></a>";
						$txt .= '<script src="js/eliminar.js"></script>';
						$txt .= "<a href='home.php?pefid=".$f['pefid']."&opera=eliminar&pg=".$pg."'onclick='return eliminar();'><ul class='social-icons icon-circle icon-zoom list-unstyled list-inline'><li><i class='fas fa-times' title='Eliminar'></i></li></ul></td></a>";	
						$txt .= "</td>";	
					$txt .= "</tr>";
				}
			$txt .= "</table>";
		$txt .= '</div>';
		}else{
			$txt .= '<div class="cuad" style="width: 90%;">';
				$txt .= '<h3>No existen datos registrados en la base de datos.</h3>';
			$txt .= '</div>';
		}
		echo $txt;
	}

	function modal($pefid, $pefnom, $pg){
		$mpef=new mpef();
		$result = $mpef->selpg();
		$respxp = $mpef->selpxp($pefid);
		$tx = '<div class="modal fade" id="myModal'.$pefid.'" role="dialog">';
          $tx .= '<div class="modal-dialog">';
            $tx .= '<div class="modal-content">';
              $tx .= '<div class="modal-header">';
                $tx .= '<button type="button" class="close" data-dismiss="modal">&times;</button>';
                $tx .= '<h2 class="modal-title">Paginas&nbsp&nbsp</h2>';
                $tx .= '<h4>Perfil: '.$pefnom.'</h4>';
              $tx .= '</div>';
              $tx .= '<form name="frmece" action="home.php?pg='.$pg.'" method="POST"">';
                $tx .= '<div class="modal-body">';
                $m = 0;
				  foreach ($result as $f){
				  	$tx .= '<div style="width: 230px;text-align: left;float: left;">';
				  	$tx .= '<input type="checkbox" name="chk'.$m.'" value="';
				  	$tx .= $f['pagid'].'"';
				  	if($respxp){
					  	foreach ($respxp as $x){
					  		if($f['pagid']==$x['pagid'])
					  		$tx .= ' checked ';
					  	}
					}
				  	$tx .= '>';
				  	$tx .= '&nbsp;&nbsp;&nbsp;'.$f['pagnom']."</div>";
				  	$m++;
				  }

				  $tx .= '<input type="hidden" name="pefid" value="'.$pefid.'">';
				  $tx .= '<input type="hidden" name="pefnom" value="'.$pefnom.'">';
				  $tx .= '<input type="hidden" name="pefcan" value="'.count($result).'">';
				  $tx .= '<input type="hidden" name="opera" value="agregar">';
                $tx .= '</div>';
                $tx .= '<div class="modal-footer">';
                  $tx .= '<input name="guper" type="submit" class="btn btn-default" value="Enviar">';
                  $tx .= '<button class="btn btn-default" data-dismiss="modal">Cerrar</button>';
                $tx .= '</div>';
              $tx .= '</form>';
            $tx .= '</div>';
          $tx .= '</div>';                             
        $tx .= '</div>';
        return $tx;
	}

	function seleccionar($pefid, $pg){
		$mtac=new mpef();
		if($pefid){
			$result=$mtac->selpag1($pefid);
		}
		$txt = '';
		$txt .= '<div class="cuad">';
		$txt .= '<div class=" col-lg-12">';
		$txt .= '<div class="card mb-5 shadow-sm border-0 shadow-hover">';
		$txt .= '<div class="card-header bg-light border-0 pt-3 pb-0">';
		$txt .= '<form action="home.php?pg='.$pg.'" method="POST">
			<div>';
				/*$txt .= '<label>C&oacute;digo</label>';
				$txt .= '<input type="number" name="pefid" value="';
					if($pefid) $txt .= $result[0]['pefid'];
				$txt .= '"';
					if($pefid) $txt .= ' readonly';
				$txt .= ' required >';*/
				
				if($pefid){
					$txt .= '<div class="cont5">';
					$txt .= '<label>C&oacute;digo</label>';
					$txt .= '<BR>';
					$txt .= '<input class="form-control" type="number" name="pefid" value="'.$result[0]['pefid'].'" readonly required >';
					$txt .= '<BR>';
				}

				$txt .= '<label>Nombre Perfil</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="text" name="pefnom" value="';
					if($pefid){ $txt .= $result[0]['pefnom']; }
				$txt .= '" required >';
				$txt .= '<BR>';

				$txt .= '</div><div class="cont2">';
				$txt .= '<label>Permitir Buscar</label>';
				$txt .= '<BR>';
				$txt .= '<input type="checkbox" name="pefbus"';
					if($pefid && $result[0]['pefbus']==1){ $txt .= 'checked'; }
				$txt .= ' >';
				$txt .= '<BR>';

				$txt .= '<label>Permitir Descargar</label>';
				$txt .= '<BR>';
				$txt .= '<input type="checkbox" name="pefdes"';
					if($pefid && $result[0]['pefdes']==1){ $txt .= 'checked'; }
				$txt .= ' >';
				$txt .= '<BR>';
				
				$txt .= '<label>Permitir Editar</label>';
				$txt .= '<BR>';
				$txt .= '<input type="checkbox" name="pefedi"';
					if($pefid && $result[0]['pefedi']==1){ $txt .= 'checked'; }
				$txt .= ' >';
				$txt .= '</div><div class="cont2">';
				$txt .= '<label>Permitir Eliminar</label>';
				$txt .= '<BR>';
				$txt .= '<input type="checkbox" name="pefeli"';
					if($pefid && $result[0]['pefeli']==1){ $txt .= 'checked'; }
				$txt .= ' >';
				$txt .= '<BR>';
				$txt .= '<BR>';



				$txt .= '<input type="hidden" name="opera" value="';
					if($pefid){ $txt .= "actualizar"; } else { $txt .= "insertar"; }
				$txt .= '"><br><center><button type="submit" class="btn btn-outline-primary">';
					if($pefid){ $txt .= "Actualizar"; } else { $txt .= "Registrar"; }
				$txt .= '</button>';
				$txt .= '&nbsp;&nbsp;&nbsp;';

				$txt .= '<input type="reset" class="btn btn-outline-primary" value="';
					if($pefid){ $txt .= "Cancelar"; } else { $txt .= "Limpiar"; }
				$txt .= '"';
					if($pefid) $txt .= " onclick='window.history.back();' ";
				$txt .= ' />';
				$txt .= '<BR>';
				$txt .= '<BR>';
				$txt .= '<BR>';
				$txt .= '</center>
			</div>
		</form>';
		$txt .= '<BR>';
		$txt .= '<BR>';
		$txt .= '</div>';

				$txt .= '</div>';
				$txt .= '</div>';
				$txt .= '</div>';
				
		echo $txt;
	}	
?>