<?php

class TablaAlertaController{
    
    public $servicio;
    public $numrep;
    public $infoGeneral;
    
    public function __construct($servicio, $numrep){
        $this->servicio=$servicio;
        $this->numrep=$numrep;
    }
    
    public function buscarDescripcion(){
        $ssql="SELECT  ca_unegocios.cue_clavecuenta, ca_unegocios.une_id, ca_unegocios.une_descripcion,
ca_unegocios.une_idpepsi, ca_unegocios.une_idcuenta, ca_unegocios.une_dir_calle, ca_unegocios.une_dir_numeroext,
ca_unegocios.une_dir_numeroint, ca_unegocios.une_dir_manzana, ca_unegocios.une_dir_lote, ca_unegocios.une_dir_colonia,
ca_unegocios.une_dir_delegacion, ca_unegocios.une_dir_municipio, ca_unegocios.une_dir_estado, ca_unegocios.une_dir_cp,
ca_unegocios.une_dir_referencia, ca_unegocios.une_dir_telefono, ins_generales.i_fechavisita, ins_generales.i_mesasignacion,
ins_generales.i_horaentradavis, ins_generales.i_horasalidavis, ins_generales.i_responsablevis, ins_generales.i_puestoresponsablevis,
ins_generales.i_numreporte,  ins_generales.i_fechafinalizado, ca_inspectores.ins_nombre,
 IF(`mue_fechoranalisisFQ`
    < `mue_fechoranalisisMB`,mue_fechoranalisisMB,mue_fechoranalisisFQ) as fechaemi,
`une_dir_telefono`,`une_dir_telefono2`,`une_dir_correoe`,i_responsablevis,
 ca_nivel5.n5_nombre,ca_nivel4.n4_nombre ,une_num_unico_distintivo
 FROM ca_unegocios
Inner Join ins_generales ON  ins_generales.i_unenumpunto = ca_unegocios.une_id
Inner Join ca_inspectores ON ins_generales.i_claveinspector = ca_inspectores.ins_clave
inner join aa_muestras on mue_numreporte=i_numreporte and mue_claveservicio=i_claveservicio
INNER JOIN ca_nivel5 ON  ca_nivel5.n5_id=ca_unegocios.une_cla_ciudad 
 INNER JOIN ca_nivel4 ON  ca_nivel4.n4_id=`une_cla_estado`
WHERE ins_generales.i_claveservicio =  ".$this->servicio." AND ins_generales.i_numreporte = :numrep";
        
        $rs=Conexion::ejecutarQuery($ssql,array("numrep"=>$this->numrep));
        return $rs;
    }
    
