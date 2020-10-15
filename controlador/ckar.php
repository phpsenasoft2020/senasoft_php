<?php
	require_once('modelo/conexion.php');
	require_once('modelo/mkar.php');
	require_once("modelo/mpaginacion.php");

    $pg = 119;
    $arc = "home.php";
    $mkar = new mkar();

    $selact = $mkar->selact();
    $idkaract = $selact[0]['idkar'];

	$idkar = isset($_POST['idkar']) ? $_POST['idkar']:NULL;
	if(!$idkar)
		$idkar = isset($_GET['idkar']) ? $_GET['idkar']:NULL;
	$fecinikar = isset($_POST['fecinikar']) ? $_POST['fecinikar']:NULL;
	$fecfinkar = isset($_POST['fecfinkar']) ? $_POST['fecfinkar']:NULL;
	$idusu = isset($_SESSION["idusu"]) ? $_SESSION["idusu"]:NULL;
	$act = isset($_POST['act']) ? $_POST['act']:NULL;


	$idprod = isset($_POST['idprod']) ? $_POST['idprod']:NULL;
	$tipdkar = isset($_POST['tipdkar']) ? $_POST['tipdkar']:NULL;
	$cantdk = isset($_POST['cantdk']) ? $_POST['cantdk']:NULL;
	$obsdk = isset($_POST['obsdk']) ? $_POST['obsdk']:NULL;
	$fecdk = isset($_POST['fecdk']) ? $_POST['fecdk']:0;

	$filtro = isset($_GET["filtro"]) ? $_GET["filtro"]:NULL;
        
    $opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
    if(!$opera)
        $opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

//Insertar
    
	if($opera=="insertar"){
		if ($fecinikar && $fecfinkar && $idusu){
			$mkar->cerkar();
			$result=$mkar->inskar($fecinikar, $fecfinkar, $idusu, 1);
			$selidkar=$mkar->selidkar($fecinikar, $fecfinkar, $idusu, 1);
			$idkar=$selidkar[0]['idka'];
			//echo "<br><br><br><br>".$idkar."<br><br><br><br>";
			echo "<script>window.location='home.php?pg=120&idkar=".$idkar."';</script>";
			$idkar = "";
	}
	else{
		echo "<script>alert('FALTA COMPLETAR CAMPOS')</script>";
	}

	$opera = "";
	}


	//Eliminar
	if($opera=="eliminar"){
		if ($idkar){
			$result=$mkar->delkar($idkar);
			$idkar = "";

		}
		else{
			echo "<script>alert('ERROR AL ELIMINAR')</script>";
		}
			$opera = "";
	}

///detalle de kardex----------------------------------------
//echo "<br><br><br><br>".$opera."<br>'".$idprod."','".$idkar."','".$tipdkar."','".$cantdkar."','".$obsdk."','".$fecdk."'<br><br><br>";
	if($opera=="insdetkar"){
		if ($idprod AND $idkar AND $tipdkar AND $cantdk AND $obsdk){
			$fecdk = date("Y-m-d H:i:s");
			$result=$mkar->insdekar($tipdkar, $fecdk, $obsdk, $cantdk, $idkar, $idprod);
			//Ajuste en caso de ser Entreda por compra de productos Nuevos disponibles
			if($tipdkar=="E" or $tipdkar=="AE"){
			//tomamos la cant disponible para KARDEX de ese producto
				$exist = $mkar->exiprod($idprod);
				$candis = $exist[0]['cantprod'];
			//Actualizo la cantidad  disponible
				$exist1 = $mkar->actexiprod($candis,$idprod,$cantdk);
			$iddekar = "";
			}else{				
			//tomamos la cant disponible para KARDEX de ese producto
				$exist = $mkar->exiprod($idprod);
				$candis = $exist[0]['cantprod'];
			//Actualizo la cantidad  disponible
				$exist1 = $mkar->actexiprod1($candis,$idprod,$cantdk);
			$iddekar = "";

			}
		}
		else{
			echo "<script>alert('FAVOR LLENAR TODOS LOS CAMPOS)</script>";
		}
		$opera = "";
	}


///detalle de kardex----------------------------------------

