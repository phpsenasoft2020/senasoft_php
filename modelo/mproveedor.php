<?php 
class mproveedor{

	function conectar(){//Función que nos conecta con la base de datos
		$modelo = new conexion();//Llamamos a la clase conexión dentro del archivo de conexion
		$conexion = $modelo->get_conexion();//Llamamos a la funcion que esta dentro de la clase antes mensionada
		return $conexion;//Devolvemos el resultado de la conexion
	}

	public function insproveedor($idprov, $nomprov, $telprov, $celprov, $emailprov){//Para insertar 
		$conexion = $this->conectar();
		$$sql="INSERT INTO proveedor (idprov, nomprov, telprov, celprov, emailprov) VALUES (:idprov, :nomprov, :telprov, :celprov, :emailprov);";//Consulta SQL
		$result=$conexion->prepare($sql);//Prepara nuestra consulta
		$result->bindParam(':idprov', $idprov);
		$result->bindParam(':nomprov', $nomprov);
		$result->bindParam(':telprov', $telprov);
		$result->bindParam(':celprov', $celprov);
		$result->bindParam(':emailprov', $emailprov);//Aseguramos los datos para evitar SQL-Injection
		if(!$result)
			echo "<script>alert('Error al registrar proveedor');</secript>";//Si hay errores no ejecuta y muestra mensaje alert en pantalla
		else{
			$result->execute();//Si no hay errores ingresa correctamente
			echo "<script>alert('proveedor registrado correctamente');</secript>";
		}
	}


	public function updproveedor($idprov, $nomprov, $telprov, $celprov, $emailprov){//Funcion para actualizar
		$conexion = $this->conectar();
		$sql="UPDATE proveedor SET idprov=:idprov, nomprov=:nomprov, telprov=:telprov, celprov=:celprov, emailprov=:emailprov WHERE idprov=:idprov";
		$result=$conexion->prepare($sql);
		//Reemplazo los parametro(PRECEDURE) por los recibidos desde el Controlador(funcion)
	 	$result->bindParam(':idprov',$idprov);
	 	$result->bindParam(':nomprov', $nomprov);
		$result->bindParam(':telprov', $telprov);
		$result->bindParam(':celprov', $celprov);
		$result->bindParam(':emailprov', $emailprov);//Aseguramos los datos para evitar SQL-Injection
		
		if(!$result)
			echo "<script>alert('Error al actualizar proveedor');</secript>";
		else{
			$result->execute();
			echo "<script>alert('proveedor actualizado correctamente');</secript>";
		}
	}
	


	public function delproveedor($idprov){//Función para eliminar
		$conexion = $this->conectar();
		$sql="DELETE FROM proveedor where idprov=:idprov;";
		$result=$conexion->prepare($sql);
		$result->bindparam(':idprov',$idprov);
		if(!$result)
			echo "<script>alert('Error al eliminar proveedor');</secript>";
		else {
			$result->execute();
			echo 'Ejecutado';
		}
	}


	public function selproveedor($idprov){//Función para buscar dentro de la base de datos
		$resultado= null;
		$conexion = $this->conectar();
		$sql="SELECT * FROM proveedor WHERE idprov=:idprov";
		$result=$conexion->prepare($sql);
		$result->execute();
		while($f=$result->fetch()){//Creación de un array con los resultados de la consulta
			$resultado[] = array(
				'idprov' => $f['idprov'],
				'nomprov' => $f['nomprov'], 
				'telprov' => $f['telprov'],
				'celprov' => $f['celprov'],
				'emailprov' => $f['emailprov']
			);//Creación del array con los resultados
		}
		echo json_encode($resultado);//Convertimos el array de la consulta a formato JSON
	}

}
?>