 <section class="content-header">
  <h1> EDITA CLIENTE</h1>
   
   </section>
   <section class="content container-fluid">
  <div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">EDITA CLIENTE</h3>
            </div>
            <div class="box-body">
             <form role="form" method="post">
              
                <label for="NuevoCliente" class="col-sm-2 control-label">NOMBRE DEL CLIENTE</label>
                <div class="col-sm-10">
<?php

$registro = New MvcController();
$registro-> editarClienteController();
$registro-> actualizarClienteController();
?>

                </div>
                <div class="box-footer" style="padding-top: 50px; border-bottom: hidden">
                <div class="pull-right">
                  <button type="submit" class="btn btn-info ">Guardar</button>
                <a type="submit" class="btn btn-default" style="margin-left: 10px" href="index.php?action=listacliente" >Cancelar</a>
              </div>
              </div>
               </form>
              </div>
            </div>
            <!-- /.box-body -->
          </div>

        </section>
            
