<?php

require_once "Controllers/controller.php";
require_once "Controllers/cuentacontroller.php";
require_once "Controllers/servicioController.php";
require_once "Controllers/franquiciaController.php";
require_once "Controllers/seccionController.php";
require_once "Controllers/unegocioController.php";
require_once "Controllers/n1Controller.php";
require_once "Controllers/n2Controller.php";
require_once "Controllers/n3Controller.php";
require_once "Controllers/n4Controller.php";
require_once "Controllers/n5Controller.php";
require_once "Controllers/n6Controller.php";
require_once "Controllers/subnivelController.php";
require_once "Controllers/ponderacionController.php";
require_once "Controllers/estandarController.php";
require_once "Controllers/abiertaController.php";
require_once "Controllers/generalController.php";
require_once "Controllers/productoController.php";
require_once "Controllers/enlacesController.php";
require_once "Controllers/usuarioController.php";
require_once "Controllers/ReporteController.php";

require_once "Models/model.php";
require_once "Models/crud_clientes.php";
require_once "Models/crud_servicios.php";
require_once "Models/crud_cuentas.php";
require_once "Models/crud_franquicias.php";
require_once "Models/crud_secciones.php";
require_once "Models/crud_unegocios.php";
require_once "Models/crud_estructura.php";
require_once "Models/crud_n1.php";
require_once "Models/crud_n2.php";
require_once "Models/crud_n3.php";
require_once "Models/crud_n4.php";
require_once "Models/crud_n5.php";
require_once "Models/crud_n6.php";
require_once "Models/crud_ponderacion.php";
require_once "Models/crud_estandar.php";
require_once "Models/crud_abierta.php";
require_once "Models/crud_subnivel.php";
require_once "Models/crud_generales.php";
require_once "Models/crud_productos.php";
require_once "Models/crud_usuario.php";
require_once "Models/crud_solicitudes.php";
require_once "Models/crud_reporte.php";
require_once "Models/crud_catalogos.php";
require_once "Models/crud_inspectores.php";
require_once "Models/crud_mesasignacion.php";

if (isset($_GET["salir"])) {
	$nuevo =new UsuarioController();
	$nuevo->Destruye_Sesion();
}


$mvc =new MvcController();
session_start();
if (isset($_SESSION['Usuario'])) {
	$mvc -> plantilla();
} else {
	
	$mvc -> inicio();
}




?>