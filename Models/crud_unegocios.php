<?php

require_once "Models/conexion.php";


class DatosUnegocio extends Conexion{

#vistaservicios

	public function vistaUnegocioModel($init=false, $page_size=false, $cta, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT une_id, une_descripcion, une_idpepsi, une_idcuenta FROM $tabla where cue_clavecuenta=:cta limit :init, :size ");
		
		$stmt-> bindParam(":init", $init, PDO::PARAM_INT);
		$stmt-> bindParam(":size", $page_size, PDO::PARAM_INT);			
		$stmt-> bindParam(":cta", $cta, PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetchAll();
		$stmt->close();
	}


	public function vistaFiltroUnegocioModel($cta, $datosbus, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT une_id, une_descripcion, une_idpepsi, une_idcuenta FROM $tabla where cue_clavecuenta=:cta and une_descripcion LIKE :opbusqueda ");
	
		$stmt-> bindParam(":opbusqueda", $datosbus, PDO::PARAM_STR);
		$stmt-> bindParam(":cta", $cta, PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetchAll();
	
		$stmt->close();

	}

	public function cuentaUnegocioModel($cta, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT une_id, une_descripcion, une_idpepsi, une_idcuenta FROM $tabla where cue_clavecuenta=:cta");
		$stmt-> bindParam(":cta", $cta, PDO::PARAM_INT);		
		$stmt-> execute();

		return $qty=$stmt->RowCount();
		$stmt->close();
	}

	public function vistaUnegocioDetalle( $uneg, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT une_id, une_descripcion, une_idpepsi, une_idcuenta FROM $tabla WHERE une_id=:uneg");
			
		$stmt-> bindParam(":uneg", $uneg, PDO::PARAM_STR);
					
		$stmt-> execute();

		return $stmt->fetch();

		$stmt->close();
	}


	public function ReportesUnegocio($idser, $iduneg, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT i_claveservicio, i_numreporte, i_finalizado FROM $tabla WHERE i_claveservicio=:idser and i_unenumpunto=:iduneg");
			
		$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);
		$stmt-> bindParam(":iduneg", $iduneg, PDO::PARAM_INT);
					
		$stmt-> execute();

		return $stmt->fetchall();

		$stmt->close();
	}

	public function UnegocioCompleta( $iduneg, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT cue_clavecuenta, une_id, une_descripcion, une_idpepsi, une_idcuenta, une_dir_calle, une_dir_numeroext, une_dir_numeroint, une_dir_manzana, une_dir_lote, une_dir_colonia, une_dir_delegacion, une_dir_municipio, une_dir_estado, une_dir_cp, une_dir_referencia, une_dir_telefono, une_cla_region, une_cla_pais, une_cla_zona, une_cla_estado, une_cla_ciudad, une_cla_franquicia, une_dir_idestado, fc_idfranquiciacta, une_num_unico_distintivo, une_estatus, une_fechaestatus FROM $tabla WHERE une_id=:iduneg");
			
		$stmt-> bindParam(":iduneg", $iduneg, PDO::PARAM_STR);
					
		$stmt-> execute();

		return $stmt->fetch();

		$stmt->close();
	}	

public function actualizarUnegocio($datosModel, $tabla) {
        try {
//procedimiento de insercion de  la cuenta	   
            $sSQL = "update $tabla
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
            $stmt = Conexion::conectar()->prepare($sSQL);

            $stmt->bindParam(":ncuenta", $datosModel["ncuenta"]);
            $stmt->bindParam(":numunineg", $datosModel["idpv"]);
            $stmt->bindParam(":desuneg", $datosModel["desuneg"]);
            $stmt->bindParam(":idpepsi", $datosModel["idpepsi"]);
            $stmt->bindParam(":idcta", $datosModel["idcta"]);
            $stmt->bindParam(":idnud", $datosModel["idnud"]);
            $stmt->bindParam(":calle", $datosModel["calle"]);
            $stmt->bindParam(":numext", $datosModel["numext"]);
            $stmt->bindParam(":numint", $datosModel["numint"]);
            $stmt->bindParam(":mz", $datosModel["mz"]);
            $stmt->bindParam(":lt", $datosModel["lt"]);
            $stmt->bindParam(":col", $datosModel["col"]);
            $stmt->bindParam(":del", $datosModel["del"]);
            $stmt->bindParam(":mun", $datosModel["une_dir_municipio"]);
            $stmt->bindParam(":edo", $datosModel["une_dir_estado"]);
            $stmt->bindParam(":cp", $datosModel["une_dir_cp"]);
            $stmt->bindParam(":ref", $datosModel["une_dir_referencia"]);
            $stmt->bindParam(":tel", $datosModel["une_dir_telefono"]);
            $stmt->bindParam(":clanivel1", $datosModel["clanivel1"]);
            $stmt->bindParam(":clanivel2", $datosModel["clanivel2"]);
            $stmt->bindParam(":clanivel3", $datosModel["clanivel3"]);
            $stmt->bindParam(":clanivel4", $datosModel["clanivel4"]);
            $stmt->bindParam(":clanivel5", $datosModel["clanivel5"]);
            $stmt->bindParam(":clanivel6", $datosModel["clanivel6"]);
            $stmt->bindParam(":nom_edo", $datosModel["une_dir_estado"]);
            $stmt->bindParam(":franqcuenta", $datosModel["franqcuenta"]);
            $stmt->bindParam(":numpun", $datosModel["numpun"]);
            $stmt->bindParam(":estatuscuenta", $datosModel["estatus"]);
            $stmt->bindParam(":fecest", $datosModel["fecest"]);

            $stmt->execute();
            return "success";
        } catch (Exception $ex) {
            return "error";
        }
    }

    function nombrePV( $ptv) {
        $res=DatosUnegocio::vistaUnegocioDetalle($ptv,"ca_unegocios");
      
       

        $nomunegocio = $res ["une_descripcion"];
     

        return $nomunegocio;
    }
    
        function unegociosxNivel($fil_ptoventa,$fil_idpepsi, $filx, $fily,$ini,$fin) {

        $sql = " select  ca_unegocios.une_id,
ca_unegocios.une_descripcion, concat(une_dir_calle,' ',
    une_dir_numeroext,' ',
    une_dir_colonia) as direccion,
   une_dir_municipio, une_idcuenta,une_id,cue_clavecuenta,fc_idfranquiciacta,
    une_idpepsi
FROM
ca_unegocios
where 1=1 ";
           if($fil_ptoventa!="")
    {
         $sql.=" and une_descripcion like '%".$fil_ptoventa ."%' ";
    }
     if($fil_idpepsi!=""){
        $sql.=" and une_idpepsi='".$fil_idpepsi."'";
        
    }
        if (isset($filx["pais"]) && $filx["pais"] != "") {
            $sql .= " AND `une_cla_region`=:pais";
            $parametros["pais"] = $filx["pais"];
        }
        if (isset($filx["uni"]) && $filx["uni"] != "") {
            $sql .= " AND `une_cla_pais`=:uni";
            $parametros["uni"] = $filx["uni"];
        }
        if (isset($filx["zon"]) && $filx["zon"] != "") {
            $sql .= "  and     ca_unegocios.une_cla_zona=:zon";
            $parametros["zon"] = $filx["zon"];
        }
        if (isset($fily["cta"]) && $fily["cta"] != "") {
            $sql .= " and ca_unegocios.cue_clavecuenta=:cta";
            $parametros["cta"] = $fily["cta"];
        }
        if (isset($filx["reg"]) && $filx["reg"] != "") {
            $sql .= " and ca_unegocios.une_cla_estado=:reg";
            $parametros["reg"] = $filx["reg"];
        }
        if (isset($filx["ciu"]) && $filx["ciu"] != "") {
            $sql .= " and ca_unegocios.une_cla_ciudad=:ciu";
            $parametros["ciu"] = $filx["ciu"];
        }
        if (isset($filx["niv6"]) && $filx["niv6"] != "") {
            $sql .= " and ca_unegocios.une_cla_franquicia=:niv6";
            $parametros["niv6"] = $filx["niv6"];
        }
        if (isset($fily["fra"]) && $fily["fra"] != "") {
            $sql .= " and ca_unegocios.fc_idfranquiciacta=:fra";
            $parametros["fra"] = $fily["fra"];
        }


        $sql .= " order by une_id";
        
        if($fin!="")
        {    $sql.=" LIMIT $ini,$fin";

//      $parametros["start"]=$ini;
//        $parametros["end"]=$fin;
        
        }

        $res = Conexion::ejecutarQuery($sql,$parametros);
      

        return $res;
    }
    
    public function unegociosxTipoMercado($tipomercado,$cliente,$franq){
        $sql="SELECT une_id, une_descripcion FROM ca_unegocios Inner Join ca_cuentas ON ca_cuentas.cue_clavecuenta = ca_unegocios.cue_clavecuenta
WHERE ca_cuentas.cue_tipomercado =:tipomer and `ca_unegocios`.`cli_idcliente`=:scli "
                . "  and fc_idfranquiciacta=:fc_idfranquiciacta
  order by une_descripcion;";
        
        $parametros=array("tipomer"=>$tipomercado,
            "scli"=>$cliente,
            "fc_idfranquiciacta"=>$franq );
        $res=Conexion::ejecutarQuery($sql,$parametros);
    }
    
    public function unegociosxNivelxTipoMer($VarNivel2,$referencianivel,$tipoMercado,$cliente,$franquicia){
        $aux2=explode(".", $referencianivel);
          $slq_franquicia = "SELECT
ca_unegocios.une_id,
ca_unegocios.une_descripcion
FROM
ca_unegocios
Inner Join ca_cuentas ON ca_unegocios.cue_clavecuenta = ca_cuentas.cue_clavecuenta AND ca_unegocios.ser_claveservicio = ca_cuentas.ser_claveservicio AND ca_unegocios.cli_idcliente = ca_cuentas.cli_idcliente";

                    switch ($VarNivel2) {
                         case 6: $filtro = " ca_unegocios.une_cla_region=$aux2[1] and
ca_unegocios.une_cla_pais=$aux2[2] and
ca_unegocios.une_cla_zona=$aux2[3] and
ca_unegocios.une_cla_estado=$aux2[4] and
ca_unegocios.une_cla_ciudad=$aux2[5] and
ca_unegocios.une_cla_franquicia=$aux2[6] ";
                                break;
                            case 5: $filtro = " ca_unegocios.une_cla_region=$aux2[1] and
ca_unegocios.une_cla_pais=$aux2[2] and
ca_unegocios.une_cla_zona=$aux2[3] and
ca_unegocios.une_cla_estado=$aux2[4] and
ca_unegocios.une_cla_ciudad=$aux2[5] ";
                                break;
                            case 4: $filtro = " ca_unegocios.une_cla_region=$aux2[1] and
ca_unegocios.une_cla_pais=$aux2[2] and
ca_unegocios.une_cla_zona=$aux2[3] and
ca_unegocios.une_cla_estado=$aux2[4] ";
                                break;
                            case 3: $filtro = "ca_unegocios.une_cla_region=$aux2[1] and
ca_unegocios.une_cla_pais=$aux2[2] and
ca_unegocios.une_cla_zona=$aux2[3] ";
                                break;
                            case 2: $filtro = "ca_unegocios.une_cla_region=$aux2[1] and
ca_unegocios.une_cla_pais=$aux2[2]";
                                break;
                            case 1: $filtro = "ca_unegocios.une_cla_region=$aux2[1]";
                                break;
                    }//fin switch
                    $slq_franquicia.=" where " . $filtro .  " and ca_cuentas.cue_tipomercado =:tipomer and `ca_unegocios`.`cli_idcliente`=:scli and
  and fc_idfranquiciacta=:franq;";
     $parametros=array("opcionSeleccionadaCuenta"=>$tipoMercado,
         "scli"=>$cliente,
         "franq"=>$franquicia);
     return Conexion::ejecutarQuery($slq_franquicia,$parametros );
    }

 public function registrarUnegocio($datosModel, $tabla) {
        try {
            $ssql = "select max(une_id) as claveuneg from $tabla";

            $stmt = Conexion::conectar()->prepare($ssql);

            $stmt->execute();
            $rs = $stmt->fetch();

            if (sizeof($rs) > 0) {

                $numunineg = $rs["claveuneg"];
            } else {
                $numunineg = 0;
            }
            $numunineg += 1;


            $stmt = null;
//procedimiento de insercion de  la cuenta	   
            $sSQL = "insert into $tabla ( cue_clavecuenta, une_id, une_descripcion, une_idpepsi, une_idcuenta, une_num_unico_distintivo, une_dir_calle, une_dir_numeroext, une_dir_numeroint, une_dir_manzana, une_dir_lote, une_dir_colonia, une_dir_delegacion, une_dir_municipio, une_dir_idestado, une_dir_cp, une_dir_referencia, une_dir_telefono, une_cla_region, une_cla_pais, une_cla_zona, une_cla_estado, une_cla_ciudad, une_cla_franquicia,une_dir_estado,fc_idfranquiciacta,une_numpunto,une_estatus,une_fechaestatus)
    values (:ncuenta, :numunineg,:desuneg,:idpepsi, :idcta, :idnud, :calle, :numext, :numint, :mz, :lt,
    :col, :del, :mun, :edo, :cp, :ref, :tel, :clanivel1, :clanivel2, :clanivel3, :clanivel4, :clanivel5, :clanivel6,
    upper(:nom_edo),:franqcuenta, :numpun, :estatuscuenta, :fecest)";
            $stmt = Conexion::conectar()->prepare($sSQL);

            $stmt->bindParam(":ncuenta", $datosModel["ncuenta"], PDO::PARAM_INT);
            $stmt->bindParam(":numunineg", $numunineg, PDO::PARAM_INT);
            $stmt->bindParam(":desuneg", $datosModel["desuneg"]);
            $stmt->bindParam(":idpepsi", $datosModel["idpepsi"]);
            $stmt->bindParam(":idcta", $datosModel["idcta"], PDO::PARAM_INT);
            $stmt->bindParam(":idnud", $datosModel["idnud"]);
            $stmt->bindParam(":calle", $datosModel["calle"]);
            $stmt->bindParam(":numext", $datosModel["numext"]);
            $stmt->bindParam(":numint", $datosModel["numint"]);
            $stmt->bindParam(":mz", $datosModel["mz"]);
            $stmt->bindParam(":lt", $datosModel["lt"]);

            $stmt->bindParam(":col", $datosModel["col"]);
            $stmt->bindParam(":del", $datosModel["del"]);
            $stmt->bindParam(":mun", $datosModel["une_dir_municipio"]);
            $stmt->bindParam(":edo", $datosModel["une_dir_estado"], PDO::PARAM_INT);
            $stmt->bindParam(":cp", $datosModel["une_dir_cp"]);
            $stmt->bindParam(":ref", $datosModel["une_dir_referencia"]);
            $stmt->bindParam(":tel", $datosModel["une_dir_telefono"]);
            $stmt->bindParam(":clanivel1", $datosModel["clanivel1"]);
            $stmt->bindParam(":clanivel2", $datosModel["clanivel2"]);
            $stmt->bindParam(":clanivel3", $datosModel["clanivel3"]);
            $stmt->bindParam(":clanivel4", $datosModel["clanivel4"]);
            $stmt->bindParam(":clanivel5", $datosModel["clanivel5"]);
            $stmt->bindParam(":clanivel6", $datosModel["clanivel6"]);

            $stmt->bindParam(":nom_edo", $datosModel["une_dir_estado"]);
            $stmt->bindParam(":franqcuenta", $datosModel["franqcuenta"], PDO::PARAM_INT);
            $stmt->bindParam(":numpun", $datosModel["numpun"], PDO::PARAM_INT);
            $stmt->bindParam(":estatuscuenta", $datosModel["estatus"], PDO::PARAM_INT);
            $stmt->bindParam(":fecest", $datosModel["fecest"]);

            $res = $stmt->execute();




            return "success";
        } catch (Exception $ex) {
            return "error";
        }
    }



}

?>	