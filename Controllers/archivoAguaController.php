<?php
//////////////////////////////////////////////////////////////////////////
//																		//
//	codigo para generar reporte anual de agua en excel   			//
//																		//
//////////////////////////////////////////////////////////////////////////
include "Models/crud_usuario.php";
include "Controllers/subnivelController.php";
include "Models/crud_inspectores.php";
include "Models/crud_n1.php";
include "Models/crud_n2.php";
include "Models/crud_n3.php";
include "Models/crud_n4.php";
include "Models/crud_n5.php";
include "Models/crud_n6.php";
include "Models/crud_cuentas.php";
include "Models/crud_franquicias.php";
include "Models/crud_servicios.php";
include "Models/crud_estandar.php";
require_once 'libs/PHPExcel-1.8/PHPExcel.php';
class ArchivoAguaController {

	
	private  $arrcolores;
	private  $cliente, $servicio;
	private   $workbook;
	public function generarArchivo(){
		
		define(VACIO,"");
		include "Utilerias/leevar.php";
		$user = $_SESSION["Usuario"];
		
		
		$arrcolores=array("azul"=>"48","verde"=>"31","naranja"=>"orange","amarillo"=>"yellow",
				"rojo"=>"62","verdeo"=>"30","gris"=>"gray", "blanco"=>"white", "verdef"=>"green", "rojof"=>"60" );
		
		$this->arrcolores=array("azul"=>"ff0066cc","verde"=>"ff2f67d1",
				"rojo"=>"ff5dade2","verdeo"=>"ff308cd8" );
		try{
			$rsu=UsuarioModel::getUsuario($user, "cnfg_usuarios");
			foreach ($rsu as $rowu) {
				$gpous= $rowu[cus_clavegrupo];
				if ($gpous=='lab')
					$tipocons= $rowu[cus_tipoconsulta];
			}
				
		// si es adm nada
		// si es lab busca el laboratorio
		// si es
		$fechaasig_i=$fechainicio.'.'.$fechainicio2;
		$fechaasig_fin=$fechafin.'.'.$fechafin2;
		
		
		
		$datini2=SubnivelController::obtienedato($fechaasig_fin,1);
		$londat2=SubnivelController::obtienelon($fechaasig_fin,1);
		
		$mesfin=substr($fechaasig_fin,$datini2,$londat2);
		
		if ($mesfin=1 || $mesfin=3 || $mesfin=5 || $mesfin=7 || $mesfin=8 || $mesfin=10 || $mesfin=12) {
			$diafin=31;
		} else if ($mesfin=4 || $mesfin=6 || $mesfin=9 || $mesfin=12) {
			$diafin=30;
		} else if ($mesfin=2) {
			$diafin=28;
		}
		
		
		$this->servicio=1;
		$this->cliente=1;
		set_time_limit(360);
		ini_set("memory_limit","120M");
		
	
		
		//CREA EL ARCHIVO PARA EXPORTAR
		$nomcuenta="Resumen_de_agua".date("dmyHi");
		
		$arch= "../Archivos/".$nomcuenta.".xlsx";
		$base=getcwd();
		
		
		////echo "--".strrpos($base,"\\");
		$base=substr($base, 0, strrpos($base,"\\"));
		$fname = tempnam($base.DIRECTORY_SEPARATOR."Archivos".DIRECTORY_SEPARATOR, $nomcuenta.".xlsx");
		$this->workbook =new PHPExcel();
		$this->workbook->getActiveSheet()->setTitle($nomcuenta);
		
		$this->workbook->setActiveSheetIndex(0);
	
		$cuenta='-1';
		$ren_ex=1;
		$año1=2012;
	
	
		
		$text_format1 =array(
				'font' => array('bold' => true,'name'=>'Arial', "size"    => 10),
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array('argb'    =>  $this->arrcolores["verdeo"])),
				"alignment" => array("horizontal"=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
		
		$text_format_det =
		array(
				'font' => array('name'=>'Arial', "size"    => 10),
				
				"alignment" => array("horizontal"=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
		
		
		$text_format_det1 =array(
				'font' => array('name'=>'Arial', "size"    => 10),
				"alignment" => array("horizontal"=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
		);
		
		
		//**** creo archivo ****
		//**** creo encabezado ****
		$enctablas=array("SERVICIO","NO DE MUESTRA","TIPO DE MUESTRA","ORIGEN DE LA MUESTRA","NO DE TOMA","FUENTE DE ABASTECIMIENTO", "NO DE UNIDADES FISICOQUIMICO","CAPACIDAD UNIDADES FISICOQUIMICO","NO DE UNIDADES MICROBIOLOGICO","CAPACIDAD DE UNIDADES MIRCOBIOLOGICO","ID CLIENTE","PUNTO DE VENTA","NO DE REPORTE","MES DE ASIGNACION","AUDITOR","FECHA Y HORA DE RECOLECCION","FECHA Y HORA DE ENTREGA","TIEMPO TRANSCURRIDO","LABORATORIO","ESTATUS","CAUSA DE CANCELACION","ANALISTA FISICOQUIMICO","FECHA DE CAPTURA FSICOQUIMICO","TIEMPO TRANSCURRIDO FISICOQUIMICO","ANALISTA MICROBIOLOGICO","FECHA DE CAPTURA MICROBIOLOGICO","TIEMPO TRANSCURRIDO MICROBIOLOGICO","FRANQUICIA DEL CLIENTE","CUENTA","REGION","ESTADO","CIUDAD","FRANQUICIA DE LA CUENTA","DIRECCION DEL PUNTO DE VENTA");
		
		/*** creo emcabezado de resultados ****/
		$sql="SELECT
cue_reactivosestandardetalle.red_parametroesp
FROM `cue_reactivosestandardetalle`
WHERE `cue_reactivosestandardetalle`.`ser_claveservicio` =1 AND concat(sec_numseccion,'.', r_numreactivo,'.', re_numcomponente,'.', re_numcaracteristica,
'.', re_numcomponente2) = '5.0.2.0.0'
ORDER BY if(cue_reactivosestandardetalle.red_numcaracteristica2=14,1,if(cue_reactivosestandardetalle.red_numcaracteristica2=15,2,
if(cue_reactivosestandardetalle.red_numcaracteristica2=19,6,if(cue_reactivosestandardetalle.red_numcaracteristica2<4,cue_reactivosestandardetalle.red_numcaracteristica2+2,
if(cue_reactivosestandardetalle.red_numcaracteristica2=20,17,if(cue_reactivosestandardetalle.red_numcaracteristica2>13 and cue_reactivosestandardetalle.red_numcaracteristica2<21,
cue_reactivosestandardetalle.red_numcaracteristica2+2,if(cue_reactivosestandardetalle.red_numcaracteristica2>3 and cue_reactivosestandardetalle.red_numcaracteristica2<14,
cue_reactivosestandardetalle.red_numcaracteristica2+3,cue_reactivosestandardetalle.red_numcaracteristica2)))))))
 ASC";
		
		
		$res0=Conexion::ejecutarQuerysp($sql);
		$totalE= sizeof($res0);
		$nomres="";
		If ($totalE>0) {
			foreach ($res0 as $row) {
				$enctablas[] = $row[0];
				//		$nomres=$nomres.$row[0].',';
			}
		}
		$arr_colxsec=array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
		
		
		$letra=65;
		$text_format =array(
				'font' => array('bold' => true,"italic"=>true,'name'=>'Arial', "size"    => 8),
				
				"alignment" => array("horizontal"=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
		
		
		
		for($i=0;$i<54;$i++) {
			$nomcol=$enctablas[$i];
			//		echo Utilerias::michr($letra);
			//	 $this->workbook->getActiveSheet()->setCellValue(Utilerias::michr($letrae++)."1", "ORDEN",$text_format1);
			 $this->workbook->getActiveSheet()->setCellValue(Utilerias::michr($letra).$ren_ex, $enctablas[$i], $text_format1);
			 $this->workbook->getActiveSheet()->getStyle(Utilerias::michr($letra).$ren_ex)->applyFromArray($text_format1);
			$this->worksheet=$this->rangoCeldas($letra, $ren_ex, $arr_colxsec[$i],$text_format,$this->worksheet);
			$letra+=$arr_colxsec[$i];
		}
		
		//**** creo estandar
		// DESPLEGAR ESTANDARES
		$letra=64;
		$text_format_std1 =array(
				'font' => array('name'=>'Arial', "size"    => 8),
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array('argb'    =>  $this->arrcolores["verde"])),
				"alignment" => array("horizontal"=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
		
		
		$esttablas=array("","","","","","", " ", " ", " "," "," "," ",
				"","","","","", " ", " ", " "," "," "," ",
				"","","","","", " ", " ", " "," "," ", " "," "," ");
		$sql="SELECT
cue_reactivosestandardetalle.red_estandar
FROM `cue_reactivosestandardetalle`
WHERE cue_reactivosestandardetalle.ser_claveservicio = 1 AND concat(sec_numseccion,'.', r_numreactivo,'.',
 re_numcomponente,'.', re_numcaracteristica,'.', re_numcomponente2) = '5.0.2.0.0' AND cue_reactivosestandardetalle.red_numcaracteristica2 <> '14' 
AND cue_reactivosestandardetalle.red_numcaracteristica2 <> '15' AND cue_reactivosestandardetalle.red_numcaracteristica2 <> '21'
ORDER BY  if (cue_reactivosestandardetalle.red_numcaracteristica2=19,4, if ((cue_reactivosestandardetalle.red_numcaracteristica2>=4
 and cue_reactivosestandardetalle.red_numcaracteristica2<=13),cue_reactivosestandardetalle.red_numcaracteristica2+1,
if (cue_reactivosestandardetalle.red_numcaracteristica2=20,15,cue_reactivosestandardetalle.red_numcaracteristica2))) ASC";
		$res0=Conexion::ejecutarQuerysp($sql);
		$totalE= sizeof($res0);
		$nomres="";
		If ($totalE>0) {
			foreach ($res0 as $row) {
				$esttablas[] = $row[0];
			}
		}
		
		for($i=0;$i<54;$i++) {
			$letra++;
			 $this->workbook->getActiveSheet()->setCellValue(Utilerias::michr($letra)."2", $esttablas[$i], $text_format_std1);
			 $this->workbook->getActiveSheet()->getStyle(Utilerias::michr($letra)."2")->applyFromArray($text_format_std1);
		}
		
		
		//**** creo detalle ****
		$sql="SELECT 
  `i_claveservicio`,
  ID,
  mue_tipomuestra,
  mue_origenmuestra,
  mue_numtoma,
  mue_fuenteabas,
  mue_numunidadesFQ,
  mue_capacidadFQ,
  mue_numunidadesMB,
  mue_capacidadMB,
  une_idpepsi,
  une_descripcion,
  mue_numreporte,
  mesas,
  i_claveinspector,
  mue_fechahora,
  rm_fechahora,
  CONCAT(
    LEFT(
      TIMEDIFF(rm_fechahora, mue_fechahora),
      2
    ),
    '.',
    TRUNCATE(
      (
        (
          RIGHT(
            LEFT(
              TIMEDIFF(rm_fechahora, mue_fechahora),
              5
            ),
            2
          )
        ) * 10
      ) / 60,
      0
    )
  ) AS tiempos_entrega,
  rm_embotelladora,
  mue_estatusmuestra,
  mue_causacan,
  mue_nomanalistaFQ,
  mue_fechoranalisisFQ,
  CONCAT(
    LEFT(
      TIMEDIFF(
        mue_fechoranalisisFQ,
        rm_fechahora
      ),
      LENGTH(
        TIMEDIFF(
          mue_fechoranalisisFQ,
          rm_fechahora
        )
      ) - 6
    ),
    '.',
    TRUNCATE(
      (
        (
          SUBSTRING(
            TIMEDIFF(
              mue_fechoranalisisFQ,
              rm_fechahora
            ),
            LENGTH(
              TIMEDIFF(
                mue_fechoranalisisFQ,
                rm_fechahora
              )
            ) - 4,
            2
          ) * 10
        ) / 60
      ),
      0
    )
  ) AS tiempo_FQ,
  mue_nomanalistaMB,
  mue_fechoranalisisMB,
  CONCAT(
    LEFT(
      TIMEDIFF(
        mue_fechoranalisisMB,
        rm_fechahora
      ),
      LENGTH(
        TIMEDIFF(
          mue_fechoranalisisMB,
          rm_fechahora
        )
      ) - 6
    ),
    '.',
    TRUNCATE(
      (
        (
          SUBSTRING(
            TIMEDIFF(
              mue_fechoranalisisMB,
              rm_fechahora
            ),
            LENGTH(
              TIMEDIFF(
                mue_fechoranalisisMB,
                rm_fechahora
              )
            ) - 4,
            2
          ) * 10
        ) / 60
      ),
      0
    )
  ) AS tiempo_MB,
  une_cla_region,
  une_cla_pais,
  une_cla_zona,
  une_cla_estado,
  une_cla_ciudad,
  fc_idfranquiciacta,
i_claveservicio,
  `i_claveservicio`,

  une_cla_franquicia,
  cue_clavecuenta,
  CONCAT(
    une_dir_calle,
    ' ',
    une_dir_numeroext,
    ' ',
    une_dir_numeroint,
    ' ',
    une_dir_manzana,
    ' ',
    une_dir_lote,
    ' COLONIA ',
    une_dir_colonia,
    ', ',
    une_dir_delegacion
  ) AS direc 
FROM
  (SELECT 
    aa_muestras.mue_idmuestra AS ID,
    aa_muestras.mue_tipomuestra,
    aa_muestras.mue_origenmuestra,
    aa_muestras.mue_numtoma,
    aa_muestras.mue_fuenteabas,
    aa_muestras.mue_numunidadesFQ,
    aa_muestras.mue_capacidadFQ,
    aa_muestras.mue_numunidadesMB,
    aa_muestras.mue_capacidadMB,
    ca_unegocios.une_descripcion,
    ca_unegocios.une_idpepsi,
    aa_muestras.mue_numreporte,
    ins_generales.i_mesasignacion AS mesas,
    aa_muestras.mue_fechahora,
    ins_generales.i_claveinspector,
    aa_muestras.mue_estatusmuestra,
    aa_muestras.mue_causacan,
    aa_muestras.mue_fechoranalisisFQ,
    aa_muestras.mue_nomanalistaMB,
    aa_muestras.mue_fechoranalisisMB,
    aa_muestras.mue_nomanalistaFQ,
    ca_unegocios.une_dir_calle,
    ca_unegocios.une_dir_numeroext,
    ca_unegocios.une_dir_numeroint,
    ca_unegocios.une_dir_manzana,
    ca_unegocios.une_cla_franquicia,
    ca_unegocios.une_dir_lote,
    ca_unegocios.une_dir_colonia,
    ca_unegocios.une_dir_delegacion,
    ca_unegocios.une_dir_municipio,
    ca_unegocios.une_dir_estado,
    ca_unegocios.une_dir_cp,
    ca_unegocios.une_cla_region,
    ca_unegocios.une_cla_pais,
    ca_unegocios.une_cla_zona,
    ca_unegocios.une_cla_estado,
    ca_unegocios.une_cla_ciudad,
    ca_unegocios.cue_clavecuenta,
    ca_unegocios.une_dir_idestado,
    ca_unegocios.fc_idfranquiciacta,
    DATE (aa_muestras.mue_fechahora) AS FECHAMUES,
    `i_claveservicio` 
  FROM
    aa_muestras 
    INNER JOIN ins_generales 
      ON aa_muestras.mue_numreporte = ins_generales.i_numreporte 
    INNER JOIN ca_unegocios 
      ON ins_generales.`i_unenumpunto`= ca_unegocios.une_id 
    WHERE DATE (str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y'))>= str_to_date(concat('01.',:fechaasig_i),'%d.%m.%Y') AND
DATE (str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y'))<= str_to_date(concat(:diafin,'.',:fechaasig_fin),'%d.%m.%Y')) AS A LEFT JOIN
 (SELECT aa_recepcionmuestra.rm_idrecepcionmuestra, aa_recepcionmuestradetalle.mue_idmuestra, aa_recepcionmuestra.rm_fechahora, aa_recepcionmuestra.rm_embotelladora 
FROM aa_recepcionmuestra Inner Join aa_recepcionmuestradetalle ON
aa_recepcionmuestra.rm_idrecepcionmuestra = aa_recepcionmuestradetalle.rm_idrecepcionmuestra 
GROUP BY aa_recepcionmuestra.rm_idrecepcionmuestra, aa_recepcionmuestradetalle.mue_idmuestra) AS B ON A.ID=B.mue_idmuestra";
		//echo $sql;
		$parametros=array("diafin"=>$diafin,"fechaasig_fin"=>$fechaasig_fin,"fechaasig_i"=>$fechaasig_i);
		if ($gpous =='lab') {
			$sql=$sql." where rm_embotelladora=:tipocons";
			$parametros["tipocons"]=$tipocons;
		}
		
		$res1=Conexion::ejecutarQuery($sql,$parametros);
		
		//die();
		$total= sizeof($res1);
		$letra=65;
		$renglon=3;
		If ($total>0) {
			foreach ($res1 as $row) {
				// busca valores
				$idserv=$row["i_claveservicio"];
				$tipomue =$row["mue_tipomuestra"];
				$origen =$row["mue_origenmuestra"];
				$numtoma =$row["mue_numtoma"];
				$fuenab=$row["mue_fuenteabas"];
				$audit=$row["i_claveinspector"];
				$labor=$row["rm_embotelladora"];
				$estatus=$row["mue_estatusmuestra"];
				$causa=$row["mue_causacan"];
				$clacli=$row["cli_idcliente"];
				$claser=$row["i_claveservicio"];
				$clareg=$row["une_cla_region"];
				$clapais=$row["une_cla_pais"];
				$clazona=$row["une_cla_zona"];
				$claestado=$row["une_cla_estado"];
				$claciudad=$row["une_cla_ciudad"];
				$clafran=$row["une_cla_franquicia"];
				$clafrancta=$row["fc_idfranquiciacta"];
				$clacta=$row["cue_clavecuenta"];
				$mesasig=Utilerias::cambiaMesG($row["mesas"]);
						
				// actualiza tipo de muestra;
				$destipomue=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",41,$tipomue);
				
				
				//origen de la muestra
				$sqlorimu="SELECT ca_catalogosdetalle.cad_idcatalogo, ca_catalogosdetalle.cad_idopcion, ca_catalogosdetalle.cad_descripcionesp, ca_catalogosdetalle.cad_descripcioning
 FROM ca_catalogosdetalle WHERE ca_catalogosdetalle.cad_idcatalogo =  '21' AND ca_catalogosdetalle.cad_idopcion =  ".$origen;
				
				$orimue=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle", 21, $origen);
				
				
				//numero de toma
				$sqlnum="SELECT ca_catalogosdetalle.cad_idcatalogo, ca_catalogosdetalle.cad_idopcion, 
ca_catalogosdetalle.cad_descripcionesp, ca_catalogosdetalle.cad_descripcioning 
FROM ca_catalogosdetalle WHERE ca_catalogosdetalle.cad_idcatalogo =  '42' 
AND ca_catalogosdetalle.cad_idopcion =  ".$numtoma;
				$toma= DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle", 42, $numtoma);
						
				//fuente de abastecimiento
				$sqlnum="SELECT ca_catalogosdetalle.cad_idcatalogo, 
ca_catalogosdetalle.cad_idopcion, ca_catalogosdetalle.cad_descripcionesp, 
ca_catalogosdetalle.cad_descripcioning FROM ca_catalogosdetalle 
WHERE ca_catalogosdetalle.cad_idcatalogo =  '45' 
AND ca_catalogosdetalle.cad_idopcion =  ".$fuenab;
				
				$fabas=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",45,$fuenab);
							
				//auditor
				$sqlnum="SELECT ca_inspectores.ins_clave, ca_inspectores.ins_nombre FROM ca_inspectores WHERE
ca_inspectores.ins_clave =  ".$audit;
				
				$rownum=DatosInspector::getInspectorxId($audit);
				$nomaudit= $rownum["ins_nombr"];
							
				//laboratorio
				if ($labor) {
					;
					
					$nomlab=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",43,$labor);
					
				} else {
					$nomlab="";
				}
				
				// estatus
				if ($estatus==5){
					$nomstatus="Terminada";
				} else if ($estatus==6){
					$nomstatus="Cancelada";
				} else {
					$nomstatus="En proceso";
				}
				
				
				//causa de cancelacion
				if ($causa) {
					$nomcau= DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle", 44, $causa);
					
				}else {
					$nomcau="";
				}
				
				// actualiza region
				$sqlnum="SELECT ca_regiones.reg_clave, ca_regiones.reg_nombre, ca_regiones.cli_idcliente FROM ca_regiones
WHERE ca_regiones.cli_idcliente =  '$clacli' AND ca_regiones.reg_clave =  '$clareg'";
				$nomreg=Datosnuno::nombreNivel1($clareg,"ca_nivel1");
				
			
				// actualiza pais
				$sqlnum="SELECT ca_paises.pais_nombre FROM ca_paises WHERE ca_paises.reg_clave =  '$clareg' AND
ca_paises.pais_clave =  '$clapais'";
				
				
			   $nompais=Datosndos::nombreNivel2($clapais, "ca_nivel2");
				
				
				// actualiza zona
				$sqlnum="SELECT ca_zonas.zona_nombre FROM ca_zonas WHERE ca_zonas.reg_clave =  '$clareg' AND
ca_zonas.pais_clave =  '$clapais' AND ca_zonas.zona_clave =  '$clazona'";
				
				$nomzona= Datosntres::nombreNivel3($clazona, "ca_nivel3");
								
				// actualiza estado
				$sqlnum="SELECT ca_estados.est_nombre FROM ca_estados WHERE ca_estados.reg_clave =  '$clareg' AND
ca_estados.pais_clave =  '$clapais' AND ca_estados.zona_clave =  '$clazona' AND ca_estados.est_clave =  '$claestado'";
							
				$nomedo=Datosncua::nombreNivel4($claestado, "ca_nivel4");
						
				// actualiza ciudad
				$sqlnum="SELECT ca_ciudades.ciu_nombre 
FROM ca_ciudades WHERE ca_ciudades.reg_clave =  '$clareg' 
AND ca_ciudades.pais_clave =  '$clapais' AND ca_ciudades.zona_clave =  '$clazona' 
AND ca_ciudades.est_clave =  '$claestado' AND ca_ciudades.ciu_clave =  '$claciudad'";
				//echo $sqlnum;
				
				$nomciu= Datosncin::nombreNivel5($claciudad, "ca_nivel5");
			
				
				// actualiza cuentas
				$sqlnum="SELECT ca_cuentas.cue_descripcion FROM ca_cuentas WHERE ca_cuentas.cli_idcliente =  ".$this->cliente." AND
ca_cuentas.cue_clavecuenta =  '$clacta'";
				
				
			   $nomcuen= DatosCuenta::nombreCuenta($clacta,$this->cliente );
				
				
				//actualiza ciudad
				$sqlnum="SELECT ca_nivelseis.niv6_nombre 
FROM ca_nivelseis WHERE ca_nivelseis.reg_clave =  '$clareg' 
AND ca_nivelseis.pais_clave = '$clapais' AND ca_nivelseis.zona_clave =  '$clazona' AND ca_nivelseis.est_clave =  '$claestado' AND ca_nivelseis.ciu_clave =  '$claciudad' AND ca_nivelseis.niv6_clave =  '$clafran'";
				
				$nomniv6= Datosnsei::nombreNivel6($clafran, "ca_nivel6");
				
				
				//actualiza franquicia cuenta
				$sqlnum="SELECT ca_franquiciascuenta.cf_descripcion FROM ca_franquiciascuenta WHERE
ca_franquiciascuenta.cli_idcliente =  '$clacli' AND
ca_franquiciascuenta.ser_claveservicio =  '$claser' AND
ca_franquiciascuenta.cue_clavecuenta =  '$clacta' AND
ca_franquiciascuenta.fc_idfranquiciacta =  '$clafrancta'";
				
				$nomfrancta= DatosFranquicia::nombreFranquicia($clacta, $clafrancta, $this->cliente);
				
				
				//actuaiza servicio
				$sqlser="SELECT ca_servicios.ser_descripcionesp FROM ca_servicios WHERE ca_servicios.ser_claveservicio =  '$idserv'";
				$rsse=DatosServicio::vistaNomServicioModel($idserv, "ca_servicios");
				
				$nomser= $rsse["ser_descripcionesp"];
				
				
				$dattablas=array($nomser,$row[1],$destipomue,$orimue,$toma,$fabas, $row[6],$row[7],$row[8],$row[9],
						$row[10],$row[11],$row[12],$mesasig,$nomaudit,$row[15],$row[16],$row[17],$nomlab,$nomstatus,
						$nomcau,$row[21],$row[22],$row[23],$row[24],$row[25],$row[26],$nomzona,$nomcuen,$nomedo,
						$nomciu,$nomniv6,$nomfrancta,$row[37]);
				
				 
				 $sqlnum="SELECT cue_reactivosestandardetalle.red_numcaracteristica2, cue_reactivosestandardetalle.red_tipodato,
 cue_reactivosestandardetalle.red_clavecatalogo FROM cue_reactivosestandardetalle
 Inner Join cue_secciones ON cue_reactivosestandardetalle.ser_claveservicio = cue_secciones.ser_claveservicio 
AND cue_reactivosestandardetalle.sec_numseccion = cue_secciones.sec_numseccion WHERE
cue_reactivosestandardetalle.ser_claveservicio =  :claser AND cue_secciones.sec_indagua =  '1' AND
cue_reactivosestandardetalle.re_numcomponente =  :comp ORDER BY if(cue_reactivosestandardetalle.red_numcaracteristica2=14,1,
if(cue_reactivosestandardetalle.red_numcaracteristica2=15,2,if(cue_reactivosestandardetalle.red_numcaracteristica2=19,6,
 if(cue_reactivosestandardetalle.red_numcaracteristica2<4,cue_reactivosestandardetalle.red_numcaracteristica2+2,
if(cue_reactivosestandardetalle.red_numcaracteristica2=20,17,if(cue_reactivosestandardetalle.red_numcaracteristica2>13 
 and cue_reactivosestandardetalle.red_numcaracteristica2<21,cue_reactivosestandardetalle.red_numcaracteristica2+2,
if(cue_reactivosestandardetalle.red_numcaracteristica2>3
and cue_reactivosestandardetalle.red_numcaracteristica2<14,cue_reactivosestandardetalle.red_numcaracteristica2+3,
cue_reactivosestandardetalle.red_numcaracteristica2))))))) ASC";
				 $parametros=array("claser"=>$claser,"comp"=>$row[2]);
				 echo "+++";
				 $rsnum=Conexion::ejecutarQuery($sqlnum,$parametros);
				 echo "fin";
				 foreach ($rsnum as $rown) {
				 	$numcar2= $rown[0];
				 	$tipodat= $rown[1];
				 	$numcat=$rown[2];
				 	// obten resultado
				 	$sqlres="SELECT ins_detalleestandar.ide_idmuestra, ins_detalleestandar.ide_valorreal FROM ins_detalleestandar
WHERE ins_detalleestandar.ide_idmuestra =  '".$row[1]."' 
AND ins_detalleestandar.ide_claveservicio =  '$claser' 
AND ins_detalleestandar.ide_numcaracteristica3 =  '".$numcar2."' 
AND ins_detalleestandar.ide_numreporte =  '".$row[12]."'";
				 	//echo $sqlres;
				 	$rsr=DatosEst::ConsultaDetalleAgua($row[1], $claser, $numcar2, $row[12]);
				 	$totalre= sizeof($rsr);
				 	if ($totalre>0) {
				 		foreach ($rsr as $rowr) {
				 			$valre= $rowr[1];
				 		}
				 		switch($tipodat) {
				 			case "C" :
				 				if (($valre) and ($numcat)) {
				 					$sqlc="SELECT ca_catalogosdetalle.cad_idcatalogo, ca_catalogosdetalle.cad_idopcion, 
ca_catalogosdetalle.cad_descripcionesp, ca_catalogosdetalle.cad_descripcioning
 FROM ca_catalogosdetalle WHERE ca_catalogosdetalle.cad_idcatalogo =  '".$numcat."' 
AND ca_catalogosdetalle.cad_idopcion =  ".$valre;
				 					
				 					$valfin=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",$numcat,$valre);
				 					
				 				}
				 				break;
				 			case "N" :
				 				$valfin=$valre;
				 				break;
				 			default :
				 				$valfin=$valre;
				 				break;
				 		} // switch
				 		
				 	} else {
				 		$valfin=" ";
				 	} // fin del if
				 	$dattablas[] = $valfin;
				 	
				 	
				 }  // while
				 // AGREGA A ARREGLO;
				 
				 // guarda en archivo
				 for($j=0;$j<54;$j++) {
				 	if ($j==33) {
				 		 $this->workbook->getActiveSheet()->setCellValue(Utilerias::michr($letra+$j).$renglon,$dattablas[$j], $text_format_det1);
				 		 $this->workbook->getActiveSheet()->getStyle(Utilerias::michr($letra+$j).$renglon)->applyFromArray($text_format_det1);
				 	} else {
				 		 $this->workbook->getActiveSheet()->setCellValue(Utilerias::michr($letra+$j).$renglon,$dattablas[$j], $text_format_det);
				 		 $this->workbook->getActiveSheet()->getStyle(Utilerias::michr($letra+$j).$renglon)->applyFromArray($text_format_det);
				 	}
				 }  // for
				 $renglon++;
			}
		}
		$sheet =  $this->workbook->getActiveSheet();
		$cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(true);
		/** @var PHPExcel_Cell $cell */
		foreach ($cellIterator as $cell) {
			$sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
		}
 		$objWriter = PHPExcel_IOFactory::createWriter($this->workbook, 'Excel2007');
		$objWriter->save($fname);
		//
	//	die();
		
		//$fh=fopen($fname, "rb");
		//fpassthru($fh);
		//unlink($fname);
		
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=iso-8859-1");
		header("Content-Disposition: inline; filename=\"".$nomcuenta.".xlsx\"");
		
		$fh=fopen($fname, "rb");
		fpassthru($fh);
		}catch(Exception $ex){
			echo "Hubo un error al generar el archivo ".$ex->getMessage();
		}
		//unlink($fname);
}
	
		
		
		function principal($col,$letra,$renglon) {
			
			/////////////////////////// nombres de las columnas////////////////////////////////////////
			$encabezado=array("Gas Volume","<3.0","3.0-3.4",">3.4","Temp.",">41F","<41F","Ratio Tests",">+/- 10%",">+/- 5%","in +/- 2-5%","in +/-2%","Right Flavor","Failed","Off Taste Description",">20 wks","10-20 wks","<10 wks","Alkalinity (ppm)",">175ppm","<175ppm","Alkalinity + Hardness",">400 ppm","<400 ppm","Total Chlorine",">0.5 ppm","<0.5 ppm","Total Dissolved Solids (ppm)",">750 ppm","500-750 ppm","<500 ppm","Score-Total","0-5","6-8","9-10");
			////////////////////////////////////////////////////////////////////////////////////////////
			$colores_Enc=array(
					array("gris","rojo","amarillo","verde"),
					array("gris","rojo","verde"),
					array("gris","rojo","naranja","amarillo","verde"),
					array("gris","rojo","verde"),
					array("gris","amarillo","gris"),
					array("gris","rojo","verde"),
					array("gris","rojo","verde"),
					array("gris","rojo","verde"),
					array("gris","rojo","amarillo","verde"),
					array("gris","rojo","amarillo","verde")
					
			);
			//definimos el arreglo que tiene el encabezado de las columnas
			switch($col) {
				case '5':	$a=0;
				$b=4;
				break;
				case '6':$a=4;
				$b=7;
				break;
				case'7':$a=7;
				$b=12;
				break;
				case'8':$a=12;
				$b=15;
				break;
				case'9':
					$a=15;
					$b=18;
					break;
				case'10':$a=18;
				$b=21;
				break;
				case'11':$a=21;
				$b=24;
				break;
				case'12':$a=24;
				$b=27;
				break;
				case'13':$a=27;
				$b=31;
				break;
				case'14':$a=31;
				$b=35;
				break;
				
			}
			
			$totcol1=0;
			$totcol2=0;
			$totcol3=0;
			
			$color_arr=$colores_Enc[$col-5];
			$j=0;
			for($i=$a;$i<$b;$i++) {
				// $color=$this->arrcolores["gris"];
				$color=$this->arrcolores[$color_arr[$j++]];
				
				$text_format =array(
						'font' => array('name'=>'Arial', "size"    => 10),
						
						'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('argb' => $this->arrcolores[$color])),
						
						"alignment" => array("horizontal"=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
				);
				
				
				 $this->workbook->getActiveSheet()->setCellValue(Utilerias::michr($letra).$renglon, $encabezado[$i], $text_format);
				 $this->workbook->getActiveSheet()->getStyle(Utilerias::michr($letra++).$renglon)->applyFromArray($text_format);
			}
			
			
			//echo "<br>col: ".$col;
			
			return $letra; //en que columna me quede
			
		}
		
		
		function rangoCeldas($linicio,$renglon, $colspan,$text_format){
			
			
			//  echo $rango."<br>";
			for($i=1;$i<$colspan;$i++){
				 $this->workbook->getActiveSheet()->setCellValue(Utilerias::michr($linicio+$i).$renglon,$text_format);
				 $this->workbook->getActiveSheet()->getStyle(Utilerias::michr($linicio+$i).$renglon)->applyFromArray($text_format);
			}
			
		
			
		}
		
	
}

