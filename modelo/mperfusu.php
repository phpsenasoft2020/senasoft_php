<?php
class musu{
	public function usuins($nomusu, $apeusu, $tipdocusu, $nodocusu, $dirusu, $ciudusu, $telusu, $celusu, $emausu, $pasusu, $fechnac){
 		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="INSERT INTO usuario(nomusu, apeusu, tipdocusu, nodocusu, dirusu, ciudusu, telusu, celusu, emausu, pasusu, fechnac) VALUES (:nomusu, :apeusu, :tipdocusu, :nodocusu, :dirusu, :ciudusu, :telusu, :celusu, :emausu, :pasusu, :fechnac);";
		//echo "<br><br><br><br>".$sql."<br>'".$idusu."','".$nodocemp."','".$nomemp."','".$pefid."','".$pass."','".$diremp."','".$telemp."','".$actemp."'<br>";
		$result=$conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':nomusu', $nomusu);
		$result->bindParam(':apeusu', $apeusu);
		$result->bindParam(':tipdocusu', $tipdocusu);
		$result->bindParam(':nodocusu', $nodocusu);
		$result->bindParam(':dirusu', $dirusu);
		$result->bindParam(':ciudusu', $ciudusu);
		$result->bindParam(':telusu', $telusu);
		$result->bindParam(':celusu', $celusu);
		$result->bindParam(':emausu', $emausu);
		$result->bindParam(':pasusu', $pasusu);
		$result->bindParam(':fechnac', $fechnac);

		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR')</script>";
		else
			$result->execute();
	}

	public function selusu($filtro,$rvalini,$rvalfin){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="SELECT u.idusu, u.nomusu, u.apeusu, u.tipdocusu, pe.pefnom, u.nodocusu, u.dirusu, u.ciudusu, u.telusu, u.celusu, u.emausu, u.pasusu, u.actusu, u.idsuc, u.tipusu, u.fechnac, CURDATE() AS hoy,
		TIMESTAMPDIFF(YEAR, fechnac, CURDATE()) AS edaemp FROM usuario AS u INNER JOIN perfil AS pe ON u.tipusu = pe.pefid";
		if ($filtro){
			$filtro = "%".$filtro."%";
			$sql .= " WHERE u.nomusu LIKE :filtro OR u.nodocusu LIKE :filtro";
		}
		$sql .= " ORDER BY u.idusu LIMIT $rvalini, $rvalfin;";
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
		$sql="SELECT count(u.idusu) AS Npe FROM usuario AS u INNER JOIN perfil AS pe ON u.tipusu = pe.pefid";
		if ($filtro) 
			$sql .= " WHERE u.nomusu LIKE '%$filtro%' OR u.nodocusu LIKE '%$filtro%';";
		return $sql;
	}

	public function selusu1($idusu){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();

		$sql="SELECT idusu, nomusu, apeusu, tipdocusu, nodocusu, dirusu, ciudusu, telusu, celusu, emausu, pasusu, actusu, idsuc, tipusu, fechnac, CURDATE() AS hoy,
		TIMESTAMPDIFF(YEAR, fechnac, CURDATE()) AS edaemp FROM usuario WHERE idusu=:idusu";
		//echo $sql;
		$result=$conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$result->bindParam(':idusu', $idusu);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function updusu($idusu,$nomusu,$apeusu,$tipdocusu,$nodocusu,$dirusu,$ciudusu,$telusu,$celusu,$emausu,$pasusu,$fechnac){
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		if($pasusu)
			$sql="UPDATE usuario SET nomusu=:nomusu, apeusu=:apeusu, tipdocusu=:tipdocusu, nodocusu=:nodocusu, dirusu=:dirusu, ciudusu=:ciudusu, telusu=:telusu, celusu=:celusu, emausu=:emausu, pasusu=:pasusu, fechnac=:fechnac WHERE idusu=:idusu";
		else
			$sql="UPDATE usuario SET nomusu=:nomusu, apeusu=:apeusu, tipdocusu=:tipdocusu, nodocusu=:nodocusu, dirusu=:dirusu, ciudusu=:ciudusu, telusu=:telusu, celusu=:celusu, emausu=:emausu, fechnac=:fechnac WHERE idusu=:idusu";

		$result=$conexion->prepare($sql);
		$result->bindParam(':idusu', $idusu);
		$result->bindParam(':nomusu', $nomusu);
		$result->bindParam(':apeusu', $apeusu);
		$result->bindParam(':tipdocusu', $tipdocusu);
		$result->bindParam(':nodocusu', $nodocusu);
		$result->bindParam(':dirusu', $dirusu);
		$result->bindParam(':ciudusu', $ciudusu);
		$result->bindParam(':telusu', $telusu);
		$result->bindParam(':celusu', $celusu);
		$result->bindParam(':emausu', $emausu);
		$result->bindParam(':fechnac', $fechnac);
		if($pasusu)
			$result->bindParam(':pasusu', $pasusu);

		if(!$result)
			echo "<script>alert('ERROR AL MODIFICAR')</script>";
		else
			$result->execute();
	}

	public function selperf(){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();

		$sql="SELECT * FROM perfil";
		//echo $sql;
		$result=$conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function seltip(){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();

		$sql="SELECT idval, nomval, idparam FROM valor WHERE idparam=1";
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