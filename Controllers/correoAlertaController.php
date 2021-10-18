<?php
//error_reporting(E_ALL);
//include_once '../../Models/conexion.php';
include_once './Models/crud_estandar.php';
include_once './Models/crud_muestras.php';
include_once 'certificacionController.php';
include_once 'tablaAlertaController.php';
include 'correoAlertas.php';
include './Utilerias/utilerias.php';

date_default_timezone_set('America/Mexico_City');

class CorreoAlertaController{
    
    public $sv;
    
    public $infoGeneral;
    public $listaSolicitudes;
    public $fechaini;
    public $fechafin;
    public $bd;
    
    public function __construct($sv){
        $this->sv=$sv;
        $this->bd=new Conexion();
    }
    
    public function definirHoras(){
        $mifecha = new DateTime();
        //para prueba$prueba="2021-09-17";
       //para pruebas $mifecha = new DateTime("2021-09-17 16:00:00");
        
        $ahora=strtotime(date("Y-m-d H:00:00"));
        $hora=strtotime(date("H:i:s"));
        $lasnueve=strtotime(date("Y-m-d 9:00:00"));
        $lascuatro=strtotime(date("Y-m-d 16:00:00"));
      
       //ára ´prueba  $ahora=strtotime(date($prueba." 16:00:00"));
      
      //para prueba   $lasnueve=strtotime(date($prueba." 9:00:00"));
      //para prueba   $lascuatro=strtotime(date($prueba." 16:00:00"));
        
      //  echo $ahora;
      //  echo "<br>".$hora;
      //  echo "<br>".$lasnueve;
      //  echo "<br>".$lascuatro;
      //  echo "***".$mifecha->format('d-m-Y H:i:s');
        if($ahora>=$lasnueve&&$ahora<$lascuatro){
            $mifecha->modify('-17 hours'); 
            $this->fechaini=$mifecha->format('Y-m-d H:00:00');
            $this->fechafin=date("Y-m-d H:00:00");
          //para pruebas  $this->fechafin=date($prueba." 9:00:00");
           // echo $mifecha->format('d-m-Y H:i:s');
            
        }
        else if($ahora>=$lascuatro){
           
            $this->fechaini=date("Y-m-d 9:00:00");
         //para pruebas  $this->fechaini=date($prueba." 9:00:00");
           
            $this->fechafin=$mifecha->format('Y-m-d 16:00:00');
        }
        
    }
    
    public function definirHorasprueba(){
        $mifecha = new DateTime();
        $prueba="2021-02-25";
        $mifecha = new DateTime("2021-09-17 16:00:00");
        
        $ahora=strtotime(date("Y-m-d H:00:00"));
        $hora=strtotime(date("H:i:s"));
        $lasnueve=strtotime(date("Y-m-d 9:00:00"));
        $lascuatro=strtotime(date("Y-m-d 16:00:00"));
        
    $ahora=strtotime(date($prueba." 16:00:00"));
        
         $lasnueve=strtotime(date($prueba." 9:00:00"));
        $lascuatro=strtotime(date($prueba." 16:00:00"));
        
        //  echo $ahora;
        //  echo "<br>".$hora;
        //  echo "<br>".$lasnueve;
        //  echo "<br>".$lascuatro;
        //  echo "***".$mifecha->format('d-m-Y H:i:s');
        if($ahora>=$lasnueve&&$ahora<$lascuatro){
            $mifecha->modify('-17 hours');
            $this->fechaini=$mifecha->format('Y-m-d H:00:00');
            $this->fechafin=date("Y-m-d H:00:00");
           $this->fechafin=date($prueba." 9:00:00");
            // echo $mifecha->format('d-m-Y H:i:s');
            
        }
        else if($ahora>=$lascuatro){
            
            $this->fechaini=date("Y-m-d 9:00:00");
             $this->fechaini=date($prueba." 9:00:00");
            
            $this->fechafin=$mifecha->format('Y-m-d 16:00:00');
        }
        
    }
    
    
    
