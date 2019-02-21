<?php

class GeneraBusqResController {
	
	public function generarBusquedaRes(){
	include "Utilerias/leevar.php";
	$tiempo_inicio = microtime(true);
	
	$fechaasig_i = $fechainicio . '.' . $fechainicio2;
	$fechaasig_fin = $fechafin . '.' . $fechafin2;
	$Usuario=$_SESSION["NombreUsuario"];
	$_SESSION["UsuarioInd"]=$Usuario;
	$vclienteu = 1;
	$vserviciou = 1;
	$sql_del_us = "delete from tmp_estadistica WHERE tmp_estadistica.usuario =:Usuario";
	//echo "<br>3".$sql_del_us;
	 DatosTemporales::eliminarEstadistica($Usuario);
	
	/* creo consulta  generica */
	$sql_porcuenta = "insert into tmp_estadistica (usuario, numreporte,mes_asignacion) select :Usuario, ins_generales.i_numreporte, str_to_date(concat('01.',ins_generales.i_mesasignacion ),'%d.%m.%Y')
FROM
  (
    ins_generales 
    INNER JOIN ca_unegocios 
      ON  ins_generales.`i_unenumpunto` = ca_unegocios.une_id
  ) 
  INNER JOIN ca_cuentas 
    ON ca_cuentas.cue_id = ca_unegocios.cue_clavecuenta 
where cue_idcliente=:vclienteu and ins_generales.i_claveservicio=:vserviciou";
	
	$parametros=array("vserviciou" => $vserviciou, "Usuario" => $Usuario,"vclienteu"=>$vclienteu);
	if ($mercado != 0) {
		$sql_porcuenta.= " AND ca_cuentas.cue_tipomercado=:mercado";
		$parametros["mercado"]=$mercado;
		$query="SELECT
ca_tipomercado.tm_nombretipo
FROM
ca_tipomercado
where ca_tipomercado.tm_clavetipo=:mercado";
		$result=Conexion::ejecutarQuery($query,array("mercado"=>$mercado));
		foreach($result as $row)
		{
			$_SESSION["ftipomerc"] = $row[0];
		}
		
	}
	if ($cuenta != 0) {
		$sql_porcuenta .= " AND ca_unegocios.cue_clavecuenta=:cuenta  ";
		$parametros["cuenta"] = $cuenta;
	}
	
	if ($franquiciacta != 0) {
		$sql_porcuenta .= " AND fc_idfranquiciacta=:franquiciacta";
		$parametros["franquiciacta"] = $franquiciacta;
		//busco nombre de la franquicia para guardarlo
		
		$_SESSION["ffrancuenta"] = DatosFranquicia::nombreFranquicia($cuenta, $franquiciacta, $this->vclienteu, $this->vserviciou);
	}
	
	if ($unidadnegocio != 0) {
		$sql_porcuenta .= " and ins_generales.i_unenumpunto=:unidadnegocio";
		$parametros["unidadnegocio"] = $unidadnegocio;
	}
	// validamos los niveles de la estructura
	
	
	if ($clanivel1 != 0) {
		$sql_porcuenta.= " AND une_cla_region=:select1  ";
		$parametros["select1"] = $clanivel1;
		
	}
	if ($clanivel2 != 0) {
		$sql_porcuenta.= " AND une_cla_pais=:select2  ";
		$_SESSION["funidadneg"] =Datosndos::nombreNivel2( $clanivel2,"ca_nivel2");
		$parametros["select2"] = $clanivel2;
	}
	if ($clanivel3 != 0) {
		$sql_porcuenta.= " AND une_cla_zona=:select3  ";
		$_SESSION["ffranquicia"] =Datosntres::nombreNivel3( $clanivel3,"ca_nivel3");
		$parametros["select3"] = $clanivel3;
	}
	if ($clanivel4 != 0) {
		$sql_porcuenta.= " AND une_cla_estado=:select4  ";
		$_SESSION["fregion"] =Datosncua::nombreNivel4( $clanivel4,"ca_nivel4");
		$parametros["select4"] = $clanivel4;
	}
	if ($clanivel5 != 0) {
		$sql_porcuenta.= " AND une_cla_ciudad=:select5  ";
		$_SESSION["fzona"] =Datosncin::nombreNivel5( $clanivel5,"ca_nivel5");
		$parametros["select5"] = $clanivel5;
	}
	if ($clanivel6 != 0) {
		$sql_porcuenta.= " AND une_cla_franquicia=:select6  ";
		$_SESSION["fcedis"] =Datosnsei::nombreNivel6( $clanivel6,"ca_nivel6");
		$parametros["select6"] = $clanivel6;
	}
	
	//modificacion del filtro de fecha se usa mes de asignacion
	if ($fechainicio != "") {
		//$fechainicioc = mod_fecha($fechainicio);
		$sql_porcuenta.= " AND str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.',:fechaasig_i ),'%d.%m.%Y')";
		$parametros["fechaasig_i"] = $fechaasig_i;
	}
	if ($fechafin != "") {
		//$fechfinc = mod_fecha($fechafin);
		$sql_porcuenta.= " AND str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.',:fechaasig_fin ),'%d.%m.%Y')";
		$parametros["fechaasig_fin"] = $fechaasig_fin;
	}
	$sql_porcuenta.= " ORDER BY i_numreporte";
	//	echo $select6;
	
	////inserta reportes en la tabla temporal tmp_estadistica
	$rs_sql_us = Conexion::ejecutarInsert($sql_porcuenta,$parametros);

	//valido si hay mas de un reporte
	$sqlt = "select * from tmp_estadistica WHERE tmp_estadistica.usuario = :Usuario";
	//echo $sqlt;
	$rs = Conexion::ejecutarQuery($sqlt,array("Usuario"=>$Usuario));
	
	$num_reg = sizeof($rs);
	/* * ******************************************************************* */
	//guardo los filtros como var de sesion
	
	if(!isset($_SESSION["fperiodo"])||$_SESSION["fperiodo"]=="")
	{	$periodo = Utilerias::fecha_res($fechainicio . '-' . $fechainicio2) . ' '.strtoupper(T_("a")).' ' . Utilerias::fecha_res($fechafin . '-' . $fechafin2);
	
	$_SESSION["fperiodo"] = $periodo;
	$_SESSION["fcuenta"] = $cuenta;
	$_SESSION["fpuntov"] = $unidadnegocio;
	$_SESSION["fnumrep"] = $num_reg;
	}
	//var_dump($_SESSION);
	
	//$_SESSION["fcompania"] =buscaNivel($select1;

	/* * ******************************************************************** */
	if ($num_reg >= 2) {  // pasa a las tablas
	  // $this->encabezaConsulta();
	//	include ("MENresumenresultados.php");
		//  header("Location: ../MEmodulos/MENestadistica.php?un=".$select6);
		return true;
	} else if ($num_reg == 1) {//si es uno envia al punto de venta
		//if ($row = mysql_fetch_array($rs))
			//header("Location: MENprincipal.php?op=Bhistorico2&Opcion=datos&prin=1&numrep=" . $row["numreporte"]."&cser=".$vserviciou."&ccli=".$vclienteu);
			header("index.php?action=indresultadosxrep&numrep=" . $rs[0]["numreporte"] . "&cser=" . $vserviciou . "&ccli=" . $vclienteu);
			
	}
	else {
		// envia mensaje de error
		//echo "hay menos de dos reportes";
		//include ("MENprincipal.php?op=Acuenta&error=1");
		
		$msg = T_("LAS OPCIONES QUE SELECCIONO NO DEVUELVEN NINGUN RESULTADO, POR FAVOR SELECCIONE OTRAS");
		$msg2 = '<table width="400" border="0"  align="center"  >' .
				'<tr><td height="30px"></td></tr><tr><td class="infocuadro" align="center">' . $msg . '</td></tr><tr><td height="30px"></td></tr>
                <tr><td align="center"><a href="index.php?action=consultaResultados">&lt;&lt;  '.T_("Regresar").'  </a> </td></tr></table>';
		echo $msg2;
		die();
	}
	
	}
	
