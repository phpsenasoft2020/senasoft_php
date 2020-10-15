<?php 
//1.2. Incluimos nuestra conexion y modelo 
require_once ("modelo/conexion.php");
require_once ("modelo/mbodega.php");
require_once('modelo/mpaginacion.php');
	//1.3. Instanciamos el modelo a variable php
$pg = 6;
	//variable $arc
$arc = "home.php";

	$mbodega = new mbodega();
	$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
	$idbod = isset($_POST['idbod']) ? $_POST['idbod']:NULL;
	if (!$idbod)
		$idbod = isset($_GET['idbod']) ? $_GET['idbod']:NULL;
	$nombod = isset($_POST['nombod']) ? $_POST['nombod']:NULL;
	$idsuc = isset($_POST['idsuc']) ? $_POST['idsuc']:NULL;
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
		if($nombod AND $idsuc){
			$mbodega->insbodega($nombod, $idsuc);
		}
		$idbod ="";
		$opera ="";	
		$del ="";
	}
	//1.4.2. Actualizar
	if($opera=="Actualizar"){

		//Validamos si la var(PHP) estan llenas y las enviamos al nuestro objeto -> metodo(parametros)
		if($idbod AND $nombod AND $idsuc){
			$mbodega->updbodega($idbod, $nombod, $idsuc);
		}	
		$idbod ="";
		$opera ="";
		$del ="";
	}
	//1.4.3. Eliminar
	if($del){		
		$mbodega->delbodega($idbod);
		$idbod ="";
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
	$conp = $mbodega->selcount($filtro);

	function form_registro($idbod){
	    $mbodega = new mbodega();
	    //Listamos nuetros Sucursales(modulo)
		$result = $mbodega->list_Sucursal();
		//Cargar los datos de nuestro user a atualizar(modulo)
		$result1 = $mbodega->sel_bodega_act($idbod);

		$txt = '';
		$txt .= '<div class="cuad">';
		$txt .= '<div class="col-lg-12">';
		$txt .= '<div class="card mb-5 shadow-sm border-0 shadow-hover">';
		$txt .= '<div class="card-header bg-light border-0 pt-3 pb-0">';

			$txt .= '<form name="frm1" action="#" method="POST" enctype="multipart/form-data">';

			
				
				$txt .= '<label>Nombre De Bodega:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="text" name="nombod" maxlength="50" value="';
					if($idbod){ $txt .= $result1[0]["nombod"]; }
				$txt .= '" required >';
				$txt .= '<BR>';



				$txt .= '<label>Id Sucursal:</label>';
				$txt .= '<BR>';
				$txt .= '<select class="form-control" name="idsuc">';
						foreach ($result as $f) {
							$txt .= '<option value="'.$f['idsuc'].'" ';
							if($f['idsuc'] and $f['idsuc']==$result[0]["idsuc"])
								$txt .="SELECTED";
							$txt .= ' >'.$f['nomsuc'].'</option>';
						}
						$txt .= '</select>';
				$txt .= '<BR>';

			
				$txt .= '<BR>';	
					//Insertamos el Boton Centrado
					$txt .= '<tr>';
					$txt .= '<th colspan="2" style="text-align: center;">';
						$txt .= '<input type="submit" class="btn btn-outline-primary" name="operacion" value="';
						if ($idbod)
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
		$mbodega = new mbodega();
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
			$txt .= '<input class="search-box" type="text" name="filtro" value="'.$filtro.'" placeholder="Nombre De Bodega"
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
					$result = $mbodega->sel_bodega($filtro,$pa->rvalini(),$pa->rvalfin());
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
						$txt .= 'Nombre De Bodega';
					$txt .= '</th>';
					$txt .= '<th>';
						$txt .= 'Sucursal A La Que Pertenece';
					$txt .= '</th>';
					$txt .= '<th></th>';
				$txt .= '</tr>';
				//Cierre de la (Cabecera_Tb)
				foreach ($result as $f) {
				//Inicio ROW - Datos de la tabla
				$txt .= '<tr>';
					$txt .= '<td class="centrado" align="center">';	
						$txt .= $f["nombod"];
					$txt .= '</td>';
					$txt .= '<td class="centrado" align="center">';	
					$txt .= "<h8>".$f['idsuc']."</h8>";

					$txt .= '</td>';
				
						//ICONOS (Boton)
						$txt .= "<td class='warning' align='center'>";
						$txt .= "<a href='home.php?pg=6&idbod=".$f['idbod']."'><ul class='social-icons icon-circle icon-zoom list-unstyled list-inline'><li><i class='fas fa-pen' title='Actualizar'></i></li></ul></a>";
						$txt .= '<script src="js/eliminar.js"></script>';
						$txt .= "<a href='home.php?pg=006&del=".$f['idbod']."'><ul class='social-icons icon-circle icon-zoom list-unstyled list-inline'><li><i class='fas fa-times' title='Eliminar'></i></li></ul></td></a>";	
						$txt .= "</td>";	
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