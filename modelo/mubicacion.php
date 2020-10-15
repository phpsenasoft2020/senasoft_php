<?php 
class mubicacion{

	function conectar(){//Función que nos conecta con la base de datos
		$modelo = new conexion();//Llamamos a la clase conexión dentro del archivo de conexion
		$conexion = $modelo->get_conexion();//Llamamos a la funcion que esta dentro de la clase antes mensionada
		return $conexion;//Devolvemos el resultado de la conexion
	}

	public function insubicacion($idubi,$nombre,$depende){//Para insertar 
		$idubi *= 100000;
		$conexion = $this->conectar();
		$sql="INSERT INTO ubicacion(idubi,nombre,depende) values (:idubi,:nombre,:depende);";//Consulta SQL
		$result=$conexion->prepare($sql);//Prepara nuestra consulta
		$result->bindparam(':idubi',$idubi);
		$result->bindparam(':nombre',$nombre);
		$result->bindparam(':depende',$depende);//Aseguramos los datos para evitar SQL-Injection
		if(!$result)
			echo "<script>alert('Error al registrar ubicacion');</secript>";//Si hay errores no ejecuta y muestra mensaje alert en pantalla
		else{
			$result->execute();//Si no hay errores ingresa correctamente
			echo "<script>alert('ubicacion registrado correctamente');</secript>";
		}
	}


	public function updubicacion($idubi,$nombre,$depende){//Funcion para actualizar
		$conexion = $this->conectar();
		$sql="UPDATE ubicacion SET nombre=:nombre,depende=:depende where idubi=:idubi;";
		$result=$conexion->prepare($sql);
		$result->bindparam(':idubi',$idubi);
		$result->bindparam(':nombre',$nombre);
		$result->bindparam(':depende',$depende);
		
		if(!$result)
			echo "<script>alert('Error al actualizar ubicacion');</secript>";
		else{
			$result->execute();
			echo "<script>alert('ubicacion actualizado correctamente');</secript>";
		}
	}
	


	public function delubicacion($idubi){//Función para eliminar
		$conexion = $this->conectar();
		$sql="DELETE FROM ubicacion where idubi=:idubi;";
		$result=$conexion->prepare($sql);
		$result->bindparam(':idubi',$idubi);
		if(!$result)
			echo "<script>alert('Error al eliminar ubicacion');</secript>";
		else {
			$result->execute();
			echo 'Ejecutado';
		}
	}

	public function selubicacion(){//Función para buscar dentro de la base de datos
		$resultado= null;
		$conexion = $this->conectar();
		$sql="SELECT d.idubi,d.nombre as muni,m.nombre as depto,d.depende FROM ubicacion as m INNER JOIN ubicacion AS d ON d.depende = m.idubi WHERE d.idubi < 100000";
		$result=$conexion->prepare($sql);
		$result->execute();
		while($f=$result->fetch()){//Creación de un array con los resultados de la consulta
			$resultado[] = array(
				'idubi' => $f['idubi'],
				'muni' => $f['muni'], 
				'depto' => $f['depto']
			);//Creación del array con los resultados
		}
		echo json_encode($resultado);//Convertimos el array de la consulta a formato JSON
	}

	public function selubi($fi){
		$resultado = null;
		$filtro = '%'.$fi.'%';
		$conexion = $this->conectar();
		$sql = "SELECT d.idubi,d.nombre as centro,m.nombre as muni,d.depende,c.nombre as depto FROM ubicacion as m INNER JOIN ubicacion AS d ON d.depende = m.idubi INNER JOIN ubicacion as c ON m.depende = c.idubi";
		if ($fi) $sql .= ' WHERE d.nombre LIKE :filtro';
		//echo $sql;
		$result=$conexion->prepare($sql);
		if ($fi) $result->bindParam(':filtro',$filtro);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[] = array(
				'idubi' => $f['idubi'],
				'centro' => $f['centro'],
				'muni' => $f['muni'], 
				'depto' => $f['depto']
			);
		}
		echo json_encode($resultado);
	}

	public function seleccionar($idubi){
		$conexion = $this->conectar();
		$sql = "SELECT d.idubi,d.nombre as centro,m.idubi as idmun,m.nombre as muni,d.depende,c.nombre as depto FROM ubicacion as m INNER JOIN ubicacion AS d ON d.depende = m.idubi INNER JOIN ubicacion as c ON m.depende = c.idubi WHERE d.idubi = :idubi";
		$result = $conexion->prepare($sql);
		$result->bindParam(':idubi',$idubi);
		$result->execute();
		while ($f=$result->fetch()){
			$resultado[] = array(
				'idubi' => $f['idubi'],
				'centro' => $f['centro'],
				'idmun' => $f['idmun'], 
			);
		}
		echo json_encode($resultado[0]);
	}



}
?>