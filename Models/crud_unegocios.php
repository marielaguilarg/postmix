<?php

require_once "Models/conexion.php";

class DatosUnegocio extends Conexion {
#vistaservicios

	public function vistaUnegocioModel($init=false, $page_size=false, $cta, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT une_id, une_descripcion, une_idpepsi,
une_dir_estado, une_dir_municipio, une_idcuenta,une_num_unico_distintivo FROM $tabla 
where cue_clavecuenta=:cta order by une_dir_estado limit :init, :size  ");
		
        $stmt->bindParam(":init", $init, PDO::PARAM_INT);

        $stmt->bindParam(":size", $page_size, PDO::PARAM_INT);
		$stmt-> bindParam(":cta", $cta, PDO::PARAM_INT);
        $stmt->execute();
	


        return $stmt->fetchAll();
    }

	public function vistaFiltroUnegocioModel($cta, $datosbus,$estado,$ciudad, $tabla){

		$sql="SELECT une_id, une_descripcion, une_idpepsi,
 une_idcuenta,une_num_unico_distintivo,une_dir_estado, une_dir_municipio FROM $tabla
where cue_clavecuenta=:cta and une_descripcion
LIKE :opbusqueda ";
	
		// agregando filtros
		if(isset($estado)&&$estado!="0") {
			$sql.=" and ca_unegocios.une_dir_idestado=:estado";
		
		}
		      
		if(isset($ciudad)){
			
			if($ciudad!="") {
				$sql.=" and ca_unegocios.une_dir_municipio=:ciudad";
			
			}
		}
		$stmt = Conexion::conectar()-> prepare($sql." order by une_dir_estado" );
		if(isset($estado)&&$estado!="0") {
			
			$stmt-> bindParam(":estado", $estado, PDO::PARAM_INT);
		}
		
		if(isset($ciudad)){
			
			if($ciudad!="") {
			
				$stmt-> bindParam(":ciudad", $ciudad, PDO::PARAM_STR);
			}
		}
        $stmt->bindParam(":opbusqueda", $datosbus, PDO::PARAM_STR);
		$stmt-> bindParam(":cta", $cta, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll();
    }

	public function cuentaUnegocioModel($cta, $tabla){

		$stmt = Conexion::conectar()-> prepare("SELECT une_id, une_descripcion, une_idpepsi, une_idcuenta FROM $tabla where cue_clavecuenta=:cta");
		$stmt-> bindParam(":cta", $cta, PDO::PARAM_INT);		


        $stmt->execute();



        return $qty = $stmt->RowCount();
    }

    public function vistaUnegocioDetalle($uneg, $tabla) {

        $stmt = Conexion::conectar()->prepare("SELECT une_id, une_descripcion, une_idpepsi, une_idcuenta FROM $tabla WHERE une_id=:uneg");



        $stmt->bindParam(":uneg", $uneg, PDO::PARAM_STR);



        $stmt->execute();



        return $stmt->fetch();
    }

    public function ReportesUnegocio($idser, $iduneg, $tabla) {

		$stmt = Conexion::conectar()-> prepare("SELECT i_claveservicio, i_numreporte, i_finalizado FROM $tabla WHERE i_claveservicio=:idser and i_unenumpunto=:iduneg");



		$stmt-> bindParam(":idser", $idser, PDO::PARAM_INT);

		$stmt-> bindParam(":iduneg", $iduneg, PDO::PARAM_INT);



        $stmt->execute();



        return $stmt->fetchall();
    }

    public function UnegocioCompleta($iduneg, $tabla) {

        $stmt = Conexion::conectar()->prepare("SELECT cue_clavecuenta, une_id, une_descripcion, une_idpepsi, une_idcuenta, une_dir_calle, une_dir_numeroext, une_dir_numeroint, une_dir_manzana, une_dir_lote, une_dir_colonia, une_dir_delegacion, une_dir_municipio, une_dir_estado, une_dir_cp, une_dir_referencia, une_dir_telefono, une_cla_region, une_cla_pais, une_cla_zona, une_cla_estado, une_cla_ciudad, une_cla_franquicia, une_dir_idestado, fc_idfranquiciacta, une_num_unico_distintivo,`une_estatus`,`une_fechaestatus` FROM $tabla WHERE une_id=:iduneg");



        $stmt->bindParam(":iduneg", $iduneg, PDO::PARAM_STR);



        $stmt->execute();



        return $stmt->fetch();
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
            if($datosModel["une_dir_estado"]>0)
            {   $reses=DatosEstado::editarEstadoModel($datosModel["une_dir_estado"],"ca_uneestados");
            $nombre=$reses["est_nombre"];
            
            }
            else $nombre="";

            $stmt->bindParam(":nom_edo", $nombre);

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

    function nombrePV($ptv) {

        $res = DatosUnegocio::vistaUnegocioDetalle($ptv, "ca_unegocios");







        $nomunegocio = $res ["une_descripcion"];





        return $nomunegocio;
    }

    function unegociosxNivel($fil_ptoventa, $fil_idpepsi, $filx, $fily, $ini, $fin) {



        $sql = " select  ca_unegocios.une_id,

ca_unegocios.une_descripcion, concat(une_dir_calle,' ',

    une_dir_numeroext,' ',

    une_dir_colonia) as direccion,

   une_dir_municipio, une_idcuenta,une_id,cue_clavecuenta,fc_idfranquiciacta,

    une_idpepsi

FROM

ca_unegocios

where 1=1 ";

        if ($fil_ptoventa != "") {

            $sql .= " and une_descripcion like '%" . $fil_ptoventa . "%' ";
        }

        if ($fil_idpepsi != "") {

            $sql .= " and une_idpepsi='" . $fil_idpepsi . "'";
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



        if ($fin != "") {
            $sql .= " LIMIT $ini,$fin";



//      $parametros["start"]=$ini;
//        $parametros["end"]=$fin;
        }



        $res = Conexion::ejecutarQuery($sql, $parametros);





        return $res;
    }

    function unegociosxNivelxServicio($servicio, $fil_ptoventa, $fil_idpepsi, $filx, $fily, $ini, $fin) {



        $sql = " select  ca_unegocios.une_id,

ca_unegocios.une_descripcion, concat(une_dir_calle,' ',

    une_dir_numeroext,' ',

    une_dir_colonia) as direccion,

   une_dir_municipio, une_idcuenta,une_id,cue_clavecuenta,fc_idfranquiciacta,

    une_idpepsi,une_num_unico_distintivo

FROM

ca_unegocios

INNER JOIN

ins_generales ON i_unenumpunto=une_id 

 WHERE `i_claveservicio`=:servicio ";

        $parametros["servicio"] = $servicio;

        if ($fil_ptoventa != "") {

            $sql .= " and une_descripcion like '%" . $fil_ptoventa . "%' ";
        }

        if ($fil_idpepsi != "") {

            $sql .= " and une_idpepsi='" . $fil_idpepsi . "'";
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





        $sql .= "  GROUP BY une_id order by une_id";



        if ($fin != "") {
            $sql .= " LIMIT $ini,$fin";



            //      $parametros["start"]=$ini;
            //        $parametros["end"]=$fin;
        }



        $res = Conexion::ejecutarQuery($sql, $parametros);





        return $res;
    }

    public function unegociosxTipoMercado($tipomercado, $cliente, $franq) {

        $sql = "SELECT une_id, une_descripcion FROM ca_unegocios Inner Join ca_cuentas ON ca_cuentas.cue_id = ca_unegocios.cue_clavecuenta

WHERE ca_cuentas.cue_tipomercado =:tipomer "
                . "  and fc_idfranquiciacta=:fc_idfranquiciacta

  order by une_descripcion;";



        $parametros = array("tipomer" => $tipomercado,
           
            "fc_idfranquiciacta" => $franq);

        $res = Conexion::ejecutarQuery($sql, $parametros);

        return $res;
    }

    public function unegocioxIdCuentaCuenta($idcta, $cta, $tabla) {

        $sql = "SELECT une_id, une_descripcion FROM ca_unegocios Inner Join ca_cuentas ON ca_cuentas.cue_id = ca_unegocios.cue_clavecuenta

WHERE ca_unegocios.une_idcuenta =:idcta 

AND ca_unegocios.cue_clavecuenta =:cta";



        $stmt = Conexion::conectar()->prepare($sql);

        $stmt->bindParam(":idcta", $idcta);

        $stmt->bindParam(":cta", $cta);

        $stmt->execute();

        return $stmt->fetchAll();
    }
    
  

    public function unegociosxNivelxTipoMer($VarNivel2, $referencianivel, $tipoMercado, $cliente, $franquicia) {

        $aux2 = explode(".", $referencianivel);

        $slq_franquicia = "SELECT

ca_unegocios.une_id,

ca_unegocios.une_descripcion

FROM

ca_unegocios

Inner Join ca_cuentas ON ca_unegocios.cue_clavecuenta = ca_cuentas.cue_id AND ca_unegocios.ser_claveservicio = ca_cuentas.ser_claveservicio AND ca_unegocios.cli_idcliente = ca_cuentas.cli_idcliente";



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

        $slq_franquicia .= " where " . $filtro . " and ca_cuentas.cue_tipomercado =:tipomer and `ca_unegocios`.`cli_idcliente`=:scli and

  and fc_idfranquiciacta=:franq;";

        $parametros = array("opcionSeleccionadaCuenta" => $tipoMercado,
            "scli" => $cliente,
            "franq" => $franquicia);

        return Conexion::ejecutarQuery($slq_franquicia, $parametros);
    }
   public function insertarUnegociodesdeSolicitud($servicio, $reporte) {
    	try{

        $ssql = "select max(une_id) as claveuneg from ca_unegocios";



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

        $sqli = "INSERT INTO ca_unegocios (cue_clavecuenta, une_id, une_descripcion,  une_idcuenta, 

 une_dir_calle, une_dir_numeroext, une_dir_numeroint,

 une_dir_manzana, une_dir_lote, une_dir_colonia,

 une_dir_delegacion, une_dir_municipio, une_dir_idestado, une_dir_cp, une_dir_referencia, une_dir_telefono, 

 une_numpunto,ca_unegocios.une_estatus,une_fechaestatus,une_idpepsi,
  une_num_unico_distintivo)

 SELECT cer_solicitud.sol_cuenta,  :numunineg, cer_solicitud.sol_descripcion,

cer_solicitud.sol_idcuenta,

 cer_solicitud.sol_dir_calle, cer_solicitud.sol_dir_numeroext, cer_solicitud.sol_dir_numeroint,

 cer_solicitud.sol_dir_manzana, cer_solicitud.sol_dir_lote, cer_solicitud.sol_dir_colonia,

 cer_solicitud.sol_dir_delegacion, cer_solicitud.sol_dir_municipio, cer_solicitud.sol_dir_estado, cer_solicitud.sol_dir_cp, cer_solicitud.sol_dir_referencia, cer_solicitud.sol_dir_telefono, 

:npunto, 1, curdate(),'',''

 FROM cer_solicitud WHERE cer_solicitud.sol_claveservicio =:servicio AND cer_solicitud.sol_idsolicitud =:reporte";

        $stmt = Conexion::conectar()->prepare($sqli);



        $stmt->bindParam(":numunineg", $numunineg, PDO::PARAM_INT);

        $stmt->bindParam(":npunto", $numunineg, PDO::PARAM_INT);

        $stmt->bindParam(":servicio", $servicio, PDO::PARAM_INT);

        $stmt->bindParam(":reporte", $reporte, PDO::PARAM_INT);



        $res = $stmt->execute();

       // $stmt->debugDumpParams();



        if (!$res)
            throw new Exception("Error al insertar solicitud");
    	}catch(PDOException $ex){
    		throw new Exception("Error al insertar solicitud");
    	}
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
	//busco el nombre del estado
            if($datosModel["une_dir_estado"]>0)
            {   $reses=DatosEstado::editarEstadoModel($datosModel["une_dir_estado"],"ca_uneestados");
            $nombre=$reses["est_nombre"];
            
            }
            else $nombre="";
            $stmt->bindParam(":nom_edo", $nombre);
            $stmt->bindParam(":franqcuenta", $datosModel["franqcuenta"], PDO::PARAM_INT);
            $stmt->bindParam(":numpun", $datosModel["numpun"], PDO::PARAM_INT);
            $stmt->bindParam(":estatuscuenta", $datosModel["estatus"], PDO::PARAM_INT);
            $stmt->bindParam(":fecest", $datosModel["fecest"]);

            $res = $stmt->execute();
//$stmt->debugDumpParams();
           if($res)
            return "success";
           return "error";
        } catch (Exception $ex) {
            return "error";
        }
    }
    
    public function unegocioxCuentaFranq( $cta,$fran) {
        
        $sql = "SELECT une_id, une_descripcion FROM ca_unegocios 
            
WHERE ca_unegocios.cue_clavecuenta =:idcta and  fc_idfranquiciacta=:franqcuenta";
        
        
        
        $stmt = Conexion::conectar()->prepare($sql);
        
        $stmt->bindParam(":idcta", $cta,PDO::PARAM_INT);
        $stmt->bindParam(":franqcuenta", $fran,PDO::PARAM_STR);
        
      
        
        $stmt->execute();
       // $stmt->debugDumpParams();
        return $stmt->fetchAll();
    }

    
    public function unegocioEstado($cta){
    	$ssqe="SELECT ca_unegocios.une_dir_idestado, ca_uneestados.est_id,
 ca_uneestados.est_nombre FROM ca_unegocios
	Inner Join ca_uneestados ON ca_unegocios.une_dir_idestado = ca_uneestados.est_id
 	where cue_clavecuenta=:numcuen
	group by ca_unegocios.une_dir_idestado";
    	   	
    	
    	$stmt = Conexion::conectar()->prepare($ssqe);
    	
    	$stmt->bindParam(":numcuen", $cta,PDO::PARAM_INT);
    	
    	
    	
    	$stmt->execute();
    	// $stmt->debugDumpParams();
    	return $stmt->fetchAll();
    	
    }

}

?>	