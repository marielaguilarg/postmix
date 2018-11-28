
 <section class="content-header">

<h3>CONFIGURACION DEL SURVEY DATA</h3>


</section>
   <section class="content container-fluid">
  <div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">NUEVA COLUMNA</h3>
            </div>
            <div class="box-body">
             <form role="form" name="form1" method="post" action="index.php?action=ssurveydata&admin=insertar">
               <div class="form-group col-md-6"><label>NUMERO DE COLUMNA :</label>
    
      <input class="form-control" name="numcol" type="text"  id="descriesp" size="70" required/>
    </div>
     <div class="form-group col-md-6"><label>TIPO DE REACTIVO :</label>
   
      <select class="form-control" name="tiporeac">
        <option value="E">Estandar</option>
        <option value="P">Ponderado</option>
        <option value="A" selected="selected">Abierto</option>
		 <option value="O">N/A</option>
		 <option value="Prod">Producto</option>
      </select>
      </div>
     <div class="form-group col-md-6"><label>NUMERO DE REACTIVO :</label>
    
      <input class="form-control" name="numreactivo" type="text"  id="descriesp" size="70" required />
     
    </div>
     <div class="form-group col-md-6"><label>DESCRIPCION :</label>
    
      <input class="form-control" name="descripcion" type="text"  id="descriesp"  size="70" required />
     
    </div>
     <div class="form-group col-md-6"><label>NOMBRE DE COLUMNA :</label>
    
      <input class="form-control" name="nomcol" type="text"  id="descriesp"  size="70" />
     
    </div>
     <div class="form-group col-md-6"><label>NUMERO DE RENGLON :</label>
    
      <input class="form-control" name="numren" type="text"  id="descriesp" size="70" />
     
    </div>
     <div class="form-group col-md-6"><label>VALOR POR OMISION :</label>
    
      <input class="form-control" name="valini" type="text"  id="descriesp" size="70" />
     
    </div>
    <div class="box-footer">
                <div class="col-sm-12" style="padding-top: 50px; border-bottom: hidden">
                 <a class="btn btn-default pull-right" style="margin-left: 10px" href="index.php?action=ssurveydata">Cancelar</a>
                <button type="submit" class="btn btn-info pull-right">Guardar</button>
              </div>
              </div>
               </form>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          </div>
        </section>


       