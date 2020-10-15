<?php
	require_once('modelo/conexion.php');
	require_once('modelo/mpag.php');
	require_once("modelo/mpaginacion.php");

	$pg = 7;
	$arc = "home.php";
	$mpag = new mpag();
	$pagid = isset($_POST['pagid']) ? $_POST['pagid']:NULL;
	if(!$pagid)
		$pagid = isset($_GET['pagid']) ? $_GET['pagid']:NULL;
	$pagnom = isset($_POST['pagnom']) ? $_POST['pagnom']:NULL;
	$pagarc = isset($_POST['pagarc']) ? $_POST['pagarc']:NULL;
	$pagmos = isset($_POST['pagmos']) ? $_POST['pagmos']:NULL;
	$pagord = isset($_POST['pagord']) ? $_POST['pagord']:NULL;
	$pagmen = isset($_POST['pagmen']) ? $_POST['pagmen']:NULL;
	$icono = isset($_POST['icono']) ? $_POST['icono']:NULL;

	$filtro = isset($_GET["filtro"]) ? $_GET["filtro"]:NULL;


	$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
	if(!$opera)
		$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

//Insertar
	if($opera=="insertar"){
		if ($pagnom && $pagarc && $pagmos && $pagord && $pagmen){
			$result=$mpag->inspag($pagid, $pagnom, $pagarc, $pagmos, $pagord, $pagmen,$icono);
			$pagid = "";
		}
		else{
			echo "<script>alert('FAVOR LLENAR TODOS LOS CAMPOS')</script>";
		}
		$opera = "";
	}

//Actualizar
	if($opera=="actualizar"){
		if ($pagid && $pagnom && $pagarc && $pagmos && $pagord && $pagmen){
		$result=$mpag->updpag($pagid, $pagnom, $pagarc, $pagmos, $pagord, $pagmen,$icono);
			$pagid = "";
		}
		else{
			echo "<script>alert('HAY CAMPOS VACIOS')</script>";
		}
		$opera = "";
	}


