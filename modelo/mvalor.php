<?php 
class mvalor{

	function conectar(){//Función que nos conecta con la base de datos
		$modelo = new conexion();//Llamamos a la clase conexión dentro del archivo de conexion
		$conexion = $modelo->get_conexion();//Llamamos a la funcion que esta dentro de la clase antes mensionada
		return $conexion;//Devolvemos el resultado de la conexion
	}

	public function insvalor($idval, $nomval, $idparam){//Para insertar 
		$conexion = $this->conectar();
		$$sql="INSERT INTO valor (idval, nomval, idparam) VALUES (:idval, :nomval, :idparam);";//Consulta SQL
		$result=$conexion->prepare($sql);//Prepara nuestra consulta
		$result->bindParam(':idval', $idval);
		$result->bindParam(':nomval', $nomval);
		$result->bindParam(':idparam', $idparam);//Aseguramos los datos para evitar SQL-Injection
		if(!$result)
			echo "<script>alert('Error al registrar valor');</secript>";//Si hay errores no ejecuta y muestra mensaje alert en pantalla
		else{
			$result->execute();//Si no hay errores ingresa correctamente
			echo "<script>alert('valor registrado correctamente');</secript>";
		}
	}


	public function updvalor($idval, $nomval, $idparam){//Funcion para actualizar
		$conexion = $this->conectar();
		$sql="UPDATE valor SET idval=:idval, nomval=:nomval, idparam=:idparam WHERE idval=:idval";
		$result=$conexion->prepare($sql);
		//Reemplazo los parametro(PRECEDURE) por los recibidos desde el Controlador(funcion)
	 	$result->bindParam(':idval',$idval);
	 	$result->bindParam(':nomval', $nomval);
		$result->bindParam(':idparam', $idparam);//Aseguramos los datos para evitar SQL-Injection
		
		if(!$result)
			echo "<script>alert('Error al actualizar valor');</secript>";
		else{
			$result->execute();
			echo "<script>alert('valor actualizado correctamente');</secript>";
		}
	}
	


	public function delvalor($idval){//Función para eliminar
		$conexion = $this->conectar();
		$sql="DELETE FROM valor where idval=:idval;";
		$result=$conexion->prepare($sql);
		$result->bindparam(':idval',$idval);
		if(!$result)
			echo "<script>alert('Error al eliminar valor');</secript>";
		else {
			$result->execute();
			echo 'Ejecutado';
		}
	}


	public function selvalor($idval){//Función para buscar dentro de la base de datos
		$resultado= null;
		$conexion = $this->conectar();
		$sql="SELECT * FROM valor WHERE idval=:idval";
		$result=$conexion->prepare($sql);
		$result->execute();
		while($f=$result->fetch()){//Creación de un array con los resultados de la consulta
			$resultado[] = array(
				'idval' => $f['idval'],
				'nomval' => $f['nomval'], 
				'idparam' => $f['idparam']
			);//Creación del array con los resultados
		}
		echo json_encode($resultado);//Convertimos el array de la consulta a formato JSON
	}

}
?>