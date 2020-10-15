<?php 
//1.2. Incluimos nuestra conexion y modelo 
require_once ("modelo/conexion.php");
require_once ("modelo/mempleado.php");
require_once ('modelo/mpaginacion.php');
	//1.3. Instanciamos el modelo a variable php
    $pg = 3;
	//variable $arc
	$arc = "home.php";

    $mempleado = new mempleado();
      $filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
	$idusu = isset($_POST['idusu']) ? $_POST['idusu']:NULL;
	if (!$idusu)
	$idusu = isset($_GET['idusu']) ? $_GET['idusu']:NULL;
	$nomusu = isset($_POST['nomusu']) ? $_POST['nomusu']:NULL;
	$apeusu = isset($_POST['apeusu']) ? $_POST['apeusu']:NULL;
	$tipdocusu = isset($_POST['tipdocusu']) ? $_POST['tipdocusu']:NULL;
	$nodocusu = isset($_POST['nodocusu']) ? $_POST['nodocusu']:NULL;
	$fechnac = isset($_POST['fechnac']) ? $_POST['fechnac']:NULL;
	$dirusu = isset($_POST['dirusu']) ? $_POST['dirusu']:NULL;
	$ciudusu = isset($_POST['ciudusu']) ? $_POST['ciudusu']:NULL;
	$telusu = isset($_POST['telusu']) ? $_POST['telusu']:NULL;
	$celusu = isset($_POST['celusu']) ? $_POST['celusu']:NULL;
	$emausu = isset($_POST['emausu']) ? $_POST['emausu']:NULL;
	$pasusu = isset($_POST['pasusu']) ? $_POST['pasusu']:NULL;
	$idsuc = isset($_POST['idsuc']) ? $_POST['idsuc']:NULL;
	$tipusu = isset($_POST['tipusu']) ? $_POST['tipusu']:NULL;
	$activo = isset($_POST['activo']) ? $_POST['activo']:NULL;
		if (!$activo)
			$activo = isset($_GET['activo']) ? $_GET['activo']:NULL;
	//capturamos la accion (C-U-D) metodo - POST(Form)
	$opera = isset($_POST['operacion']) ? $_POST['operacion']:NULL;
	$del = isset($_POST['del']) ? $_POST['del']:NULL;
	//capturamos la accion (C-U-D) metodo - GET(URL)
	$del = isset($_GET['del']) ? $_GET['del']:NULL;
	$opera = isset($_POST['operacion']) ? $_POST['operacion']:NULL;
	

	if($opera=="Insertar"){

		$pp = sha1(md5($pasusu));
		//Validamos si la var(PHP) estan llenas y las enviamos al nuestro objeto -> metodo(parametros)
		if($nomusu AND $apeusu AND $tipdocusu AND $nodocusu  AND $fechnac AND $dirusu AND $ciudusu AND $telusu AND $celusu AND $emausu AND $pasusu AND $idsuc AND $tipusu){
			$mempleado->insempleado($nomusu, $apeusu, $tipdocusu, $nodocusu, $fechnac, $dirusu, $ciudusu, $telusu, $celusu, $emausu, $pp, $idsuc, $tipusu);
		}
		$idusu ="";
		$opera ="";	
		$del ="";
	}
	//1.4.2. Actualizar
	if($opera=="Actualizar"){

		$pp = sha1(md5($pasusu));
		//Validamos si la var(PHP) estan llenas y las enviamos al nuestro objeto -> metodo(parametros)
		if($idusu AND $nomusu AND $apeusu AND $tipdocusu AND $nodocusu  AND $fechnac AND $dirusu AND $ciudusu AND $telusu AND $celusu AND $emausu AND $pasusu AND $idsuc AND $tipusu){
			$mempleado->updempleado($idusu, $nomusu, $apeusu, $tipdocusu, $nodocusu, $fechnac, $dirusu, $ciudusu, $telusu, $celusu, $emausu, $pp, $idsuc, $tipusu);
		}	
		//$idusu ="";
		$opera ="";
		$del ="";
	}
	//Capturamos el estado del usuario (Activo e Inactivo)
	if ($activo && $idusu){
		$result=$mempleado->upd_act_emp($activo,$idusu);
		$idusu = "";
	}
	//1.4.3. Eliminar
	if($del){		
		$mempleado->delempleado($del);
		$idusu ="";
		$opera ="";	
		$del ="";
	}

	//Paginacion
	$bo = '';
	//Varible numero de registro a mostrar
	$nreg = 5;
	//Crea un objeto [pa] que se instanciar la clase [mpagina.php]
	$pa = new mpaginacion();
	$preg = $pa->mpagin($nreg);
	//Variable de cant_num_registros
	$conp = $mempleado->selcount($filtro); 
	/*1.5. Creamos la funcion de nuestra vista (HTML) que se cargara en (vtab.php)*/

	/*1.5. Creamos la funcion de nuestra vista (HTML) que se cargara en (vtab.php)*/

	function form_registro($idusu){
	    $mempleado = new mempleado();
	    //Listamos nuetros perfiles(modulo)
		$result = $mempleado->list_perfil();
		$result2 = $mempleado->list_Tipodedocumento();
		$result3 = $mempleado->list_Sucursal();

		//Cargar los datos de nuestro user a atualizar(modulo)
		$result1 =$mempleado->sel_empleado_act($idusu);
		//Cargar los departamentos
		$datubi = $mempleado->selubi();

		$txt = '';
		$txt .= '<div class="cuad">';
		$txt .= '<div class="col-lg-12">';
		$txt .= '<div class="card mb-5 shadow-sm border-0 shadow-hover">';
		$txt .= '<div class="card-header bg-light border-0 pt-3 pb-0">';
			$txt .= '<form name="frm1" action="#" method="POST" enctype="multipart/form-data">';
		
				$txt .= '<div class="cont1">';

				$txt .= '<label>Nombre:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="text" name="nomusu" maxlength="50" value="';
					if($idusu){ $txt .= $result1[0]["nomusu"]; }
				$txt .= '" required >';
				$txt .= '<BR>';


				$txt .= '<label>Apellido:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="varchar" name="apeusu" maxlength="50" value="';
					if($idusu){ $txt .= $result1[0]["apeusu"]; }
				$txt .= '" required >';
				$txt .= '<BR>';				


				$txt .= '<label>Tipo De Documento:</label>';
				$txt .= '<BR>';
				$txt .= '<select class="form-control" name="idval">';
						foreach ($result2 as $f) {
							$txt .= '<option value="'.$f['idval'].'" ';
							if($f['idval'] and $f['idval']==$result2[0]["idval"])
								$txt .="SELECTED";
							$txt .= ' >'.$f['nomval'].'</option>';
						}
						$txt .= '</select>';
				$txt .= '<BR>';

				$txt .= '<label>No. Documento:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="number" name="nodocusu" maxlength="50" value="';
					if($idusu){ $txt .= $result1[0]["nodocusu"]; }
				$txt .= '" required >';
				$txt .= '<BR>';


				$txt .= '<label>Fecha de nacimiento:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="date" name="fechnac" maxlength="50" value="';
					if($idusu){ $txt .= $result1[0]["fechnac"]; }
				$txt .= '" required >';
				$txt .= '<BR>';
					

				$txt .= '<label>Direccion:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="varchar" name="dirusu" maxlength="50" value="';
					if($idusu){ $txt .= $result1[0]["dirusu"]; }
				$txt .= '" required >';
				$txt .= '<BR>';

				//************************7a Fila Inicio (tr) departament
				$txt .= '<label>Departamento:</label>';
				$txt .= '<BR>';	
						//Name:depto+evento[OnChenge]
						$txt .= '<label><select class="form-control" name="depto" onChange="javascript:recargarCiudades(this.value);">';
						foreach ($datubi as $dubi){
							$txt .= '<option value="'.$dubi['idubi'].'" ';
							if($idusu and $result1[0]['depende']==$dubi['idubi']){
								$txt .= "selected "; }
							$txt .= ' >'.$dubi['nombre'].'</option>';
						}
						$txt .= '</select>';
					$txt .= '</label>';
					$txt .= '<BR>';
//************************7a Fila Cierre
//************************8a Fila Inicio (tr) Municipio REPINTARA (JS)
					
					$txt .= '</div><div class="cont2">';

					$txt .= '<label>Municipio:</label>';
					$txt .= '<BR>';
					$txt .= '<label>';
						$txt .= '<div id="reloadMun">';
						$txt .= '<select class="form-control" name="ciudusu">';
						$txt .= '<option selected value ="0">Seleccione Municipio</option>';
						if($idusu){
						$txt .='<option value="'.$result1[0]['depende'].'" selected>'.$result1[0]['nombre'].'</option>';
						}
						$txt .= '</select>';
						$txt .= '</div>';
					$txt .= '</label>';
					$txt .= '<BR>';
					
//************************8a Fila Cierre


				$txt .= '<label>Telefono:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="number" name="telusu" value="';
					if($idusu){ $txt .= $result1[0]["telusu"]; }
				$txt .= '" required >';
				$txt .= '<BR>';

				$txt .= '<label>Celular:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="number" name="celusu" value="';
					if($idusu){ $txt .= $result1[0]["celusu"]; }
				$txt .= '" required >';
				$txt .= '<BR>';


				$txt .= '<label>Usuario:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="email" name="emausu" maxlength="50" value="';
					if($idusu){ $txt .= $result1[0]["emausu"]; }
				$txt .= '" required >';
				$txt .= '<BR>';

				$txt .= '<label>Contraseña:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="text" name="pasusu" maxlength="50" value="';
					if($idusu){ $txt .= $result1[0]["pasusu"]; }
				$txt .= '" required >';
				$txt .= '<BR>';


				$txt .= '<label>Sucursal:</label>';
				$txt .= '<BR>';
				$txt .= '<select class="form-control" name="idsuc">';
						foreach ($result3 as $f) {
							$txt .= '<option value="'.$f['idsuc'].'" ';
							if($f['idsuc'] and $f['idsuc']==$result3[0]["idsuc"])
								$txt .="SELECTED";
							$txt .= ' >'.$f['nomsuc'].'</option>';
						}
						$txt .= '</select>';
				$txt .= '<BR>';

					

				$txt .= '<label>Tipo De Usuario:</label>';
				$txt .= '<BR>';
				$txt .= '<select class="form-control" name="pefid">';
						foreach ($result as $f) {
							$txt .= '<option value="'.$f['pefid'].'" ';
							if($f['pefid'] and $f['pefid']==$result[0]["pefid"])
								$txt .="SELECTED";
							$txt .= ' >'.$f['pefnom'].'</option>';
						}
						$txt .= '</select>';
				$txt .= '<BR>';
	$txt .= '<tr>';
$txt .= '</div>';
				$txt .= '<BR>';
				$txt .= '<BR>';
					//Insertamos el Boton Centrado
					$txt .= '<tr>';
					$txt .= '<th colspan="2" style="text-align: center;">';
						$txt .= '<input type="submit" class="btn btn-outline-primary" name="operacion" value="';
						if ($idusu)
							$txt .= 'Actualizar';
						else
							$txt .= 'Insertar';
					$txt .= '" />';
					//Cierre Boton
					$txt .= '<BR>';
					$txt .= '<BR>';
					$txt .= '</div>';
					$txt .= '</div>';
					$txt .= '</div>';
					$txt .= '</tr>';;
			//Cierre Formulario	
			$txt .= '</form>';
		//Cierre Etiqueta DIV	
		$txt .= '</div>';
		//Imprimimos el Formulario(Vista)
		echo $txt;
	}
	/*1.6. Creamos la funcion de nuestra vista (HTML) Listar_Registro*/
