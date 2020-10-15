<?php 
class mcon{
	public function insconf($nit, $nomemp, $dircon, $mosdir, $telcon, $mostel, $celcon, $moscel, $emacon, $mosema, $logocon,$consen){
 		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="CALL confins(:nit, :nomemp, :dircon, :mosdir, :telcon, :mostel, :celcon, :moscel, :emacon, :mosema, :logocon, :consen)";
		//echo $sql;
		$result=$conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':nit', $nit);
		$result->bindParam(':nomemp', $nomemp);
		$result->bindParam(':dircon', $dircon);
		$result->bindParam(':mosdir', $mosdir);
		$result->bindParam(':telcon', $telcon);
		$result->bindParam(':mostel', $mostel);
		$result->bindParam(':celcon', $celcon);
		$result->bindParam(':moscel', $moscel);
		$result->bindParam(':emacon', $emacon);
		$result->bindParam(':mosema', $mosema);
		$result->bindParam(':logocon', $logocon);
		$result->bindParam(':consen', $consen);

		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR')</script>";
		else
			$result->execute();
	}

	public function selpag($filtro,$rvalini,$rvalfin){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="SELECT idconf, nit, nomemp, dircon, mosdir, telcon, mostel, celcon, moscel, emacon, mosema, logocon, consen FROM configuracion";
		if ($filtro){
			$filtro = "%".$filtro."%";
			$sql .= " WHERE nomemp LIKE :filtro";
		}
		$sql .= " ORDER BY idconf LIMIT $rvalini, $rvalfin;";
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
		$sql="SELECT count(idconf) AS Npe FROM configuracion";
		if ($filtro) 
			$sql .= " WHERE nomemp LIKE '%$filtro%';";
		return $sql;
	}

	public function selconf1($idconf,$para=1){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();

		if($para==1){
			$sql=" SELECT * FROM configuracion WHERE idconf=:idconf";
		}else{
			$sql=" SELECT logocon FROM configuracion WHERE idconf=:idconf";
		}

		//echo $sql;
		$result=$conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$result->bindParam(':idconf', $idconf);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function selconf5(){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="SELECT idconf, nit, nomemp, dircon, mosdir, telcon, mostel, celcon, moscel, emacon, mosema, logocon, consen, consen FROM configuracion";
		$sql .= " ORDER BY idconf LIMIT 0,10;";
		//echo $sql;
		$result=$conexion->prepare($sql);

		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function updconf($idconf,$nit, $nomemp, $dircon, $mosdir, $telcon, $mostel, $celcon, $moscel, $emacon, $mosema, $logocon,$consen){
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="CALL confupd(:idconf,:nit, :nomemp, :dircon, :mosdir, :telcon, :mostel, :celcon, :moscel, :emacon, :mosema, :logocon, :consen)";
		$result=$conexion->prepare($sql);
		
		$result->bindParam(':idconf', $idconf);
		$result->bindParam(':nit', $nit);
		$result->bindParam(':nomemp', $nomemp);
		$result->bindParam(':dircon', $dircon);
		$result->bindParam(':mosdir', $mosdir);
		$result->bindParam(':telcon', $telcon);
		$result->bindParam(':mostel', $mostel);
		$result->bindParam(':celcon', $celcon);
		$result->bindParam(':moscel', $moscel);
		$result->bindParam(':emacon', $emacon);
		$result->bindParam(':mosema', $mosema);
		$result->bindParam(':logocon', $logocon);
		$result->bindParam(':consen', $consen);

		if(!$result)
			echo "<script>alert('ERROR AL MODIFICAR')</script>";
		else
			$result->execute();
	}

	public function seltipd(){
		$resultado=null;
		$modelo=new conexion();
		$conexion=$modelo->get_conexion();
		$sql="SELECT idconf, nit, nomemp, dircon, mosdir, telcon, mostel, celcon, moscel, emacon, mosema, logocon, consen FROM configuracion WHERE idconf='0';";
		//echo $sql;
		$result=$conexion->prepare($sql);

		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
}
?>