<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Postmix</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="views/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="views/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="views/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="views/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="views/plugins/iCheck/square/blue.css">

 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <script src='https://www.google.com/recaptcha/api.js'></script>

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Muesmerc
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Escriba su usuario y Contrase&ntilde;a</p>

    <form  method="post">
     <?php
                $ingreso = new usuarioController();
                $ingreso ->validarUsuarioController();
                ?>   
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="logemail">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Contrase&ntilde;a" name="logpass">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
     

      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
<!--           <div class="g-recaptcha" data-sitekey="6LdZapsUAAAAAPcjkPWs8SrsV1s_EY8S73ut4jIg"></div> -->
          
    
            <label>
              <input type="checkbox"> Recordarme
            </label>
          </div>
        </div>
     </div>   
    
          

      <div class="row">
        <div class="col-xs-12">
          <div class="checkbox icheck">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
        </div>
        </div>
     </div>
        <!-- /.col -->
    
      
    </form>

    
    <!-- /.social-auth-links -->

  </div>
  <!-- /.login-box-body -->
</div>

<!-- jQuery 3 -->
<script src="views/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="views/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
