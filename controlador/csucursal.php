<?php 
//1.2. Incluimos nuestra conexion y modelo 
require_once ("modelo/conexion.php");
require_once ("modelo/msucursal.php");
require_once('modelo/mpaginacion.php');
	//1.3. Instanciamos el modelo a variable php
$pg = 4;
	//variable $arc
$arc = "home.php";

	$msucursal = new msucursal();
	$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
	$idsuc = isset($_POST['idsuc']) ? $_POST['idsuc']:NULL;
	if (!$idsuc)
		$idsuc = isset($_GET['idsuc']) ? $_GET['idsuc']:NULL;
	$nomsuc = isset($_POST['nomsuc']) ? $_POST['nomsuc']:NULL;
	$dirsuc = isset($_POST['dirsuc']) ? $_POST['dirsuc']:NULL;
	$ciusuc = isset($_POST['ciusuc']) ? $_POST['ciusuc']:NULL;
	$telsuc = isset($_POST['telsuc']) ? $_POST['telsuc']:NULL;
	
	//capturamos la accion (C-U-D) metodo - POST(Form)
	$opera = isset($_POST['operacion']) ? $_POST['operacion']:NULL;
	$del = isset($_POST['del']) ? $_POST['del']:NULL;
	//capturamos la accion (C-U-D) metodo - GET(URL)
	$del = isset($_GET['del']) ? $_GET['del']:NULL;
	$opera = isset($_POST['operacion']) ? $_POST['operacion']:NULL;
	//1.4. Validamos el tipo de operacion (Accion (Evento_Vista))

	//1.4.1. Inserción
	if($opera=="Insertar"){
		//Validamos si la var(PHP) estan llenas y las enviamos al nuestro objeto -> metodo(parametros)
		if($idsuc AND $nomsuc AND $dirsuc AND $eciusuc AND $telsuc){
			$msucursal->inssucursal($nomsuc,$dirsuc,$ciusuc,$telsuc);
		}
		$idsuc ="";
		$opera ="";	
		$del ="";
	}
	//1.4.2. Actualizar
	if($opera=="Actualizar"){
		//Validamos si la var(PHP) estan llenas y las enviamos al nuestro objeto -> metodo(parametros)
		if($idsuc AND $nomsuc AND $dirsuc AND $ciusuc AND $telsuc){
			$msucursal->updsucursal($idsuc,$nomsuc,$dirsuc,$ciusuc,$telsuc);
		}	
		$idsuc ="";
		$opera ="";
		$del ="";
	}
	//1.4.3. Eliminar
	if($del){		
		$msucursal->delsucursal($idsuc);
		$idsuc ="";
		$opera ="";	
		$del ="";
	}
	/*1.5. Creamos la funcion de nuestra vista (HTML) que se cargara en (vtab.php)*/
//1.5. Creamos las FUNCION Y CODIGO FORM para visualizar en (VISTA(vusu.php))
	//- N O T A - Deberemos guardar algunos icnos en la carpeta [/image] (Actualizar - Eliminar)
	$bo = '';
	//Varible numero de registro a mostrar
	$nreg = 6;
	//Crea un objeto [pa] que se instanciar la clase [mpagina.php]
	$pa = new mpaginacion();
	$preg = $pa->mpagin($nreg);
	//Variable de cant_num_registros
	$conp = $msucursal->selcount($filtro);

	function form_registro($idsuc){
	    $msucursal = new msucursal();
	    //Listamos nuetros perfiles(modulo)
		$result = $msucursal->list_Empresa();
		//Cargar los datos de nuestro user a atualizar(modulo)
		$result1 = $msucursal->sel_sucursal_act($idsuc);
		//Cargar los departamentos
		$datubi = $msucursal->selubi();

		$txt = '';
		$txt .= '<div class="cuad">';
		$txt .= '<div class="col-lg-12">';
		$txt .= '<div class="card mb-5 shadow-sm border-0 shadow-hover">';
		$txt .= '<div class="card-header bg-light border-0 pt-3 pb-0">';

			$txt .= '<form name="frm1" action="#" method="POST" enctype="multipart/form-data">';


				
				$txt .= '<div class="cont1">';

				$txt .= '<label>Nombre De Sucursal:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="text" name="nomsuc" maxlength="50" value="';
					if($idsuc){ $txt .= $result1[0]["nomsuc"]; }
				$txt .= '" required >';
				$txt .= '<BR>';


				$txt .= '<label>Direccion De Sucursal:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="text" name="dirsuc" maxlength="50" value="';
					if($idsuc){ $txt .= $result1[0]["dirsuc"]; }
				$txt .= '" required >';
				$txt .= '<BR>';


				//************************7a Fila Inicio (tr) departament
				$txt .= '<label>Departamento:</label>';
				$txt .= '<BR>';	
						//Name:depto+evento[OnChenge]
						$txt .= '<label><select class="form-control" name="depto" onChange="javascript:recargarCiudades(this.value);">';
						foreach ($datubi as $dubi){
							$txt .= '<option value="'.$dubi['idubi'].'" ';
							if($idsuc and $result1[0]['depende']==$dubi['idubi']){
								$txt .= "selected "; }
							$txt .= ' >'.$dubi['nombre'].'</option>';
						}
						$txt .= '</select>';
					$txt .= '</label>';
//************************7a Fila Cierre
//************************8a Fila Inicio (tr) Municipio REPINTARA (JS)
					$txt .= '</div><div class="cont2">';
					$txt .= '<label>Municipio:</label>';
					$txt .= '<BR>';
					$txt .= '<label>';
						$txt .= '<div id="reloadMun">';
						$txt .= '<select class="form-control" name="ubicas">';
						$txt .= '<option selected value ="0">Seleccione Municipio</option>';
						if($idsuc){
						$txt .='<option value="'.$result1[0]['ciusuc'].'" selected>'.$result1[0]['nombre'].'</option>';
						}
						$txt .= '</select>';
						$txt .= '</div>';
					$txt .= '</label>';
					$txt .= '<BR>';
					
//************************8a Fila Cierre

					$txt .= '<label>Telefono:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="varchar" name="telsuc" maxlength="50" value="';
					if($idsuc){ $txt .= $result1[0]["telsuc"]; }
				$txt .= '" required >';
				$txt .= '<BR>';


				$txt .= '<BR>';	
					//Insertamos el Boton Centrado
					$txt .= '<tr>';
					$txt .= '<th colspan="2" style="text-align: center;">';
						$txt .= '<input type="submit" class="btn btn-outline-primary" name="operacion" value="';
						if ($idsuc)
							$txt .= 'Actualizar';
						else
							$txt .= 'Insertar';
					$txt .= '" />';
					//Cierre Boton
					$txt .= '</tr>';
					$txt .= '<BR>';
					$txt .= '<BR>';
				$txt .= '</div>';
				$txt .= '</div>';
				$txt .= '</div>';
			//Cierre Formulario	
			$txt .= '</form>';
		//Cierre Etiqueta DIV	
		$txt .= '</div>';
		//Imprimimos el Formulario(Vista)
		echo $txt;
	}
	/*1.6. Creamos la funcion de nuestra vista (HTML) Listar_Registro*/

