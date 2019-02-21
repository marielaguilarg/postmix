 <!-- Content Wrapper. Contains page content -->
  
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>CUENTAS &nbsp; &nbsp; <small></small></h1>
      
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

          
<?php

$ingreso = new cuentaController();
$ingreso -> borrarCuentaController();
$ingreso -> vistaCuentasController();



?>

  <!-- /.content-wrapper -->
  </section>