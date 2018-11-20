<?php
//////////////////////////////////////////////////////////////////////////
//																		//
//	codigo para generar reporte anual en excel   			//
//																		//
//////////////////////////////////////////////////////////////////////////

require_once 'libs/PHPExcel-1.8/PHPExcel.php';
 require_once ('libs/php-gettext-1.0.12/gettext.inc');
require 'Utilerias/inimultilenguaje.php';
include "Models/crud_cuentas.php";

class ArchivoVMController
{
    
    
    private $arrcolores,$im,$aceptados,$mes_asig,$ttotal,$ttotal2;
    private  $cliente,$servicio;
    private $tablaux;
   
    private $worksheet,$workbook;
    public function descargarArchivo(){
        include "Utilerias/leevar.php";
      
        
      
       
        //$cuenta=$_POST["cuenta"];
        $this->servicio=1;
        $this->cliente=100;
        set_time_limit(360);
        ini_set("memory_limit","120M");
      
            
        $this->arrcolores=array("azul"=>"ff0066cc","verde"=>"ff00CC00","naranja"=>"ffFF9900",
            "amarillo"=>"ffFFFF33","ff9933FF","rojo"=>"ffFF0000","verdeo"=>"ffCCFFFF",
            "gris"=>"ff999999", "verdef"=>"ff006600", "rojof"=>"ffAA0000" );
//             $this->arrcolores=array("azul"=>"27","verde"=>"50","naranja"=>"orange","amarillo"=>"yellow",
//                 "rojo"=>"red","verdeo"=>"50","gris"=>"gray", "verdef"=>"green", "rojof"=>"60" );
            
            //    $arrcolores=array("azul"=>PHPExcel_Style_Color::COLOR_BLUE,"verde"=>PHPExcel_Style_Color::COLOR_GREEN,"naranja"=>PHPExcel_Style_Color::COLOR_DARKYELLOW,
            //        "amarillo"=>PHPExcel_Style_Color::COLOR_YELLOW,"rojo"=>PHPExcel_Style_Color::COLOR_RED,"verdeo"=>PHPExcel_Style_Color::COLOR_DARKGREEN,
            //        "gris"=>PHPExcel_Style_Color::COLOR_WHITE, "verdef"=>PHPExcel_Style_Color::COLOR_DARKGREEN, "rojof"=>PHPExcel_Style_Color::COLOR_DARKRED );
            if($consulta=='t')			//revisamos si será consulta de todas las cuentas
                $cuenta='-1';					 //o sólo de 1
          
                     //CREA EL ARCHIVO PARA EXPORTAR
              $nomcuenta="Resumen_de_resultados".date("dmyHi");
                    
                    $arch= "../Archivos/".$nomcuenta.".xlsx";
                    
                    $fname = tempnam("../Archivos/", $nomcuenta.".xlsx");
                    $this->workbook =new PHPExcel();
                
                    $this->worksheet =$this->workbook->getActiveSheet();
                    $this->workbook->getActiveSheet()->setTitle($cuenta);
                    $this->reporte($cuenta,$arch);				//funcion que hace el reporte
                    // creaarch($arch,$cadtabla);
                    
                    $this->im=$this->ttotal=$this->ttotal2=0;
                 
                    $cellIterator = $this->worksheet->getRowIterator()->current()->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(true);
                    /** @var PHPExcel_Cell $cell */
                    foreach ($cellIterator as $cell) {
                    	$this->worksheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
                    }
                    $objWriter = PHPExcel_IOFactory::createWriter(   $this->workbook, 'Excel2007');
                    $objWriter->save($fname);
                    
                    header("Content-Type: application/x-msexcel; name=\"".$nomcuenta.".xlsx\"");
                    header("Content-Disposition: inline; filename=\"".$nomcuenta.".xlsx\"");
                    $fh=fopen($fname, "rb");
                    fpassthru($fh);
                    unlink($fname);
    
    }
    
