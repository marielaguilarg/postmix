<?php

//////////////////////////////////////////////////////////////////////////
//																		//
//	codigo para generar reporte en excel   			//
//																		//
//////////////////////////////////////////////////////////////////////////
include_once "Models/crud_usuario.php";
include_once "Models/crud_solicitudes.php";
include_once "Models/crud_catalogoDetalle.php";
include_once "Models/crud_inspectores.php";
include_once "Utilerias/utilerias.php";
require_once "libs/PHP_XLSXWriter-master/xlsxwriter.class.php";

class RepFacturacionController
{
    private $mini;
    private $mfin;
    
    private $pini;
    private $pfin;
    private $cinsp;
    private $worksheet;
    private $workbook;
    private $action;
    private $titulo;
    private $hoja;
    private $renglon;
   
    public function vistaRepFacturacion(){
        include "Utilerias/leevar.php";
        
        
        $opcion=$archivo;	//opcionj para saber si genera el archivo o despliega el html
        
        //$cuenta=$_POST["cuenta"];
        //$servicio=1;
      if($admin=="panfac")
      {
         $this->titulo="REGISTRO DE FACTURACION";
         $this->action="index.php?action=listafacturas";
      }else{
          $this->titulo="REPORTE DE FACTURACION";
          $this->action="imprimirReporte.php?admin=repfac";
      }
        set_time_limit(360);
        ini_set("memory_limit","120M");
        
          
        /***************para las listas de seleccion******************/
        
        if ($claclien) {
            //actualiza meses
            if (ctype_space(${$fechainicio})) {
                $mesini="";
            } else {
                $mesini=${$fechainicio};
            }
            // actualiza periodos
            $enctablas=array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre","Octubre","Noviembe","Diciembre");
            $i=0;
            for ($i=0;$i<12;$i++) {
                $j=$i+1;
                if ($fechainicio==$j) {
                    $this->mini[]="<option value='$j' selected> $enctablas[$i]</option>";
                }else{
                    $this->mini[]="<option value='$j'> $enctablas[$i]</option>";
                }
            
            }
           
            $i=0;
            for ($i=0;$i<12;$i++) {
                $j=$i+1;
                if ($fechafin==$j) {
                    $this->mfin[]="<option value='$j' selected> $enctablas[$i]</option>";
                }else{
                    $this->mfin[]="<option value='$j'> $enctablas[$i]</option>";
                }
              
            }
           
//             $sqlp="SELECT ca_mesasignacion.num_per_asig FROM ca_mesasignacion GROUP BY ca_mesasignacion.num_per_asig";
//             $rsp=DatosMesasignacion::listaMesAsignacion("ca_mesasignacion");
           for($a=2011;$a<2035 ;$a++) {
                if ($fechainicio2==$a) {
                    $this->pini[]="<option value='".$a."' selected>".$a."</option>";
                } else {
                    $this->pini[]="<option value='".$a."'>".$a."</option>";
                }
               
            }
            
       
            for($a=2011;$a<2035 ;$a++) {
                if ($fechafin2==$rowp['num_per_asig']) {
                    $this->pfin[]="<option value='".$a."' selected>".$a."</option>";
                } else {
                    $this->pfin[]="<option value='".$a."'>".$a."</option>";
                }
              
            }
            
             //    $html->asignar('cinsp',$inicio."<option value='".$row['cli_idcliente']."' selected>"
            $ssql=("SELECT * from ca_clientes ");
            $rs=Datos::vistaClientesModel("ca_clientes");
            $i=0;
            foreach ($rs as $row) {
                if ($i<1) {
                    $inicio='<option value="" >- Seleccione un cliente -</option>';
                } else {
                    $inicio="";
                }
                if ($row['cli_idcliente']==$claclien) {
                    $this->cinsp[]=$inicio."<option value='".$row['cli_id']."' selected>".$row['cli_nombre']." </option>";
                }else{
                    $this->cinsp[]=$inicio."<option value='".$row['cli_id']."'>".$row['cli_nombre']."</option>";
                }
                $i++;
              
            } // fin del while clientes
            $i=0;
          
            $ssqls=("SELECT * from ca_servicios where cli_idcliente='$claclien'");
            $rss=DatosServicio::vistaServicioxCliente($claclien,"ca_servicios");
            foreach ($rss as $rows) {
            
                $this->cserv[]=$inicio."<option value='".$rows['ser_id']."'>".$rows['ser_descripcionesp']."</option>";
                //$i++;
            
            }
            
        }else{  // no hay idclien
            $enctablas=array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre","Octubre","Noviembe","Diciembre");
            for ($i=0;$i<12;$i++) {
                $j=$i+1;
                $this->mini[]="<option value='$j'> $enctablas[$i]</option>";
               
            }
         
            for ($i=0;$i<12;$i++) {
                $j=$i+1;
                $this->mfin[]="<option value='$j'> $enctablas[$i]</option>";
               
            }
       
            $sqlp="SELECT ca_mesasignacion.num_per_asig FROM ca_mesasignacion GROUP BY ca_mesasignacion.num_per_asig";
            for($a=2011;$a<2035 ;$a++) {
                $this->pini[]="<option value='".$a."'>".$a."</option>";
              
            }
            
        
            for($a=2011;$a<2035 ;$a++) {
                $this->pfin[]="<option value='".$a."'>".$a."</option>";
               
            }
            
            //poner la opcion todos para obligar a seleccionar el cliente y asi funcione la lista del servicio
            $i=0;
            $ssql=("SELECT * from ca_clientes;");
            $rs=Datos::vistaClientesModel("ca_clientes");
            
            foreach ($rs as $row) {
                
                
                if ($i<1) {
                    $inicio='<option value="" >-Seleccione un cliente-</option>';
                } else {
                    $inicio="";
                }
                
                $this->cinsp[]=$inicio."<option value='".$row['cli_id']."'>".$row['cli_nombre']."</option>";
                $i++;
                //  $inicio="";
             //  $this->OPSERVICIOS[]='<option value="0">- '.strtoupper(T_("Todas")).' -</option></select>';
               
            }
           
        }
        
        
        
    
        
        
    }
  