//Eliminar
	if($opera=="eliminar"){
		if ($pagid){
			$result=$mpag->elipag($pagid);
			$pagid = "";
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
	$conp = $mpag->sqlcount($filtro);

	function cargar($conp,$nreg,$pg,$bo,$filtro,$arc){
		$mpag=new mpag();
		$pa = new mpaginacion($nreg);

        $txt = '<table>';
          $txt .= '<tr>';
            $txt .= '<td>';
				$txt .= '<form id="formfil" name="frmfil" method="GET" action="'.$arc.'" class="txtbold">';
				$txt .= '<input name="pg" type="hidden" value="'.$pg.'" />';
			$txt .= '<input class="search-box" type="text" name="filtro" value="'.$filtro.'" placeholder="Nombre de página"
					onChange="this.form.submit();">';
					$txt .= '<label for="search-box"><span class="glyphicon fas fa-search search-icon"></span></label>';
				$txt .= '</form>';
			$txt .= '</td>';
            $txt .= '<td align="right" style="padding-left: 10px;">';

            $bo = "<input type='hidden' name='filtro' value='".$filtro."' />";
            $txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc); 
            $result = $mpag->selpag($filtro, $pa->rvalini(), $pa->rvalfin());

            $txt .= '</td>';
          $txt .= '</tr>';
      $txt .= '</table>';

		if ($result){
			$txt .= '<div class="cuad" style="width: 90%;">';
			$txt .= "<table class='table table-hover'>
				<tr>
					<th class='success ocultar2'>Nombre</th>
					<th class='success'>Mostrar</th>
					<th class='success ocultar'>Orden</th>
					<th class='success'>Icono</th>
					<th class='success'></th>
				</tr>";
				foreach ($result as $f){	
					$txt .= "<tr>";
						$txt .= "<td class='active ocultar2'>";
						$txt .= "<span style='font-size: 20px;'><strong>".$f['pagid']." - ".$f['pagnom']."</strong></span>";
						$txt .= "<br><strong>Archivo: </strong>".$f['pagarc'];
						$txt .= "<br><strong>Menu: </strong>".$f['pagmen'];
						$txt .= "</td>";
						$txt .= "<td class='active centrado' align='center'>";
						if($f['pagmos']==1)
							$txt .= "<i class='fas fa-check-circle' style='font-size: 18px; color: #6C6C6C;'></i>";
						else
							$txt .= "<i class='fas fa-times-circle' style='font-size: 18px; color: #db5a3c;'></i>";
						$txt .= "</td>";
						$txt .= "<td class='active centrado ocultar' align='center'>".$f['pagord']."</td>";

						$txt .= "<td class='active centrado' align='center'>";
							$txt .= "<i style='width: 40px;'' class='";
								$txt .= $f['icono'];
							$txt .= "'></i>";
						$txt .= "</td>";


						$txt .= "<td class='warning' align='center'>";
					$txt .= "<a href='home.php?pagid=".$f['pagid']."&pg=".$pg."'><ul class='social-icons icon-circle icon-zoom list-unstyled list-inline'><li><i class='fas fa-pen' title='Actualizar'></i></a></li></ul>";
					$txt .= '<script src="js/eliminar.js"></script>';
					$txt .= "<a href='home.php?pagid=".$f['pagid']."&opera=eliminar&pg=".$pg."'onclick='return eliminar();'><ul class='social-icons icon-circle icon-zoom list-unstyled list-inline'><li><i class='fas fa-times' title='Eliminar'></i></a></li></ul></td>";
					$txt .= "</tr>";
				}
			$txt .= "</table>";
			$txt .= "</div>";
		}else{
			$txt .= '<div class="cuad" style="width: 90%;">';
				$txt .= '<h3>No existen datos registrados en la base de datos.</h3>';
			$txt .= '</div>';
		}
		echo $txt;
	}

	function seleccionar($pagid, $pg){
		if($pagid){
			$mpag=new mpag();
			$result=$mpag->selpag1($pagid);
		}
		$txt = '';
		$txt .= '<div class="cuad">';
		$txt .= '<div class=" col-lg-12">';
		$txt .= '<div class="card mb-5 shadow-sm border-0 shadow-hover">';
		$txt .= '<div class="card-header bg-light border-0 ">';
		$txt .= '<form action="home.php?pg='.$pg.'" method="POST">
			<div class="cont1">';
				$txt .= '<label>C&oacute;digo</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="number" name="pagid" value="';
					if($pagid) $txt .= $result[0]['pagid'];
				$txt .= '"';
					if($pagid) $txt .= ' readonly';
				$txt .= ' required >';
				$txt .= '<BR>';
				$txt .= '<label>Nombre</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="text" name="pagnom" value="';
					if($pagid){ $txt .= $result[0]['pagnom']; }
				$txt .= '" required >';
				$txt .= '<BR>';
				$txt .= '<label>Archivo</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="text" name="pagarc" value="';
					if($pagid){ $txt .= $result[0]['pagarc']; }
				$txt .= '" required >';
				$txt .= '<BR>';

				$txt .= '<label>Mostrar</label>';
				$txt .= '<BR>';
				$txt .= '<select class="form-control" name="pagmos" >';
					$txt .= '<option value="1"';
						if($pagid and $result[0]['pagmos']==1){ $txt .= " selected "; }
					$txt .= '>Si</option>';
					$txt .= '<option value="2"';
						if($pagid and $result[0]['pagmos']<>1){ $txt .= " selected "; }
					$txt .= '>No</option>';
				$txt .= '</select>';
				$txt .= '</div><div class="cont2">';
				$txt .= '<BR>';
				
				$txt .= '<label>Men&uacute;</label>';
				$txt .= '<BR>';
				$txt .= '<select class="form-control" name="pagmen" >';
					$txt .= '<option value="Home"';
						if($pagid and $result[0]['pagmen']=="Home"){ $txt .= " selected "; }
					$txt .= '>Home</option>';
					$txt .= '<option value="Index"';
						if($pagid and $result[0]['pagmen']=="Index"){ $txt .= " selected "; }
					$txt .= '>Index</option>';
				$txt .= '</select>';
				$txt .= '<BR>';

				$txt .= '<label>Orden</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="number" name="pagord" value="';
					if($pagid){ $txt .= $result[0]['pagord']; }
				$txt .= '" required >';
				$txt .= '<BR>';

				$txt .= '<label>Icono</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="text" name="icono" value="';
						if($pagid){ $txt .= $result[0]['icono']; }
				$txt .= '" required >';

				$txt .= '<input type="hidden" name="opera" value="';
					if($pagid){ $txt .= "actualizar"; } else { $txt .= "insertar"; }
				$txt .= '"><br><center><button type="submit" class="btn btn-outline-primary">';
					if($pagid){ $txt .= "Actualizar"; } else { $txt .= "Registrar"; }
				$txt .= '</button>';
				$txt .= '&nbsp;&nbsp;&nbsp;';

				$txt .= '<input type="reset" class="btn btn-outline-primary" value="';
					if($pagid){ $txt .= "Cancelar"; } else { $txt .= "Limpiar"; }
				$txt .= '"';
					if($pagid) $txt .= " onclick='window.history.back();' ";
				$txt .= ' />';

				$txt .= '</center>
			</div>
		</form>';
		$txt .= '</div>';
				$txt .= '</div>';
				$txt .= '</div>';
				$txt .= '</div>';
		echo $txt;
	}
?>