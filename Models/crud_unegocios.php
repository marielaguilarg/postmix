<?php

require_once "Models/conexion.php";


class DatosUnegocio extends Conexion{

#vistaservicios

	public function vistaUnegocioModel($init=false, $page_size=false, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT une_id, une_descripcion, une_idpepsi, une_idcuenta FROM $tabla limit :init, :size");
		
		$stmt-> bindParam(":init", $init, PDO::PARAM_INT);
		$stmt-> bindParam(":size", $page_size, PDO::PARAM_INT);			
		$stmt-> execute();

		return $stmt->fetchAll();
		
	}


	public function vistaFiltroUnegocioModel($datosbus, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT une_id, une_descripcion, une_idpepsi, une_idcuenta FROM $tabla where une_descripcion LIKE :opbusqueda");
	
		$stmt-> bindParam(":opbusqueda", $datosbus, PDO::PARAM_STR);
		$stmt-> execute();

		return $stmt->fetchAll();
	
		

	}

	public function cuentaUnegocioModel($tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT une_id, une_descripcion, une_idpepsi, une_idcuenta FROM $tabla");
				
		$stmt-> execute();

		return $qty=$stmt->RowCount();
		
	}

	public function vistaUnegocioDetalle( $uneg, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT une_id, une_descripcion, une_idpepsi, une_idcuenta FROM $tabla WHERE une_id=:uneg");
			
		$stmt-> bindParam(":uneg", $uneg, PDO::PARAM_STR);
					
		$stmt-> execute();

		return $stmt->fetch();

		
	}


	public function ReportesUnegocio($idser, $iduneg, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT i_numreporte, i_finalizado FROM ins_generales WHERE i_claveservicio=:idser and i_claveuninegocio=:iduneg");
			
		$stmt-> bindParam(":idser", $idser, PDO::PARAM_STR);
		$stmt-> bindParam(":iduneg", $iduneg, PDO::PARAM_STR);
					
		$stmt-> execute();

		return $stmt->fetchall();

		
	}

