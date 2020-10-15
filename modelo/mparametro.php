<?php 
class mparametro{

	function conectar(){//Función que nos conecta con la base de datos
		$modelo = new conexion();//Llamamos a la clase conexión dentro del archivo de conexion
		$conexion = $modelo->get_conexion();//Llamamos a la funcion que esta dentro de la clase antes mensionada
		return $conexion;//Devolvemos el resultado de la conexion
	}

	public function insparametro($idparam, $nomparam){//Para insertar 
		$conexion = $this->conectar();
		$sql="INSERT INTO parametro (idparam, nomparam) VALUES (:idparam, :nomparam);";//Consulta SQL
		$result=$conexion->prepare($sql);//Prepara nuestra consulta
		$result->bindParam(':idparam', $idparam);
		$result->bindParam(':nomparam', $nomparam);//Aseguramos los datos para evitar SQL-Injection
		if(!$result)
			echo "<script>alert('Error al registrar parametro');</secript>";//Si hay errores no ejecuta y muestra mensaje alert en pantalla
		else{
			$result->execute();//Si no hay errores ingresa correctamente
			echo "<script>alert('parametro registrado correctamente');</secript>";
		}
	}


	public function updparametro($idparam, $nomparam){//Funcion para actualizar
		$conexion = $this->conectar();
		$sql="UPDATE parametro SET idparam=:idparam, nomparam=:nomparam WHERE idparam=:idparam";
		$result=$conexion->prepare($sql);
		//Reemplazo los parametro(PRECEDURE) por los recibidos desde el Controlador(funcion)
	 	$result->bindParam(':idparam',$idparam);
	 	$result->bindParam(':nomparam', $nomparam);//Aseguramos los datos para evitar SQL-Injection
		
		if(!$result)
			echo "<script>alert('Error al actualizar parametro');</secript>";
		else{
			$result->execute();
			echo "<script>alert('parametro actualizado correctamente');</secript>";
		}
	}
	


	public function delparametro($idparam){//Función para eliminar
		$conexion = $this->conectar();
		$sql="DELETE FROM parametro where idparam=:idparam;";
		$result=$conexion->prepare($sql);
		$result->bindparam(':idparam',$idparam);
		if(!$result)
			echo "<script>alert('Error al eliminar parametro');</secript>";
		else {
			$result->execute();
			echo 'Ejecutado';
		}
	}


	public function selparametro($idparam){//Función para buscar dentro de la base de datos
		$resultado= null;
		$conexion = $this->conectar();
		$sql="SELECT * FROM parametro WHERE idparam=:idparam";
		$result=$conexion->prepare($sql);
		$result->execute();
		while($f=$result->fetch()){//Creación de un array con los resultados de la consulta
			$resultado[] = array(
				'idparam' => $f['idparam'],
				'nomparam' => $f['nomparam']
			);//Creación del array con los resultados
		}
		echo json_encode($resultado);//Convertimos el array de la consulta a formato JSON
	}

}
?>