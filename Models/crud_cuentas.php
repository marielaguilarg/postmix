<?php


require_once "Models/conexion.php";

class DatosCuenta extends Conexion{

    // vistaclientes
    public function vistaCuentasModel($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT cue_id, cue_descripcion, cue_tipomercado FROM $tabla");

        $stmt->execute();

        return $stmt->fetchAll();
    }

        public function vistaCuentasxcliente($idcliente,$tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT cue_id, cue_descripcion, cue_tipomercado FROM $tabla where cue_idcliente=:id_cliente ;");
		$stmt->bindParam("id_cliente", $idcliente,PDO::PARAM_INT);
		$stmt-> execute();

		return $stmt->fetchAll();
	}
	

	public function listaClientesModel($tabla){
        $stmt = Conexion::conectar()->prepare("SELECT cli_id, cli_nombre FROM $tabla ");

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function registroCuentaModel($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (cue_descripcion, cue_tipomercado, cue_siglas, cue_lugar, cue_idcliente) VALUES (:cue_descripcion, :cue_tipomercado, :cue_siglas, :cue_lugar, :cue_idcliente)");

        $stmt->bindParam(":cue_descripcion", $datosModel["nomcuen"], PDO::PARAM_STR);

        $stmt->bindParam(":cue_tipomercado", $datosModel["tipomercuen"], PDO::PARAM_INT);

        $stmt->bindParam(":cue_siglas", $datosModel["siglascuen"], PDO::PARAM_STR);

        $stmt->bindParam(":cue_lugar", $datosModel["lugarcuen"], PDO::PARAM_INT);

        $stmt->bindParam(":cue_idcliente", $datosModel["cliencuen"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "success";
        } 
        else {

            return "error";
        }
    }

    // edita servicio
    public function editarCuentaModel($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT cue_id, cue_descripcion, cue_tipomercado, cue_siglas, cue_lugar, cue_idcliente FROM $tabla  WHERE  cue_id = :idc");

        $stmt->bindParam(":idc", $datosModel, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch();
    }

    public function actualizarCuentaModel($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("	UPDATE $tabla SET  cue_descripcion= :cuedes, cue_tipomercado= :cuetipo, cue_siglas= :cuesiglas, cue_lugar= :cuelugar, cue_idcliente= :cuecli WHERE cue_id= :cue_id");

        $stmt->bindParam(":cuedes", $datosModel["cuedes"], PDO::PARAM_STR);

        $stmt->bindParam(":cuetipo", $datosModel["cuetipo"], PDO::PARAM_INT);

        $stmt->bindParam(":cuecli", $datosModel["cuecli"], PDO::PARAM_INT);

        $stmt->bindParam(":cuesiglas", $datosModel["cuesiglas"], PDO::PARAM_STR);

        $stmt->bindParam(":cuelugar", $datosModel["cuelugar"], PDO::PARAM_STR);

        $stmt->bindParam(":cue_id", $datosModel["id"], PDO::PARAM_INT);

        IF ($stmt->execute()) {

            return "success";
        } 
        else {

            return "error";
        }

        $stmt->close();
    }

    // borra servicio
    public function borrarCuentaModel($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE cue_id = :ids");

        $stmt->bindParam(":ids", $datosModel, PDO::PARAM_INT);

        IF ($stmt->execute()) {

            return "success";
        } 
        else {

            return "error";
        }

        $stmt->close();
    }

function nombreCuenta($cuenta, $cliente) {

    $sql = "SELECT
ca_cuentas.cue_idcliente,

ca_cuentas.cue_id,
ca_cuentas.cue_descripcion,
ca_cuentas.cue_tipomercado,
ca_cuentas.cue_siglas,
ca_cuentas.cue_lugar
FROM
ca_cuentas
where ca_cuentas.cue_idcliente=:cliente ";

    $sql.=" and cue_id=:cuenta";
    $sql.=" order by ca_cuentas.cue_id";
  
    $res = Conexion::conectar()->prepare($sql);
    $res->bindParam(":cuenta", $cuenta, PDO::PARAM_INT);
    $res->bindParam(":cliente", $cliente, PDO::PARAM_INT);
    $res->execute();
   
  $reg=$res->fetchAll();
    
    foreach ($reg as $row) {
        $nombre = $row["cue_descripcion"];
    }

    return $nombre;
}

public function cuentasxNiveltm($VarNivel2,$aux,$cliente,$cuenta){
        $sql_cuentas = "SELECT



ca_cuentas.cue_id,ca_cuentas.cue_descripcion

FROM

ca_unegocios

Inner Join ca_cuentas ON ca_unegocios.cue_clavecuenta = ca_cuentas.cue_id  ";

        switch ($VarNivel2) {

            case 6:
                $filtro = " ca_unegocios.une_cla_region=$aux[1] and

ca_unegocios.une_cla_pais=$aux[2] and

ca_unegocios.une_cla_zona=$aux[3] and

ca_unegocios.une_cla_estado=$aux[4] and

ca_unegocios.une_cla_ciudad=$aux[5] and

ca_unegocios.une_cla_franquicia=$aux[6] ";

                break;

            case 5:
                $filtro = " ca_unegocios.une_cla_region=$aux[1] and

ca_unegocios.une_cla_pais=$aux[2] and

ca_unegocios.une_cla_zona=$aux[3] and

ca_unegocios.une_cla_estado=$aux[4] and

ca_unegocios.une_cla_ciudad=$aux[5] ";

                break;

            case 4:
                $filtro = " ca_unegocios.une_cla_region=$aux[1] and

ca_unegocios.une_cla_pais=$aux[2] and

ca_unegocios.une_cla_zona=$aux[3] and

ca_unegocios.une_cla_estado=$aux[4] ";

                break;

            case 3:
                $filtro = "ca_unegocios.une_cla_region=$aux[1] and

ca_unegocios.une_cla_pais=$aux[2] and

ca_unegocios.une_cla_zona=$aux[3] ";

                break;

            case 2:
                $filtro = "ca_unegocios.une_cla_region=$aux[1] and

ca_unegocios.une_cla_pais=$aux[2]";

                break;

            case 1:
                $filtro = "ca_unegocios.une_cla_region=$aux[1]";

                break;
        } // fin switch

        $sql_cuentas .= " where " . $filtro . " and cue_tipomercado=:opcionSeleccionadaCuenta and `ca_cuentas`.`cue_idcliente`=:scli";

        $sql_cuentas .= " GROUP BY ca_unegocios.cue_clavecuenta;";

        $parametros = array(
            "scli" => $cliente,

            "opcionSeleccionadaCuenta" => $cuenta
        );

        $res = Conexion::ejecutarQuery($sql_cuentas, $parametros);

        return $res;
    }

    public function cuentasxNivel($VarNivel2, $aux, $cliente)
    {
        $sql_cuentas = "SELECT

        

ca_cuentas.cue_id,ca_cuentas.cue_descripcion

FROM

ca_unegocios

Inner Join ca_cuentas ON ca_unegocios.cue_clavecuenta = ca_cuentas.cue_id  ";

        switch ($VarNivel2) {

            case 6:
                $filtro = " ca_unegocios.une_cla_region=$aux[1] and

        ca_unegocios.une_cla_pais=$aux[2] and

        ca_unegocios.une_cla_zona=$aux[3] and

        ca_unegocios.une_cla_estado=$aux[4] and

        ca_unegocios.une_cla_ciudad=$aux[5] and

        ca_unegocios.une_cla_franquicia=$aux[6] ";

                break;

            case 5:
                $filtro = " ca_unegocios.une_cla_region=$aux[1] and

        ca_unegocios.une_cla_pais=$aux[2] and

        ca_unegocios.une_cla_zona=$aux[3] and

        ca_unegocios.une_cla_estado=$aux[4] and

        ca_unegocios.une_cla_ciudad=$aux[5] ";

                break;

            case 4:
                $filtro = " ca_unegocios.une_cla_region=$aux[1] and

        ca_unegocios.une_cla_pais=$aux[2] and

        ca_unegocios.une_cla_zona=$aux[3] and

        ca_unegocios.une_cla_estado=$aux[4] ";

                break;

            case 3:
                $filtro = "ca_unegocios.une_cla_region=$aux[1] and

        ca_unegocios.une_cla_pais=$aux[2] and

        ca_unegocios.une_cla_zona=$aux[3] ";

                break;

            case 2:
                $filtro = "ca_unegocios.une_cla_region=$aux[1] and

        ca_unegocios.une_cla_pais=$aux[2]";

                break;

            case 1:
                $filtro = "ca_unegocios.une_cla_region=$aux[1]";

                break;
        } // fin switch

        $sql_cuentas .= " where " . $filtro . " and `ca_cuentas`.`cue_idcliente`=:scli";

        $sql_cuentas .= " GROUP BY ca_unegocios.cue_clavecuenta;";

        $parametros = array(
            "scli" => $cliente
        );

        $res = Conexion::ejecutarQuery($sql_cuentas, $parametros);

        return $res;
    }

    public function cuentasxCliente($tabla, $tipoMercado, $cliente)
    {
        $sql_cuentas = "SELECT cue_id, cue_descripcion FROM $tabla WHERE cue_tipomercado=:opcionSeleccionadaCuenta" . 
        " and `ca_cuentas`.`cue_idcliente`=:scli;";

        $parametros = array(
            "opcionSeleccionadaCuenta" => $tipoMercado,

            "scli" => $cliente
        );

        $res = Conexion::ejecutarQuery($sql_cuentas, $parametros);

        return $res;
    }

    public function cuentasxCliente2($tabla, $cliente)
    {
        $sql_cuentas = "SELECT cue_id, cue_descripcion FROM $tabla WHERE  `ca_cuentas`.`cue_idcliente`=:scli;";

        $parametros = array(
            "scli" => $cliente
        );

        $res = Conexion::ejecutarQuery($sql_cuentas, $parametros);

        return $res;
    }

    public function registroPonderaCuenta($datosModel, $tabla){

		$stmt = Conexion::conectar()-> prepare("INSERT INTO cue_seccionesdetalles (ser_claveservicio, sec_numseccion, sd_clavecuenta, sd_ponderacion, sd_fechainicio, sd_fechafinal) VALUES(:nser, :nsec, :ncta, :npond, :fecini, :fecfin)");

		$stmt->bindParam(":nser", $datosModel["nser"], PDO::PARAM_INT);
		$stmt->bindParam(":nsec", $datosModel["nsec"], PDO::PARAM_INT);
		$stmt->bindParam(":ncta", $datosModel["ncta"], PDO::PARAM_INT);
		$stmt->bindParam(":npond", $datosModel["npond"], PDO::PARAM_INT);
		$stmt->bindParam(":fecini", $datosModel["fecini"], PDO::PARAM_STR);
		$stmt->bindParam(":fecfin", $datosModel["fecfin"], PDO::PARAM_STR);

		if($stmt-> execute()){

			return "success";
		}
		 else{

		 	return "error";
		 }
		 $stmt->close();

	}

public function validaperiodocuenta($datosModel, $tabla){
		$stmt = Conexion::conectar()-> prepare("SELECT `cue_seccionesdetalles`.`sd_fechainicio`, `cue_seccionesdetalles`.`sd_fechafinal`, `cue_seccionesdetalles`.`ser_claveservicio`,`cue_seccionesdetalles`.`sec_numseccion`, `cue_seccionesdetalles`.`sd_clavecuenta` FROM $tabla WHERE `cue_seccionesdetalles`.`ser_claveservicio` =:nser AND `cue_seccionesdetalles`.`sec_numseccion` =:nsec AND `cue_seccionesdetalles`.`sd_clavecuenta` =:ncta AND `cue_seccionesdetalles`.`sd_fechainicio` <=:fecini AND `cue_seccionesdetalles`.`sd_fechafinal` >=:fecini");

		$stmt->bindParam("nser", $datosModel["nser"],PDO::PARAM_INT);
		$stmt->bindParam("nsec", $datosModel["nsec"],PDO::PARAM_INT);
		$stmt->bindParam("ncta", $datosModel["ncta"],PDO::PARAM_INT);
		$stmt->bindParam("fecini", $datosModel["fecini"],PDO::PARAM_STR);	
		
		$stmt-> execute();

		return $stmt->fetch();
	}


}

