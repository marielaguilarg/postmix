<script type="text/javascript">
<!--
$("document").ready(function(){
	$("#tipocatalogo").hide();
    $(".tiponum").hide();
});
$(function(){
$("#formareac").change(function(){
	
var op=this.value;

if(op=="C")
{	$("#tipocatalogo").toggle('slow');
    $(".tiponum").toggle(false);
} 
else if(op=="N")
{	$("#tipocatalogo").toggle(false);
    $(".tiponum").toggle(true);
} else {
	$("#tipocatalogo").toggle(false);
    $(".tiponum").toggle(false);
}
});

});
//-->
</script>


<!-- Content Header (Page header) -->

    <section class="content-header">
      <h1> AGREGAR CARACTERISTICA ESTANDAR</h1>
      
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      
        <div class="row">
		
        <div class="col-md-12">
             <div class="box box-info">
             <div class="box-body">
              <form role="form" method="post" onsubmit="return validar(this)">
                  <?php
                      $registro = New EstandarController();     
                      $registro->nuevaEstandarDetController();
                    ?>

                <!-- Datos alta de cuenta -->
                <div class="row">
                <div class="form-group col-md-6">
                  <label>DESCRIPCION EN ESPAÑOL</label>
                  <input type="text" class="form-control" name="descesp" required >

                </div>
                <div class="form-group col-md-6">
                  <label>DESCRIPCION EN INGLES</label>
                  <input type="text" class="form-control" name="descing" required>
                </div>

                <div class="form-group col-md-6">
                  <label>FORMATO DE REACTIVO</label>
                  <select class="form-control" name="formareac" id="formareac" required>
                      <option value="">--- Elija el formato ---</option>
                      <option value="C">CATALOGO</option>
                      <option value="N">NUMERICO</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>PONDERACION</label>
                  <input type="text" class="form-control" name="pondera">
                </div>
               
                <div class="form-group col-md-6">
                  <label>ESTANDAR</label>
                  <input name="estandar" id="estandar" class="form-control" >
                </div>
                </div>  
                <div class="row" id="tipocatalogo">
                <div class="form-group col-md-6">
                  <label>CATALOGO</label>
                  <select class="form-control cascada" name="numcatalogo"    data-group="niv-1"
                                    data-id="niv1"
                                    data-target="niv-2"
                                    data-url="indcomboboxestdetalle.php?"
                                    data-replacement="container1"
                                    data-default-label="--- Elija el catalogo ---" >
                      <option value="">--- Elija el catalogo ---</option>
                    <?php
                       $registro = New EstandarController();     
                       $registro->listacatalogos();
                    ?>
                      
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>OPCION CORRECTA</label>
                  <select class="form-control cascada" name="valopcatalogo"    data-group="niv-1"
                                    data-id="niv-2"
                                 
                                    data-replacement="container1"
                                    data-default-label="--- Elija opción ---">
                      <option value="">--- Elija opción ---</option>
                      
                  </select>
                </div>
                </div>
                <div class="row tiponum">
                <div class="form-group col-md-6">
                   <label >CALCULO ESPECIAL</label>
                    <input type="checkbox" name="calesp" />
                </div>
                <div class="form-group col-md-6">
                  <label>TIPO DE CALCULO</label>
                  <select class="form-control" name="tipocalesp">
                      <option value="">--- Elija el tipo ---</option>
                      <option value="1">PROPORCION AGUA-JARABE</option>
                      <option value="2">CALCULO DE CO2</option>
                  </select>

                </div>
                <div class="form-group col-md-6">
                  <label>POSICION EN EL CALCULO</label>
                  <select class="form-control" name="poscal">
                      <option value="">--- Elija el formato ---</option>
                      <option value="A">A</option>
                      <option value="B">B</option>
                      <option value="C">C</option>
                  </select>

                </div>
                </div>  
                <div class="form-group col-md-6 tiponum">
                   <label >SIGNO UNO</label>
                    <input name="siguno" id="siguno" class="form-control" >
                </div>
                <div class="form-group col-md-6 tiponum">
                  <label>VALOR MINIMO</label>
                  <input name="valmin" id="valmin" class="form-control" >
                </div>
                <div class="form-group col-md-6 tiponum">
                   <label >SIGNO DOS</label>
                    <input name="sigdos" id="sigdos" class="form-control" >
                </div>
                <div class="form-group col-md-6 tiponum">
                  <label>VALOR MAXIMO</label>
                  <input name="valmax" id="valmax" class="form-control" >
                </div>
                 <div class="form-group col-md-12">
                   <label >ALERTA MODERADA</label>
                   </div>
  <div class="form-group col-md-6 tiponum">
                   <label >SIGNO UNO</label>
                    <input name="sigunomod" id="sigunomod" class="form-control" >
                </div>
                <div class="form-group col-md-6 tiponum">
                  <label>VALOR MINIMO</label>
                  <input name="valminmod" id="valminmod" class="form-control" >
                </div>
                <div class="form-group col-md-6 tiponum">
                   <label >SIGNO DOS</label>
                    <input name="sigdosmod" id="sigdosmod" class="form-control" >
                </div>
                <div class="form-group col-md-6 tiponum">
                  <label>VALOR MAXIMO</label>
                  <input name="valmaxmod" id="valmaxmod" class="form-control" >
                </div>

                <div class="form-group col-md-6">
                   <label >INCLUYE EN ARCHIVO</label>
                    <input type="checkbox" name="indsyd" />
                </div>
                <div class="form-group col-md-6">
                    <label >LUGAR EN ARCHIVO</label>
                    <input name="lugarsyd" id="lugarsyd" class="form-control" >
                </div>

                <div class="form-group col-md-6">
                   <label >GENERA GRAFICA</label>
                    <input type="checkbox" name="graf"  />
                </div>
                <div class="form-group col-md-6">
                    <label >TIPO DE REACTIVO</label>
                    <select class="form-control" name="tipo_grafica">
                      <option value="">--- Elija el formato ---</option>
                      <option value="C">CUALITATIVO</option>
                      <option value="N">CUANTITATIVO</option>
                  </select>
                </div>
               

                <div class="form-group col-md-6">
                   <label >INDICADOR</label>
                   <input type="checkbox" name="indicador"  />
                </div>
                <div class="form-group col-md-6">
                   <label >LUGAR EN GRAFICA DE INDICADORES</label>
                   <input name="lugarindi" id="lugarindi" class="form-control" >
                </div>

                <div class="form-group col-md-4">
                    <label >RANGO VERDE</label>
                    <input  name="rango_verdei" id="rango_verdei" class="form-control" >
                    <label > - </label>
                    <input  name="rango_verdef" id="rango_verdef" class="form-control" >
                </div>
                <div class="form-group col-md-4">
                    <label >RANGO AMARILLO</label>
                    <input name="rango_amarilloi" id="rango_amarilloi" class="form-control" >
                    <label > - </label>
                    <input name="rango_amarillof" id="rango_amarillof" class="form-control" >
                </div>
                <div class="form-group col-md-4">
                    <label >RANGO ROJO</label>
                    <input name="rango_rojoi" id="rango_rojoi" class="form-control" >
                    <label > - </label>  
                    <input name="rango_rojof" id="rango_rojof" class="form-control" >
                </div>
                             
              

                <div class="form-group col-md-6">
                <label >METODO DE ANALISIS PEPSICO</label>
                <input type="text" class="form-control" name="anapepsi" >
                </div>
                <div class="form-group col-md-6">
                <label >REFERENCIA INTERNACIONAL</label>
                <input type="text" class="form-control" name="refinter" >
                </div>
                


                 <!-- Pie de formulario -->
                 <div class="box-footer col-md-12">
                        <div class="pull-right">
                    <button type="submit" class="btn btn-info">GUARDAR</button>
                  <?php
                 $registro = New EstandarController();
                  $registro->botonRegresaEstDetController() ?>
                 </div>
                  <?php
                 $registro = New EstandarController();     
                 $registro-> registraestdetController();  
                // $registro->botonRegresaabdetController() ?>

                 </div>

              </form>
        </div>
	    </div>
	    </div>


	  

  </div>
   <script src="js/jquery.cascading-drop-down.js"></script>

    <script>

    $('.cascada').ssdCascadingDropDown({

        nonFinalCallback: function(trigger, props, data, self) {



            trigger.closest('form')

                    .find('input[type="submit"]')

                    .attr('disabled', true);



        },

        finalCallback: function(trigger, props, data) {



            if (props.isValueEmpty()) {

                trigger.closest('form')

                        .find('input[type="submit"]')

                        .attr('disabled', true);

            } else {

                trigger.closest('form')

                        .find('input[type="submit"]')

                        .attr('disabled', false);

            }



        }

    });

</script>
  
