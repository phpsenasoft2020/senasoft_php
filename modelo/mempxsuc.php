<?php 
class mempxsuc{

	function conectar(){//Función que nos conecta con la base de datos
		$modelo = new conexion();//Llamamos a la clase conexión dentro del archivo de conexion
		$conexion = $modelo->get_conexion();//Llamamos a la funcion que esta dentro de la clase antes mensionada
		return $conexion;//Devolvemos el resultado de la conexion
	}

	public function insempxsuc($idemp, $idsuc, $idusu){//Para insertar 
		$conexion = $this->conectar();
		$sql="INSERT INTO empsuc(idemp,idsuc,idusu) VALUES (:idemp, :idsuc, :idusu);";//Consulta SQL
		$result=$conexion->prepare($sql);//Prepara nuestra consulta
		$result->bindParam(':idemp', $idemp);
		$result->bindParam(':idsuc', $idsuc);
		$result->bindParam(':idusu', $idusu);//Aseguramos los datos para evitar SQL-Injection
			if(!$result)
	  		echo "<script>alert('ERROR al asignar empleado');</script>";
	  	else
	  	$result->execute();
	  		echo "<script>alert('Empleado asignado correctamente...');</script>";
		}


	public function updempxsuc($idemp, $idsuc, $idusu){//Funcion para actualizar
		$conexion = $this->conectar();
		$sql="UPDATE empsuc SET idemp=:idemp, idsuc=:idsuc idusu=:idusu WHERE idemp=:idemp";
		$result=$conexion->prepare($sql);
		//Reemplazo los parametro(PRECEDURE) por los recibidos desde el Controlador(funcion)
	 	$result->bindParam(':idemp', $idemp);
		$result->bindParam(':idsuc', $idsuc);
		$result->bindParam(':idusu', $idusu);//Aseguramos los datos para evitar SQL-Injection
		
		if(!$result)
			echo "<script>alert('Error al actualizar');</script>";
		else
			$result->execute();
			echo "<script>alert('Empleado Actualizado');</script>";
		}
	


	public function delempxsuc($idemp){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion(); 
		$sql = "DELETE idemp, idsuc, idusu FROM empsuc WHERE idemp=:idemp;";
		$result = $conexion->prepare($sql);
		$result->bindParam(':idemp',$idemp);
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


	//1.3.5.1. Crear Funcion CARGA_DATOS [COMBOBOX]
	public function list_Empleado(){
		$resultado2 = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idusu, nomusu FROM usuario;";
		$result2 = $conexion->prepare($sql);
		$result2->execute();
		while($f=$result2->fetch()){
			$resultado2[]=$f;
		}
		return $resultado2;
	}

	//1.3.5.1. Crear Funcion CARGA_DATOS [COMBOBOX]
	public function list_Empresa(){
		$resultado3 = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idemp, razsocialemp FROM empresa;";
		$result3 = $conexion->prepare($sql);
		$result3->execute();
		while($f=$result3->fetch()){
			$resultado3[]=$f;
		}
		return $resultado3;
	}

	//1.3.5.2. Crear Funcion Cargar datos de un usuario al formulario para (Actualizar)
	public function sel_empxsuc_act($idemp){
		$resultado1 = NULL;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idemp, idsuc, idusu FROM empsuc WHERE idemp=:idemp;";
		$result1 = $conexion->prepare($sql);
		$result1->bindParam(':idemp',$idemp);
		$result1->execute();
		while ($f1=$result1->fetch()){
			$resultado1[]=$f1;
		}
		return $resultado1;
	}


	public function sel_empxsuc($filtro,$rvini,$rvfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion(); 
		$sql = 'SELECT idemp,idsuc,idusu FROM empsuc';
		if($filtro){
			$filtro = '%'.$filtro.'%';
			$sql .= ' WHERE idemp LIKE :filtro';
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
		$sql = 'SELECT COUNT(idusu) AS Npe FROM empsuc';
		if($filtro){
			$filtro = '%'.$filtro.'%';
			$sql .= ' WHERE idusu LIKE "'.$filtro.'";';
		}
		//echo $sql;
		return $sql;
	}

}
?>