    public function consultarReportesxFinalizados(){
        /*********filtrar por fecha y hora ***/
        
       $this->definirHoras();
      // $this->definirHorasprueba();
        $parametros=array("servicio"=>$this->sv);
        $sql_sol="SELECT   `ins_generales`.`i_numreporte`
            
        , `ins_generales`.`i_claveservicio`
        , `ins_generales`.`i_finalizado`
        , `ins_generales`.`i_fechafinalizado`
        , `ca_unegocios`.`cue_clavecuenta`
        , `ca_unegocios`.`une_descripcion`,une_idcuenta, une_num_unico_distintivo,
        
    COUNT(i_numreporte) AS total, IF(`mue_fechoranalisisFQ`
        < `mue_fechoranalisisMB`,mue_fechoranalisisMB,mue_fechoranalisisFQ) AS fechaemi
    FROM  ins_generales
        INNER JOIN `ins_detalleestandar` ON `ide_claveservicio`=i_claveservicio AND `ide_numreporte`=i_numreporte
        AND `ide_numseccion`=5 AND `ide_numreactivo`=0 AND `ide_numcomponente`=2 AND  (`ide_numcaracteristica3`=1 OR `ide_numcaracteristica3`=17)
            
          INNER JOIN ca_unegocios
          ON `i_unenumpunto`=`une_id`";
       
          
            $sql_sol=$sql_sol."
      INNER JOIN aa_muestras ON mue_numreporte=i_numreporte AND mue_claveservicio=i_claveservicio
    WHERE (ins_generales.i_finalizado=1 OR ins_generales.i_finalizado=-1)
 AND i_claveservicio=:servicio
    GROUP BY ide_numreporte 
 HAVING total>1 AND fechaemi>=:fechaini and fechaemi<:fechafin   
ORDER BY fechaemi DESC;";
        
        $parametros["fechaini"]=$this->fechaini;
        $parametros["fechafin"]=$this->fechafin;
        $rs_sql_sol = $this->bd->ejecutarQuery($sql_sol,$parametros);
        //var_dump($parametros);
        foreach ($parametros as $value) {
            Utilerias::guardarError("correoAlertaController: params".$value);
        }
        echo "correoAlertaController: Sql= ".$sql_sol." parametros=".$parametros["fechaini"]."-".$parametros["fechafin"]."sv-".$parametros["servicio"];
        
        Utilerias::guardarError("correoAlertaController: Sql= ".$sql_sol." parametros=".$parametros["fechaini"]."-".$parametros["fechafin"]."sv-".$parametros["servicio"]);
        return $rs_sql_sol;
    }
    
    
    public function listarReportesCriticos(){
        $contl=1;
        $rs_sql_sol=$this->consultarReportesxFinalizados();
        $contl=1;
       
           
        Utilerias::guardarError("correoAlertaController: tamaño lista fin ".sizeof($rs_sql_sol));
        //para cada reporte
        foreach($rs_sql_sol as $row_rs_sql_sol ) {
            
            $reportes=array();
            
             $reportes[ 'Nrep']=  $row_rs_sql_sol ["i_numreporte"]  ;
         
            
            //busco el dictamen en la seccion 5
            $ssql="SELECT  r_numreactivo ,ins_detalle.id_claveservicio, ins_detalle.id_numreporte,
     ins_detalle.id_numseccion, ins_detalle.id_numreactivo, ins_detalle.id_aceptado,
    ins_detalle.id_noaplica, r.r_descripcionesp from
    (  SELECT
       *
    FROM
        `cue_reactivos`
        WHERE ser_claveservicio =:servicio AND 
        sec_numseccion =  '4' AND
     r_numreactivo IN(3,7,22,23)) AS r
        LEFT  JOIN `ins_detalle`
            ON (r.`ser_claveservicio` = `ins_detalle`.`id_claveservicio`)
            AND (r.`sec_numseccion` = `ins_detalle`.`id_numseccion`)
            AND (r.`r_numreactivo` = `ins_detalle`.`id_numreactivo`) 

AND  id_noaplica<>-1 AND 
    id_aceptado<>-1 AND ins_detalle.id_numreporte =:numrep
                
     GROUP BY     r.`ser_claveservicio`
        ,r.`sec_numseccion`,r_numreactivo
    ORDER BY r_numreactivo
    ";
           
            $rs=$this->bd->ejecutarQuery($ssql,array("servicio"=>$this->sv,"numrep"=> $reportes[ 'Nrep']));
            
            $resas="";
            $condi=$noap=0; //variables para saber si el dictamen es condicionado o no aceptado
            $certificacionController=new CertificacionController();
            foreach($rs as $row) {
                //  	echo "<br>--".$row["id_aceptado"]."---".$row["id_noaplica"];
                
                if ($row["id_noaplica"]==-1){
                    $condi=1; //sera condicionado
                    
                }else
                    if ($row["id_aceptado"]==-1)
                    { $resas="APROBADO"; //sera aprobado
                    
                }else{
                    $noap=1;  //con un no aceptado el dictamen es no
                    break;
                    
                    
                }
                
            }
            $res=DatosEst::cumplimientoSeccion($this->sv,"5.0.2",$reportes[ 'Nrep']);
            if($res!="")
            {//	throw new Exception("No hay información suficiente para generar el certificado, verifique el reporte");
                $tache5=$res;
            }
            
            //	echo "<br>".$reportes[ 'Nrep']."---".$noap."---".$condi."--".$tache5;
            if ($noap||$tache5=="tache") {
                $resas="NO APROBADO";
                $reportes["tipoalerta"]=$certificacionController->tipoAlerta($this->sv, $reportes[ 'Nrep']);
            }else{
                
                if ($condi&&$tache5=="palomita"){
                    $resas="CONDICIONADO";
                    $reportes["tipoalerta"]="MODERADO";
                    
                    
                }else
                {$resas="APROBADO"; //ni es alerta
                continue;
                }
            }
            
            //busco el tipo de alerta
            if($reportes["tipoalerta"]=="MODERADO")//solo quiero ver criticos
            {	continue;
            
            
            }
          
            
            $reportes[ 'resul']=  $resas;
            
            
          
            // $html->asignar('impres',"<td width='246' class='$color' ><div align='center'><a href='javascript:imprimirCER(".$row_rs_sql_sol["sol_numrep"].");'><img src='../img/print_gold.png' alt='Imprimir' width='28' height='33' border='0' /></a></div>");
            $this->listaSolicitudes[]=$reportes;
            $contl++;
        } //finalizo de revisar cada reporte
   
       // var_dump($this->listaSolicitudes);
    }
    
