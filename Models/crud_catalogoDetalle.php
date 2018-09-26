<?php


class DatosCatalogoDetalle {
     public function listaCatalogoDetalle($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT
  `cad_idcatalogo`,
  `cad_idopcion`,
  `cad_descripcionesp`,
  `cad_descripcioning`,
  `cad_otro`
     FROM $tabla where ca_catalogosdetalle.cad_idcatalogo= :id");
         
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		
		$stmt-> execute();

		return $stmt->fetchAll();
	}
        
        
        public function getCatalogoDetalle($tabla,$catalogo,$opcion){
            
         $sql_cat = "SELECT
ca_catalogosdetalle.cad_descripcionesp,
ca_catalogosdetalle.cad_descripcioning
FROM".
$tabla."
WHERE
ca_catalogosdetalle.cad_idcatalogo =  :clavecatalogo AND
ca_catalogosdetalle.cad_idopcion =  :opcion";
//  echo "<br> oo ".$sql_cat;
        $stmt = Conexion::conectar()-> prepare($sql_cat);

    $stmt-> bindParam(":clavecatalogo", $catalogo, PDO::PARAM_INT);
    $stmt-> bindParam(":opcion",$opcion , PDO::PARAM_INT);
     $stmt-> execute();

    $result_cat=$stmt->fetchall();
     foreach($result_cat as $row_cat) {
        if ($_SESSION["idiomaus"] == 2)
            $res= $row_cat["cad_descripcioning"];
        else
            $res = $row_cat["cad_descripcionesp"];
    }
          
        
      return $res;
        }

public function listaCatalogoDetalleOpc($datosModel, $op, $tabla){
    $stmt = Conexion::conectar()-> prepare("SELECT
  `cad_idcatalogo`,
  `cad_idopcion`,
  `cad_descripcionesp`,
  `cad_descripcioning`,
  `cad_otro`
     FROM $tabla where ca_catalogosdetalle.cad_idcatalogo= :id and cad_idopcion=:op");
         
    $stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
    $stmt->bindParam(":op", $op, PDO::PARAM_INT);
    
    $stmt-> execute();

    return $stmt->fetch();
  }

}
