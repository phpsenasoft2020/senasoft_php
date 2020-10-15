<?php 
class mfactura{

	function conectar(){//Función que nos conecta con la base de datos
		$modelo = new conexion();//Llamamos a la clase conexión dentro del archivo de conexion
		$conexion = $modelo->get_conexion();//Llamamos a la funcion que esta dentro de la clase antes mensionada
		return $conexion;//Devolvemos el resultado de la conexion
	}



	//1.3.5.2. Crear Funcion Cargar datos de un usuario al formulario para (Actualizar)
	public function sel_factura_act($idfac){
		$resultado1 = NULL;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idfac, idemp, fechfac, subtotal, total, ivafac, cola FROM factura WHERE idfac=:idfac;";
		$result1 = $conexion->prepare($sql);
		$result1->bindParam(':idfac',$idfac);
		$result1->execute();
		while ($f1=$result1->fetch()){
			$resultado1[]=$f1;
		}
		return $resultado1;
	}


	public function sel_factura($filtro,$rvini,$rvfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion(); 
		$sql = 'SELECT idfac, idemp, fechfac, subtotal, total, ivafac, cola FROM factura';
		if($filtro){
			$filtro = '%'.$filtro.'%';
			$sql .= ' WHERE nombod LIKE :filtro';
		}
		$sql .= ' LIMIT '.$rvini.', '.$rvfin.';';
		$result = $conexion->prepare($sql);
		if($filtro){
			$result->bindParam(':filtro',$filtro);
		}
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function selcount($filtro){
		$sql = 'SELECT COUNT(idfac) AS Npe FROM factura';
		if($filtro){
			$filtro = '%'.$filtro.'%';
			$sql .= ' WHERE idfac LIKE "'.$filtro.'";';
		}
		//echo $sql;
		return $sql;
	}

}
?>