<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Muesmerc | POSTMIX</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="views/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="views/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="views/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="views/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
<script src="views/dist/js/jquery-3.0.0.min.js"></script>

  <link rel="stylesheet" href="views/dist/css/skins/skin-blue.min.css">

<link rel="stylesheet" href="views/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="views/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="views/plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="views/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="views/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="views/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="views/dist/css/skins/_all-skins.min.css">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Post</b>MIX</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Post</b>MIX</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
          <!-- /.messages-menu -->

          <!-- Notifications Menu -->
          
          <!-- Tasks Menu -->
         
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="views/dist/img/User-Icon.jpg" class="user-image" >
              <span class="hidden-xs">
              <?php
              $datini=UsuarioController::Obten_NomUsuario();
                echo $datini;               
                 ?> 

              </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="views/dist/img/User-Icon.jpg" class="img-circle" alt="User Image">

                <p>
                <?php
                  $datini=UsuarioController::Obten_NomUsuario();
                  echo $datini;

                  $cargo=UsuarioController::Obten_Cargo();
                  echo "<small>".$cargo."</small>";               
                 ?>
                  
                  
                </p>
              </li>
              
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <!--<a href="#" class="btn btn-default btn-flat">Profile</a>-->
                </div>
                <div class="pull-right">
                  <a href=index.php?salir=1 class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
            
          
         
          <!-- Control Sidebar Toggle Button -->

        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
 <!--- menu lateral -->

<?php
   include "modulos/enlaces.php"
?>
<!--- fin menu lateral --->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
         </section>

  <?php

  $mvc= new MvcController();
  $mvc-> enlacesPaginasController();
  
  ?>
    <!-- Main content -->
    <section class="content container-fluid">

      <!----- Inicia contenido ----->
        


    <!----- Finaliza contenido ----->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">&nbsp;</div>
    <!-- Default to the left --><strong>Copyright &copy; 2018 Muesmerc S.A. de C.V.</strong> Todos los derechos reservados. </footer>

 
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->


<!-- Bootstrap 3.3.7 -->
<script src="views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="views/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- AdminLTE App -->
<script src="views/plugins/input-mask/jquery.inputmask.js"></script>
<script src="views/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="views/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="views/dist/js/adminlte.min.js"></script>

<script src="views/bower_components/moment/min/moment.min.js"></script>
<script src="views/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="views/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="views/dist/js/demo.js"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()
      //Date picker
    //$('#datepicker').datepicker({
    //  autoclose: true
   // })

    $('#datepicker2').datepicker({
      autoclose: true
    })

   $('#datepicker').datepicker({
       autoclose: true,
       dateformat: 'mm/dd/yyyy' 
   });


   
  })
</script>



</body>
</html>
