
<script type="text/javascript">

    function Activar()
    {
        document.getElementById("subbutton").disabled = false;
    }
    function cargando(form) {
        if (document.getElementById("userfile").value.length || document.getElementById("archsql").value.length)
        {
            document.getElementById("form1").style.display = 'none';
            document.getElementById("form2").style.display = 'none';
            document.getElementById('loading').style.display = 'inline';

        }

    }


</script>
<?php
require 'Controllers/importadorUneAsigController.php';

$importadorController = new ImportadorUneAsigController();

$importadorController->importar();
//echo "entra";
?>
<section class="content-header">

    <h3>IMPORTAR TABLA DE PUNTOS DE VENTA ASIGNADOS</h3>

</section>
<?php
 if(!empty($importadorController->resultado)){
     echo $importadorController->resultado;
 }
?>
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <?php 
               
                if(!empty($importadorController->listaFalta)){
                    
                    echo "   <div class='box-body'> Existen datos a importar que no coinciden con los catálogos del sistema verifique y vuleva a importar el archivo"
                    . "<br> o puede continuar con el proceso dando click en continuar<br>";
                 ?>
                <div >
                    <table class="table"><thead><th>NOMBRE REGION</th>
                        <th>NOMBRE CIUDAD</th></thead>
                        <tbody>
                            <?php
                            foreach($importadorController->listaFalta as $ren){
                            
                             echo '<tr><td>'.$ren["nombreregion"].'</td><td>'.$ren["ciudad"].'</td></tr>';
                            }?>
                        </tbody></table>
                </div>
                   <div class="col-sm-12" style="padding-top: 50px; border-bottom: hidden">
                         <form role="form" name="uform" action="index.php?action=simportarpvasignados&adm=cont" method="post" enctype="multipart/form-data" onsubmit="cargando(this);" >
                                    <input type="hidden" value="<?php echo $_POST['anio'];?>" name="anio">
  <a  class="btn btn-default pull-left" href="index.php?action=simportarpvasignados" >REGRESAR</a>
                                <button type="submit" id="subbutton" class="btn btn-info pull-right" >CONTINUAR</button>
                         </form>
                            </div>
            </div>
                <?php
                }else
                  if($importadorController->hayDatos){
                    
                    echo "   <div class='box-body'> Ya se importó información de ese año"
                    . "<br> si continúa con el proceso se perderá la información previa<br>";
                 ?>
             
                   <div class="col-sm-12" style="padding-top: 50px; border-bottom: hidden">
                         <form role="form" name="uform" action="index.php?action=simportarpvasignados&adm=cont1" method="post" enctype="multipart/form-data" onsubmit="cargando(this);" >
                             <input type="hidden" value="<?php echo $_POST['anio'];?>" name="anio">
  <a  class="btn btn-default pull-left" href="index.php?action=simportarpvasignados" >REGRESAR</a>
                                <button type="submit" id="subbutton" class="btn btn-info pull-right" >CONTINUAR</button>
                         </form>
                            </div>
            </div>
                <?php
                }
                else{
                ?>
                <div class="box-header with-border">
                    <h3 class="box-title">SELECCIONAR ARCHIVO :</h3>
                </div>
                <div class="box-body">
                    <form role="form" name="uform" action="index.php?action=simportarpvasignados&adm=imp" method="post" enctype="multipart/form-data" onsubmit="cargando(this);" >


                        <div class="col-sm-8" ><label> Archivo de datos excel </label>
                            <input type="file" name="archivoimport" id="userfile" class="form-control"   onchange="Activar();" accept=".xlsx" /></div>
                        <div class="col-sm-4" ><label> Año </label>
                            <select name="anio" class="form-control" id="anio" required>
                                <option value="">Seleccione una opción</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                  <option value="2029">2029</option>
                                <option value="2030">2030</option>
                               


                            </select> 
                            <div class="col-sm-12" style="padding-top: 50px; border-bottom: hidden">
                                <button type="submit" id="subbutton" class="btn btn-info pull-right" disabled="disabled">IMPORTAR</button>
                            </div>
                  
                </div>
                          </form>
            </div>
                <?php }?>
            <!-- /.box-body -->
        </div>
    </div>
</section>


