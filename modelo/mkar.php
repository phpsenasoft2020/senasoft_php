<?php
class mkar{
	public function inskar($fecinikar, $fecfinkar, $idusu, $act){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "INSERT INTO kardex(fecinikar, fecfinkar, idusu, act) VALUES(:fecinikar, :fecfinkar, :idusu, :act);";
		$result = $conexion->prepare($sql);
		$result->bindParam(':fecinikar',$fecinikar);
		$result->bindParam(':fecfinkar',$fecfinkar);
		$result->bindParam(':idusu',$idusu);
		$result->bindParam(':act',$act);

		if(!$result)
			echo "<script>alert('Error al insertar');</script>";
		else
			$result->execute();
	}
	public function cerkar(){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "UPDATE kardex SET act='0';";
		$result = $conexion->prepare($sql);

		if(!$result)
			echo "<script>alert('Error al insertar');</script>";
		else
			$result->execute();
	}

	public function selkar($filtro,$rvalini,$rvalfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT k.idkar, k.fecinikar, k.fecfinkar, k.idusu, u.nomusu as empl, k.act FROM kardex AS k INNER JOIN usuario AS u ON k.idusu=u.idusu";
		if ($filtro){
	 	 	$sql .= " WHERE k.idkar=:filtro";
		}

		$sql .= " ORDER BY k.fecinikar ASC, k.idkar ASC LIMIT $rvalini, $rvalfin;";
		$result = $conexion->prepare($sql);
		if ($filtro)
			$result->bindParam(':filtro',$filtro);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function selidkar ($fecinikar, $fecfinkar, $idusu, $act){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT max(idkar) AS idka FROM kardex WHERE fecinikar=:fecinikar AND fecfinkar=:fecfinkar AND idusu=:idusu AND act=:act";
		echo $sql;
		$result = $conexion->prepare($sql);
		$result->bindParam(':fecinikar',$fecinikar);
		$result->bindParam(':fecfinkar',$fecfinkar);
		$result->bindParam(':idusu',$idusu);
		$result->bindParam(':act',$act);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function sqlcount($filtro){
		$sql="SELECT count(idkar) AS Npe FROM kardex";
		if ($filtro) 
			$sql .= " WHERE pefnom LIKE '%$filtro%';";
			return $sql;
	}

	public function selusu(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idusu, nomusu FROM usuario;";
		$result = $conexion->prepare($sql);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function delkar($idkar){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "DELETE FROM kardex WHERE idkar=:idkar;";
		$result = $conexion->prepare($sql);

		$result->bindParam(':idkar',$idkar);
		if(!$result)
			echo "<script>alert('Error al insertar');</script>";
		else
			$result->execute();
	}

	public function selkar1($idkar){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT k.idkar, k.fecinikar, k.fecfinkar, k.idusu, u.nomusu as empl, k.act FROM kardex AS k INNER JOIN usuario AS u ON k.idusu=u.idusu WHERE idkar=:idkar;";
		$result = $conexion->prepare($sql);
		$result->bindParam(':idkar',$idkar);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	public function selact(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idkar FROM kardex WHERE act=1;";
		$result = $conexion->prepare($sql);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}


//detalle de kardex
	public function insdekar($tipdkar, $fecdk, $obsdk, $cantdk, $idkar, $idprod){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "INSERT INTO detkar (tipdkar, fecdk, obsdk, cantdk, idkar, idprod) VALUES (:tipdkar, :fecdk, :obsdk, :cantdk, :idkar, :idprod);";
		$result = $conexion->prepare($sql);
		$result->bindParam(':tipdkar',$tipdkar);
		$result->bindParam(':fecdk',$fecdk);
		$result->bindParam(':obsdk',$obsdk);
		$result->bindParam(':cantdk',$cantdk);
		$result->bindParam(':idkar',$idkar);
		$result->bindParam(':idprod',$idprod);

		if(!$result)
			echo "<script>alert('Error al insertar');</script>";
		else
			$result->execute();
	}

	public function seldekar($idkar){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="SELECT DISTINCT d.idkar, d.idprod, m.nomprod, m.precioprod, m.cantprod FROM detkar AS d INNER JOIN producto AS m ON d.idprod=m.idprod WHERE d.idkar=:idkar ";
		//echo "<br><br><br><br><br>".$sql." '".$idkar."'<br>";
		$result=$conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idkar', $idkar);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function seldevalo($idprod,$idkar){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql = "SELECT d.tipdkar, SUM(d.cantdk) AS tot FROM detkar AS d INNER JOIN producto AS p ON d.idprod=p.idprod WHERE d.idprod = :idprod AND idkar=:idkar";
		$sql .= " GROUP BY d.idkar, d.idprod, p.nomprod, d.tipdkar";
	
		//echo "<br><br><br><br><br>".$sql." '".$idprod."'<br>";
		$result=$conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idprod', $idprod);
		$result->bindParam(':idkar', $idkar);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function sqlcountdk($idkar, $filtro){
		$sql="SELECT COUNT(DISTINCT d.idprod) AS Npe FROM detkar AS d INNER JOIN producto AS p ON d.idprod=p.idprod WHERE d.idkar='$idkar'";
		if($filtro){
			$sql .= "AND p.descripro LIKE '%$filtro%' ";
		}
		
		//echo $sql;
		return $sql;

	}

	public function selobsv($idkar,$idprod){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql = "SELECT CONCAT(tipdkar,' - ',obsdk) AS Obser FROM detkar WHERE idprod=:idprod AND idkar=:idkar AND tipdkar IN ('E','AE','S','AS')";
		//echo "<br><br><br><br><br>".$sql." '".$idprod."'<br>";
		$result=$conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idprod', $idprod);
		$result->bindParam(':idkar', $idkar);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}


	public function selpro(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT * FROM producto";
		$result = $conexion->prepare($sql);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function deldekar($iddekar){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL deldekar(:iddekar);";
		$result = $conexion->prepare($sql);

		$result->bindParam(':iddekar',$iddekar);
		if(!$result)
			echo "<script>alert('Error al insertar');</script>";
		else
			$result->execute();
	}

	public function seldekar1($iddekar){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT iddekar,tipdkar,fecdk,obsdk,cantdk,idkar,idprod FROM detkar WHERE iddekar=:iddekar;";
		$result = $conexion->prepare($sql);
		$result->bindParam(':iddekar',$iddekar);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	public function selmat(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idprod, nomprod, precioprod FROM producto";
		$result = $conexion->prepare($sql);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	public function exiprod($idprodd){
		$resultado1 = NULL;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT cantprod FROM producto WHERE idprod=:idprod;";
		$result = $conexion->prepare($sql);
		$result->bindParam(':idprod',$idprod);
		$result->execute();
		while ($f1=$result->fetch()){
			$resultado1[]=$f1;
		}
		return $resultado1;
	}
	public function actexiprod($cantprod,$idprod,$cant){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion(); 
		$sql = "UPDATE producto SET cantprod=(:cantprod+(:cant)) WHERE idprod=:idprod;";
		$result = $conexion->prepare($sql);
		$result->bindParam(':cantprod',$cantprod);
		$result->bindParam(':cant',$cant);
		$result->bindParam(':idprod',$idprod);
		if(!$result)
			echo "<script>alert('Error al actualizar');</script>";
		else
			$result->execute();
	}
	public function actexiprod1($cantprod,$idprod,$cant){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion(); 
		$sql = "UPDATE producto SET cantprod=(:cantprod-(:cant)) WHERE idprod=:idprod;";
		$result = $conexion->prepare($sql);
		$result->bindParam(':cantprod',$cantprod);
		$result->bindParam(':cant',$cant);
		$result->bindParam(':idprod',$idprod);
		if(!$result)
			echo "<script>alert('Error al actualizar');</script>";
		else
			$result->execute();
	}

}
?>