//Paginacion
    $bo="";
    $nreg = 3;
    $pa = new mpaginacion();
    $preg = $pa->mpagin($nreg);
    $conp = $mkar->sqlcount($filtro);

 function cargar($conp,$nreg,$pg,$bo,$filtro,$arc){
		$mkar=new mkar();
		$pa = new mpaginacion($nreg);
		$txt = '';
		$txt .= '<center>';
			$txt .= '<table>';
				$txt .= '<tr>';
					$txt .= '<td>';
				$txt .= '<form id="formfil" name="frmfil" method="GET" action="'.$arc.'" class="txtbold">';
				$txt .= '<input name="pg" type="hidden" value="'.$pg.'" />';
			$txt .= '<input class="search-box" type="text" name="filtro" value="'.$filtro.'" placeholder="Nombre De Kardex"
					onChange="this.form.submit();">';
					$txt .= '<label for="search-box"><span class="glyphicon fas fa-search search-icon"></span></label>';
				$txt .= '</form>';
			$txt .= '</td>';
					$txt .= '<td align="right" style="padding-left: 20px;">';
						$bo = "<input type='hidden' name='filtro' value='".$filtro."' />";
						$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
						$result = $mkar->selkar($filtro, $pa->rvalini(), $pa->rvalfin());
					$txt .= '</td>';
				$txt .= '</tr>';
			$txt .= '</table>';
		$txt .= '</center><br>';

		if ($result){
			$txt .= '<center>';
			$txt .= '<div class="cuad" style="width: 90%;">';
			$txt .= '<table width="100%" cellspacing="0px" align="center" class="table table-hover">';
				//Inicio de la (Cabecera_Tb)			
				$txt .= '<tr class="bg-info">';
					$txt .= '<th>';
						$txt .= 'Kardex';
					$txt .= '</th>';
					$txt .= '<th>';
						$txt .= 'Activo';
					$txt .= '</th>';
					$txt .= '<th></th>';
				$txt .= '</tr>';
				//Cierre de la (Cabecera_Tb)
				foreach ($result as $f) {
				//Inicio ROW - Datos de la tabla
				$txt .= '<tr>';
					//Kardex
					$txt .= '<td align="center">';	
						$txt .= "<big><strong>Kardex No.".$f['idkar']."</strong></big><br>";
						$txt .= "<strong>Fecha de Inicio: </strong>".$f['fecinikar']."&nbsp;&nbsp;&nbsp;";
						$txt .= "<strong>Fecha de Fin: </strong>".$f['fecfinkar']."<br>";
						$txt .= "<strong>Empleado: </strong>".$f['empl']."&nbsp;&nbsp;&nbsp;";
					$txt .= '</td>';
					//Activo
					$txt .= '<td class="centrado" align="center">';	
						if($f['act']==1){
							$txt .= "<i class='fas fa-check-circle' style='font-size: 18px; color: #6C6C6C;'></i>";
						}else{
							$txt .= "<i class='fas fa-times-circle' style='font-size: 18px; color: #db5a3c;'></i>";
						}
					$txt .= '</td>';
					//Extras
					$txt .= "<td class='warning' align='center'>";
					$txt .= "<a href='home.php?idkar=".$f['idkar']."&pg=120'><ul class='social-icons icon-circle icon-zoom list-unstyled list-inline'><li><i class='fas fa-pen' title='Actualizar'></i></li></ul></a>";

					$txt .= "<a href='vista/vpdfkar.php?idkar=".$f['idkar']."&pdf=1547' target='_blank'><ul class='social-icons icon-circle icon-zoom list-unstyled list-inline'><li><i class='fas fa-file-pdf' title='Generar PDF'></i></li></ul></a>";

					$txt .= "<a href='vista/vpdfkar.php?idkar=".$f['idkar']."' target='_blank'><ul class='social-icons icon-circle icon-zoom list-unstyled list-inline'><li><i class='fas fa-copy' title='Imprimir'></i></a></li></ul></td>";
					$txt .= '</td>';
				//Cierre ROW - Datos de la tabla
				$txt .= '</tr>';
				}
			$txt .= '</table>';
		}else{
			$txt .= "<center><h5>No existen resultados en la búsqueda</h5></center>";
		}
		$txt .= '</div>';
		$txt .= '</center>';
		echo $txt;
	}


