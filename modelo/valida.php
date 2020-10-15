<?PHP
	//2.1.2. Activo la varible de Sesion y invocamos nuestra conexio
	session_start();
	require_once('conexion.php');
	//2.1.3. Captura de dato (POST) en variables PHP

	$user= isset($_POST["user"])? $_POST["user"]:NULL;
	$pass= isset($_POST["pass"])? $_POST["pass"]:NULL;
	insper($user,$pass);
	//2.1.4. Creamos la funcion validacion de usuario y contraseña

	function insper($user,$pass){
	  if($user && $pass){
			//Incriptamos el campo ($pass en $pp)
			$pp = sha1(md5($pass));
			//Llamamos nuestro procedimiento almacenado
			$sql = "SELECT a. idusu, a.nomusu, a.tipusu,b.pefnom,b.pefbus,b.pefdes,b.pefedi,b.pefeli FROM usuario AS a INNER JOIN perfil AS b ON a.tipusu = b.pefid WHERE a.emausu=:user AND a.pasusu = :pass;";
			$modelo=new conexion();
			$conexion=$modelo->get_conexion();
			$result=$conexion->prepare($sql);
			//Enviamos los parametros de nuestra consulta
			$result->bindparam(':user',$user);
			$result->bindparam(':pass',$pp);
			if($result)
			//Ejecutamos la consulta
				$result->execute();
			while($f=$result->fetch()){
				$res[]=$f;
			}
			$res= isset($res) ? $res:NULL;
			//Verificamos la cant de registros encontrados
			$coutR = count($res);
			if($coutR==1){
				//Capturamos en variables de sesion los datos de nuestro usuario
				$_SESSION["idusu"] = $res[0]['idusu'];
				$_SESSION["nomusu"] = $res[0]['nomusu'];
				$_SESSION["pefid"] = $res[0]['tipusu'];
				$_SESSION["pefnom"] = $res[0]['pefnom'];
				$_SESSION["pefbus"] = $res[0]['pefbus'];
				$_SESSION["pefdes"] = $res[0]['pefdes'];
				$_SESSION["pefedi"] = $res[0]['pefedi'];
				$_SESSION["pefeli"] = $res[0]['pefeli'];
				$_SESSION["autentificado"] = '¿*-?¡--@';
				//Autorizamos el ingreso a (home.php=Mod_Admin)(HTML-JS)
				echo "<script type='text/javascript'>window.location='../home.php';</script>";	
			}else{
	

				//NO se Autorizara el ingreso a (home.php=Mod_Admin)
				session_destroy();
				echo "<script type='text/javascript'>window.location='../index.php?errorusuario=si';</script>";
			}	
		}
	}  
?>