    //ya que tengo los reportes pinto la alerta
    
    public function crearTablas(){
       
        $listaTablas="";
        $i=1;
        foreach ( $this->listaSolicitudes as $reporte){
           // var_dump($reporte);
          //  die($reporte["Nrep"]);
            $tabla=new TablaAlertaController($this->sv, $reporte["Nrep"]);
           /* $listaTablas.="<div>
                        <span>Alerta no. ".$i++."</span>
 ".$tabla->armarTabla()."</div>";*/
            $listaTablas.=" <tr><td style='padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;'>
        
                        <span>Alerta no. ".$i++."</span>
 ".$tabla->armarTabla()."</td></tr>";
            
              
        }
        return $listaTablas;
    }
    
    public function enviarCorreo(){
        $this->listarReportesCriticos();
        $dia=date("d");
        $mesas=date("m-Y");
        $mesletras=Utilerias::cambiaMesG($mesas);
        
        //paso la fecha a letra
        
        $fecha=$dia." de ".$mesletras;
        if($this->listaSolicitudes&&sizeof($this->listaSolicitudes)>0) //hay alertas
        {
            Utilerias::guardarError("correoAlertaController: tamaño lista solicitudes ".sizeof($this->listaSolicitudes));
            $correo=new CorreoAlertas();
            $correo->crearCorreo( $this->crearTablas(), $fecha);
            $correo->enviar();
            
             Utilerias::guardarError("correoAlertaController: Se envio el correo de alerta exitosamente");
            
            
        }
        
        
    }
    
    
    
}
    
    