function form_mostrar($conp,$nreg,$pg,$bo,$filtro,$arc,$pefedi,$pefeli){
		$mempleado = new mempleado();
		$pa = new mpaginacion();
		$txt = '';
		//Creamos el cuadro de buscar (filtros-Busquedas)
		$txt .= "<table>";
			//Una Fila
			$txt .= "<tr>";
				//1ra Columna - Formulario buscar
				$txt .= '<td>';
				$txt .= '<form id="formfil" name="frmfil" method="GET" action="'.$arc.'" class="txtbold">';
				$txt .= '<input name="pg" type="hidden" value="'.$pg.'" />';
			$txt .= '<input class="search-box" type="text" name="filtro" value="'.$filtro.'" placeholder="Nombre De Usuario"
					onChange="this.form.submit();">';
					$txt .= '<label for="search-box"><span class="glyphicon fas fa-search search-icon"></span></label>';
				$txt .= '</form>';
			$txt .= '</td>';
				//2da Columna control de paginacion
				$txt .= "<td align='right' style='padding-left: 10px;'>";
					$bo = "<input type='hidden' name='filtro' value='".$filtro."' />";
					//Llamamos el metodo de contar la cantida de paginas
					$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
					//Llamar los datos para completar la paginacion
					$result = $mempleado->sel_empleado($filtro,$pa->rvalini(),$pa->rvalfin());
				$txt .= "</td>";
			//Cierre Fila
			$txt .= "</tr>";
		$txt .= "</table>";
		if ($result) {
		$txt .= '<div class="cuad" width="100%">';
			$txt .= '<table width="100%" cellspacing="0px" align="center">';
			$txt .= "<table class='table table-responsive'>";
				//Inicio de la (Cabecera_Tb)			
				$txt .= '<tr>';
					$txt .= '<th>';
						$txt .= 'Usuario';
					$txt .= '</th>';
					$txt .= '<th class="centeri">';
						$txt .= 'Estado';
					$txt .= '</th>';
					$txt .= '<th class="centeri">';
						$txt .= 'Sucursal';
					$txt .= '</th>';
					$txt .= '<th></th>';
				$txt .= '</tr>';
				//Cierre de la (Cabecera_Tb)
				foreach ($result as $f) {
				//Inicio ROW - Datos de la tabla
				$txt .= '<tr>';
				$txt .= "<td class='active lefi2'>";
				$txt .= "<span style='font-size: 20px;'><strong>".$f['apeusu']." ".$f['nomusu']."</strong></span>";
				$txt .= "<br><strong>".$f['tipdocusu']." - ".$f['nodocusu']."</strong>";
				$txt .= "<br><strong>Direccion: </strong>".$f['dirusu'];
				$txt .= "<br><strong>Ciudad: </strong>".$f['ciudusu'];
				$txt .= "<br><strong>Telefono: </strong>".$f['celusu'];
				$txt .= "<br><strong>Email: </strong>".$f['emausu'];
				$txt .= "<br><strong>Fecha Na: </strong>".$f['fechnac'];
				$txt .= "</td>";
					$txt .= '<td class="centrado" align="center">';	
						if($f['actusu']==1)
							$txt .= "<i class='fas fa-check-circle' style='font-size: 18px; color: #6C6C6C;'></i>";
						else
							$txt .= "<i class='fas fa-times-circle' style='font-size: 18px; color: #db5a3c;'></i>";
					$txt .= '</td>';
					$txt .= '<td class="centrado" align="center">';	
						$txt .= $f["idsuc"];
					$txt .= '</td>';

						//ICONOS-MOdificar (Boton)
					$txt .= "<td class='warning' align='center'>";
					$txt .= "<a href='home.php?pg=003&idusu=".$f['idusu']."'><ul class='social-icons icon-circle icon-zoom list-unstyled list-inline'><li><i class='fas fa-pen' title='Actualizar'></i></a></li></ul>";
					//ICONOS-Eliminar (Boton)
					$txt .= "<a href='home.php?pg=003&del=".$f['idusu']."'><ul class='social-icons icon-circle icon-zoom list-unstyled list-inline'><li><i class='fas fa-times' title='Eliminar'></i></a></li></ul></td>";

				//Cierre ROW - Datos de la tabla
				$txt .= '</tr>';
				}
			$txt .= '</table>';
			$txt .= '<BR>';
					$txt .= '<BR>';
					$txt .= '<BR>';
					
				
	$txt .= '</div>';
	}else{
	$txt.= '<div class="cuad" style=" width": 90%;">';
	$txt.= '<h3> No existen datos registrado en la base de datos...</h3>';
	$txt.='</div>';
        }

		echo $txt;
	
	}

?>