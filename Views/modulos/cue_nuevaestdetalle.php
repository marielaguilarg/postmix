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
              <form role="form" method="post" onsubmit="return validar(this)"></span>
                  <?php
                      $registro = New EstandarController();     
                      $registro->nuevaEstandarDetController();
                    ?>

                <!-- Datos alta de cuenta -->
                <div class="row">
                <div class="form-group col-md-6">
                  <label>DESCRIPCION EN ESPAÑOL</label>
                  <input type="text" class="form-control" name="descesp" >

                </div>
                <div class="form-group col-md-6">
                  <label>DESCRIPCION EN INGLES</label>
                  <input type="text" class="form-control" name="descing" >
                </div>

                <div class="form-group col-md-6">
                  <label>FORMATO DE REACTIVO</label>
                  <select class="form-control" name="formareac">
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
                <div class="row">
                <div class="form-group col-md-6">
                  <label>CATALOGO</label>
                  <select class="form-control" name="numcatalogo">
                      <option value="">--- Elija el catalogo ---</option>
                    <?php
                       $registro = New EstandarController();     
                       $registro->listacatalogos();
                    ?>
                      
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>OPCION CORRECTA</label>
                  <select class="form-control" name="valopcatalogo">
                      <option value="">--- Elija el opcion ---</option>
                  </select>
                </div>
                </div>
                <div class="row">
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
                <div class="form-group col-md-6">
                   <label >SIGNO UNO</label>
                    <input name="siguno" id="siguno" class="form-control" >
                </div>
                <div class="form-group col-md-6">
                  <label>VALOR MINIMO</label>
                  <input name="valmin" id="valmin" class="form-control" >
                </div>
                <div class="form-group col-md-6">
                   <label >SIGNO DOS</label>
                    <input name="sigdos" id="sigdos" class="form-control" >
                </div>
                <div class="form-group col-md-6">
                  <label>VALOR MAXIMO</label>
                  <input name="valmax" id="valmax" class="form-control" >
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
                  <?php
                 $registro = New EstandarController();
                  $registro->botonRegresaEstDetController() ?>
                  <button type="submit" class="btn btn-info pull-right">Guardar</button>  
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