	public function UnegocioCompleta( $iduneg, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT cue_clavecuenta, une_id, une_descripcion, une_idpepsi, une_idcuenta, une_dir_calle, une_dir_numeroext, une_dir_numeroint, une_dir_manzana, une_dir_lote, une_dir_colonia, une_dir_delegacion, une_dir_municipio, une_dir_estado, une_dir_cp, une_dir_referencia, une_dir_telefono, une_cla_region, une_cla_pais, une_cla_zona, une_cla_estado, une_cla_ciudad, une_cla_franquicia, une_dir_idestado, fc_idfranquiciacta, une_num_unico_distintivo,`une_estatus`,`une_fechaestatus` FROM $tabla WHERE une_id=:iduneg");
			
		$stmt-> bindParam(":iduneg", $iduneg, PDO::PARAM_STR);
					
		$stmt-> execute();

		return $stmt->fetch();

		
	}
        public function registrarUnegocio($datosModel,$tabla){
            try{
            $ssql="select max(une_id) as claveuneg from $tabla";
            
            $stmt=Conexion::conectar()-> prepare($ssql);
           
            $stmt-> execute();
            $rs= $stmt->fetch();
          
            if (sizeof($rs) >0){
                 
            $numunineg = $rs["claveuneg"];
	  
		
            }else{	
               $numunineg=0;
            }
            $numunineg+=1;
	
         
            $stmt=null;
//procedimiento de insercion de  la cuenta	   
$sSQL= "insert into $tabla ( cue_clavecuenta, une_id, une_descripcion, une_idpepsi, une_idcuenta, une_num_unico_distintivo, une_dir_calle, une_dir_numeroext, une_dir_numeroint, une_dir_manzana, une_dir_lote, une_dir_colonia, une_dir_delegacion, une_dir_municipio, une_dir_idestado, une_dir_cp, une_dir_referencia, une_dir_telefono, une_cla_region, une_cla_pais, une_cla_zona, une_cla_estado, une_cla_ciudad, une_cla_franquicia,une_dir_estado,fc_idfranquiciacta,une_numpunto,une_estatus,une_fechaestatus)
    values (:ncuenta, :numunineg,:desuneg,:idpepsi, :idcta, :idnud, :calle, :numext, :numint, :mz, :lt,
    :col, :del, :mun, :edo, :cp, :ref, :tel, :clanivel1, :clanivel2, :clanivel3, :clanivel4, :clanivel5, :clanivel6,
    upper(:nom_edo),:franqcuenta, :numpun, :estatuscuenta, :fecest)";
    $stmt=Conexion::conectar()-> prepare($sSQL);

 $stmt-> bindParam(":ncuenta",$datosModel["ncuenta"],PDO::PARAM_INT); 
 $stmt-> bindParam(":numunineg",$numunineg,PDO::PARAM_INT);
 $stmt-> bindParam(":desuneg",$datosModel["desuneg"]);
 $stmt-> bindParam(":idpepsi",$datosModel["idpepsi"]);
 $stmt-> bindParam(":idcta",$datosModel["idcta"],PDO::PARAM_INT); 
 $stmt-> bindParam(":idnud",$datosModel["idnud"]); 
 $stmt-> bindParam(":calle",$datosModel["calle"]); 
 $stmt-> bindParam(":numext",$datosModel["numext"]);
 $stmt-> bindParam(":numint",$datosModel["numint"]); 
 $stmt-> bindParam(":mz",$datosModel["mz"]); 
 $stmt-> bindParam(":lt",$datosModel["lt"]);
 
 $stmt-> bindParam(":col",$datosModel["col"]);
 $stmt-> bindParam(":del",$datosModel["del"]); 
 $stmt-> bindParam(":mun",$datosModel["une_dir_municipio"]);
 $stmt-> bindParam(":edo",$datosModel["une_dir_estado"],PDO::PARAM_INT);
 $stmt-> bindParam(":cp",$datosModel["une_dir_cp"]); 
 $stmt-> bindParam(":ref",$datosModel["une_dir_referencia"]);
 $stmt-> bindParam(":tel",$datosModel["une_dir_telefono"]); 
 $stmt-> bindParam(":clanivel1",$datosModel["clanivel1"]);
 $stmt-> bindParam(":clanivel2",$datosModel["clanivel2"]);
 $stmt-> bindParam(":clanivel3",$datosModel["clanivel3"]); 
 $stmt-> bindParam(":clanivel4",$datosModel["clanivel4"]);
 $stmt-> bindParam(":clanivel5",$datosModel["clanivel5"]);
 $stmt-> bindParam(":clanivel6",$datosModel["clanivel6"]);
 
 $stmt-> bindParam(":nom_edo",$datosModel["une_dir_estado"]);
 $stmt-> bindParam(":franqcuenta",$datosModel["franqcuenta"],PDO::PARAM_INT);
 $stmt-> bindParam(":numpun",$datosModel["numpun"],PDO::PARAM_INT); 
 $stmt-> bindParam(":estatuscuenta",$datosModel["estatus"],PDO::PARAM_INT);
 $stmt-> bindParam(":fecest",$datosModel["fecest"]);

            $res=$stmt-> execute();
           
        
            $stmt->debugDumpParams();
        
            return "success";
            }catch(Exception $ex){
                return "error";
            }

        }
           public function actualizarUnegocio($datosModel,$tabla){
          
//procedimiento de insercion de  la cuenta	   
$sSQL= "update $tabla
   set 
cue_clavecuenta=:ncuenta,
une_descripcion=:desuneg,
une_idpepsi=:idpepsi,
une_idcuenta= :idcta,
une_num_unico_distintivo= :idnud,
une_dir_calle= :calle,
une_dir_numeroext= :numext,
une_dir_numeroint= :numint,
une_dir_manzana= :mz,
une_dir_lote=:lt,
une_dir_colonia= :col,
une_dir_delegacion=:del,
une_dir_municipio= :mun,
une_dir_idestado=:edo,
une_dir_cp= :cp,
une_dir_referencia= :ref,
une_dir_telefono= :tel,
une_cla_region=:clanivel1,
une_cla_pais=:clanivel2,
une_cla_zona= :clanivel3,
une_cla_estado=:clanivel4,
une_cla_ciudad= :clanivel5,
une_cla_franquicia= :clanivel6,
une_dir_estado=upper(:nom_edo),
fc_idfranquiciacta=:franqcuenta,
une_numpunto= :numpun,
une_estatus= :estatuscuenta,
une_fechaestatus= :fecest where une_id=:numunineg";
$stmt=Conexion::conectar()-> prepare($sSQL);
 
 $stmt-> bindParam(":ncuenta",$datosModel["ncuenta"]); 
 $stmt-> bindParam(":numunineg",$datosModel["idpv"]);
 $stmt-> bindParam(":desuneg",$datosModel["desuneg"]);
 $stmt-> bindParam(":idpepsi",$datosModel["idpepsi"]);
 $stmt-> bindParam(":idcta",$datosModel["idcta"]); 
 $stmt-> bindParam(":idnud",$datosModel["idnud"]); 
 $stmt-> bindParam(":calle",$datosModel["calle"]); 
 $stmt-> bindParam(":numext",$datosModel["numext"]);
 $stmt-> bindParam(":numint",$datosModel["numint"]); 
 $stmt-> bindParam(":mz",$datosModel["mz"]); 
 $stmt-> bindParam(":lt",$datosModel["lt"]);
 $stmt-> bindParam(":col",$datosModel["col"]);
 $stmt-> bindParam(":del",$datosModel["del"]); 
 $stmt-> bindParam(":mun",$datosModel["une_dir_municipio"]);
 $stmt-> bindParam(":edo",$datosModel["une_dir_estado"]);
 $stmt-> bindParam(":cp",$datosModel["une_dir_cp"]); 
 $stmt-> bindParam(":ref",$datosModel["une_dir_referencia"]);
 $stmt-> bindParam(":tel",$datosModel["une_dir_telefono"]); 
 $stmt-> bindParam(":clanivel1",$datosModel["clanivel1"]);
 $stmt-> bindParam(":clanivel2",$datosModel["clanivel2"]);
 $stmt-> bindParam(":clanivel3",$datosModel["clanivel3"]); 
 $stmt-> bindParam(":clanivel4",$datosModel["clanivel4"]);
 $stmt-> bindParam(":clanivel5",$datosModel["clanivel5"]);
 $stmt-> bindParam(":clanivel6",$datosModel["clanivel6"]);
 $stmt-> bindParam(":nom_edo",$datosModel["une_dir_estado"]);
 $stmt-> bindParam(":franqcuenta",$datosModel["franqcuenta"]);
 $stmt-> bindParam(":numpun",$datosModel["numpun"]); 
 $stmt-> bindParam(":estatuscuenta",$datosModel["estatus"]);
 $stmt-> bindParam(":fecest",$datosModel["fecest"]);

            $stmt-> execute();
          $stmt->debugDumpParams();
            var_dump($stmt->errorInfo());

        }
         
function nombrePV($cuenta, $franquicia,$ptv){
    $vserviciou=1;
    $sql_titulo = "SELECT * 
    FROM ins_generales
    Inner Join ca_unegocios ON ins_generales.i_idcliente = ca_unegocios.cli_idcliente AND ins_generales.i_claveservicio = ca_unegocios.ser_claveservicio AND ins_generales.i_clavecuenta = ca_unegocios.cue_clavecuenta AND ca_unegocios.cli_idcliente = ins_generales.i_idcliente AND ca_unegocios.ser_claveservicio = ins_generales.i_claveservicio AND ins_generales.i_claveuninegocio = ca_unegocios.une_claveunegocio
    Inner Join ca_cuentas ON ca_unegocios.cli_idcliente = ca_cuentas.cli_idcliente AND ca_unegocios.ser_claveservicio = ca_cuentas.ser_claveservicio AND ca_unegocios.cue_clavecuenta = ca_cuentas.cue_clavecuenta
    WHERE ins_generales.i_claveuninegocio = :ptv    and ca_unegocios.ser_claveservicio=:vserviciou 
        and ins_generales.i_clavecuenta=':cuenta and `fc_idfranquiciacta`=:franquicia";
    $stmt = Conexion::conectar()->prepare($sql_titulo);
    $stmt-> bindParam(":cuenta", $cuenta, PDO::PARAM_INT);
    $stmt-> bindParam(":ptv", $ptv, PDO::PARAM_INT);
    $stmt-> bindParam(":vserviciou", $vserviciou, PDO::PARAM_INT);
    $stmt-> bindParam(":franquicia", $franquicia, PDO::PARAM_INT);
         $res=$stmt->execute();
     foreach ($res as $row_rs_sql_titulo) {
       

        $nomunegocio= $row_rs_sql_titulo ["une_descripcion"];
        }
      
        return $nomunegocio;
}

	

}

?>	