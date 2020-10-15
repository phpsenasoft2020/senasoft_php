<?php 
//1.2. Incluimos nuestra conexion y modelo 
require_once ("modelo/conexion.php");
require_once ("modelo/mempresa.php");
require_once('modelo/mpaginacion.php');
	//1.3. Instanciamos el modelo a variable php
$pg = 2;
	//variable $arc
$arc = "home.php";

	$mempresa = new mempresa();
	$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
	$idemp   = isset($_POST['idemp']) ? $_POST['idemp']:NULL;
	if (!$idemp  )
	$idemp = isset($_GET['idemp']) ? $_GET['idemp']:NULL;
	$razsocialemp = isset($_POST['razsocialemp']) ? $_POST['razsocialemp']:NULL;
	$nitemp = isset($_POST['nitemp']) ? $_POST['nitemp']:NULL;
	$clasemp = isset($_POST['clasemp']) ? $_POST['clasemp']:NULL;
	$sedecentemp = isset($_POST['sedecentemp']) ? $_POST['sedecentemp']:NULL;
	$ciudemp = isset($_POST['ciudemp']) ? $_POST['ciudemp']:NULL;
	$emailemp  = isset($_POST['emailemp']) ? $_POST['emailemp']:NULL;
	$telemp = isset($_POST['telemp']) ? $_POST['telemp']:NULL;
	$logemp = isset($_POST['logemp']) ? $_POST['logemp']:NULL;
	//Creamos la variables de foto de tipo FILES (nomb_variable+(name[nomb_archivo]))
	$anexo = isset($_FILES["anexo"]['name']) ? $_FILES["anexo"]['name']:NULL;
	//capturamos la accion (C-U-D) metodo - POST(Form)
	$opera = isset($_POST['operacion']) ? $_POST['operacion']:NULL;
	$del = isset($_POST['del']) ? $_POST['del']:NULL;
	//capturamos la accion (C-U-D) metodo - GET(URL)
	$del = isset($_GET['del']) ? $_GET['del']:NULL;
	$opera = isset($_POST['operacion']) ? $_POST['operacion']:NULL;
	//1.4. Validamos el tipo de operacion (Accion (Evento_Vista))

	// 1.4. Validamos el tipo de operacion (Accion(Evento_Vista(User)))
	//Controlar del lado del Programador(Server) / NO Hacking (Vista/User)
	if($anexo AND $idemp){
		//Capturar el tamaño del archivo
		$docpes=round($_FILES["anexo"]['size']/2048,0);
		//La Var(temp) si guarda el archivo
		$temp=$_FILES['anexo']['tmp_name'];
		//La Var(docext) guarda la extencion del archivo
		$docext=pathinfo($_FILES["anexo"]['name'], PATHINFO_EXTENSION);
		//echo "<br><br>"."Peso: ".$docpes." Extencion: ".$docext."<br><br>";
		if($docpes<=2048 AND ($docext=="png" OR $docext=="jpg" OR $docext=="jpeg")){
		//echo "Con este archivo si podemos trabajar";
		$target_path = "foto/".$idemp.".".$docext;
	   //echo $target_path; 
		if(move_uploaded_file($_FILES['anexo']['tmp_name'], $target_path)){
		$foto = $target_path;
		echo "<script type='text/javascript'>alert('El archivo se ha cargado con exito');</script>";
	}
	}else{
		echo "<script type='text/javascript'>alert('Solo se permiten archivos de imagen tipo [png, jpeg o jppg] y su peso no puede exceder de 1024 Kb. Los datos del archivo seleccionado son: Tipo de archivo=".$docext." y tamaño= ".$docpes." Kb');</script>";
		//$foto = "";
	}

	}


	//1.4.1. Inserción
	if($opera=="Insertar"){
		//Validamos si la var(PHP) estan llenas y las enviamos al nuestro objeto -> metodo(parametros)
		if($razsocialemp AND $nitemp AND $eclasemp AND $sedecentemp AND $ciudemp AND $emailemp AND $telemp AND $logemp){
			$mempresa->insempresa($razsocialemp, $nitemp, $clasemp, $sedecentemp, $ciudemp, $emailemp, $telemp, $logemp);
		}
		$idemp ="";
		$opera ="";	
		$del ="";
	}
	//1.4.2. Actualizar
	if($opera=="Actualizar"){
		//Validamos si la var(PHP) estan llenas y las enviamos al nuestro objeto -> metodo(parametros)
		if($idemp AND $razsocialemp AND $nitemp AND $eclasemp AND $sedecentemp AND $ciudemp AND $emailemp AND $telemp AND $logemp){
			$mempresa->updempresa($idemp, $razsocialemp, $nitemp, $clasemp, $sedecentemp, $ciudemp, $emailemp, $telemp, $logemp);
		}	
		$idemp ="";
		$opera ="";
		$del ="";
	}
	//1.4.3. Eliminar
	if($del){		
		$mempresa->delempresa($idemp);
		$idemp ="";
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
	$conp = $mempresa->selcount($filtro);

	function form_registro($idemp){
	    $mempresa = new mempresa();
	    //Listamos nuetros perfiles(modulo)
		$result = $mempresa->list_Tipodeempresa();
		//Cargar los datos de nuestro user a atualizar(modulo)
		$result1 = $mempresa->sel_empresa_act($idemp);
		//Cargar los departamentos
		$datubi = $mempresa->selubi();

		$txt = '';
		$txt .= '<div class="cuad">';
		$txt .= '<div class="col-lg-12">';
		$txt .= '<div class="card mb-5 shadow-sm border-0 shadow-hover">';
		$txt .= '<div class="card-header bg-light border-0 pt-3 pb-0">';

			$txt .= '<form name="frm1" action="#" method="POST" enctype="multipart/form-data">';
			$txt .= '<div class="cont1">';
				$txt .= '<label>Nombre De Empresa:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="text" name="razsocialemp" maxlength="50" value="';
					if($idemp){ $txt .= $result1[0]["razsocialemp"]; }
				$txt .= '" required >';



				$txt .= '<BR>';
				$txt .= '<label>Nit:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="number" name="nitemp" max="999999999999" value="'.$idemp.'"/>';
				$txt .= '<BR>';


				$txt .= '<label>Tipo De Empresa:</label>';
				$txt .= '<BR>';
				$txt .= '<select class="form-control" name="idval">';
						foreach ($result as $f) {
							$txt .= '<option value="'.$f['idval'].'" ';
							if($f['idval'] and $f['idval']==$result[0]["idval"])
								$txt .="SELECTED";
							$txt .= ' >'.$f['nomval'].'</option>';
						}
						$txt .= '</select>';
			



				$txt .= '<BR>';
				$txt .= '<label>Direccion De Empresa:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="text" name="nitemp" maxlength="50" value="';
					if($idemp  ){ $txt .= $result1[0]["nitemp"]; }
				$txt .= '" required >';
				$txt .= '<BR>';


				$txt .= '<label>Sede Central:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="varchar" name="sedecentemp" maxlength="50" value="';
					if($idemp  ){ $txt .= $result1[0]["sedecentemp"]; }
				$txt .= '" required >';
				$txt .= '<BR>';

				$txt .= '</div><div class="cont2">';
				//************************7a Fila Inicio (tr) departament
				$txt .= '<label>Departamento:</label>';
				$txt .= '<BR>';	
						//Name:depto+evento[OnChenge]
						$txt .= '<label><select class="form-control" name="depto" onChange="javascript:recargarCiudades(this.value);">';
						foreach ($datubi as $dubi){
							$txt .= '<option  value="'.$dubi['idubi'].'" ';
							if($idemp and $result1[0]['depende']==$dubi['idubi']){
								$txt .= "selected "; }
							$txt .= ' >'.$dubi['nombre'].'</option>';
						}
						$txt .= '</select>';
					$txt .= '</label>';
					$txt .= '<BR>';
//************************7a Fila Cierre
//************************8a Fila Inicio (tr) Municipio REPINTARA (JS)
					
					$txt .= '<label>Municipio:</label>';
					$txt .= '<BR>';
					$txt .= '<label>';
						$txt .= '<div id="reloadMun">';
						$txt .= '<select class="form-control" name="ciudemp">';
						$txt .= '<option selected value ="0">Seleccione Municipio</option>';
						if($idemp){
						$txt .='<option value="'.$result1[0]['depende'].'" selected>'.$result1[0]['nombre'].'</option>';
						}
						$txt .= '</select>';
						$txt .= '</div>';
					$txt .= '</label>';
					$txt .= '<BR>';
					
//************************8a Fila Cierre

					$txt .= '<label>Correo:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="email" name="emailemp" maxlength="50" value="';
					if($idemp){ $txt .= $result1[0]["emailemp"]; }
				$txt .= '" required >';
				$txt .= '<BR>';


				$txt .= '<label>Telefono:</label>';
				$txt .= '<BR>';
				$txt .= '<input class="form-control" type="varchar" name="telemp" maxlength="50" value="';
					if($idemp){ $txt .= $result1[0]["telemp"]; }
				$txt .= '" required >';
				$txt .= '<BR>';


				//1raFilas (<tr>)
				$txt .= '<tr>';
					//1ra Cabeceras Negrita (<th>)
					$txt .= '<th align="left">';
						$txt .= 'Logo:';
					$txt .= '<BR>';
					$txt .= '</th>';
					//2da Cabecera normal (<td>)
					$txt .= '<td>';
					//
						$txt .= '<input type="file" name="anexo" accept="image/jpge, image/png">';
					$txt .= '</td>';
				$txt .= '<tr>';
			
				$txt .= '<BR>';	
				$txt .= '<BR>';	
				$txt .= '<BR>';	
					//Insertamos el Boton Centrado
					$txt .= '<tr>';
					$txt .= '<th colspan="2" style="text-align: center;">';
						$txt .= '<input type="submit" class="btn btn-outline-primary" name="operacion" value="';
						if ($idemp)
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
		$mempresa = new mempresa();
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
			$txt .= '<input class="search-box" type="text" name="filtro" value="'.$filtro.'" placeholder="Nombre De Empresa"
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
					$result = $mempresa->sel_empresa($filtro,$pa->rvalini(),$pa->rvalfin());
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
						$txt .= 'Foto';
					$txt .= '</th>';
					$txt .= '<th>';
						$txt .= 'Empresa';
					$txt .= '</th>';
					$txt .= '<th></th>';
				$txt .= '</tr>';
				//Cierre de la (Cabecera_Tb)
				foreach ($result as $f) {
				//Inicio ROW - Datos de la tabla
				$txt .= '<tr>';
					$txt .= '<td align="center">';
					$txt .= '<img src="'.$f['logemp'].'" width="25px" />';
					$txt .= '</td>';
					$txt .= "<td class='active lefi'>";
					$txt .= "<span style='font-size: 20px;'><strong>".$f['nitemp']." - ".$f['razsocialemp']."</strong></span>";
					$txt .= "<br><strong>Sede: </strong>".$f['sedecentemp'];
					$txt .= "<br><strong>Email: </strong>".$f['emailemp'];
					$txt .= "<br><strong>Telefono: </strong>".$f['telemp'];
					$txt .= "</td>";
						//ICONOS-MOdificar (Boton)
						$txt .= "<td class='warning' align='center'>";
						$txt .= "<a href='home.php?pg=002&idemp=".$f['idemp']."'><ul class='social-icons icon-circle icon-zoom list-unstyled list-inline'><li><i class='fas fa-pen' title='Actualizar'></i></li></ul></a>";
						//ICONOS-Eliminar (Boton)
						$txt .= "<a href='home.php?pg=002&del=".$f['idemp']."'><ul class='social-icons icon-circle icon-zoom list-unstyled list-inline'><li><i class='fas fa-times' title='Eliminar'></i></li></ul></td></a>";	
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