	function buscaNivel($refer) {
		$arre_aux=explode('.', $refer);
		
		$long=(count($arre_aux));
		$pais=$arre_aux[1];
		$zona=$arre_aux[2];
		$estado=$arre_aux[3];
		$ciudad=$arre_aux[4];
		$cedis=$arre_aux[5];
		$region = 1;
		switch ($long) {
			case 2:   $sql = "select ca_paises.pais_nombre as nombre from ca_paises where ca_paises.reg_clave=$region and ca_paises.pais_clave=" . $pais;
			
			
			
			break;
			case 3:  $sql = "SELECT
ca_zonas.zona_nombre as nombre
FROM
ca_zonas
WHERE
ca_zonas.reg_clave =  '$region' AND
ca_zonas.pais_clave =  '$pais' AND
ca_zonas.zona_clave =  '$zona';";
			break;
			case 4:
				
				
				$sql = "SELECT
ca_estados.est_nombre as nombre
FROM
ca_estados
where ca_estados.reg_clave=$region and
ca_estados.pais_clave=$pais and
ca_estados.zona_clave=$zona and
ca_estados.est_clave=$estado";
				break;
			case 5:
				$sql = "SELECT ca_ciudades.ciu_nombre as nombre
FROM
ca_ciudades
where ca_ciudades.reg_clave=$region and
ca_ciudades.pais_clave=$pais and
ca_ciudades.zona_clave=$zona and
ca_ciudades.est_clave=$estado and
ca_ciudades.ciu_clave=$ciudad";
				break;
			case 6:
				
				$sql="SELECT
ca_nivelseis.niv6_nombre as nombre
FROM
ca_nivelseis where ca_nivelseis.reg_clave=$region and
ca_nivelseis.pais_clave=$pais and
ca_nivelseis.zona_clave=$zona and
ca_nivelseis.est_clave=$estado and
ca_nivelseis.ciu_clave=$ciudad and
ca_nivelseis.niv6_clave=$cedis";
				break;
				
			default:$sql="select * from ca_regiones";
			break;
		}
		//echo $sql;
		//$result=mysql_query($sql);
// 		foreach($row=  mysql_fetch_array($result))
// 		{
// 			$nombre=$row[0];
// 		}
	//	mysql_free_result($result);
		return $nombre;
		
		
	}
	
	
		
}


