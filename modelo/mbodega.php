<?php 
class mbodega{

	function conectar(){//Función que nos conecta con la base de datos
		$modelo = new conexion();//Llamamos a la clase conexión dentro del archivo de conexion
		$conexion = $modelo->get_conexion();//Llamamos a la funcion que esta dentro de la clase antes mensionada
		return $conexion;//Devolvemos el resultado de la conexion
	}

	public function insbodega($nombod, $idsuc){//Para insertar 
		$conexion = $this->conectar();
		$sql="INSERT INTO bodega (nombod,idsuc) VALUES (:nombod,:idsuc);";//Consulta SQL
		$result=$conexion->prepare($sql);//Prepara nuestra consulta
		$result->bindParam(':nombod', $nombod);
		$result->bindParam(':idsuc', $idsuc);//Aseguramos los datos para evitar SQL-Injection
			if(!$result)
	  		echo "<script>alert('ERROR al insertar Bodega');</script>";
	  	else
	  	$result->execute();
	  		echo "<script>alert('Bodega registrado correctamente...');</script>";
		}


	public function updbodega($idbod, $nombod, $idsuc){//Funcion para actualizar
		$conexion = $this->conectar();
		$sql="UPDATE bodega SET idbod=:idbod, nombod=:nombod, idsuc=:idsuc WHERE idbod=:idbod";
		$result=$conexion->prepare($sql);
		//Reemplazo los parametro(PRECEDURE) por los recibidos desde el Controlador(funcion)
	 	$result->bindParam(':idbod',$idbod);
	 	$result->bindParam(':nombod', $nombod);
		$result->bindParam(':idsuc', $idsuc);//Aseguramos los datos para evitar SQL-Injection
		
		if(!$result)
			echo "<script>alert('Error al actualizar');</script>";
		else
			$result->execute();
			echo "<script>alert('Bodega Actualizado');</script>";
		}
	


	public function delbodega($idbod){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion(); 
		$sql = "DELETE idbod, nombod, idsuc FROM bodega WHERE idbod=:idbod;";
		$result = $conexion->prepare($sql);
		$result->bindParam(':idbod',$idbod);
		if(!$result)
			echo "<script>alert('Error al ELIMINAR');</script>";
		else
			$result->execute();
	}


	//1.3.5.1. Crear Funcion CARGA_DATOS [COMBOBOX]
	public function list_Sucursal(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idsuc, nomsuc FROM sucursal;";
		$result = $conexion->prepare($sql);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	//1.3.5.2. Crear Funcion Cargar datos de un usuario al formulario para (Actualizar)
	public function sel_bodega_act($idbod){
		$resultado1 = NULL;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idbod, nombod, idsuc FROM bodega WHERE idbod=:idbod;";
		$result1 = $conexion->prepare($sql);
		$result1->bindParam(':idbod',$idbod);
		$result1->execute();
		while ($f1=$result1->fetch()){
			$resultado1[]=$f1;
		}
		return $resultado1;
	}


	public function sel_bodega($filtro,$rvini,$rvfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion(); 
		$sql = 'SELECT idbod, nombod, idsuc FROM bodega';
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
		$sql = 'SELECT COUNT(idbod) AS Npe FROM bodega';
		if($filtro){
			$filtro = '%'.$filtro.'%';
			$sql .= ' WHERE nombod LIKE "'.$filtro.'";';
		}
		//echo $sql;
		return $sql;
	}

}
?>