    /*****************************************************************************************************/
    /******************************Genera consulta a la base de datos**********************************/
    function consulta($columna,$cuenta,$fechaini) {
        
        $ren=1;
        switch($columna)			//busca la consulta para cada columna definida del reporte
        {
            case 5:
                /*************************VOLUMEN************************/
                $sec=8;
                $com=2;
                $car=9;
                
                $cad="   SELECT ins_detalleestandar.ide_valorreal, if(ins_detalleestandar.ide_valorreal<3,1,'') as col1, if(ins_detalleestandar.ide_valorreal>=3
and ins_detalleestandar.ide_valorreal<3.4,1,'')as col2, if(ins_detalleestandar.ide_valorreal>=3.4,1,'') as col3";
               $res=$this->consultaEstandar($cad,$fechaini, $cuenta, $this->cliente, $this->servicio, $sec, $com, $car, $ren);
              
                break;
            case 6:
                /****************************TEMPERATURA***************************/
                $sec=8;
                $com=2;
                $car=8;
                
                $cad="SELECT
	ins_detalleestandar.ide_valorreal, if(ins_detalleestandar.ide_valorreal>41,1,'') as col1, if(ins_detalleestandar.ide_valorreal<=41,1,'') as col2";
               $res=$this->consultaEstandar($cad,$fechaini, $cuenta, $this->cliente, $this->servicio, $sec, $com, $car, $ren);
              
                break;
                
            case 8:
                
                /****************************SABOR***************************/
                
                $cad="SELECT
if(ins_detalleestandar.ide_valorreal=1,'1','') as col1,if(ins_detalleestandar.ide_valorreal=2,'failed','') as col2,if(ins_detalleestandar.ide_valorreal=1,'N/A',ins_detalleestandar.ide_comentario)";
               $res=$this->consultaEstandar($cad,$fechaini, $cuenta, $this->cliente, $this->servicio,8, 1, 5, $ren);
              
                break;
                /***************************************edad de jarabes*******************/
            case 9:
                $cad="SELECT Sum(if( ins_detalleproducto.ip_semana >= '20',ins_detalleproducto.ip_numcajas,0)) AS col1,
Sum(if( ins_detalleproducto.ip_semana >= '10' AND ins_detalleproducto.ip_semana <'20',ins_detalleproducto.ip_numcajas,0)) AS col2,
Sum(if( ins_detalleproducto.ip_semana < '10',ins_detalleproducto.ip_numcajas,0)) AS col3
FROM ins_generales
left join( select * from ins_detalleproducto where  ins_detalleproducto.ip_claveservicio=:servicio) ins_detalleproducto
 on
ins_detalleproducto.ip_numreporte = ins_generales.i_numreporte
 INNER JOIN `ca_unegocios` ON `une_id`=i_unenumpunto
            WHERE ins_generales.i_mesasignacion =:fechaini
  AND  `cue_clavecuenta`=:cuenta
            AND ins_generales.i_claveservicio=:servicio
GROUP BY ins_detalleproducto.ip_numreporte ORDER BY ins_generales.i_fechavisita ASC";
                //              echo $cad."<br>";
                $parametros=array("fechaini"=>$fechaini,
                    "servicio"=>$this->servicio,
                    "cuenta"=>$cuenta
                );
                $res=Conexion::ejecutarQuery($cad,$parametros);
             
                break;
                
                
            case 10:
                $sec=5;
                $com=2;
                $car=6;
                /****************************ALCALINIDAD***************************/
                
                $cad="SELECT ins_detalleestandar.ide_valorreal, if(ins_detalleestandar.ide_valorreal>175,1,'') as col1, if(ins_detalleestandar.ide_valorreal<=175,1,'') as col2";
               $res=$this->consultaEstandar($cad,$fechaini, $cuenta, $this->cliente, $this->servicio, $sec, $com, $car, $ren);
              
                break;
            case 11:
                $sec=5;
                $com=2;
                $car=6;
                /****************************ALCALINIDADH***************************/
                //   $cad=consultaEstandar($fechaini, $cuenta, $this->cliente, $servicio, $sec, $com, $car, $ren);
                $cad="SELECT sum1 , col1,  col2
                
FROM ins_generales
 left join
(select Sum(a.ide_valorreal) sum1 , if(Sum(a.ide_valorreal)>400,1,'') as col1, if(Sum(a.ide_valorreal)<=400,1,'') as col2, a.ide_numreporte   from ins_detalleestandar a
where a.ide_claveservicio =:servicio  and
a.ide_numseccion =:sec AND a.ide_numcomponente =:com
AND (a.ide_numcaracteristica3 = '5' OR a.ide_numcaracteristica3 = '6')and
a.ide_numrenglon =  '1'  GROUP BY a.ide_numseccion, a.ide_numreactivo, a.ide_numreporte )
as a ON a.ide_numreporte = ins_generales.i_numreporte
INNER JOIN `ca_unegocios` ON `une_id`=i_unenumpunto
            WHERE ins_generales.i_mesasignacion =:fechaini
  AND  `cue_clavecuenta`=:cuenta  AND ins_generales.i_claveservicio=:servicio
ORDER BY ins_generales.i_fechavisita, ins_generales.i_numreporte ASC ";
                $parametros=array("fechaini"=>$fechaini,
                    "servicio"=>$this->servicio,
                    "sec"=>$sec,
                    "com"=>$com,
                    "cuenta"=>$cuenta
                );
                $res=Conexion::ejecutarQuery($cad,$parametros);
                break;
            case 12:
                $sec=5;
                $com=2;
                $car=8;
                /****************************CLORO***************************/
                $cad="SELECT
	ins_detalleestandar.ide_valorreal, if(ins_detalleestandar.ide_valorreal>0.5,1,'') as col1,
	if(ins_detalleestandar.ide_valorreal<=0.5,1,'') as col2";
               $res=$this->consultaEstandar($cad,$fechaini, $cuenta, $this->cliente, $this->servicio, $sec, $com, $car, $ren);
              
                break;
            case 13:
                $sec=5;
                $com=2;
                $car=9;
                /****************************SOLIDOS***************************/
                $cad="SELECT
	ins_detalleestandar.ide_valorreal, if(ins_detalleestandar.ide_valorreal>750,1,'') as col1,
                    
	 if(ins_detalleestandar.ide_valorreal>500 AND  ins_detalleestandar.ide_valorreal<=750,1,'') as col2,
	 if(ins_detalleestandar.ide_valorreal<=500,1,'') as col3";
               $res=$this->consultaEstandar($cad,$fechaini, $cuenta, $this->cliente, $this->servicio, $sec, $com, $car, $ren);
               
                break;
            case 14:
                
                $sec=5;
                $com=2;
                $car=9;
                /**************************** APPEREANCE ***************************/
                $cad="SELECT
	round(count(ins_detalle.id_aceptado)/8*10) tot,
	if ((count(ins_detalle.id_aceptado)/8*100)>=0 and (count(ins_detalle.id_aceptado)/8*100)<=55,1,'') as col1,
	if ((count(ins_detalle.id_aceptado)/8*100)>55 and (count(ins_detalle.id_aceptado)/8*100)<=85,1,'') as col2,
	if ((count(ins_detalle.id_aceptado)/8*100)>85 and (count(ins_detalle.id_aceptado)/8*100)<=100,1,'') as col3
	
            FROM ins_generales left join (select * from ins_detalle
            where ins_detalle.id_claveservicio=:servicio and ins_detalle.id_aceptado = '-1'
            and ins_detalle.id_numseccion=9
and ins_detalle.id_numreactivo in(1,2,3,4,5,6,7,8) )  as ins_detalle on ins_generales.i_numreporte = ins_detalle.id_numreporte
INNER JOIN `ca_unegocios` ON `une_id`=i_unenumpunto
            WHERE `cue_clavecuenta`=:cuenta
and  ins_generales.i_claveservicio=:servicio and
 ins_generales.i_mesasignacion =:fechaini
        
 group by ins_detalle.id_numreporte ORDER BY ins_generales.i_fechavisita ASC, ins_detalle.id_numseccion ASC";
                $parametros=array("fechaini"=>$fechaini,
                    "servicio"=>$this->servicio,
                    "cuenta"=>$cuenta
                );
                $res=Conexion::ejecutarQuery($cad,$parametros);
                break;
                
                
            default :$res=0;
            break;
        }
        //echo "<br>".$cad;
        return $res;
    }
    
    function consultaEstandar($cad,$fechaini,$cuenta,$sec,$com,$car,$ren)
    {
        $cad.=" FROM ins_generales
left join (SELECT *
FROM ins_detalleestandar
 WHERE  ins_detalleestandar.ide_numseccion =:sec AND ins_detalleestandar.ide_numcomponente =:com
AND ins_detalleestandar.ide_numcaracteristica3 =:car";
        
        if($ren>0) // una linea
            $cad.=" AND ins_detalleestandar.ide_numrenglon =".$ren;
         $cad.=" and   ins_detalleestandar.ide_claveservicio =:servicio) as ins_detalleestandar on ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
INNER JOIN `ca_unegocios` ON `une_id`=i_unenumpunto
            WHERE ins_generales.i_mesasignacion =:fechaini
  AND  `cue_clavecuenta`=:cuenta
 AND ins_generales.i_claveservicio=:servicio
ORDER BY ins_generales.i_fechavisita,ins_generales.i_numreporte ASC";
            $parametros=array("fechaini"=>$fechaini,
                "servicio"=>$this->servicio,
                "sec"=>$sec,
                "com"=>$com,
                "car"=>$car,
                "cuenta"=>$cuenta
            );
            $res=Conexion::ejecutarQuery($cad,$parametros);
            return $res;
    }
    
    function consultaEstandarTC($cad,$fechaini,$sec,$com,$car,$ren) // filtros para todas las cuentas
    {
        $cad.=" FROM ins_generales
left join (SELECT *
FROM ins_detalleestandar
 WHERE  ins_detalleestandar.ide_numseccion =:sec AND ins_detalleestandar.ide_numcomponente =:com
AND ins_detalleestandar.ide_numcaracteristica3 =:car";
        if($ren>0) // una linea
            $cad.=" AND ins_detalleestandar.ide_numrenglon =:ren";
        $cad.=" and   ins_detalleestandar.ide_claveservicio =:servicio) as ins_detalleestandar on ins_detalleestandar.ide_numreporte = ins_generales.i_numreporte
 
  WHERE ins_generales.i_mesasignacion =:fechaini 
 AND ins_generales.i_claveservicio=:servicio
ORDER BY ins_generales.i_fechavisita,ins_generales.i_numreporte ASC";
            
            $parametros=array("fechaini"=>$fechaini,
                "servicio"=>$this->servicio,
                "sec"=>$sec,
                "com"=>$com,
                "car"=>$car
            );
            
            
            $res=Conexion::ejecutarQuery($cad,$parametros);
            die();
            return $res;
            
    }
    /**************Genera consulta a la base de datos para todas las cuentas
     cuando se quiera un reporte de todas *****************************/
    function consulta_gral($columna,$fechaini) {
        
        $ren=1;
        switch($columna)			//busca la consulta para cada columna definida del reporte
        {
            case 5:
                /*************************VOLUMEN************************/
                $sec=8;
                $com=2;
                $car=9;
                
                $cad="   SELECT ins_detalleestandar.ide_valorreal, if(ins_detalleestandar.ide_valorreal<3,1,'') as col1, if(ins_detalleestandar.ide_valorreal>=3
and ins_detalleestandar.ide_valorreal<3.4,1,'')as col2, if(ins_detalleestandar.ide_valorreal>=3.4,1,'') as col3";
                $res=$this->consultaEstandarTC($cad,$fechaini, $this->cliente, $this->servicio, $sec, $com, $car, $ren);
                
                break;
            case 6:
                /****************************TEMPERATURA***************************/
                $sec=8;
                $com=2;
                $car=8;
                
                $cad="SELECT
	ins_detalleestandar.ide_valorreal, if(ins_detalleestandar.ide_valorreal>41,1,'') as col1, if(ins_detalleestandar.ide_valorreal<=41,1,'') as col2";
                $res=$this->consultaEstandarTC($cad,$fechaini,  $this->cliente, $this->servicio, $sec, $com, $car, $ren);
                break;
                
            case 8:
                
                /****************************SABOR***************************/
                
                $cad="SELECT
if(ins_detalleestandar.ide_valorreal=1,'1','') as col1,if(ins_detalleestandar.ide_valorreal=2,'failed','') as col2,if(ins_detalleestandar.ide_valorreal=1,'N/A',ins_detalleestandar.ide_comentario)";
                $res=$this->consultaEstandarTC($cad,$fechaini, $this->cliente, $this->servicio,8, 1, 5, $ren);
                break;
                /***************************************edad de jarabes*******************/
            case 9:
                $cad="SELECT Sum(if( ins_detalleproducto.ip_semana >= '20',ins_detalleproducto.ip_numcajas,0)) AS col1,
Sum(if( ins_detalleproducto.ip_semana >= '10' AND ins_detalleproducto.ip_semana <'20',ins_detalleproducto.ip_numcajas,0)) AS col2,
Sum(if( ins_detalleproducto.ip_semana < '10',ins_detalleproducto.ip_numcajas,0)) AS col3
FROM ins_generales
left join( select * from ins_detalleproducto where  ins_detalleproducto.ip_claveservicio=:servicio) ins_detalleproducto on
ins_detalleproducto.ip_numreporte = ins_generales.i_numreporte
           
   WHERE ins_generales.i_mesasignacion =:fechaini 

            AND ins_generales.i_claveservicio=:servicio
GROUP BY ins_detalleproducto.ip_numreporte ORDER BY ins_generales.i_fechavisita ASC";
                //              echo $cad."<br>";
                $parametros=array("servicio"=>$this->servicio,
                   
                    "fechaini"=>$fechaini
                   
                );
                $res=Conexion::ejecutarQuery($cad,$parametros);
                break;
                
                
            case 10:
                $sec=5;
                $com=2;
                $car=6;
                /****************************ALCALINIDAD***************************/
                
                $cad="SELECT ins_detalleestandar.ide_valorreal, if(ins_detalleestandar.ide_valorreal>175,1,'') as col1, if(ins_detalleestandar.ide_valorreal<=175,1,'') as col2";
                $res=$this->consultaEstandarTC($cad,$fechaini, $this->cliente, $this->servicio, $sec, $com, $car, $ren);
                
                break;
            case 11:
                $sec=5;
                $com=2;
                $car=6;
                /****************************ALCALINIDADH***************************/
                //   $cad=consultaEstandar($fechaini, $cuenta, $this->cliente, $this->servicio, $sec, $com, $car, $ren);
                $cad="SELECT sum1 , col1,  col2
                
FROM ins_generales
 left join
(select Sum(a.ide_valorreal) sum1 , if(Sum(a.ide_valorreal)>400,1,'') as col1, if(Sum(a.ide_valorreal)<=400,1,'') as col2, a.ide_numreporte   from ins_detalleestandar a
where a.ide_claveservicio =:servicio and
a.ide_numseccion =:sec AND a.ide_numcomponente =:com
AND (a.ide_numcaracteristica3 =5 OR a.ide_numcaracteristica3 =6)and
a.ide_numrenglon =1  GROUP BY a.ide_numseccion, a.ide_numreactivo, a.ide_numreporte )
as a ON a.ide_numreporte = ins_generales.i_numreporte
 
 WHERE ins_generales.i_mesasignacion =:fechaini  
 
 AND ins_generales.i_claveservicio=:servicio
ORDER BY ins_generales.i_fechavisita, ins_generales.i_numreporte ASC ";
                $parametros=array("servicio"=>$this->servicio,
                    "sec"=>$sec,
                    "fechaini"=>$fechaini
                   
                    );
                $res=Conexion::ejecutarQuery($cad,$parametros);
                break;
            case 12:
                $sec=5;
                $com=2;
                $car=8;
                /****************************CLORO***************************/
                $cad="SELECT
	ins_detalleestandar.ide_valorreal, if(ins_detalleestandar.ide_valorreal>0.5,1,'') as col1,
	if(ins_detalleestandar.ide_valorreal<=0.5,1,'') as col2";
                $res=$this->consultaEstandarTC($cad,$fechaini, $this->cliente, $this->servicio, $sec, $com, $car, $ren);
                break;
            case 13:
                $sec=5;
                $com=2;
                $car=9;
                /****************************SOLIDOS***************************/
                $cad="SELECT
	ins_detalleestandar.ide_valorreal, if(ins_detalleestandar.ide_valorreal>750,1,'') as col1,
                    
	 if(ins_detalleestandar.ide_valorreal>500 AND  ins_detalleestandar.ide_valorreal<=750,1,'') as col2,
	 if(ins_detalleestandar.ide_valorreal<=500,1,'') as col3";
                $res=$this->consultaEstandarTC($cad,$fechaini,$this->cliente, $this->servicio, $sec, $com, $car, $ren);
                break;
            case 14:
                
                $sec=5;
                $com=2;
                $car=9;
                /**************************** APPEREANCE ***************************/
                $cad="SELECT
	round(count(ins_detalle.id_aceptado)/8*10) tot,
	if ((count(ins_detalle.id_aceptado)/8*100)>=0 and (count(ins_detalle.id_aceptado)/8*100)<=55,1,'') as col1,
	if ((count(ins_detalle.id_aceptado)/8*100)>55 and (count(ins_detalle.id_aceptado)/8*100)<=85,1,'') as col2,
	if ((count(ins_detalle.id_aceptado)/8*100)>85 and (count(ins_detalle.id_aceptado)/8*100)<=100,1,'') as col3
	
            FROM ins_generales left join (select * from ins_detalle
            where ins_detalle.id_claveservicio=:servicio and ins_detalle.id_aceptado = '-1'
            and ins_detalle.id_numseccion=9
and ins_detalle.id_numreactivo in(1,2,3,4,5,6,7,8) )  as ins_detalle on ins_generales.i_numreporte = ins_detalle.id_numreporte
WHERE  ins_generales.i_claveservicio=:servicio AND ins_generales.i_mesasignacion =:fechaini
  group by ins_detalle.id_numreporte ORDER BY ins_generales.i_fechavisita ASC, ins_detalle.id_numseccion ASC";
                $parametros=array("servicio"=>$this->servicio,
                    
                    "fechaini"=>$fechaini
                );
                $res=Conexion::ejecutarQuery($cad,$parametros);
                break;
                
                
            default :$res=0;
            break;
        }
        //echo "<br>".$cad;
        
        //echo "<br>".$cad;
      
        return $res;
    }
    
    
    /****************************calcula los porcentajes totales por mes***********************************/
    function totales($columna,$total,$res) {
       
        //echo "col en tot:".$columna;
        //echo $consulta."<br>";
       // $res=Conexion::ejecutarQuery($consulta);
        $totalesr=$totalesv=0;
        
        switch($columna)				//de acuerdo a la prueba será el calculo
        {
            case 5:
                /*************************VOLUMEN************************/
                foreach($res as $row) {
                    //echo "val ".$row["col1"];
                    if($row["col1"]==1)
                        $totalesr++;
                        if($row["col2"]==1||$row["col3"]==1)
                            $totalesv++;
                }
                break;
            case 6:case 10:case 11:case 12:
                /****************************TEMPERATURA***************************/
                foreach($res as $row) {
                    if($row["col1"]=='1')
                        $totalesr++;
                        if($row["col2"]=='1')
                            $totalesv++;
                }
                break;
            case 7:
                $sec=8;
                $com=1;
                $car=9;
                /****************************RATIO**********************************/
                $cad=0;
                break;
            case 8:
                
                /****************************SABOR***************************/
                foreach($res as  $row) {
                    if($row["col1"]!='')
                        $totalesv++;
                        else
                            $totalesr++;
                            //echo $totalesr;
                }
                
                break;
                /***************************************edad de jarabes*******************/
            case 9:
                foreach($res as $row) {
                    $x=$row["col3"];
                    $totalesv=$x+$totalesv;
                    //echo " totver1= ".$totalesv;
                    //$totalesv+=$totalesv;
                    
                    $totalesr=$row["col1"]+$row["col2"]+$totalesr;
                    //$totalesr+=totalesr;
                    
                }
                $total=$totalesr+$totalesv;
                $this->ttotal2+=$total;			//para este caso se suman el total de cajas por mes y no el de reportes
                break;
                
            case 13:case 14:
                
                /****************************SOLIDOS***************************/
                foreach($res as $row) {
                    if($row["col3"]=='1')
                        $totalesv++;
                        else
                            $totalesr++;
                }
                break;
            default :$cad=0;
            break;
        }
        //calcula el procentaje
        if($total!=0){
            $x=$totalesr/$total*100;
            $porc_r=(round($x*100)/100); 	//redondeamos la cifra
            $x=$totalesv/$total*100;
            $porc_v=(round($x*100)/100); 	//redondeamos la cifra
        }
        else {
            //  echo $consulta."<br>";
            $x=0;
            $porc_r=0;
            $porc_v=0;
        }
        $arr["tverde"]=$totalesv;
        $arr["trojo"]=$totalesr;
        $arr["porcr"]=$porc_r;
        $arr["porcv"]=$porc_v;
        return $arr;	//devuelve un arreglo con los porcentajes
        // aceptados (verde) y no aceptados (rojo) y los totales
        
        
    }
    
    /****************************despliega el nombre de la unidad de negocio y fecha de visita********/
    
    function unegocio($cuenta,$fechaini,$ban, $ren) {
      
        
        //    //////////////////////// encabezados de las columnas//////////////////////////////
        //    $encabezado=array("Business Unit","Market","Store Name","Survey Date-Time");
        //    /////////////////////////////////////////////////////////////////////////////////
        $this->totcol1=0; 
        $text_format =array(
              'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('argb'   =>  $this->arrcolores["amarillo"])),
            'font' => array("size"    => 10,
            "name"    => 'Arial Unicode MS'
        ));
      
        if ($cuenta!=-1)			//cuando cuenta es -1 significa que es un reporte de todas las cuentas
        {    //si no hace la consulta de los datos del negocio de una cuenta
            $sSQL="SELECT
	ca_nivel2.n2_nombre pais,une_dir_municipio cd,
	ca_unegocios.une_descripcion as nom,
	concat(if(timestampdiff(day,ins_generales.i_fechavisita,last_day(str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')))<0,date_format(last_day(str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')),'%m/%d/%Y'),date_format(ins_generales.i_fechavisita,'%m/%d/%Y')),
	\" \",ins_generales.i_horaentradavis) as hora,
	ins_generales.i_claveservicio as serv,
	ins_generales.i_numreporte as rep
	
FROM
ins_generales
inner Join ca_unegocios ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
inner Join ca_nivel2 ON  ca_unegocios.une_cla_pais = ca_nivel2.n2_id
WHERE
	ca_unegocios.cue_clavecuenta =:cuenta AND
	ins_generales.i_mesasignacion =:fechaini AND
                
ins_generales.i_claveservicio=:servicio  ORDER BY
	ins_generales.i_fechavisita ASC;";
            $parametros=array("cuenta"=>$cuenta,
                "fechaini"=>$fechaini,
               "cuenta"=>$cuenta,
                "servicio"=>$this->servicio
            );
        } else		//para todas las cuentas
        {    $sSQL="SELECT
       ca_nivel2.n2_nombre pais, une_dir_municipio cd,
		ca_unegocios.une_descripcion as nom,
	concat(if(timestampdiff(day,ins_generales.i_fechavisita,last_day(str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')))<0,date_format(last_day(str_to_date(concat('01.',ins_generales.i_mesasignacion),'%d.%m.%Y')),'%m/%d/%Y'),date_format(ins_generales.i_fechavisita,'%m/%d/%Y')),
	\" \",ins_generales.i_horaentradavis) as hora,
	ins_generales.i_claveservicio as serv,
	ins_generales.i_numreporte as rep
	
FROM
ins_generales
inner Join ca_unegocios ON ins_generales.i_unenumpunto = ca_unegocios.une_id
inner Join ca_nivel2 ON 
 ca_unegocios.une_cla_pais = ca_nivel2.n2_id

    WHERE ins_generales.i_mesasignacion =:fechaini   AND
     
ins_generales.i_claveservicio=:servicio  ORDER BY
 ins_generales.i_fechavisita ASC ;";
                $parametros=array(
                    "fechaini"=>$fechaini,
                   
                    "servicio"=>$this->servicio
                );}
                $letra=65;
                if($res=Conexion::ejecutarQuery($sSQL,$parametros)) {
                    $num_reg = sizeof($res);
                    //$ren=2;
                    //        if($num_reg>1){
                    foreach($res as $row) {
                        //$tablatemp->nuevoren();
                        $letra=65;
                        for ($i=0;$i<4;$i++) {
                            $val=$row[$i];
                            //	$tablatemp->nuevacol($val,$arrcolores["verdeo"],"");
                            //     echo michr($letra).$ren."--". $val."<br>";
                            
                            
                            $this->worksheet->setCellValue($this->michr($letra).$ren, $val); 
                            $this->worksheet->getStyle($this->michr($letra++).$ren)->applyFromArray($text_format);
                            
                        }
                        //$tablatemp->finren();
                        $ren++;
                        //
                        
                    }
                    
                   
                }
              
//                 else
//                     throw new Exception("Error");
                    // $ren++;
                    
                    $fecha=explode('.',$fechaini);		//convierte la fecha en formato nombre mes año
                    $fecha2=date("F Y",mktime(0,0,0,$fecha[0],1,$fecha[1]));
                    $letra=65;
                    $text_format = array(
                         'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                         		'startcolor' => array('argb'   =>  $this->arrcolores["amarillo"])),
                        'font' => array("size"    => 10,
                        "name"    => 'Arial Unicode MS'
                    ));
                    
                    $this->worksheet->setCellValue($this->michr($letra).$ren, "PV evaluados en ".$fecha2); 
                    $this->worksheet->getStyle($this->michr($letra++).$ren)->applyFromArray($text_format);
                    
                  
                    
                    $this->worksheet->setCellValue($this->michr($letra).$ren, $num_reg);  
                    $this->worksheet->getStyle($this->michr($letra++).$ren)->applyFromArray($text_format);
                    
                    $this->ttotal=$this->ttotal+$num_reg;
                    //$tablatemp->finren();
                    //	return $tablatemp->cierretabla();
                    //return $cadena;
                    //return $cadena;
                    
                    return array($letra,$ren);
                    
                    
    }
    /*****************************calculos para prueba de radio***********************************/
    function valoresratio($cuenta,$fechaini,$rep,$x,$letra,$renglon) {
     
         
        //$x=5;
        //se calculan los rangos
        $valron=$x*(1-.1);
        $valnan=$x*(1-.05);
        $valamn=$x*(1-.02);
        $valrop=$x*(1+.1);
        $valnap=$x*(1+.05);
        $valamp=$x*(1+.02);
        
        if ($cuenta!='-1')		//para una cuenta
        {  $sSQL1="SELECT
		if(a.ide_valorreal <=".$valron." OR a.ide_valorreal >".$valrop.",a.ide_valorreal,0) AS rojo,
		if((a.ide_valorreal>".$valron."AND a.ide_valorreal <='".$valnan."')OR (a.ide_valorreal >".$valnap." AND a.ide_valorreal <='".$valrop."'),a.ide_valorreal,0) AS naranja,
		if((a.ide_valorreal >".$valnan." AND a.ide_valorreal <=".$valamn.") OR (a.ide_valorreal >".$valamp." AND a.ide_valorreal <=".$valnap."),a.ide_valorreal,0) AS amarillo,
		if(a.ide_valorreal >".$valamn." AND a.ide_valorreal <=".$valamp.",a.ide_valorreal,0) AS verde
		FROM
		ins_generales
		Inner Join ins_detalleestandar AS a ON ins_generales.i_claveservicio = a.ide_claveservicio AND a.ide_numreporte = ins_generales.i_numreporte
		inner join `ca_unegocios` ON `une_id`=`i_unenumpunto`
        WHERE
		ins_generales.i_mesasignacion =:fechaini AND
        ins_generales.i_claveservicio=:servicio   AND
		cue_clavecuenta =:cuenta AND
		a.ide_numseccion =  '8' AND
		a.ide_numcomponente =  '1' AND
		a.ide_numcaracteristica3 =  '9' and
		ins_generales.i_numreporte=:rep";
            //echo "<br>".$sSQL1;
            $parametros=array("fechaini"=>$fechaini,
                "cuenta"=>$cuenta,
                "servicio"=>$this->servicio,
                "rep"=>$rep);
        } else		//para todas
        {     $sSQL1="SELECT
		if(a.ide_valorreal <=".$valron." OR a.ide_valorreal >".$valrop.",a.ide_valorreal,0) AS rojo,
		if((a.ide_valorreal>".$valron."AND a.ide_valorreal <='".$valnan."')OR (a.ide_valorreal >".$valnap." AND a.ide_valorreal <='".$valrop."'),a.ide_valorreal,0) AS naranja,
		if((a.ide_valorreal >".$valnan." AND a.ide_valorreal <=".$valamn.") OR (a.ide_valorreal >".$valamp." AND a.ide_valorreal <=".$valnap."),a.ide_valorreal,0) AS amarillo,
		if(a.ide_valorreal >".$valamn." AND a.ide_valorreal <=".$valamp.",a.ide_valorreal,0) AS verde
		FROM
		ins_generales
		Inner Join ins_detalleestandar AS a ON ins_generales.i_claveservicio = a.ide_claveservicio AND a.ide_numreporte = ins_generales.i_numreporte
		WHERE
		ins_generales.i_mesasignacion =:fechaini AND
               
ins_generales.i_claveservicio=:servicio    AND
		a.ide_numseccion =  '8' AND
		a.ide_numcomponente =  '1' AND
		a.ide_numcaracteristica3 =  '9' and
		ins_generales.i_numreporte=:rep ";
        $parametros=array("fechaini"=>$fechaini,
           
            "servicio"=>$this->servicio,
            "rep"=>$rep);
        }
                
                $valores[0]= $valores[1]= $valores[2]= $valores[3]=0;
                $res1=Conexion::ejecutarQuery($sSQL1,$parametros);
               
                $total= sizeof($res1);		//numero de renglones por reporte
                $this->worksheet->setCellValue($this->michr($letra).$renglon, $total);
           //     $this->worksheet->getStyle($this->michr($letra).$renglon)->applyFromArray($text_format);
                
                
                if ($total>0) {
                    foreach($res1 as $row1) {
                        if ($row1[0]!=0)
                            $valores[0]++;			//muestras en rojo
                            else
                                if ($row1[1]!=0)
                                    $valores[1]++;		//muestras en naranja
                                    else
                                        if ($row1[2]!=0)
                                            $valores[2]++;		//muestras en amarillo
                                            else
                                                if ($row1[3]!=0)
                                                    $valores[3]++;		//muestras en verde
                    }
                    //calcular porcentajes
                    $a=$valores[0]/$total*100;
                    $a=round($a);
                    
                    $this->worksheet->setCellValue($this->michr($letra++).$renglon,$a);
                    
                    
                    $a=$valores[1]/$total*100;
                    $a=round($a);
                    $this->worksheet->setCellValue($this->michr($letra++).$renglon,$a);
                    
                    
                    $a=$valores[2]/$total*100;
                    $a=round($a);
                    $this->worksheet->setCellValue($this->michr($letra++).$renglon,$a);
                    
                    
                    $a=$valores[3]/$total*100;
                    $a=round($a);
                    $this->worksheet->setCellValue($this->michr($letra++).$renglon,$a);
                    
                    
                    
                    
                }
                $this->tablaux[$rep][0]=$total;
                for($i=1;$i<5;$i++)		//guardamos en el arreglo temporal el numero de reportes por color
                {
                    
                    $this->tablaux[$rep][$i]=$valores[$i-1];
                    
                }
                return $letra;
                
                
                
    }
    /*******************************tabla radio por reporte********************************/
    function ratio($cuenta,$fechaini,$letra,$renglon) {
      
       
        //$tablatemp = new tablahtml();
        $totmedidas=$validos=$novalidos=$a=$b=0;
        if ($cuenta=='-1')
            // seleccionamos el valor con el que se probará //para todas las cuentas
        {    $sSQL1="SELECT
	cue_reactivosestandardetalle.red_valormin as valmin,
	cue_reactivosestandardetalle.red_valormax as valmax,
	ins_generales.i_numreporte as numrep
	FROM
	ins_generales
	Inner Join cue_reactivosestandardetalle
		Inner Join ins_detalleestandar ON ins_generales.i_claveservicio = ins_detalleestandar.ide_claveservicio AND ins_generales.i_numreporte = ins_detalleestandar.ide_numreporte AND ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente
	WHERE
	cue_reactivosestandardetalle.ser_claveservicio =:servicio
	and cue_reactivosestandardetalle.r_numreactivo=0
	and cue_reactivosestandardetalle.re_numcaracteristica=0
	and cue_reactivosestandardetalle.re_numcomponente2=0
	and cue_reactivosestandardetalle.red_numcaracteristica2=9
	and	ins_generales.i_mesasignacion =:fechaini
	 AND ins_detalleestandar.ide_numseccion =  '8' AND
	 ins_detalleestandar.ide_numcomponente =  '1' AND
	 ins_detalleestandar.ide_numcaracteristica3 =  '9' GROUP BY
	 ins_detalleestandar.ide_numreporte ORDER BY ins_generales.i_fechavisita ASC";
        $parametros=array("fechaini"=>$fechaini,
          
            "servicio"=>$this->servicio);
        }
            else
            {     $sSQL1="SELECT
	cue_reactivosestandardetalle.red_valormin as valmin,
	cue_reactivosestandardetalle.red_valormax as valmax,
	ins_generales.i_numreporte as numrep
	FROM
	ins_generales

	Inner Join cue_reactivosestandardetalle
		Inner Join ins_detalleestandar ON ins_generales.i_claveservicio = ins_detalleestandar.ide_claveservicio AND ins_generales.i_numreporte = ins_detalleestandar.ide_numreporte AND ins_detalleestandar.ide_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND ins_detalleestandar.ide_numseccion = cue_reactivosestandardetalle.sec_numseccion AND ins_detalleestandar.ide_numreactivo = cue_reactivosestandardetalle.r_numreactivo AND ins_detalleestandar.ide_numcomponente = cue_reactivosestandardetalle.re_numcomponente
	inner join `ca_unegocios` ON `une_id`=`i_unenumpunto`
WHERE
	cue_reactivosestandardetalle.ser_claveservicio =:servicio 
	and cue_reactivosestandardetalle.r_numreactivo=0
	and cue_reactivosestandardetalle.re_numcaracteristica=0
	and cue_reactivosestandardetalle.re_numcomponente2=0
	and cue_reactivosestandardetalle.red_numcaracteristica2=9
	and	ins_generales.i_mesasignacion =:fechaini
	 AND
	cue_clavecuenta =:cuenta AND
	 ins_detalleestandar.ide_numseccion =  '8' AND
	 ins_detalleestandar.ide_numcomponente =  '1' AND
	 ins_detalleestandar.ide_numcaracteristica3 =  '9' GROUP BY
	 ins_detalleestandar.ide_numreporte order by ins_generales.i_fechavisita ASC";
            $parametros=array("fechaini"=>$fechaini,
               "cuenta"=>$cuenta,
                "servicio"=>$this->servicio);
            }
                //echo $sSQL1;
                $res1=Conexion::ejecutarQuery($sSQL1,$parametros);
              
                $total= sizeof($res1);
                
                $letrai=$letra;
             
                if ($total>0) {
                    foreach($res1 as $row1) {
                        
                        $x=($row1["valmax"]+$row1["valmin"])/2;
                        //echo "xx ".$row1["valmax"]."ff".$row1["valmin"];
                        //echo "   ddd   ".$x;
                        //  $tablatemp->nuevoren();
                        
                        //$row1["valmax"]
                        
                        $letra=$this->valoresratio($cuenta,$fechaini,$row1["numrep"],$x,$letrai,$renglon);			//llamamos a la funcion rato para calcular los valores de cada reporte
                        //echo "en rat2 ".$letra;
                        $ind=$row1["numrep"];
                        //$tablatemp->finren();
                        //se acumulan los totales para el porcentaje final
                        
                        $totmedidas+=$this->tablaux[$ind][0];
                        $validos+=$this->tablaux[$ind][1]+$this->tablaux[$ind][2];
                        
                        $novalidos+=$this->tablaux[$ind][4]+$this->tablaux[$ind][3];
                        $renglon++;
                        //echo "<br> rep".$ind." i ".$this->tablaux[$ind][0]." r ".$this->tablaux[$ind][1]."n  ".$this->tablaux[$ind][2]." a ".$this->tablaux[$ind][3]." v ".$this->tablaux[$ind][4];
                    }
                    //se calcula el porcentaje final
                    $a=$novalidos*100/$totmedidas;
                    $b=$validos*100/$totmedidas;
                }
              
                $a_ratio[0]=$validos;
                $a_ratio[1]=$totmedidas;
                
                $this->aceptados[$this->im][7]=$a_ratio;
                $x=$this->aceptados[$this->im][7];
                //echo "<br>arreglo ratio  ".$this->im." x".$x[0]." - ".$x[1];
                //echo "<br>arreglo ratio".$this->im." ".$a_ratio[0]."  ".$a_ratio[1];
                
                // $tablatemp->nuevoren();
                //$tablatemp->nuevacol(VACIO,"","");
                
                $this->worksheet->setCellValue($this->michr($letrai++).$renglon,"");
                $text_format =array(
                    'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                    		'startcolor' => array('argb'   =>  $this->arrcolores["rojof"])),
                    'font' => array("size"    => 10,
                    "name"    => 'Arial Unicode MS'
                ));
                
                $this->worksheet->setCellValue($this->michr($letrai).$renglon,round($a*100)/100);
                $this->worksheet->getStyle($this->michr($letrai).$renglon)->applyFromArray($text_format);
                $this->worksheet=$this->rangoCeldas($letrai++, $renglon, 2,$text_format,$this->worksheet);
                $letrai++;
                
                $text_format = array(
                     'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                     		'startcolor' => array('argb'   =>  $this->arrcolores["verdef"])),
                    'font' => array("size"    => 10,
                    "name"    => 'Arial Unicode MS'
                ));
                
                $this->worksheet->setCellValue($this->michr($letrai).$renglon,round($b*100)/100); 
                $this->worksheet->getStyle($this->michr($letrai).$renglon)->applyFromArray($text_format);
                $this->worksheet=$this->rangoCeldas($letrai++, $renglon, 2,$text_format,$this->worksheet);
                $letrai++;
                
                return $letrai;
                
    }
    
    
    
    /******************DESPLIEGUE DE CADA PRUEBA*****************************/
    
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
            // $color=$arrcolores["gris"];
            $color=$this->arrcolores[$color_arr[$j++]];
            
            $text_format =array(
                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('argb'   => $color)),
                'font' => array("size"    => 10,
                'name'    => 'Arial Unicode MS'
            ));
            
            
            $this->worksheet->setCellValue($this->michr($letra).$renglon, $encabezado[$i]); 
            $this->worksheet->getStyle($this->michr($letra++).$renglon)->applyFromArray($text_format);
            
            
        }
        
        
        //echo "<br>col: ".$col;
        
        return $letra; //en que columna me quede
        
    }
    function creaSeccion($col,$cuenta,$fechaini,$ban,$renglon,$letrai) {
       
        $totcol1=0;
        $totcol2=0;
        $totcol3=0;
        
     
        if($col!=7) {
            if($cuenta=='-1')		//consulta todas las cuentas
                $res=$this->consulta_gral($col,$fechaini,$this->servicio,$this->cliente);
            else		//consulta para 1 cuenta
                 $res=$this->consulta($col,$cuenta,$fechaini,$this->servicio,$this->cliente);
                   
                    if($res!=0) {
                       
                        
                        $num_reg = sizeof($res);		//numero de reportes por mes
                        if($num_reg!=0) {
                            foreach($res as $row) {
                                // $tablatemp->nuevoren();
                                $color=$this->arrcolores["verdeo"];
                                $letrait=$letrai;
                                for($i=0;$i<sizeof($row)/2;$i++) {
                                    
                                    $val=$row[$i];
                                   
                                    $this->worksheet->setCellValue($this->michr($letrait).$renglon, $val);
                                    $letrait++;
                                }
                                
                                $renglon++;
                                
                                // $tablatemp->finren();
                            }
                            
                            // $renglon++;
                            
                            $ultren=$this->totales($col,$num_reg,$res);
                            $this->aceptados[$this->im][$col]=$ultren["tverde"];
                            //echo "<br>total col ".$col." ".$ultren["tverde"];
                            
                            
                            /******************se despliega el porcentaje total por mes*********/
                            $color1=$this->arrcolores["rojof"];
                            $color2=$this->arrcolores["verdef"];
                            $exp2=$exp1="";
                            if ($col==5) {
                                $this->worksheet->setCellValue($this->michr($letrai++).$renglon, "");
                                $accion2='$this->worksheet=$this->rangoCeldas($letrai++, $renglon, 2,$text_format,$this->worksheet);';
                                $exp2=2;
                                
                            }
                            
                            if($col==8) {
                                
                                $color1=$this->arrcolores["verdef"];
                                
                                $color2=$this->arrcolores["rojof"];
                                $this->aceptados[$this->im][$col]=$ultren["trojo"];
                            }
                            if($col==9) {
                                $exp1=2;
                                $accion1='$this->worksheet=$this->rangoCeldas($letrai++, $renglon, 2,$text_format,$this->worksheet);';
                            }
                            if($col==10||$col==11||$col==12||$col==6) {
                                $this->worksheet->setCellValue($this->michr($letrai++).$renglon, "");
                                
                            }
                            if($col==13||$col==14) {
                                $this->worksheet->setCellValue($this->michr($letrai++).$renglon, "");
                                $exp1=2;
                                $accion1='$this->worksheet=$this->rangoCeldas($letrai++, $renglon, 2,$text_format,$this->worksheet);';
                                
                                
                            }
                        
                            
                            $text_format =array(
                                
                                
                                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                                		'startcolor' => array('argb'   => $color1)),
                                'font' => array("size"    => 10,
                                "name"    => 'Arial Unicode MS'
                            ));
                            
                            $this->worksheet->setCellValue($this->michr($letrai).$renglon, $ultren["porcr"]);
                            $this->worksheet->getStyle($this->michr($letrai).$renglon)->applyFromArray($text_format);
                            eval($accion1);
                            $letrai++;
                            $text_format = array(
                                
                                
                                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                                		'startcolor' => array('argb'   => $color2)),
                                'font' => array("size"    => 10,
                                "name"    => 'Arial Unicode MS'
                            ));
                            $this->worksheet->setCellValue($this->michr($letrai).$renglon,$ultren["porcv"]);
                            $this->worksheet->getStyle($this->michr($letrai).$renglon)->applyFromArray($text_format);
                             eval($accion2);
                            $letrai++;
                            //$tablatemp->finren();
                            
                            
                        }
                        else {
                            //relleno con espacios en blanco
                            $letrait=$letrai;
                            for($i=0;$i<sizeof($res[0]);$i++) {
                                $this->worksheet->setCellValue($this->michr($letrait).$renglon,"");
                                
                                $letrait++;
                            }
                            
                            
                            $text_format = array(
                                
                                
                                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                                		'startcolor' => array('argb'   =>  $this->arrcolores["rojof"])),
                                'font' => array("size"    => 10,
                                "name"    => 'Arial Unicode MS'
                            ));
                            
                            $this->worksheet->setCellValue($this->michr($letrai).$renglon,"0");
                            $this->worksheet->getStyle($this->michr($letrai).$renglon)->applyFromArray($text_format);
                            
                            $letrai++;
                            $text_format = array(
                                
                                
                                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                                		'startcolor' => array('argb'   =>  $this->arrcolores["verdef"])),
                                'font' => array("size"    => 10,
                                "name"    => 'Arial Unicode MS'
                            ));
                            
                            $this->worksheet->setCellValue($this->michr($letrai).$renglon,"0"); 
                            $this->worksheet->getStyle($this->michr($letrai).$renglon)->applyFromArray($text_format);
                            
                            $letrai++;
                            $this->aceptados[$this->im][$col]=0;
                            // $letrait=$letrai;
                            // $tablatemp->finren();
                        }
                        
                      
                        
                    }
                    return $letrait; // saber en que col me quedé
                    //   return $tablatemp->cierretabla();
        }
        else	//crea tabla "ratio"
        {
            $letra=$this->ratio($cuenta,$fechaini, $letrai,$renglon);
            
            return $letra;
        }
        
        
    }
    
    
    /***********************************ABRE Y ESCRIBE ARCHIVO EN EXCEL*****************/
    function creaarch($archivo,$cadena) {
        //$archivo= "c:\\".$cuenta."_".$fecha.".xls";
        $fp = @fopen($archivo, "w");
        $write = @fputs($fp, $cadena);
        @fclose($fp);
        //echo "ya";
    }
    
    /****************************************GENERA REPORTE POR CUENTA***************************/
    function reporte($cuenta,$nomarchivo) {
        
        include "Utilerias/leevar.php";
        
        //////////////////////////////////// nombres de cada columna o prueba//////////////////////////////
        $enctablas=array("INSPECCIONES REALIZADAS","CO2 VOLUME","PRODUCT TEMPERATURE","RATIO","CORRECT FLAVOR",
            "SYRUP AGE","ALKALINITY","ALKANINITY + HARDNESS","TOTAL CHLORINE","TOTAL DISSOLVED SOLIDS","APPERANCE");
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $arr_colxsec=array(
            4, 3, 5,  3, 3,3,3,3,4,4);
      
        $mes2=$fechafin;
        $anio2=$fechafin2;
        $this->mes_asig=$fec1=$fechainicio.".".$fechainicio2;		//fecha de inicio
        $fec2=$fechafin.".".$fechafin2;						//fecha de fin del reporte
        
        //$fec1="2008-08-01";
        //$fec2="2008-12-30";
        
        $anio1=$fechainicio2;
        $mes1=$fechainicio;
        /*$arreglo=explode('-',$fec1);
         $anio1=$arreglo[0];
         $mes1=$arreglo[1];*/
       
        $this->im=0;
      
      
       
     
        
        $ren_ex=1;
     
        if ($cuenta=='-1')	//despliega encabezado para todas las cuentas
        {
         
            //$cadarchivo.="<td height='60' style='font:bold; color:#FFFFFF' bgcolor=\"".$arrcolores["azul"]."\" colspan=3>".$enctablas[0]."  DEL PERIODO:  ".$anio1."</td></tr><tr>";
            $letra=65;
            $text_format = array(
                 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                		'startcolor' => array('argb'   => $this->arrcolores["verde"])),
            		'font' => array('italic' => true,'bold' => true,"size"    => 12,
                'name'    => 'Arial'
            ));
            
            $this->worksheet->setCellValue($this->michr($letra).$ren_ex, $enctablas[0]."  DEL PERIODO:  ".$anio1);
            $this->worksheet->getStyle($this->michr($letra).$ren_ex)->applyFromArray($text_format);
            $this->worksheet=$this->rangoCeldas($letra, $ren_ex, 4,$text_format);
            // $objPHPExcel->getActiveSheet()->mergeCells(rangoCeldas($letra,$ren_ex,3));
            
        }
        else 
        {
             $res=DatosCuenta::editarCuentaModel($cuenta,"ca_cuentas");
             $nomcuenta=$res["cue_descripcion"];
            // $cadarchivo.="<td height='60' style='font:bold; color:#FFFFFF' bgcolor=\"".$arrcolores["azul"]."\" colspan=3>".$enctablas[0]."  ".$nomcuenta." DEL PERIODO:  ".$anio1."</td></tr><tr>";
            $letra=65;
            $text_format = array(
              
                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                		'startcolor' => array('argb'   => $this->arrcolores["verde"])),
            		'font' => array('italic' => true,'bold' => true,"size"    => 12,
                "name"    => 'Arial Unicode MS'
            ));
            // $this->worksheet->set_column(1, 2, 20);
            $text_format->set_merge();
            $this->worksheet->setCellValue($this->michr($letra).$ren_ex, $nomcuenta."  DEL PERIODO:  ".$anio2);
            $this->worksheet->getStyle($this->michr($letra).$ren_ex)->applyFromArray($text_format);
            $this->worksheet=$this->rangoCeldas($letra, $ren_ex, 4,$text_format);
            
        }
        $letra++;
        $ren_ex++;
        $text_format = array(
           
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
            		'startcolor' => array('argb'   => $this->arrcolores["azul"])),
        		'font' => array('italic' => true,'bold' => true,"size"    => 12,
            "name"    => 'Arial Unicode MS'
        ));
        $this->worksheet->setCellValue($this->michr($letra).$ren_ex, $enctablas[0]);
        $letra=69;
        for($i=1;$i<11;$i++) {
            
            //$cadarchivo.="<td style='font:bold; color:#FFFFFF' bgcolor=\"".$this->arrcolores["azul"]."\">".$enctablas[$i]."</td>";
            
            
        	$this->worksheet->setCellValue($this->michr($letra).$ren_ex, $enctablas[$i]); 
        	$this->worksheet->getStyle($this->michr($letra).$ren_ex)->applyFromArray($text_format);
            $this->worksheet=$this->rangoCeldas($letra, $ren_ex, $arr_colxsec[$i-1],$text_format);
            // $objPHPExcel->getActiveSheet()->mergeCells(rangoCeldas($letra,$ren_ex,$arr_colxsec[$i-1]));
            
            $letra+=$arr_colxsec[$i-1];
            
        }
        // agrego  titulos de pv
        //////////////////////// encabezados de las columnas//////////////////////////////
        $encabezadopv=array("Business Unit","Market","Store Name","Survey Date-Time");
        /////////////////////////////////////////////////////////////////////////////////
        $letra=65;
        
        for($i=0;$i<4;$i++) {
            // echo michr($letra).'3'."--". $encabezadopv[$i]."<br>";
            $text_format = array(
              
                
                'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                		'startcolor' => array('argb'   => $this->arrcolores["gris"])),
            		'font' => array('italic' => true,'bold' => true,"size"    => 10,
                "name"    => 'Arial Unicode MS'
            ));
            
            $this->worksheet->setCellValue($this->michr($letra).'3', $encabezadopv[$i]); 
            $this->worksheet->getStyle($this->michr($letra).'3')->applyFromArray($text_format);
            //$tablatemp->nuevacol($encabezado[$i],$this->arrcolores["gris"],"");		//despliega el nombre de cada columna
            $letra++;
            
        }
        
        // titulos de secciones
        $renglon=3;
        for($j=5;$j<15;$j++) {
            //$ttotal=0;
            // $cadtabla=$cadtabla."<td height=\"15\">";
            
            $letra=$this->principal($j,$letra,$renglon);				//despliega todas las columnas del reporte
            
            
            
        }
        
        
        //OBTENEMOS EL PERIODO DEL CUAL SE VA A GENERAR EL REPORTE
        
        $fecaux=$fec1;
        //echo $mes1;
        $fin=12;
        if($anio1==$anio2) {
            $fin=$mes2;
        }
        
        //echo $fin;
        $j=0;
        $i=$mes1;
        $l=$anio1;
        $fecha_i=($i+1-1).'.'.$l;
        // elije hoja
        $ren_ex=4;
    
        /*************************depliega tablas por mes********************************/
        for($l=$anio1;$l<=$anio2;$l++) {
            if ($anio2>$l) {
                $fin=12;
            }
            $cont=0;
            
            for($i=$mes1;$i<=$fin;$i++) {
                
                //$cadtabla=$cadtabla."<tr>";
                //$cadtabla=$cadtabla."<td height=\"15\">";
                //$fecha_i=$i.'.'.$l;
                //echo "fff".substr('000'.($i+1),-2);
                
                //$cadtabla=4this->$cadtabla.unegocio($cuenta,$fecha_i,$cont,$this->servicio, $this->cliente)."</td><td>;;;</td>";
                $coordenada=$this->unegocio($cuenta,$fecha_i,$cont,$ren_ex);
                     
                $letra=69;
                //15
                for($j=5;$j<15;$j++) {
                    //$ttotal=0;
                    // $cadtabla=$cadtabla."<td height=\"15\">";
                    
                    //$letra=principal($j,$cuenta,$fecha_i,$cont,$letra,$renglon);				//despliega todas las columnas del reporte
                    
                    $letra=$this->creaSeccion($j, $cuenta, $fecha_i, $cont, $ren_ex, $letra);
                    //echo "<br>aceptados afuera col".$j." ".$aceptados[$this->im][$j];
                    
                    // $letra++;
                }
                
                $cont++;
                $this->im++;
                $arreglot[$j++]=0;
                
                $mes_asig=($i+1).'.'.$l;		//calcula el siguiente mes de asignación
                $fecha_i=($i+1).'.'.$l;
                $renglon++;
                $ren_ex=$coordenada[1]; //busco el renglon donde me quede
                $ren_ex++;
            }
            $mes1=1;
            $fin=$mes2;
            $mes_asig='1'.'.'.($l+1);
            
        }
        $k=0;
        $arraux[0]=$arraux[1]=0;
        //echo "esta es i".$i;
        //se obtiene la evaluacion promedio anual
        $aceptadasratio=0;
     
        for($ind=5;$ind<15;$ind++) {
            
            for($im=0;$im<$i;$im++) {
                
                if ($ind==7) {
                    $arraux=$this->aceptados[$im][$ind];
                    //echo "aqui ".$im.$ind."  ".$aceptados[$im][$ind];
                    $aceptadasratio+=$arraux[0];
                    $totalratio+=$arraux[1];
                    //echo "<br>arreglo ratio2 ".$im." ".$arraux[0]."  ".$arraux[1];
                    
                    //echo "<br>arreglo col".$ind."ratio ".$arreglot[$k];
                }
                else
                    if($ind==9) {
                        if($this->ttotal2!=0) {
                            $x=$this->aceptados[$im][$ind]/$this->ttotal2*100;
                            $arreglot[$k]=$arreglot[$k]+round($x*100)/100;
                        }
                        else
                            $arreglot[$k]=0;
                    }
                else {
                    if($this->ttotal!=0) {
                        $x=$this->aceptados[$im][$ind]/$this->ttotal*100;
                        $arreglot[$k]=$arreglot[$k]+round($x*100)/100;
                    }
                    else
                        $arreglot[$k]=0;
                }
                
                //echo "<br>arreglo col ".$ind." ".$aceptados[$im][$ind];
            }
            
            if ($ind==7&&$totalratio!=0) {
                $arreglot[$k]=round($aceptadasratio/$totalratio*100*100)/100;
            }
            
            $k++;
        }
        
        //$renaceptados="<tr><td height=\"15\">EVALUACION PROMEDIO ANUAL<td>";
        $text_format = array(
          
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
            		'startcolor' => array('argb'   => $this->arrcolores["amarillo"])),
        		'font' => array('italic' => true,'bold' => true,"size"    => 10,
            "name"    => 'Arial Unicode MS'
        ));
        
        $this->worksheet->setCellValue("A".$ren_ex,"PV Evaluados: ".$this->ttotal); 
        $this->worksheet->getStyle("A".$ren_ex)->applyFromArray($text_format);
        $this->worksheet=$this->rangoCeldas(65, $ren_ex, 2,$text_format);
        // $objPHPExcel->getActiveSheet()->mergeCells(rangoCeldas(65,$ren_ex,2));
        
    
        $this->worksheet->setCellValue("C".$ren_ex,"PROMEDIO ANUAL"); 
        $this->worksheet->getStyle("C".$ren_ex)->applyFromArray($text_format);
        $this->worksheet=$this->rangoCeldas(67, $ren_ex, 2,$text_format);
        //$objPHPExcel->getActiveSheet()->mergeCells(rangoCeldas(67,$ren_ex,2));
        $k=0;
        $letra=69;
        $text_format =array(
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
            		'startcolor' => array('argb'   => $this->arrcolores["verde"])),
        		'font' => array('italic' => true,'bold' => true,"size"    => 10,
            "name"    => 'Arial Unicode MS'
        ));
        for ($i=1;$i<sizeof($enctablas);$i++) {
            
            
            $this->worksheet->setCellValue($this->michr($letra).$ren_ex, $enctablas[$i]." : ".$arreglot[$k++]); 
            $this->worksheet->getStyle($this->michr($letra).$ren_ex)->applyFromArray($text_format);
            $this->worksheet=$this->rangoCeldas($letra, $ren_ex, $arr_colxsec[$i-1],$text_format);
            // $objPHPExcel->getActiveSheet()->mergeCells(rangoCeldas($letra,$ren_ex,$arr_colxsec[$i-1]));
            $letra+=$arr_colxsec[$i-1];
        }
        
     
        
    }
    
    function michr($indice){
        if($indice>=65&&$indice<=90){
            return chr($indice);
        }
        if($indice>142){
            return "C".chr($indice-(78));
        }
        if($indice>116){
            return "B".chr($indice-52);
        }
        if($indice>90){
            return "A".chr($indice-26);
        }
    }
    
    function rangoCeldas($linicio,$renglon, $colspan,$text_format){
        
        
        //  echo $rango."<br>";
        for($i=1;$i<$colspan;$i++){
        	$this->worksheet->setCellValue($this->michr($linicio+$i).$renglon,'');
        	$this->worksheet->getStyle($this->michr($linicio+$i).$renglon)->applyFromArray($text_format);
        }
        
        return $this->worksheet;
        
    }
    function colorCelda($objPHPExcel,$color,$celda){
     //   $objPHPExcel->getActiveSheet()->getStyle($celda)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle($celda)->getFill()->getStartColor()->setARGB($color);
        return $objPHPExcel;
    }
}






