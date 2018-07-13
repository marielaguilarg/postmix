<?php

class Navegacion {
    
     private $listaSeccion;
    private $listaPeriodo;
    private $listaNivel;
    private $servicio;
    private $cliente;
    
      public function cargarFiltros($servicio, $cliente) {
        $Usuario = $_SESSION ["usuarioconsulta"];


        $arr_meses = array(strtoupper(T_("Enero")), strtoupper(T_("Febrero")), strtoupper(T_("Marzo")), strtoupper(T_("Abril")), strtoupper(T_("Mayo")), strtoupper(T_("Junio")), strtoupper(T_("Julio")), strtoupper(T_("Agosto")), strtoupper(T_("Septiembre")), strtoupper(T_("Octubre")), strtoupper(T_("Noviembre")), strtoupper(T_("Diciembre")));

        $opciones_mes = "";
        $vidiomau = $_SESSION["uidioma"];
         $this->servicio=$servicio;
        $this->cliente=$cliente;
        $grupo = $_SESSION["GrupoUs"];
        $sql_anio = "SELECT 	 
	num_per_asig	 
	FROM 
	ca_mesasignacion 
	GROUP BY num_per_asig
	ORDER BY num_per_asig";
        $rsanio = Conexion::ejecutarQuerysp($sql_anio);

        foreach ($rsanio as $rowanio) {

            $opciones_mes = '<li class="dropdown"><a href="#">' . $rowanio[0] . '</a>';
            $opciones_mes .= "<ul>";
            $cadmes = "";
            foreach ($arr_meses as $key => $value) {
                $cadmes .= '<li><a href="javascript:Cargar(\'p\',\'' . ($key + 1) . '.' . $rowanio[0] . '\');">' . $value . '</a></li>';
            }

            $opciones_mes .= $cadmes . '</ul></li>';
            $this->listaPeriodo[] = $opciones_mes;
        }




// genera secciones

        $secciones = DatosEst::buscaSeccionesIndi($this->servicio,$vidiomau);

        $secdefault = $secciones[0][0];
        foreach ($secciones as $key) {

            $this->listaSeccion[] = ' <li><a href="javascript:Cargar(\'s\',\'' . $key[0] . '\');">' . $key[1] . '</a></li>';
        }

        /*         * * menu para elegir nivel ** */
        /*         * **************************************************** */


        if ($grupo == 'adm' || $grupo == 'mue' || $grupo == 'aud') {   //nivel uno por default
            $GradoNivel = $VarNivel2 = 1;
            $Nivel01 = 1;
            $Nivel02 = 1;
        } else {

            $rs_usuarios = UsuarioModel::getUsuario($Usuario, "cnfg_usuarios");


            foreach ($rs_usuarios as $row_usuarios) {
//            $html->asignar('USUARIO', "<span class='TitPost'>" . $row_usuarios ["cus_nombreusuario"] . "</span>");
                $GradoNivel = $row_usuarios ["cus_tipoconsulta"];
                $grupo = $row_usuarios ["cus_clavegrupo"];
                $Nivel01 = $row_usuarios ["cus_nivel1"];
                $Nivel02 = $row_usuarios ["cus_nivel2"];
//                    echo "niv".$Nivel02;
                $Nivel03 = $row_usuarios ["cus_nivel3"];
                $Nivel04 = $row_usuarios ["cus_nivel4"];
                $Nivel05 = $row_usuarios ["cus_nivel5"];
                $Nivel06 = $row_usuarios ["cus_nivel6"];
                $uscliente = $row_usuarios ["cus_cliente"];
                $usservicio = $row_usuarios ["cus_servicio"];
                $uscliente = 100;
                $usservicio = 1;
                $Nivel01 = 1;
            }
        }

        $VarNivel2 = $GradoNivel;

        if ($grupo != "cue") {

            if ($VarNivel2 == 1) {

                $cadlista0 = buscaniv2($Nivel01);
                $this->listaNivel = $cadlista0;
            }
            if ($VarNivel2 == 2) {

                $cadlista0 = buscaniv3($Nivel01, $Nivel02);

                $this->listaNivel = $cadlista0;
            }

            if ($VarNivel2 == 3) {


                $cadlista = buscaniv4($Nivel01, $Nivel02, $Nivel03, '');
                $this->listaNivel = $cadlista;
            }

            if ($VarNivel2 == 4) {
                if ($grupo == "muf") {
                    $cadlista = buscaniv4($Nivel01, $Nivel02, $Nivel03, $Nivel04);
                    $this->listaNivel = $cadlista;
                } else {
                    $cadlistaniv5 = buscaniv5($Nivel01, $Nivel02, $Nivel03, $Nivel04);
                    $this->listaNivel = $cadlistaniv5;
                }
            }

            if ($VarNivel2 == 5) {
                $cadlistaniv6 = buscaniv6($Nivel01, $Nivel02, $Nivel03, $Nivel04, $Nivel05);
                $this->listaNivel = $cadlistaniv6;
            }
            if ($VarNivel2 == 6) {
                /* quito la opcion en el menu */
                $this->listaNivel = '';
            }
        }
    }

   
function borrarRutaActual($indice){ 
  $pilanav=$_SESSION["histonav"] ; //pila de navegacion
//  echo "antes";
//  print_r($pilanav);
  if(is_array($pilanav))
  { $rpila=array_reverse($pilanav); //pila de reversa
  foreach($rpila as $key=>$ruta)
  { if(key($rpila)>=$indice)
      //lo borro
      unset($rpila[$key]);
  }
  //actualizo pila
  $_SESSION["histonav"]=array_reverse($rpila);  
  }
}

function agregarRuta($indice, $ruta, $descripcion){
    $pilanav=$_SESSION["histonav"] ; //pila de navegacion
    //busco ultima posicion
    if(is_array($pilanav))
        $ultimo=end($pilanav);
    //reviso que haya algo
    if($ultimo!=false)
    {   $ultpos=$ultimo["pos"]+1;
    }
    else
    {// es el primero
        $ultpos=0;
    }
    //agrego ruta
    $pilanav[$indice]=array("pos"=>$ultpos,"ruta"=>$ruta,"desc"=>$descripcion);
     $_SESSION["histonav"]=$pilanav;
    
}

function  desplegarNavegacion(){
    
    $navegacion=""    ;
    $pilanav=$_SESSION["histonav"] ; 
    $contzindex=9;
    foreach ($pilanav as $historial){
         
         $navegacion.='<li><a href="'.$historial["ruta"].'" style="z-index:'.($contzindex--).';">'.($historial["desc"]).'</a></li>';

     }
     return $navegacion;
    
    
    
    
}


   
    function buscaniv6($Nivel01, $Nivel02, $Nivel03, $Nivel04, $Nivel05) {


        $RS_SQM_TE5 = Datosnsei::vistanseiModel($Nivel05, "ca_nivel6");
        $cadlistaniv6 = "";
        foreach ($RS_SQM_TE5 as $registro5) {
            $cadlistaniv6 .= ' <li><a href="javascript:Cargar(\'u\',\'' . $Nivel04 . '.' . $Nivel05 . '.' . $registro5 [0] . '\',\'7\',\'' . $Nivel01 . '.' . $Nivel02 . '.' . $Nivel03 . '\');">' . $registro5 [1] . '</a></li>';
        }//fin niv 6

        $registro5 = null;
        return $cadlistaniv6;
    }

