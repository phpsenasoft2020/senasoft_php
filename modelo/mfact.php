<?php
    class mfact{
        function conectar(){//Función que nos conecta con la base de datos
            $modelo = new conexion();//Llamamos a la clase conexión dentro del archivo de conexion
            $conexion = $modelo->get_conexion();//Llamamos a la funcion que esta dentro de la clase antes mensionada
            return $conexion;//Devolvemos el resultado de la conexion
        }
        public function seleccionar($id){
            $conexion = $this->conectar();
            $sql="SELECT c.idprod,a.nomprod,a.precioprod,a.cantprod,a.unidprod FROM detalle_factura as c INNER JOIN producto as a ON c.idprod = a.idprod WHERE c.idfac = :id";
            $result = $conexion->prepare($sql);
            $result->bindParam(':id',$id);
            $result->execute();
            while($f=$result->fetch()){
                $resultado[] = array(
                    'idprod' => $f['idprod'],
                    'nombre' => $f['nomprod'], 
                    'precio' => $f['precioprod'],
                    'cant' => $f['cantprod'],
                    'unid' => $f['unidprod']                
                );//Creación del array con los resultados
            }
            echo json_encode($resultado);
        }

        public function insertar($idemp,$subtotal,$iva,$total,$cola){//Para insertar 
            $conexion = $this->conectar();
            $sql="INSERT INTO factura(idemp,subtotal,ivafac,total,cola) values (:idemp,:subtotal,:iva,:total,:cola);";//Consulta SQL
            $result=$conexion->prepare($sql);//Prepara nuestra consulta
            $result->bindparam(':idemp',$idemp);
            $result->bindparam(':subtotal',$subtotal);
            $result->bindparam(':iva',$iva);
            $result->bindparam(':total',$total);
            $result->bindparam(':cola',$cola);
            //Aseguramos los datos para evitar SQL-Injection
            if(!$result)
                echo "<script>alert('Error al registrar Producto');</secript>";//Si hay errores no ejecuta y muestra mensaje alert en pantalla
            else{
                $result->execute();//Si no hay errores ingresa correctamente
                $ultimo = $this->ultima();
            }
        }
        
        public function detalleadd($idfact,$idprod){//Para insertar
            $conexion = $this->conectar();
            $sql="INSERT INTO detalle_factura(idfac,idprod) values (:idfact,:idprod);";//Consulta SQL
            $result=$conexion->prepare($sql);//Prepara nuestra consulta
            $result->bindparam(':idfact',$idfact);
            $result->bindparam(':idprod',$idprod);
            //Aseguramos los datos para evitar SQL-Injection
            if(!$result)
                echo "<script>alert('Error al registrar Producto');</secript>";//Si hay errores no ejecuta y muestra mensaje alert en pantalla
            else{
                $result->execute();//Si no hay errores ingresa correctamente
                echo $_SESSION['idfac'];
            }
        }

        public function detallequit($idfact,$idprod){//Para insertar 
            $conexion = $this->conectar();
            $sql="DELETE FROM detalle_factura WHERE idfac = '$idfact' AND idprod = '$idprod'";//Consulta SQL
            echo $sql;
            $result=$conexion->prepare($sql);//Prepara nuestra consulta
            $result->bindparam(':idfact',$idfact);
            $result->bindparam(':idprod',$idprod);
            //Aseguramos los datos para evitar SQL-Injection
            if(!$result)
                echo "Error al eliminar Producto";//Si hay errores no ejecuta y muestra mensaje alert en pantalla
            else{
                $result->execute();//Si no hay errores ingresa correctamente
                echo 'Eliminado correctamente';
            }
        }
        
        public function actualizar($idemp,$subtotal,$iva,$total,$idfac){//Para actualizar los precios de factura
            $conexion = $this->conectar();
            $sql="UPDATE factura SET idemp=:idemp,subtotal=:subtotal,ivafac=:iva,total=:total WHERE idfac = :idfac;";//Consulta SQL
            $result=$conexion->prepare($sql);//Prepara nuestra consulta
            $result->bindparam(':idemp',$idemp);
            $result->bindparam(':subtotal',$subtotal);
            $result->bindparam(':iva',$iva);
            $result->bindparam(':total',$total);
            $result->bindparam(':idfac',$idfac);
            //Aseguramos los datos para evitar SQL-Injection
            if(!$result)
                echo "<script>alert('Error al registrar Producto');</secript>";//Si hay errores no ejecuta y muestra mensaje alert en pantalla
            else{
                $result->execute();//Si no hay errores ingresa correctamente
                echo "<script>alert('Producto registrado correctamente');</secript>";
            }
        }
        
        public function ultima(){//Para averiguar la ultima factura agregada 
            $conexion = $this->conectar();
            $sql="SELECT max(idfac) as idfac from factura";
            $result = $conexion->prepare($sql);
            $result->execute();
            while($f=$result->fetch()){
                $resultado[] = array(
                    'idfac' => $f['idfac']
                );//Creación del array con los resultados
            }
            echo json_encode($resultado[0]);
            $_SESSION['idfac'] = $resultado[0]['idfac'];
	    }
    }
?>