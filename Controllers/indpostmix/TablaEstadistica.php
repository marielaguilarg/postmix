<?php


class ResumenResultado {
    private $indicador;
    private $periodo;
    private $tipo_periodo;
    private $nivel;
    private $nombrenivel;
    private $totalresultados;
    private $tamano_muestra;
    private $estandar;
    private $cumplen;
    private $nocumplen;
    private $franquicia;
    private $promedio;
    private $desviacion_estandar;
    private $atributo;
    private $porcentaje_cumplen;
    private $numero_pruebas;
    private $tipo_seccion;
   
    
    function getTipo_seccion() {
        return $this->tipo_seccion;
    }

    function setTipo_seccion($tipo_seccion) {
        $this->tipo_seccion = $tipo_seccion;
    }

        function getIndicador() {
        return $this->indicador;
    }

    function getPeriodo() {
        return $this->periodo;
    }

    
    function getNivel() {
        return $this->nivel;
    }

   

    function getTamano_muestra() {
        return $this->tamano_muestra;
    }

    function getEstandar() {
        return $this->estandar;
    }

    function getCumplen() {
        return $this->cumplen;
    }

    function getNocumplen() {
        return $this->nocumplen;
    }

    function getFranquicia() {
        return $this->franquicia;
    }

    function getPromedio() {
        return $this->promedio;
    }

    function getDesviacion_estandar() {
        return $this->desviacion_estandar;
    }

    function getAtributo() {
        return $this->atributo;
    }

    function getPorcentaje_cumplen() {
        return $this->porcentaje_cumplen;
    }

    function setIndicador($indicador) {
        $this->indicador = $indicador;
    }

    function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }

    function setNivel($nivel) {
        $this->nivel = $nivel;
    }

  

    function setTamano_muestra($tamano_muestra) {
        $this->tamano_muestra = $tamano_muestra;
    }

    function setEstandar($estandar) {
        $this->estandar = $estandar;
    }

    function setCumplen($cumplen) {
        $this->cumplen = $cumplen;
    }

    function setNocumplen($nocumplen) {
        $this->nocumplen = $nocumplen;
    }

    function setFranquicia($franquicia) {
        $this->franquicia = $franquicia;
    }

    function setPromedio($promedio) {
        $this->promedio = $promedio;
    }

    function setDesviacion_estandar($desviacion_estandar) {
        $this->desviacion_estandar = $desviacion_estandar;
    }

    function setAtributo($atributo) {
        $this->atributo = $atributo;
    }

    function setPorcentaje_cumplen($porcentaje_cumplen) {
        $this->porcentaje_cumplen = $porcentaje_cumplen;
    }


    function getNombrenivel() {
        return $this->nombrenivel;
    }

    function getTotalresultados() {
        return $this->totalresultados;
    }

    function getNumero_pruebas() {
        return $this->numero_pruebas;
    }

    function getTipo_periodo() {
        return $this->tipo_periodo;
    }

    function setNombrenivel($nombrenivel) {
        $this->nombrenivel = $nombrenivel;
    }

    function setTotalresultados($totalresultados) {
        $this->totalresultados = $totalresultados;
    }

    function setNumero_pruebas($numero_pruebas) {
        $this->numero_pruebas = $numero_pruebas;
    }

    function setTipo_periodo($tipo_periodo) {
        $this->tipo_periodo = $tipo_periodo;
    }

         
    
}

class EstablecimientoCumple{
    
    private $puntoVenta;
    private $resultado;
    private $estilo;
    private $liga;
    
    function getEstilo() {
        return $this->estilo;
    }

    function getLiga() {
        return $this->liga;
    }

    function setEstilo($estilo) {
        $this->estilo = $estilo;
    }

    function setLiga($liga) {
        $this->liga = $liga;
    }

        
    function getPuntoVenta() {
        return $this->puntoVenta;
    }

    function getResultado() {
        return $this->resultado;
    }

    function setPuntoVenta($puntoVenta) {
        $this->puntoVenta = $puntoVenta;
    }

    function setResultado($resultado) {
        $this->resultado = $resultado;
    }


    
}

class ConsultaIndicadores{
    
    private  $nivel;
    private $nombre_nivel;
    private $periodo;
    private $mes_indice;
    private $franquicia;
    private $nombre_franquicia;
    private $nombre_seccion;
    private $seccion;
   
    private $resultados; //no estoy segura de esta
    
    function getNivel() {
        return $this->nivel;
    }

    function getPeriodo() {
        return $this->periodo;
    }

   

    function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }

    function getNombre_nivel() {
        return $this->nombre_nivel;
    }

    function getMes_indice() {
        return $this->mes_indice;
    }

    function setNombre_nivel($nombre_nivel) {
        $this->nombre_nivel = $nombre_nivel;
    }

    function setMes_indice($mes_indice) {
        $this->mes_indice = $mes_indice;
    }

    function getFranquicia() {
        return $this->franquicia;
    }

    function getNombre_franquicia() {
        return $this->nombre_franquicia;
    }

    function getResultados() {
        return $this->resultados;
    }

    function setFranquicia($franquicia) {
        $this->franquicia = $franquicia;
    }

    function setNombre_franquicia($nombre_franquicia) {
        $this->nombre_franquicia = $nombre_franquicia;
    }

    function setResultados($resultados) {
        $this->resultados = $resultados;
    }


    function getNombre_seccion() {
        return $this->nombre_seccion;
    }

    function getSeccion() {
        return $this->seccion;
    }

    function setNombre_seccion($nombre_seccion) {
        $this->nombre_seccion = $nombre_seccion;
    }
    

    function setSeccion($seccion) {
        $this->seccion = $seccion;
    }



    
}

class ResumenResultadoxPeriodo{
   
   
    
    private $nombrefranquicia;
    private $idfranquicia;
    private $nombrenivel;
  private $resultados1;
  private $resultados2;
  private $resultados3;
  private $estotal;
    
  
  function getNombrefranquicia() {
      return $this->nombrefranquicia;
  }

  function getIdfranquicia() {
      return $this->idfranquicia;
  }

  function getNombrenivel() {
      return $this->nombrenivel;
  }

  function getResultados1() {
      return $this->resultados1;
  }

  function getResultados2() {
      return $this->resultados2;
  }

  function getResultados3() {
      return $this->resultados3;
  }

  function setResultados1($resultados1) {
      $this->resultados1 = $resultados1;
  }

  function setResultados2($resultados2) {
      $this->resultados2 = $resultados2;
  }

  function setResultados3($resultados3) {
      $this->resultados3 = $resultados3;
  }

    function setNombrefranquicia($nombrefranquicia) {
      $this->nombrefranquicia = $nombrefranquicia;
  }

  function setIdfranquicia($idfranquicia) {
      $this->idfranquicia = $idfranquicia;
  }

  function setNombrenivel($nombrenivel) {
      $this->nombrenivel = $nombrenivel;
  }


  function Estotal() {
      return $this->estotal;
  }

  function setEstotal($estotal) {
      $this->estotal = $estotal;
  }


  
}

