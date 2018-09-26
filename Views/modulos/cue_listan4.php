<section class="content-header">
<h1>Nivel 4 &nbsp; &nbsp;</h1>
<ol class="breadcrumb" >
        <li><a href="index.php?action=listan1"><em class="fa fa-dashboard"></em> Nivel 1</a></li>
      <?php

      $vista = new NcuaController();
      $vista -> asignavar();

?>

       
</ol>
</section>

<section class="content container-fluid">
 <div class="box-body no-padding">
              <table class="table">
                <tr>
                  <th style="width: 20%">No.</th>
                 
                  <th style="width: 56%">NOMBRE</th>
                  <th style="width: 56%">DETALLE</th>
                </tr>
              
<?php

$ingreso = new NcuaController();
$ingreso -> vistancuaController();

?>

               </table>
            </div>
            <!-- /.box-body -->
           
          </div>
          <!-- /.box -->
        </div>
        </div>


</section>