    public function buscarResultados(){
        $ssql4="SELECT ins_detalleestandar.ide_claveservicio, ins_detalleestandar.ide_numreporte, ins_detalleestandar.ide_numseccion,
ins_detalleestandar.ide_valorreal, ins_detalleestandar.ide_idmuestra, cue_reactivosestandardetalle.red_estandar,
 cue_reactivosestandardetalle.red_parametroesp, ins_detalleestandar.ide_numcaracteristica3,cue_reactivosestandardetalle.red_clavecatalogo,
 cue_reactivosestandardetalle.red_tipodato, ins_detalleestandar.ide_aceptado FROM ins_detalleestandar
Inner Join cue_reactivosestandardetalle ON cue_reactivosestandardetalle.ser_claveservicio = ins_detalleestandar.ide_claveservicio
AND cue_reactivosestandardetalle.sec_numseccion = ins_detalleestandar.ide_numseccion AND cue_reactivosestandardetalle.r_numreactivo = ins_detalleestandar.ide_numreactivo
 AND cue_reactivosestandardetalle.re_numcomponente = ins_detalleestandar.ide_numcomponente
AND cue_reactivosestandardetalle.re_numcaracteristica = ins_detalleestandar.ide_numcaracteristica1
AND cue_reactivosestandardetalle.re_numcomponente2 = ins_detalleestandar.ide_numcaracteristica2 AND cue_reactivosestandardetalle.red_numcaracteristica2 = ins_detalleestandar.ide_numcaracteristica3
Inner Join cue_secciones ON cue_secciones.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio
AND cue_secciones.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion
 WHERE
ins_detalleestandar.ide_claveservicio = ".$this->servicio." AND ins_detalleestandar.ide_numreporte =:numrep AND
cue_secciones.sec_indagua =  '1' AND ins_detalleestandar.ide_numrenglon =  '1'
and (ins_detalleestandar.ide_numcaracteristica3<>14 and ins_detalleestandar.ide_numcaracteristica3<>20
and ins_detalleestandar.ide_numcaracteristica3<>21 and ins_detalleestandar.ide_numcaracteristica3<>15)
ORDER BY if(ins_detalleestandar.ide_numcaracteristica3=2,1, if(ins_detalleestandar.ide_numcaracteristica3=1,2,
if(ins_detalleestandar.ide_numcaracteristica3=12,7,  if(ins_detalleestandar.ide_numcaracteristica3=4,11,
if(ins_detalleestandar.ide_numcaracteristica3=5,5,  if(ins_detalleestandar.ide_numcaracteristica3=9,4,
if(ins_detalleestandar.ide_numcaracteristica3=6,6, if(ins_detalleestandar.ide_numcaracteristica3=13,8,
 if(ins_detalleestandar.ide_numcaracteristica3=19,10, ins_detalleestandar.ide_numcaracteristica3))))))))) ASC";
        $rs4=Conexion::ejecutarQuery($ssql4,array("numrep"=>$this->numrep));
        return $rs4;
    }
    public function llenarResultados(){
        $parametro=$parametros="";
        // pongo fisicoquimicos
        for ($x=1; $x<12; $x++){
            $parametro=$parametro.$this->buscarResultado($x);
            
            
        }
        $parametros=substr($parametro,0,strlen($parametro)-2);
        $this->infoGeneral->resultados["fq"]=$parametros;
        $parametro=$parametros="";
        for ($x=12; $x<14; $x++){
            $parametro=$parametro.$this->buscarResultado($x);
            
            
        }
        $parametros=substr($parametro,0,strlen($parametro)-2);
        $this->infoGeneral->resultados["mb"]=$parametros;
        
    }
    
      
            public function buscarResultado($x){
               
                switch($x) {
                    case '1':
                        $concepto="OLOR";
                        $standar="SIN OLOR";
                        $numop=2;
                        break;
                    case '2':
                        $concepto="SABOR";
                        $standar="SIN SABOR EXTRANO";
                        $numop=1;
                        break;
                    case '3':
                        $concepto="COLOR";
                        $standar="SIN COLOR";
                        $numop=3;
                        break;
                    case '4':
                        $concepto="SOLIDOS DISUELTOS TOTALES";
                        $standar="<=750 mg/L";
                        $numop=9;
                        break;
                    case '5':
                        $concepto="ALCALINIDAD";
                        $standar="<=175 mg/L CaCO3";
                        $numop=5;
                        break;
                    case '6':
                        $concepto="DUREZA";
                        $standar="<=225 mg/L CaCO3 ";
                        $numop=6;
                        break;
                    case '7':
                        $concepto="HIERRO";
                        $standar="<=0.1 mg/L";
                        $numop=12;
                        break;
                    case '8':
                        $concepto="MANGANESO";
                        $standar="<=0.05 mg/L ";
                        $numop=13;
                        break;
                    case '9':
                        $concepto="CLORO TOTAL";
                        $standar="<=0.5 mg/L";
                        $numop=8;
                        break;
                    case '10':
                        $concepto="TURBIDEZ";
                        $standar="<=1 NTU ";
                        $numop=19;
                        break;
                    case '11':
                        $concepto="PH";
                        $standar="6.5 - 8.5 ";
                        $numop=4;
                        break;
                    case '12':
                        $concepto="COLIFORMES TOTALES";
                        $standar="0 UFC/100ml ";
                        $numop=17;
                        break;
                    case '13':
                        $concepto="E COLI";
                        $standar="0 UFC/100ml ";
                        $numop=18;
                        break;
                }
                
                
                
                
                
                $sql5="SELECT ins_detalleestandar.ide_valorreal,  ins_detalleestandar.ide_numcaracteristica3,
cue_reactivosestandardetalle.red_clavecatalogo, cue_reactivosestandardetalle.red_tipodato,
 ins_detalleestandar.ide_aceptado
FROM ins_detalleestandar Inner Join cue_reactivosestandardetalle ON cue_reactivosestandardetalle.ser_claveservicio = ins_detalleestandar.ide_claveservicio
 AND cue_reactivosestandardetalle.sec_numseccion = ins_detalleestandar.ide_numseccion
AND cue_reactivosestandardetalle.r_numreactivo = ins_detalleestandar.ide_numreactivo AND cue_reactivosestandardetalle.re_numcomponente = ins_detalleestandar.ide_numcomponente
AND cue_reactivosestandardetalle.re_numcaracteristica = ins_detalleestandar.ide_numcaracteristica1 AND cue_reactivosestandardetalle.re_numcomponente2 = ins_detalleestandar.ide_numcaracteristica2
AND cue_reactivosestandardetalle.red_numcaracteristica2 = ins_detalleestandar.ide_numcaracteristica3
Inner Join cue_secciones ON cue_secciones.ser_claveservicio = cue_reactivosestandardetalle.ser_claveservicio AND cue_secciones.sec_numseccion = cue_reactivosestandardetalle.sec_numseccion
WHERE  ins_detalleestandar.ide_claveservicio =  ".$this->servicio." AND ins_detalleestandar.ide_numreporte =:numrep AND
cue_secciones.sec_indagua =  '1' AND ins_detalleestandar.ide_numrenglon =  '1'
and ins_detalleestandar.ide_numcaracteristica3=$numop";
                $rs5=Conexion::ejecutarQuery($sql5,array("numrep"=>$this->numrep));
                $num_reg = sizeof($rs5);
                $parametro="";
                if ($num_reg>0){
                    foreach($rs5 as $row5) {
                        
                        if ($row5["ide_aceptado"]!=-1) {
                            $parametro=$concepto.", ";
                        }
                    }
                    //corto la coma
                  
                }
                return $parametro;
            }
          
                  
    
    
    public function armarTabla(){
        
        $rs=$this->buscarDescripcion();
        $this->infoGeneral=new InfoGeneral();
        //echo $treg;
        foreach($rs as $row) {
            
        
            $this->infoGeneral->pv=$row["une_descripcion"];
            
            
           $this->infoGeneral->direccion=$row["une_dir_calle"]." No. ".$row["une_dir_numeroext"]. " COLONIA ".$row["une_dir_colonia"].
                                        " ".$row["une_dir_cp"];
           $this->infoGeneral->ciudad=$row["une_dir_municipio"];
           $this->infoGeneral->encargado=$row["i_responsablevis"];
            
           $this->infoGeneral->telefono=$row["une_dir_telefono"]." ".$row["une_dir_telefono2"];
           $this->infoGeneral->region=$row["n4_nombre"];
           $this->infoGeneral->nud=$row["une_num_unico_distintivo"];
           $this->infoGeneral->cargo=$row["i_puestoresponsablevis"];
           $this->infoGeneral->estado=$row["n5_nombre"];
                     
         }
         $this->llenarResultados();
       //  $num_reg = sizeof($rs4);
         //if ($num_reg>0){
             // condiciones de la muestra
             //     		$pdf->Image('img/palomita.png' , 64 ,25, 5 , 5,'PNG');
             //     	//	$pdf->Image('img/palomita.png' , 49 ,46, 5 , 5,'PNG');
             //     		$pdf->Image('img/palomita.png' , 115 ,25, 5 , 5,'PNG');
         /***busco resultados  E0E8F5**/
         $tabla='
                    
                    <table class="tablaDatos" style="width:100%;">
                        <thead class="titulo1">
<tr><th colspan="6">INFORMACION GENERAL DEL ESTABLECIMIENTO</th></tr></thead>
                        
                            <tbody >
                            <tr><td class="titulo2" >NUD</td>
                            <td style="width:18%">'. $this->infoGeneral->nud.'</td>
                            <td class="titulo2">PUNTO DE VENTA</td>
                            <td colspan="3">'. $this->infoGeneral->pv.'</td>
                            </tr>
                            <tr>
                            <td class="titulo2">DOMICILIO</td>
                            <td colspan="3">'. $this->infoGeneral->direccion.'</td>
                            <td class="titulo2">ESTADO</td>
                           
                            <td>'. $this->infoGeneral->estado.'</td>
                            <tr><td class="titulo2">CIUDAD</td>
                            <td>'. $this->infoGeneral->ciudad.'</td>
                            <td class="titulo2">REGION</td>
                            <td>'. $this->infoGeneral->region.'</td>
                            <td class="titulo2">ENCARGADO</td>
                            <td>'. $this->infoGeneral->encargado.'</td></tr>
                            <tr>
                            <td class="titulo2">CARGO</td>
                            <td>'. $this->infoGeneral->cargo.'</td>
                            <td class="titulo2">TEL. DE CONTACTO</td>
                            <td colspan="3">'. $this->infoGeneral->telefono.'</td>
                            </tr>
                            <tr><td colspan="6" class="titulo1" >ALERTA DE CALIDAD DE AGUA</td>';
         if( $this->infoGeneral->resultados["fq"]!=''){
             $tabla.='<tr>
 <td class="titulo2">DESVIACION</td>
                        <td>FISICOQUIMICA</td>
 <td class="titulo2">PARAMETRO(S)</td>
                        <td colspan="3">'.$this->infoGeneral->resultados["fq"].'</td>
                      </tr>';
         }
         if( $this->infoGeneral->resultados["mb"]!=''){
             $tabla.='<tr>
<td class="titulo2">DESVIACION</td>
                        <td>MICROBIOLOGICA</td>
 <td class="titulo2">PARAMETRO(S)</td>
                        <td colspan="3">'.$this->infoGeneral->resultados["mb"].'</td>
                      </tr>';
         }
            
         $tabla.='  </tr>
                                        
                        </tbody>
                    </table>
                    '    ;
         return $tabla;
         
    }
 
}
    
    class InfoGeneral{
        public $nud;
        public $pv;
        public $domicilio;
        public $ciudad;
        public $region;
        public $cargo;
        public $telefono;
        public $estado;
        public $encargado;
        public $resultados;
        
    }