function seleccionar($idkar, $pg){
        $mkar=new mkar();
        if($idkar){
            $result=$mkar->selkar1($idkar);
        }
            $res = $mkar->selact();
		$txt = '';
		$txt .= '<div class="cuad">';        
            $txt .= '<form action="home.php?pg='.$pg.'" method="POST" id="form">';
				$txt .= '<center><div>';
					date_default_timezone_set('America/Bogota');
					$fecinikar = date("Y-m-01 H:i:s");
					$fecfinkar = date("Y-m-30 H:i:s");
	                $txt .= '<label>Fecha inicial</label>';
	                $txt .= '<input type="datetime" name="fecinikar" value="';
	                    if($idkar){ $txt .= $result[0]['fecinikar']; } else{ $txt .= $fecinikar; }
	                $txt .= '" required class="form-control">';
	                $txt .= '<label>Fecha final</label>';
	                $txt .= '<input type="datetime" name="fecfinkar" value="';
	                    if($idkar){ $txt .= $result[0]['fecfinkar']; } else{ $txt .= $fecfinkar; }
	                $txt .= '" required class="form-control">';
	                $txt .= '<input type="hidden" name="opera" value="insertar">';
	                $txt .= '<br><center><button type="submit" class="btn btn-success">';
	                    $txt .= "Registrar";
	                $txt .= '</button></center>';
				$txt .= '</div></center>';
	        $txt .= '</form>';
        $txt .= '</div><br>';
        echo $txt;
    }

   ///DETALLE--------------------------------
    function mosenc($idkar){
        $mkar=new mkar();
        $datfac = $mkar->selkar1($idkar);

        if ($datfac){
            $txt = '';
            $txt .= '<center>';
            $txt .= '<div class="col-md-12 col">';
                $txt .= '<center>';
                    $txt .= '<h1>Kardex No. '.$idkar.'</h1>';
                $txt .= '</center>';                 
                $txt .= '<hr>';
            $txt .= '</div>';
            $txt .= "<table class='table table-hover'>";
                $txt .= "<tr>";
                    $txt .= "<th class='tablefor'>Fecha Inicial:</th>";
                    $txt .= "<td>".$datfac[0]['fecinikar']."</td>";
                    $txt .= "<th class='tablefor'>Fecha Final:</th>";
                    $txt .= "<td>".$datfac[0]['fecfinkar']."</td>";
                $txt .= "</tr>";
                $txt .= "<tr>";
                    $txt .= "<th class='tablefor'>Activo:</th>";
                    $txt .= "<td>";
                    if($datfac[0]['act']==1){
						$txt .= "<i class='fas fa-check-circle' style='font-size: 18px; color: #6C6C6C;'></i>";
					}else{
						$txt .= "<i class='fas fa-times-circle' style='font-size: 18px; color: #db5a3c;'></i>";
					}
					$txt .= "</td>";
                    $txt .= "<th class='tablefor'>Empleado:</th>";
                    $txt .= "<td>".$datfac[0]['empl']."</td>";
                $txt .= "</tr>";
            $txt .= "</table></center>";
        }else{
            $txt = "<center><h5>No existen resultados</h5></center>";
        }
        echo $txt;
    }

