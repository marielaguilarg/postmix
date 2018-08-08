<?php

require_once "Models/conexion.php";

class DatosProducto extends Conexion{

	public function vistaProductosModel($datosServ, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT gen_claveservicio, gen_numdato, gen_lugarsyd, gen_numdatoref, gf_nombreesp, gf_nombreing FROM $tabla Inner Join cue_generales ON gf_numdato = gen_numdatoref WHERE gf_idtabla = 'V' AND gen_claveservicio = :numser ORDER BY gen_numdato");

		$stmt-> bindParam(":numser", $datosServ, PDO::PARAM_INT);
				
		$stmt-> execute();

		return $stmt->fetchAll();
	}

    public function datosProductosModel( $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT gf_numdato, gf_nombreesp, gf_nombreing, gf_idtabla FROM $tabla WHERE gf_idtabla='V' order by gf_numdato");
	
		$stmt-> execute();

		return $stmt->fetchAll();

		$stmt->close();

	}

	public function editarProductoModel($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT gen_claveservicio, gen_numdato, gen_lugarsyd, gen_numdatoref, gen_tipodato from cue_generales where concat(gen_claveservicio,gen_numdato)=:ids");
	
		$stmt-> bindParam(":ids", $datosModel, PDO::PARAM_INT);

		$stmt-> execute();

		return $stmt->fetchAll();

		$stmt->close();


	}



	public function datosProductoModel( $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT gf_numdato, gf_nombreesp, gf_nombreing, gf_idtabla FROM $tabla WHERE gf_idtabla='V' order by gf_numdato");
	
		$stmt-> execute();

		return $stmt->fetchAll();

		$stmt->close();

	}

		public function actualizaProductosModel($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("UPDATE cue_generales Set gen_lugarsyd=:lugarsyd, gen_numdatoref=:datoref where concat(gen_claveservicio,gen_numdato)=:nsec");

			$stmt-> bindParam(":nsec", $datosModel["nsec"], PDO::PARAM_INT);
			$stmt-> bindParam(":lugarsyd", $datosModel["lugarsyd"], PDO::PARAM_INT);
			$stmt-> bindParam(":datoref", $datosModel["datoref"], PDO::PARAM_INT);
			
			IF($stmt-> execute()){

				return "success";
			}
			
			else {

				return "error";
		
			};
		
			$stmt->close();

		}


	public function vistaRepProductosModel($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT ip_numseccion,ip_numrenglon,ip_numsistema,ip_descripcionproducto,ip_numcajas, ip_fechaproduccion,ip_fechacaducidad,ip_condicion,ip_edaddias,ip_semana,ip_estatus,ip_sinetiqueta FROM $tabla WHERE ip_claveservicio =:sv AND ip_numseccion =:sec and ip_numreporte =:numrep");

			$stmt-> bindParam(":sec", $datosModel["sec"], PDO::PARAM_INT);
			$stmt-> bindParam(":sv", $datosModel["sv"], PDO::PARAM_INT);
			$stmt-> bindParam(":numrep", $datosModel["nrep"], PDO::PARAM_INT);
			
			$stmt-> execute();

			return $stmt->fetchAll();

			$stmt->close();

	}
	
	function getDetalleProducto($vservicio, $seccion, $reporte) {
	    
	    $SQL_FJARABER = "SELECT *
	 		   FROM ins_detalleproducto
			  WHERE ins_detalleproducto.ip_claveservicio = :idser
			    AND ip_numseccion =:idnumseccion
				AND ip_numreporte =:numrep";
	    //echo $SQL_FJARABER;
	    $stmt = Conexion::conectar()-> prepare($SQL_FJARABER);
	    
	    $stmt-> bindParam(":referencia", $seccion, PDO::PARAM_STR);
	    $stmt-> bindParam(":reporte",$reporte , PDO::PARAM_INT);
	    $stmt-> bindParam(":servicio", $vservicio, PDO::PARAM_INT);
	    $stmt-> execute();
	    
	    $result=$stmt->fetchall();
	  
	    return $result;
	}
	
        
          function CumplimientoProducto($vservicio, $referencia, $reporte) {
   
    $SQL_FJARABER = "SELECT
(((SUM(if(`ins_detalleproducto`.`ip_condicion`='V',`ins_detalleproducto`.`ip_numcajas`,0)))*100)/(SUM(`ins_detalleproducto`.`ip_numcajas`))) as NIVELACEPTACION,
				    cue_secciones.sec_descripcionesp,
cue_secciones.sec_descripcioning
FROM
ins_generales
Inner Join ins_detalleproducto ON ins_generales.i_claveservicio = ins_detalleproducto.ip_claveservicio AND ins_generales.i_numreporte = ins_detalleproducto.ip_numreporte
Inner Join cue_secciones ON ins_detalleproducto.ip_numseccion = cue_secciones.sec_numseccion
WHERE `ins_generales`.`i_numreporte` = :reporte and ins_generales.i_claveservicio=:servicio
				     AND  ins_detalleproducto.ip_numseccion =:referencia
					 AND ins_detalleproducto.ip_sinetiqueta=0
GROUP BY  `ins_detalleproducto`.`ip_numreporte`, `ins_detalleproducto`.`ip_numseccion`";
//echo $SQL_FJARABER;
   $stmt = Conexion::conectar()-> prepare($SQL_FJARABER);

    $stmt-> bindParam(":referencia", $referencia, PDO::PARAM_STR);
    $stmt-> bindParam(":reporte",$reporte , PDO::PARAM_INT);
    $stmt-> bindParam(":servicio", $vservicio, PDO::PARAM_INT);
    $stmt-> execute();

    $result=$stmt->fetchall();
    foreach ($result as $ROW_FJARABE) {

        if ($_SESSION["idiomaus"] == 2)
            $res[0] = $ROW_FJARABE ["sec_descripcioning"];
        else
            $res[0] = $ROW_FJARABE ["sec_descripcionesp"];
        $res[1] = "< 10 " . T_("semanas");
        if ($ROW_FJARABE ['NIVELACEPTACION'] >= 80)
            $res[2] = "tache";
        else
            $res[2] = "paloma";
        $res[3] = $referencia;
    }
    return $res;
}

    public function nombreOpProducto($datosModel, $tabla){
		$stmt=Conexion::conectar()->prepare("SELECT cad_descripcionesp FROM ca_catalogosdetalle WHERE cad_idcatalogo =:idcat AND cad_idopcion =:idop");

			$stmt-> bindParam(":idcat", $datosModel["idcat"], PDO::PARAM_INT);
			$stmt-> bindParam(":idop", $datosModel["idop"], PDO::PARAM_INT);
			
			$stmt-> execute();

			return $stmt->fetch();

			$stmt->close();

	}

}

?>
