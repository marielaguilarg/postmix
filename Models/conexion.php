<?php

class Conexion {

  	public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=inspeccionpostmix_pruebas", "root", "root");
	//	$link = new PDO("mysql:host=localhost;dbname=appshcdc_inspeccionpostmix", "appshcdc_adminpost", "AdminPostmix18:)");
		return $link;


	}

    public static function ejecutarQuery($sql, $listParam) {
 try {

            $stmt = Conexion::conectar()->prepare($sql);

            foreach ($listParam as $key => $param) {
   if ($param == null)
                    $stmt->bindValue(":" . $key, NULL, PDO::PARAM_NULL);
                else
                    $stmt->bindValue(":" . $key, $param, PDO::PARAM_STR);
            }
          
            $stmt->execute();

      
          $stmt->debugDumpParams();


            $respuesta = $stmt->fetchAll();

            if ($stmt->errorInfo()[1] != null) {

                //var_dump($stmt->errorInfo());

                throw new Exception("Error al ejecutar consulta en la bd");
            }

            return $respuesta;
 } catch (PDOException $e){
  
            throw new Exception("Error al ejecutar consulta en la bd");
        }
    }

    public function ejecutarInsert($sql, $listParam) {



        try {



            $stmt = Conexion::conectar()->prepare($sql);

            foreach ($listParam as $key => $param) {
     if ($param == null)
                    $stmt->bindValue(":" . $key, NULL, PDO::PARAM_NULL);
                else
                    $stmt->bindValue(":" . $key, $param, PDO::PARAM_STR);
            }

            if (!$stmt->execute()) {

                //echo var_dump($stmt->errorInfo());
                //  $stmt->debugDumpParams();

                throw new Exception("Error al insertar/actualizar");
            }
        } catch (PDOException $e) {



            throw new Exception("Error al ejecutar insert en la bd " . $e);
        }
    }

    public function ejecutarQuerysp($sql) {

        try {

            $stmt = Conexion::conectar()->prepare($sql);
    $stmt->execute();
 $respuesta = $stmt->fetchAll();

            //   $stmt->debugDumpParams();

            if ($stmt->errorInfo()[1] != null) {



                throw new Exception("Error al ejecutar consulta en la bd" . $stmt->errorInfo()[2]);
            }

            return $respuesta;
        } catch (Exception $e) {

            throw new Exception("Error al ejecutar consulta en la bd");
        }
    }

}

?>