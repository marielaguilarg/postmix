<?php


class BorrarImagenesController {
	
	function borrarImagenes(){
		
		include "Utilerias/leevar.php";
		//obtengo cuenta, servicio, etc
		$aux=explode('.',$ref);
		$ricliente=$aux[0];
		$riservicio=$aux[1];
		$ricuenta=$aux[2];
		$aux=explode(".",$feci);
		$fechainicio=$aux[0];
		$fechainicio2=$aux[1];
		$aux=explode(".",$fecf);
		$fechafin=$aux[0];
		$fechafin2=$aux[1];
		//borro de bd y elimino imagen
		if($ricliente!=0)
			if($riservicio!=0) {
				if($ricuenta!=0) { // borro por periodo
					//por cuenta
					$sql="delete ins_imagendetalle FROM ins_imagendetalle
INNER JOIN ins_generales ON i_claveservicio=id_imgclaveservicio AND i_numreporte=id_imgnumreporte
inner join `ca_unegocios`
ON `une_id`=`i_unenumpunto` AND `cue_clavecuenta`=:ricuenta
WHERE id_imgclaveservicio=:riservicio 
 AND STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.', :fechainicio ,'.',:fechainicio2),'%d.%m.%Y')
 AND STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.', :fechafin ,'.',:fechafin2),'%d.%m.%Y') ;    ";
					//            echo $sql;
					//            $rs1=mysql_query($sql);
					
					$parametros["ricuenta"]=$ricuenta;
					$parametros["riservicio"]=$riservicio;
					
				}
				else // todas las cuentas
				{
					// con periodo y por servicio
					$sql="delete ins_imagendetalle FROM ins_imagendetalle
INNER JOIN ins_generales ON i_claveservicio=id_imgclaveservicio AND i_numreporte=id_imgnumreporte
WHERE id_imgclaveservicio=:riservicio
  AND STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.', :fechainicio ,'.',:fechainicio2),'%d.%m.%Y')
 AND STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.', :fechafin ,'.',:fechafin2),'%d.%m.%Y')  ;    ";
					//            echo $sql;
					//            $rs1=mysql_query($sql);
					$parametros["riservicio"]=$riservicio;
					
				}
			}
		else {// todos los servicios
			// con periodo
			// busco los servicios
			$sql="delete ins_imagendetalle FROM ins_imagendetalle
INNER JOIN ins_generales ON i_claveservicio=id_imgclaveservicio AND i_numreporte=id_imgnumreporte

INNER JOIN `ca_servicios` ON `ser_id`=`i_claveservicio` AND `ser_idcliente`=:ricliente
where STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.', :fechainicio ,'.',:fechainicio2),'%d.%m.%Y')
 AND STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.', :fechafin ,'.',:fechafin2),'%d.%m.%Y') ;     ";
			//            echo $sql;
			//            $rs1=mysql_query($sql);
			$parametros["ricliente"]=$ricliente;
		}
		else {//todos los clientes
			//con periodo
			$sql="delete ins_imagendetalle FROM ins_imagendetalle
INNER JOIN ins_generales ON i_claveservicio=id_imgclaveservicio AND i_numreporte=id_imgnumreporte
WHERE STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')>=str_to_date(concat('01.', :fechainicio ,'.',:fechainicio2),'%d.%m.%Y')
 AND STR_TO_DATE(CONCAT('01.',i_mesasignacion),'%d.%m.%Y')<=str_to_date(concat('01.', :fechafin ,'.',:fechafin2),'%d.%m.%Y') ;     ";
			//            echo $sql;
			//            $rs1=mysql_query($sql);
			
		}
	
		
		$parametros["fechainicio"]=$fechainicio;
		$parametros["fechainicio2"]=$fechainicio2;
		$parametros["fechafin"]=$fechafin;
		$parametros["fechafin2"]=$fechafin2;
		try{
		Conexion::ejecutarInsert($sql,$parametros);
		} catch(Exception $ex){
			echo "Hubo un error al borrar. Intente nuevamente";
			die();
		}
		$arr_arch=$_SESSION["arch_borrar"];
		//var_dump($arr_arch);
		// borro archivos
		//
		foreach ($arr_arch as $key => $arrc) {
			//    echo "servicio ".$key;
			foreach ($arrc as $key2=>$value) {
				//        echo "--cuenta ".$key2."<br/>";
				// var_dump($value);
				foreach($value as $key3=>$value3 ){
					//agrego archivos
					$directorio=$value3;
					// $perm=chmod($directorio, 0777);
					//   echo "--".$directorio."<br>";
					//             echo "<<".unlink($directorio);
					$this->rrmdir($directorio);
					
				}
			}
		}
		
		$msg = "PROCESO FINALIZADO SATISFACTORIAMENTE";
		$msg2 = '<table width="400" border="0"  align="center"  >' .
				'<tr><td height="30px"></td></tr><tr><td class="infocuadro" align="center">' . $msg . '</td></tr><tr><td height="30px"></td></tr>
                <tr><td align="center"><a href="index.php?action=srespaldoimagenes">&lt;&lt;  '."Regresar".'  </a> </td></tr></table>';
		echo $msg2;
	}
		function rrmdir($dir) {
			//$v_dir = getcwd();
			//echo "borrar ".$v_dir;
			if (is_dir($dir)) {
				
				$objects = scandir($dir);
				foreach ($objects as $object) {
					//	 echo "--".$object."<br>";
					if ($object != "." && $object != "..") {
						if (is_dir($dir."/".$object) ) rrmdir($dir."/".$object);
						else{ //echo "borrando ".$dir."/".$object;
							unlink($dir."/".$object); }
					}
				}
				reset($objects);
				rmdir($dir);
			}
			else{
				//  echo "borrando ".$dir."<br>";
				unlink($dir); }
				
		
	}
}

