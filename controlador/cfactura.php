<?php 
//1.2. Incluimos nuestra conexion y modelo 
require_once ("modelo/conexion.php");
require_once ("modelo/mfactura.php");
require_once('modelo/mpaginacion.php');
	//1.3. Instanciamos el modelo a variable php
$pg = 15;
	//variable $arc
$arc = "home.php";

	$mfactura = new mfactura();
	$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
	$idfac = isset($_POST['idfac']) ? $_POST['idfac']:NULL;
	if (!$idfac)
	$idfac = isset($_GET['idfac']) ? $_GET['idfac']:NULL;
	$idemp = isset($_POST['idemp']) ? $_POST['idemp']:NULL;
	$fechfac = isset($_POST['fechfac']) ? $_POST['fechfac']:NULL;
	$subtotal = isset($_POST['subtotal']) ? $_POST['subtotal']:NULL;
	$total = isset($_POST['total']) ? $_POST['total']:NULL;
	$ivafac = isset($_POST['ivafac']) ? $_POST['ivafac']:NULL;
	$cola = isset($_POST['cola']) ? $_POST['cola']:NULL;
	//capturamos la accion (C-U-D) metodo - POST(Form)
	$opera = isset($_POST['operacion']) ? $_POST['operacion']:NULL;
	$del = isset($_POST['del']) ? $_POST['del']:NULL;
	//capturamos la accion (C-U-D) metodo - GET(URL)
	$del = isset($_GET['del']) ? $_GET['del']:NULL;
	$opera = isset($_POST['operacion']) ? $_POST['operacion']:NULL;
	


	$bo = '';
	//Varible numero de registro a mostrar
	$nreg = 6;
	//Crea un objeto [pa] que se instanciar la clase [mpagina.php]
	$pa = new mpaginacion();
	$preg = $pa->mpagin($nreg);
	//Variable de cant_num_registros
	$conp = $mfactura->selcount($filtro);

// 1.6. Creamos las FUNCION Y CODIGO TABAL para visualizar en (VISTA(vusu.php))

	function form_mostrar($conp,$nreg,$pg,$bo,$filtro,$arc,$pefedi,$pefeli){
		$mfactura = new mfactura();
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
			$txt .= '<input class="search-box" type="text" name="filtro" value="'.$filtro.'" placeholder="Nombre De Factura"
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
					$result = $mfactura->sel_factura($filtro,$pa->rvalini(),$pa->rvalfin());
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
						$txt .= 'Factura';
					$txt .= '</th>';
					$txt .= '<th>';
						$txt .= 'Cola';
					$txt .= '</th>';
					$txt .= '<th></th>';
				$txt .= '</tr>';
				//Cierre de la (Cabecera_Tb)
				foreach ($result as $f) {
				//Inicio ROW - Datos de la tabla
				$txt .= '<tr>';
				$txt .= "<td class='active lefi'>";
						$txt .= "<span style='font-size: 20px;'><strong>".$f['idfac']." - ".$f['idemp']."</strong></span>";
						$txt .= "<br><strong>Fecha: </strong>".$f['fechfac'];
						$txt .= "<br><strong>Subtotal: </strong>".$f['subtotal'];
						$txt .= "<br><strong>Total: </strong>".$f['total'];
						$txt .= "<br><strong>Iva: </strong>".$f['ivafac'];
				$txt .= "</td>";
					$txt .= '<td align="center">';	
						$txt .= $f["cola"];
					$txt .= '</td>';
			
						//ICONOS-MOdificar (Boton)

					$txt .= "<td class='warning' align='center'>";
					$txt .= "<a href='home.php?pg=15&idfac=".$f['idfac']."'><ul class='social-icons icon-circle icon-zoom list-unstyled list-inline'><li><i class='fas fa-pen' title='Actualizar'></i></a></li></ul>";
					//ICONOS-Eliminar (Boton)
					$txt .= "<a href='home.php?pg=15&del=".$f['idfac']."'><ul class='social-icons icon-circle icon-zoom list-unstyled list-inline'><li><i class='fas fa-times' title='Eliminar'></i></a></li></ul></td>";
					
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