function mosdetkar($idkar,$pg,$arc){
		$mkar=new mkar();
		$result = $mkar->seldekar($idkar);

		$txt = '<div class="container">';
		if ($result){
		$txt .= "<table class='table table-striped'>
		<tr>
		<th class='tablefor'>Producto</th>
		<th class='tablefor'>E</th>
		<th class='tablefor'>AE</th>
		<th class='tablefor'>S</th>
		<th class='tablefor'>AS</th>
		<th class='tablefor'>cantprod</th>
		<th class='tablefor'>Observación</th>
		
		
		</tr>";
		foreach ($result as $f){
			$dtval = $mkar->seldevalo($f['idprod'],$idkar);
			$dtobs = $mkar->selobsv($idkar, $f['idprod']);
			//$exis = $mkar->exiprod($f['extprod']);
			$exis = $f['cantprod'];
			$txt .= "<tr>";
				/*$txt .= "<td class='active' align='center'>".$f['iddet']."</td>";*/
				$txt .= "<td class='active' align='center'>".$f['nomprod']."</td>";
				$txt .= "<td class='active' align='center'>";
					if($dtval){
						foreach ($dtval as $dtv) {
							if($dtv['tipdkar']=="E"){
								$txt .= $dtv['tot'];
								$exis = $exis+$dtv['tot'];
							}
						}	
					}
				$txt .= "</td>";
				$txt .= "<td class='active' align='center'>";
					if($dtval){
						foreach ($dtval as $dtv) {
							if($dtv['tipdkar']=="AE"){
								$txt .= $dtv['tot'];
								$exis = $exis+$dtv['tot'];
							}
						}	
					}
				$txt .= "</td>";
				$txt .= "<td class='active' align='center'>";
					if($dtval){
						foreach ($dtval as $dtv) {
							if($dtv['tipdkar']=="S"){
								$txt .= $dtv['tot'];
								$exis = $exis-$dtv['tot'];
							}
						}	
					}
				$txt .= "</td>";
				$txt .= "<td class='active' align='center'>";
					if($dtval){
						foreach ($dtval as $dtv) {
							if($dtv['tipdkar']=="AS"){
								$txt .= $dtv['tot'];
								$exis = $exis-$dtv['tot'];
							}
						}	
					}
				$txt .= "</td>";
				$txt .= "<td class='active' align='center'><strong>";
					$txt .= $f['cantprod'];
				$txt .= "</strong></td>";
				$txt .= "<td class='active' align='center'>";
					if($dtobs){
						$txt .= "<img src='image/histo.png' title='";
						foreach ($dtobs as $dtob) {
							$txt .= $dtob['Obser']."\n";
						}
						$txt .= "' >";
					}
				$txt .= "</td>";
				/*
				$txt .= "<td class='warning' align='center'>";
				$txt .=	'<script src="js/eliminar.js"></script>';

				$txt .= "<a href='home.php?idkar=".$idkar."&iddet=".$f['iddet']."&opera=eliminar&pg=".$pg."' onclick='return eliminar();'><img
				src='image/trash.png' title='Eliminar' width='20px'></a></td>";*/
			$txt .= "</tr>";
		}
		$txt .= "</table>";
			
		}else{
	$txt .= "<center><h5>No existen resultados en la búsqueda</h5></center>";
		}
	$txt .= '</div>';
	$txt .= '<div class="col-sm-2"></div>';
		echo $txt;
	}


function insdetkar($idkar, $pg){
        $mkar=new mkar();
 		$resk = $mkar->selkar1($idkar);
        $resp = $mkar->selmat();
        

        $txt = '<form action="home.php?pg='.$pg.'" method="POST" id="form">';
        $txt .= '<center>';
		$txt .= '<div>';
                    $txt .= '<center>';
                    $txt .= '<h3>Agregar Ajustes</h3>';
                    $txt .= '</center>';
                $txt .= '<label>Tipo</label>';
 					$txt .= "<select name='tipdkar' class='form-control'>";
 						$txt .= "<option value='E'>Entrada (Productos que llegan)</option>";
						$txt .= "<option value='AE'>Ajuste de Entrada (Sobraron)</option>";
						$txt .= "<option value='S'>Salida (Productos que se piden)</option>";
						$txt .= "<option value='AS'>Ajuste de Salida (perdidas)</option>";
					$txt .= "</select>";

                date_default_timezone_set('America/Bogota');
				$fechoy = date("Y-m-d H:i:s");

                $txt .= '<input type="hidden" name="fecdk" value="';
                    $txt .= $fechoy;
                $txt .= '" required class="form-control">';
   
                	$txt .= '<input type="hidden" name="idkar" value="'.$idkar.'">';
								

				$txt .= '<label>Producto</label>';
                $txt .= '<select name="idprod" class="form-control">';
				if($resp){
					foreach($resp AS $p){
						$txt .= '<option value="'.$p["idprod"].'"';
						$txt .= '>'.$p["idprod"]." - ".$p['nomprod'].'</option>';
					}
				}
				$txt .='</select>';

				$txt .= '<label>Cantidad</label>';
				$txt .= '<input type="number" name="cantdk" value="0" required class="form-control">';
				$txt .= '<label>Observación</label>';
                $txt .= '<textarea name="obsdk" required class="form-control"></textarea>';
                $txt .= '<input type="hidden" name="opera" value="insdetkar">';
                $txt .= '<br><center><button type="submit" class="btn btn-primary">';
                    $txt .= "Registrar"; 
                $txt .= '</button>';
                $txt .= '&nbsp;&nbsp;&nbsp;';
                $txt .= '</center>
            </div>
        </form>';
        echo $txt;
    } 
?>