    public function generarArchivo(){
        
        $ini = microtime(true);
        set_time_limit(500);
        ini_set("memory_limit","120M");
        
      
        //echo $idserv;
      
        include ('Utilerias/leevar.php');
     
        $user = $_SESSION["Usuario"];
        
        $sqlu="SELECT cnfg_usuarios.cus_tipoconsulta,
cnfg_usuarios.cus_clavegrupo FROM cnfg_usuarios WHERE cnfg_usuarios.cus_usuario =  '$user'";
        $rsu=usuarioModel::getUsuarioId($user,"cnfg_usuarios");
        foreach ($rsu as $rowu) {
            $gpous= $rowu[cus_clavegrupo];
        }
        
        //CREA EL ARCHIVO PARA EXPORTAR
        
        $nomarch="facturacion".date("dmyHi");
        $base=getcwd();
        ////echo $base;
        ////echo "--".strrpos($base,"\\");
        $base=substr($base, 0, strrpos($base,"\\"));
        
        $arrcolores=array("azul"=>"48","verde"=>"31","naranja"=>"orange","amarillo"=>"yellow",
            "rojo"=>"62","verdeo"=>"#0066cc","gris"=>"gray", "blanco"=>"white", "verdef"=>"green", "rojof"=>"60" );
        
        $fname = tempnam($base."\\Archivos\\", $nomarch.".xlsx");
        $this->worksheet = new XLSXWriter();
        $this->hoja='Inicio';
        
      
       
        
        
        $text_format_b =array(
            'font-style'    => 'bold',
            
            'fill'   =>  $arrcolores["verdeo"],
            'font-size'    => 10,
            font    => 'Arial Unicode MS',
      //      vAlign => 'vjustify',
           'halign' => 'Center'
        );
        
     	
        $letrae=65;
        
        //////////////////////////////////// nombres de cada columna o prueba//////////////////////////////
        $enctablas=array("NO DE PUNTO DE VENTA", "UNIDAD DE NEGOCIO", "FRANQUICIA CLIENTE", "CUENTA", "FRANQUICIA CUENTA", "REGION", "ESTADO", "CIUDAD O MUNICIPIO", "PUNTO DE VENTA (NOMBRE)","ID PEPSI","ID CUENTA","DOMICILIO","MES ASIGNACION","ESTATUS","FECHA DE ESTATUS","FECHA DE VISITA", "NO. DE REPORTE","AUDITOR","NO MUESTRA AGUA","EMBOTELLADORA","REPORTE CIC","NO. REPORTE CIC","FINALIZADO","NO. FACTURA", "SIN COBRO");
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        /*** DESPLIEGO TITULOS DE COLUMNA**/
        $arr_colxsec=array(
            4,3,5,3,3,3,3,3,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4);
        
    
     
        // inicio en letra a=65
        $letra=65;
    
        $i=0;
    //    for($i=0;$i<25;$i++) {
            $this->worksheet->writeSheetRow($this->hoja, $enctablas,$text_format_b);
   //     }
       
        
       
        
        
        // detalle
        $fr=explode('-', $fecharep);
        $fecrec=$fr[2]."-".$fr[1].".".$fr[0];
        
        $mes_asig=$fechainicio.".".$fechainicio2;
        $mes_asig2=$fechafin.".".$fechafin2;
        $cclien=$claclien;
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
        
        $this->datosUNegocio($mes_asig,$mes_asig2,$diafin, $cclien, $idserv);
        $fin = microtime(true);
        $tiempo = $fin - $ini;
       
        //
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header("Content-Disposition: attachment; filename=\"".$nomarch.".xlsx\"");
        $this->worksheet->writeToStdOut();
        //$fh=fopen($fname, "rb");
        //fpassthru($fh);
        //unlink($fname);
        //header("Content-Type: application/x-msexcel; name=\"example-demo.xls\"");
        //header("Content-Disposition: inline; filename=\"example-demo.xls\"");
//         $fh=fopen($fname, "rb");

//         fpassthru($fh);
//         unlink($fname);
    }
        function datosUNegocio($mes_asig,$mes_asigfin, $diafin, $claclien,$idserv) {
      
            
            if ($idserv==1) {
                $sqluneg="SELECT une_numpunto, n2_nombre, n3_nombre, cue_descripcion, cf_descripcion, n4_nombre, 
n4_nombre, une_dir_municipio,une_descripcion, une_idpepsi,une_idcuenta, dir,i_mesasignacion, une_estatus, fecha_estatus,
i_fechavisita, i_numreporte, i_claveinspector,ide_idmuestra,i_reportecic,i_numreportecic, i_finalizado, i_numfactura, 
i_sincobro
FROM (SELECT ca_unegocios.une_numpunto, ca_unegocios.une_dir_municipio, ca_unegocios.une_descripcion,
ca_unegocios.une_idpepsi, ca_unegocios.une_idcuenta, concat(ca_unegocios.une_dir_calle,' ',ca_unegocios.une_dir_numeroext,' ',ca_unegocios.une_dir_numeroint,' ',
ca_unegocios.une_dir_manzana,' ',ca_unegocios.une_dir_lote,' ',ca_unegocios.une_dir_colonia,' ',ca_unegocios.une_dir_delegacion,' ',
ca_unegocios.une_dir_municipio,' ',ca_unegocios.une_dir_estado,' ',ca_unegocios.une_dir_cp) AS dir,
ca_unegocios.une_estatus, date_format(ca_unegocios.une_fechaestatus,'%d-%m-%Y') AS fecha_estatus,
 ca_unegocios.cue_clavecuenta, ca_unegocios.une_id,
ca_nivel5.n5_nombre, ca_nivel4.n4_nombre, ca_nivel3.n3_nombre, ca_nivel2.n2_nombre, ca_cuentas.cue_descripcion,
ca_franquiciascuenta.cf_descripcion 
FROM ca_unegocios 
Left Join ca_nivel5 ON  ca_unegocios.une_cla_ciudad = ca_nivel5.n5_id 
Left Join ca_nivel4 ON  ca_unegocios.une_cla_estado = ca_nivel4.n4_id
Left Join ca_nivel3 ON  ca_unegocios.une_cla_zona = ca_nivel3.n3_id
Left Join ca_nivel2 ON  ca_unegocios.une_cla_pais = ca_nivel2.n2_id
Left Join ca_cuentas ON  ca_unegocios.cue_clavecuenta = ca_cuentas.cue_id
Left Join ca_franquiciascuenta ON ca_unegocios.fc_idfranquiciacta = ca_franquiciascuenta.fc_idfranquiciacta 
AND ca_cuentas.cue_idcliente = ca_franquiciascuenta.cli_idcliente 
 AND ca_cuentas.cue_id = ca_franquiciascuenta.cue_clavecuenta
 WHERE  ca_cuentas.cue_idcliente =:claclien ORDER BY ca_unegocios.une_numpunto ) AS A  INNER JOIN (SELECT  i_claveservicio,
  i_unenumpunto, i_mesasignacion, i_fechavisita, i_numreporte, i_claveinspector, ide_idmuestra,i_reportecic,i_numreportecic, 
i_finalizado, i_numfactura, i_sincobro FROM  (SELECT  ins_generales.i_claveservicio, 
 ins_generales.i_unenumpunto, ins_generales.i_mesasignacion, ins_generales.i_fechavisita, ins_generales.i_numreporte,
 ins_generales.i_claveinspector, ins_generales.i_reportecic, ins_generales.i_numreportecic, ins_generales.i_finalizado, ins_generales.i_numfactura, ins_generales.i_sincobro
FROM ins_generales WHERE DATE (str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y'))>= str_to_date(concat('01.',:mes_asig),'%d.%m.%Y')  
AND DATE (str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y'))<= str_to_date(concat(:diafin,'.',:mes_asigfin),'%d.%m.%Y')  AND ins_generales.i_claveservicio=:idserv) AS C 
LEFT JOIN  (SELECT ins_detalleestandar.ide_numreporte, ins_detalleestandar.ide_idmuestra, ins_detalleestandar.ide_numrenglon 
FROM ins_detalleestandar 
where ins_detalleestandar.ide_numrenglon = '1' and ins_detalleestandar.ide_idmuestra <>0
AND ins_detalleestandar.ide_claveservicio =:idserv GROUP BY ins_detalleestandar.ide_numreporte,
 ins_detalleestandar.ide_idmuestra ) AS D ON i_numreporte=ide_numreporte) AS B
ON  B.i_unenumpunto = A.une_id";
                $parametros=array("claclien"=>$claclien,"idserv"=>$idserv,"mes_asig"=>$mes_asig,"diafin"=>$diafin,"mes_asigfin"=>$mes_asigfin );
            } else {
                $sqluneg=("SELECT une_numpunto, n2_nombre, n3_nombre, cue_descripcion, cf_descripcion, n4_nombre, 
n5_nombre, une_dir_municipio,une_descripcion, une_idpepsi,une_idcuenta, dir,i_mesasignacion, une_estatus, fecha_estatus,
i_fechavisita, i_numreporte, i_claveinspector, ide_idmuestra, i_reportecic, i_numreportecic, i_finalizado, i_numfactura,
 i_sincobro FROM
(SELECT ca_unegocios.une_numpunto, ca_unegocios.une_dir_municipio, ca_unegocios.une_descripcion, ca_unegocios.une_idpepsi,
 ca_unegocios.une_idcuenta,
concat(ca_unegocios.une_dir_calle,' ',ca_unegocios.une_dir_numeroext,' ',ca_unegocios.une_dir_numeroint,' ',
ca_unegocios.une_dir_manzana,' ',ca_unegocios.une_dir_lote,' ',ca_unegocios.une_dir_colonia,' ',
ca_unegocios.une_dir_delegacion,' ',ca_unegocios.une_dir_municipio,' ',ca_unegocios.une_dir_estado,' ',
ca_unegocios.une_dir_cp) AS dir,
 ca_unegocios.une_estatus, date_format(ca_unegocios.une_fechaestatus,'%d-%m-%Y') AS fecha_estatus, 
 ca_unegocios.cue_clavecuenta, ca_unegocios.une_id,
 ca_nivel5.n5_nombre, ca_nivel4.n4_nombre, ca_nivel3.n3_nombre, ca_nivel2.n2_nombre, ca_cuentas.cue_descripcion,
 ca_franquiciascuenta.cf_descripcion FROM ca_unegocios
Left Join ca_nivel5 ON ca_unegocios.une_cla_ciudad = ca_nivel5.n5_id
Left Join ca_nivel4 ON  ca_unegocios.une_cla_estado = ca_nivel4.n4_id
Left Join ca_nivel3 ON  ca_unegocios.une_cla_zona = ca_nivel3.n3_id
Left Join ca_nivel2 ON  ca_unegocios.une_cla_pais = ca_nivel2.n2_id
Left Join ca_cuentas ON ca_unegocios.cue_clavecuenta = ca_cuentas.cue_id
Left Join ca_franquiciascuenta ON ca_unegocios.fc_idfranquiciacta = ca_franquiciascuenta.fc_idfranquiciacta 
AND ca_cuentas.cue_idcliente = ca_franquiciascuenta.cli_idcliente 

AND ca_cuentas.cue_id = ca_franquiciascuenta.cue_clavecuenta
WHERE ca_cuentas.cue_idcliente=:claclien
ORDER BY ca_unegocios.une_numpunto ) AS A
INNER JOIN (
SELECT  i_claveservicio, i_unenumpunto, i_mesasignacion, i_fechavisita, i_numreporte, 
i_claveinspector, ide_idmuestra,i_reportecic, i_numreportecic, i_finalizado, i_numfactura, i_sincobro FROM
 (SELECT  ins_generales.i_claveservicio, 
ins_generales.i_unenumpunto, ins_generales.i_mesasignacion, ins_generales.i_fechavisita, ins_generales.i_numreporte,
 ins_generales.i_claveinspector,
ins_generales.i_reportecic, ins_generales.i_numreportecic, ins_generales.i_finalizado, ins_generales.i_numfactura, 
ins_generales.i_sincobro
FROM
ins_generales
Left Join cer_solicitud ON ins_generales.i_claveservicio = cer_solicitud.sol_claveservicio AND ins_generales.i_numreporte = cer_solicitud.sol_numrep
WHERE DATE (str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y'))>= str_to_date(concat('01.',:mes_asig),'%d.%m.%Y')
AND DATE (str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y'))<= str_to_date(concat('31.',:mes_asigfin),'%d.%m.%Y') 
 AND
cer_solicitud.sol_estatussolicitud =  '3') AS C
LEFT JOIN
(SELECT ins_detalleestandar.ide_numreporte, ins_detalleestandar.ide_idmuestra, ins_detalleestandar.ide_numrenglon 
FROM ins_detalleestandar 
where ins_detalleestandar.ide_numrenglon = '1' and ins_detalleestandar.ide_idmuestra <>0
 GROUP BY ins_detalleestandar.ide_numreporte, 
ins_detalleestandar.ide_idmuestra ) AS D ON i_numreporte=ide_numreporte) AS B ON 
 B.i_unenumpunto = A.une_id");
             $parametros=array("claclien"=>$claclien,"mes_asig"=>$mes_asig,"mes_asigfin"=>$mes_asigfin );
                
            }
            $resultuneg=Conexion::ejecutarQuery($sqluneg,$parametros);
        // die();
            $letra=65;
            $ren_ex=2;
            
            $text_format_det =array(
                
                
                'font-size'    => 10,
                font    => 'Arial Unicode MS',
                'halign' => 'Center'
            );
        //    var_dump($resultuneg);die();
            foreach ($resultuneg as $rowuneg) {
            	$this->renglon=array();
                for($i=0;$i<12;$i++) {//despliego cada columna
                    // echo $letra;
                  //  $this->worksheet->writeSheetRow($this->hoja, $rowuneg, $text_format_det);
                	$this->renglon[]=$rowuneg[$i];
               }
                $mesasig = Utilerias::cambiaMesG($rowuneg[12]);
                $this->renglon[]=$mesasig;
               // $this->worksheet->writeSheetRow($this->hoja, $mesasig, $text_format_det);
                $cveest = $rowuneg[13];
                $fecest = $rowuneg[14];
                $fecvis = $rowuneg[15];
                $numrep = $rowuneg[16];
                $cveins = $rowuneg[17];
                $nummues = $rowuneg[18];
                $repcic = $rowuneg[19];
                if ($repcic)
                {
                    $repcicd = "Si";
                } else {
                    $repcicd = "No";
                }
                $numrepcic=$rowuneg[20];
                // finaliza para servicio =3
                if ($idserv=3){
                    // busca finalizado para seccion 3
                    $sqles = "SELECT cer_solicitud.sol_estatussolicitud FROM cer_solicitud 
WHERE cer_solicitud.sol_numrep =  '".$numrep."' AND cer_solicitud.sol_claveservicio =  '3'";
                    $rses = DatosSolicitud::cuentasolicitudModel($numrep,3,"cer_solicitud");
                    foreach ($rses as $rowes){
                        $final=$rowes['sol_estatussolicitud'];
                        if ($rowes['sol_estatussolicitud']==3) {
                            $repfin="Si";
                        }else{
                            $repfin="No";
                        }
                    }
                }else{
                    $finaliza=$rowuneg[21];
                    if ($finaliza)
                    {
                        $repfin = "Si";
                    } else {
                        $repfin = "No";
                    }
                }
                $numfac=$rowuneg[22];
                $sc=$rowuneg[23];
                if ($sc)
                {
                    $repsc = "Si";
                } else {
                    $repsc = "No";
                }
                $this->busest($cveest, $fecest, $fecvis, $numrep, $ren_ex);
                $this->busaud($cveins, $nummues, $ren_ex);
                $this->busemb($nummues, $ren_ex, $repcicd, $numrepcic, $repfin,$numfac,$repsc);
                $this->worksheet->writeSheetRow($this->hoja, $this->renglon, $text_format_det);
                
                $ren_ex++;
            }
        }
        
        function busest($cveest1, $fecest1, $fecvis1, $numrep1, $ren_ex1){
            
            $text_format_det =array(
                
                
                'font-size'    => 10,
                font    => 'Arial Unicode MS',
                'halign' => 'Center'
            );
            $sqltrep="SELECT
ca_catalogosdetalle.cad_descripcionesp,
ca_catalogosdetalle.cad_idopcion
FROM
ca_catalogosdetalle
WHERE
ca_catalogosdetalle.cad_idcatalogo =  '46' and
ca_catalogosdetalle.cad_idopcion ='$cveest1'";
            //ECHO $sqltrep;
            $rstreg=DatosCatalogoDetalle::getCatalogoDetalle("ca_catalogosdetalle",46,$cveest1);
          
//             $this->worksheet->writeSheetRow($this->hoja, $rstreg, $text_format_det);
//                 $this->worksheet->writeSheetRow($this->hoja, $fecest1, $text_format_det);
//                 $this->worksheet->writeSheetRow($this->hoja, $fecvis1, $text_format_det);
//                 $this->worksheet->writeSheetRow($this->hoja, $fecvis1, $text_format_det);
            
                $this->renglon[]=$rstreg;
                $this->renglon[]=$fecest1;
                $this->renglon[]=$fecvis1;
                $this->renglon[]=$fecvis1;
                
                
                
        }
        
        
        
        function busaud($cveins1, $nummues1, $ren_ex1){
            
            $text_format_det =array(
                
                
                'font-size'    => 10,
                font    => 'Arial Unicode MS',
                'halign' => 'Center'
            );
            $sqltrep="SELECT
ca_inspectores.ins_nombre
FROM
ca_inspectores
where
ca_inspectores.ins_clave=$cveins1";
            //ECHO $sqltrep;
            $rowtr=DatosInspector::getInspectorxId($cveins1);
       
            //    $this->worksheet->writeSheetRow($this->hoja, $rowtr["ins_nombre"], $text_format_det);
            //    $this->worksheet->writeSheetRow($this->hoja, $nummues1, $text_format_det);
               
                $this->renglon[]=$rowtr["ins_nombre"];
                $this->renglon[]=$nummues1;
                
                
        }
        
        function busemb($nummues1, $ren_ex1,$repcic1,$numrepcic1,$repfin1,$numfac1,$repsc1){
            $text_format_det =array(
                
                
                'font-size'    => 10,
                font    => 'Arial Unicode MS',
                'halign' => 'Center'
            );
            $sqltrep="select cad_descripcionesp
from
(SELECT
aa_recepcionmuestra.rm_embotelladora, aa_recepcionmuestradetalle.mue_idmuestra
FROM
aa_recepcionmuestra
Inner Join aa_recepcionmuestradetalle ON aa_recepcionmuestra.rm_idrecepcionmuestra = aa_recepcionmuestradetalle.rm_idrecepcionmuestra
WHERE
aa_recepcionmuestradetalle.mue_idmuestra =:nummues1
GROUP BY
aa_recepcionmuestradetalle.mue_idmuestra) as a
inner join
(SELECT
ca_catalogosdetalle.cad_descripcionesp,
ca_catalogosdetalle.cad_idopcion
FROM
ca_catalogosdetalle
WHERE
ca_catalogosdetalle.cad_idcatalogo =  '43') as B on  a.rm_embotelladora=B.cad_idopcion;";
            $sqltrep;
            $rstreg=Conexion::ejecutarQuery($sqltrep,array("nummues1"=>$nummues1));
          //  die();
            foreach ( $rstreg as $rowtr) {
               // $this->worksheet->writeSheetRow($this->hoja, $rowtr[0], $text_format_det);
                $this->renglon[]=$rowtr[0];
            }
//             $this->worksheet->writeSheetRow($this->hoja, $repcic1, $text_format_det);
//             $this->worksheet->writeSheetRow($this->hoja, $numrepcic1, $text_format_det);
//             $this->worksheet->writeSheetRow($this->hoja, $repfin1, $text_format_det);
//             $this->worksheet->writeSheetRow($this->hoja, $numfac1, $text_format_det);
//             $this->worksheet->writeSheetRow($this->hoja, $repsc1, $text_format_det);
            $this->renglon[]=$repcic1;
            $this->renglon[]=$numrepcic1;
            $this->renglon[]=$repfin1;
            $this->renglon[]=$numfac1;
            $this->renglon[]=$repsc1;
        }
        
        
        
        function michr($indice){
            //echo $indice;
            if($indice>=65&&$indice<=90){
                return chr($indice);
            }
            if($indice>90&&$indice<=116){
                return "A".chr($indice-26);
            }
            /*if($indice>116&&$indice<=142){
             return "B".chr($indice-52);
             }
             if($indice>142&&$indice<=168){
             return "C".chr($indice-78);
             }*/
        }
        
        
    /**
     * @return mixed
     */
    public function getMini()
    {
        return $this->mini;
    }

    /**
     * @return mixed
     */
    public function getMfin()
    {
        return $this->mfin;
    }

    /**
     * @return mixed
     */
    public function getPini()
    {
        return $this->pini;
    }

    /**
     * @return mixed
     */
    public function getPfin()
    {
        return $this->pfin;
    }

    /**
     * @return mixed
     */
    public function getCinsp()
    {
        return $this->cinsp;
    }
    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->titulo;
    }


    
  
    
}