    function buscaniv5($Nivel01, $Nivel02, $Nivel03, $Nivel04) {
        $SQL_TEM4 = "SELECT ciu_clave, ciu_nombre
                                     FROM ca_ciudades
                                    WHERE reg_clave='" . $Nivel01 . "' 
                                      AND pais_clave ='" . $Nivel02 . "' 
                                      AND zona_clave='" . $Nivel03 . "' 
                                      AND est_clave='" . $Nivel04 . "'";
        $RS_SQM_TE4 = Datosncin::vistancinModel($Nivel04, "ca_nivel5");

        $cadlistaniv5 = "";
        foreach ($RS_SQM_TE4 as $registro4) {

            $cadlistaniv5 .= ' <li class="dropdown"><a href="javascript:Cargar(\'u\',\'' . $Nivel04 . '.' . $registro4 [0] . '\',\'6\',\'' . $Nivel01 . '.' . $Nivel02 . '.' . $Nivel03 . '\');">' . $registro4 [1] . '</a>';
            $cadlistaniv5 .= '<ul>';


            $cadlistaniv6 = $this->buscaniv6($Nivel01, $Nivel02, $Nivel03, $Nivel04, $registro4 [0]);
            $cadlistaniv5 .= $cadlistaniv6 . '</ul></li>';
        }//fin niv 5

        $registro4 = null;
        $SQL_TEM4 = null;

        return $cadlistaniv5;
    }

    function buscaniv4($Nivel01, $Nivel02, $Nivel03, $Nivel04) {

        if ($Nivel04) {
            $RS_SQM_TE = Datosncua::getNcua($Nivel04);
        } else {

            $RS_SQM_TE = Datosncua::vistancuaModel($Nivel03, "ca_nivel4");
        }

        $cadlista = "";
        foreach ($RS_SQM_TE as $registro) {
            $Nivel04 = $registro [0];
            $cadlista .= ' <li class="dropdown"> <a href="javascript:Cargar(\'u\',\'' . $registro [0] . '.\',\'5\',\'' . $Nivel01 . '.' . $Nivel02 . '.' . $Nivel03 . '\');">' . $registro [1] . '</a>';
            $cadlista .= '<ul>';
            $cadlistaniv5 = $this->buscaniv5($Nivel01, $Nivel02, $Nivel03, $Nivel04);


            $cadlista .= $cadlistaniv5 . '</ul></li>';
        }//fin niv4

        return $cadlista;
    }

    function buscaniv3($Nivel01, $Nivel02) {


        $RS_SQM_TE = Datosntres::vistantresModel($Nivel02, "ca_nivel3");
        $cadlista = "";
        foreach ($RS_SQM_TE as $registro) {

            $cadlista .= ' <li class="dropdown"> <a href="javascript:Cargar(\'u\',\'\',\'4\',\'' . $Nivel01 . '.' . $Nivel02 . '.' . $registro [0] . '\');">' . $registro [1] . '</a>';
            $cadlista .= '<ul>';
            $cadlistaniv5 = $this->buscaniv4($Nivel01, $Nivel02, $registro [0], '');


            $cadlista .= $cadlistaniv5 . '</ul></li>';
        }//fin niv4

        return $cadlista;
    }

    function buscaniv2($Nivel01) {

        $RS_SQM_TE = Datosndos::vistanDosModel($Nivel01, "ca_nivel2");
        $cadlista = "";
        foreach ($RS_SQM_TE as $registro ) {

            $cadlista .= ' <li class="dropdown"> <a href="javascript:Cargar(\'u\',\'\',\'3\',\'' . $Nivel01 . '.' . $registro [0] . '\');">' . $registro [1] . '</a>';
            $cadlista .= '<ul>';
            $cadlistaniv5 = $this->buscaniv3($Nivel01, $registro[0]);


            $cadlista .= $cadlistaniv5 . '</ul></li>';
        }//fin niv4

        return $cadlista;
    }

 
}
