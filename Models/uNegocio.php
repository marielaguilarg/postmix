
<?php

class Unegocio {
   private $franquicia;
   private $ciudad;
   private $puntoVenta;
   
   function getFranquicia() {
       return $this->franquicia;
   }

   function getCiudad() {
       return $this->ciudad;
   }

   function getPuntoVenta() {
       return $this->puntoVenta;
   }

   function setFranquicia($franquicia) {
       $this->franquicia = $franquicia;
   }

   function setCiudad($ciudad) {
       $this->ciudad = $ciudad;
   }

   function setPuntoVenta($puntoVenta) {
       $this->puntoVenta = $puntoVenta;
   }


   
   
}
