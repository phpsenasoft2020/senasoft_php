<?php
class mubi{
//$codubi,$nomubi,$depubi
	public function insubi($codubi,$nomubi, $depubi){
 		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="CALL ubiins(:codubi,:nomubi,:depubi)";
		//echo $sql;
		$result=$conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':codubi', $codubi);
		$result->bindParam(':nomubi', $nomubi);
		$result->bindParam(':depubi', $depubi);

		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR')</script>";
		else
			$result->execute();
	}

	public function selubi($filtro,$rvalini,$rvalfin){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="SELECT  c.codubi, c.nomubi AS ciu, d.nomubi AS dep FROM ubicacion AS c INNER JOIN ubicacion AS d ON c.depubi=d.codubi";
		if ($filtro){
			$filtro = "%".$filtro."%";
			$sql .= " WHERE c.nomubi LIKE :filtro";
		}
		$sql .= " ORDER BY c.codubi LIMIT $rvalini, $rvalfin;";
		//echo $sql;
		$result=$conexion->prepare($sql);

		$result->bindParam(':filtro', $filtro);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function sqlcount($filtro){
		$sql="SELECT count(c.codubi) AS Npe FROM ubicacion AS c INNER JOIN ubicacion AS d ON c.depubi=d.codubi";
		if ($filtro) 
			$sql .= " WHERE c.nomubi LIKE '%$filtro%';";
		return $sql;
	}

	public function selubi1($codubi){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();

		$sql="SELECT * FROM ubicacion WHERE codubi=:codubi";
		//echo $sql;
		$result=$conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$result->bindParam(':codubi', $codubi);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function updubi($codubi,$nomubi, $depubi){
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="CALL ubiupd(:codubi,:nomubi,:depubi)";
		$result=$conexion->prepare($sql);
		$result->bindParam(':codubi', $codubi);
		$result->bindParam(':nomubi', $nomubi);
		$result->bindParam(':depubi', $depubi);

		if(!$result)
			echo "<script>alert('ERROR AL MODIFICAR')</script>";
		else
			$result->execute();
	}

	public function eliubi($codubi){
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="CALL ubidel(:codubi)";
		//echo "<br><br><br>".$sql."   '".$codubi."'<br><br>";
		$result=$conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':codubi', $codubi);

		if (!$result)
			echo "<script>alert('ERROR AL ELIMINAR')</script>";
		else
			$result->execute();
	}

	public function seldep(){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();

		$sql="SELECT c.codubi, c.nomubi AS ciu FROM ubicacion AS c WHERE depubi='0' ORDER BY c.nomubi";
		//echo $sql;
		$result=$conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
}
?>