// 1.6. Creamos las FUNCION Y CODIGO TABAL para visualizar en (VISTA(vusu.php))

	function form_mostrar($conp,$nreg,$pg,$bo,$filtro,$arc,$pefedi,$pefeli){
		$msucursal = new msucursal();
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
			$txt .= '<input class="search-box" type="text" name="filtro" value="'.$filtro.'" placeholder="Nombre De Sucursal"
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
					$result = $msucursal->sel_sucursal($filtro,$pa->rvalini(),$pa->rvalfin());
				$txt .= "</td>";
			//Cierre Fila
			$txt .= "</tr>";
		$txt .= "</table>";
		
		if($result){
		$txt .= '<div class="cuad1" style="width: 90%; ">';
			$txt .= '<table1 width="100%" cellspacing="0px" align="center">';
							$txt .= "<table class='table table-hover'>";
				//Inicio de la (Cabecera_Tb)		
				$txt .= '<tr>';
					$txt .= '<th>';
						$txt .= 'Sucursal';
					$txt .= '</th>';
					$txt .= '<th></th>';
				$txt .= '</tr>';
				//Cierre de la (Cabecera_Tb)
				foreach ($result as $f) {
				//Inicio ROW - Datos de la tabla
				$txt .= '<tr>';
				$txt .= "<td class='active lefi'>";
						$txt .= "<span style='font-size: 20px;'><strong>".$f['nomsuc']."</strong></span>";
						$txt .= "<br><strong>Direccion: </strong>".$f['dirsuc'];
						$txt .= "<br><strong>Ciudad: </strong>".$f['ciusuc'];
						$txt .= "<br><strong>Telefono: </strong>".$f['telsuc'];
					$txt .= '</td>';
				
						//ICONOS-MOdificar (Boton)

					$txt .= "<td class='warning' align='center'>";
					$txt .= "<a href='home.php?pg=004&idsuc=".$f['idsuc']."'><ul class='social-icons icon-circle icon-zoom list-unstyled list-inline'><li><i class='fas fa-pen' title='Actualizar'></i></a></li></ul>";
					//ICONOS-Eliminar (Boton)
					$txt .= "<a href='home.php?pg=004&del=".$f['idsuc']."'><ul class='social-icons icon-circle icon-zoom list-unstyled list-inline'><li><i class='fas fa-times' title='Eliminar'></i></a></li></ul></td>";
				//Cierre ROW - Datos de la tabla
				$txt .= '</tr>';
				}
			$txt .= '</table>';
			$txt .= '<BR>';
					$txt .= '<BR>';
					$txt .= '<BR>';
		$txt .= '</div>';
		}else{
		$txt .= '<div class="cuad" style="width: 90%;">';
		$txt .= '<h3>No existen datos registrado en la base de datos...</h3>';
		$txt .= '</div>';		
	}
		echo $txt;
	}

?>