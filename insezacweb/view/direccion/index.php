<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Catálogos</h1>
    <h2 class="">Dirección</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a href="?c=Inicio">Inicio</a></li>
      <li class="active">Dirección</a></li>
    </ol>
  </div>
</div>
<div class="container clear_both padding_fix">
  <div class="row">
    <div class="col-md-12">
      <div class="block-web">
        <div class="header">
          <div class="row" style="margin-top: 15px; margin-bottom: 12px;">
            <div class="col-sm-7">
              <div class="actions"> </div>
              <h2 class="content-header theme_color" style="margin-top: -5px;">&nbsp;&nbsp;Direcciones</h2>
            </div>
            <div class="col-md-5">
              <div class="btn-group pull-right">
                <b>
                  <?php if($_SESSION['tipoUsuario']==1){?>
                  <div class="btn-group" style="margin-right: 10px;"> 
                    <a class="btn btn-sm btn-success tooltips" href="?c=Direccion&a=Crud&nuevoRegistro=true" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Registrar nueva Direccion"> <i class="fa fa-plus"></i> Registrar </a>
                    <a class="btn btn-sm  tooltips btn-warning"  href="#modalImportar" style="margin-right: 10px;"  data-toggle="modal" data-target="#modalImportar" data-original-title="Importar direcciones" type="button" class="btn btn-default tooltips" data-toggle="tooltip" data-placement="bottom" title=""><i class="fa fa-upload"></i>&nbsp;Importar</a>
                    <a href="assets/files/direcciones.xlsx" download="direcciones.xlsx" class="btn btn-sm btn-primary tooltips" data-original-title="Descargar archivo direcciones.xlsx" type="button" class="btn btn-default tooltips" data-toggle="tooltip" data-placement="bottom" title=""> <i class="fa  fa-download"></i>&nbsp;Descargar</a> 
                  </div>
                  <?php } ?>
                </b>
              </div>
            </div>    
          </div>
        </div>
        <?php if(isset($mensaje)){ if(!isset($error)){?>
        <div class="row" style="margin-bottom: -20px; margin-top: 20px">
          <div class="col-md-12">
            <div class="alert alert-success fade in">
              <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
              <i class="fa fa-check"></i>&nbsp;<?php echo $mensaje; ?>
            </div>
          </div>
        </div> 
        <?php } if(isset($error)){ ?>
        <div class="row" style="margin-bottom: -20px; margin-top: 20px">
          <div class="col-md-12">
            <div class="alert alert-danger">
              <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
              <i class="fa fa-warning"></i>&nbsp;<?php echo $mensaje; ?>
            </div>
          </div>
        </div>
        <?php } }?>
        <div class="porlets-content">
          <div class="table-responsive">
            <table  class="display table table-bordered table-striped" id="dynamic-table">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th>Titular</th>
                  <?php if($_SESSION['tipoUsuario']==1){?>
                  <td><center><b>Editar</b></center></td>
                  <td><center><b>Borrar</b></center></td> 
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
               <?php foreach($this->model->Listar() as $r): ?>
                <tr class="gradeA">

                <td><?php echo $r->direccion; ?></td>
                <td><?php echo $r->descripcion; ?></td>
                <td><?php echo $r->titular; ?></td>
               <?php if($_SESSION['tipoUsuario']==1){?>
                    <td class="center">
                      <a href="index.php?c=Direccion&a=Crud&idDireccion=<?php echo $r->idDireccion ?>" class="btn btn-primary btn-sm" role="button"><i class="fa fa-edit"></i></a>
                    </td>
                    <td class="center">
                      <a onclick="eliminarDireccion(<?php echo $r->idDireccion;?>);" class="btn btn-danger btn-sm" href="#modalEliminar"  data-toggle="modal" data-target="#modalEliminar" role="button"><i class="fa fa-eraser"></i></a>
                    </td>
                    <?php } ?>
                  </tr>

                  <td></td>
                   <td></td>
                    <td></td>
                     <td></td>
                      <td></td>

                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Titular</th>
                <?php if($_SESSION['tipoUsuario']==1){?>
                <td><center><b>Editar</b></center></td>
                <td><center><b>Borrar</b></center></td> 
                <?php } ?>
              </tr>
            </tfoot>
          </table>
        </div><!--/table-responsive-->
      </div><!--/porlets-content-->
    </div><!--/block-web-->
  </div><!--/col-md-12-->
</div><!--/row-->
</div>
<div class="modal fade" id="modalImportar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"> 
        <div class="row">
          <div class="block-web">
            <div class="header">
              <h3 class="content-header theme_color">&nbsp;Importar direcciones</h3>
            </div>
            <div class="porlets-content" style="margin-bottom: -65px;">
              <p>Importa tu archivo excel con los datos de los direcciones en caso de que haya algun cambio, si no tienes el archivo puedes descargarlo y agregar o eliminar los datos necesarios.</p>
              <p><strong>Nota: </strong>Al importar el archivo actualizado debe tener el nombre de <strong class="theme_color">direcciones.xlsx</strong> para poder ser leído correctamente.</p> 
              <br>
              <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Seleccionar archivo</span>
                <!-- The file input field used as target for the file upload widget -->
                <input id="fileupload" type="file" name="files[]" multiple class="direcciones">
              </span>
              <br>
              <br>
              <!-- The global progress bar -->
              <div id="progress" class="progress">
                <div class="progress-bar progress-bar-success"></div>
              </div>
              <!-- The container for the uploaded files -->
              <div id="files" class="files"></div>
            </div><!--/porlets-content--> 
          </div><!--/block-web--> 
        </div>
      </div>
      <div class="modal-footer">
        <div class="row col-md-5 col-md-offset-7">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <a href="?c=Direccion&a=Importar" class="btn btn-primary">Importar datos</a>
        </div>
      </div>
    </div><!--/modal-content--> 
  </div><!--/modal-dialog--> 
</div><!--/modal-fade--> 
<div class="modal fade" div-modal-content id="modalCrud" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 50%;">
    <div class="modal-content" id="div-modal-content">
    </div><!--/modal-content--> 
  </div><!--/modal-dialog--> 
</div><!--/modal-fade--> 
<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content  panel default red_border horizontal_border_1">
      <div class="modal-body"> 
        <div class="row">
          <div class="block-web">
            <div class="header">
              <h3 class="content-header theme_color">&nbsp;Eliminar dirección</h3>
            </div>
            <div class="porlets-content" style="margin-bottom: -50px;">
              <h4>¿Esta segúro que desea eliminar la  Direccion?</h4>
            </div><!--/porlets-content--> 
          </div><!--/block-web--> 
        </div>
      </div>
      <div class="modal-footer" style="margin-top: -10px;">
        <div class="row col-md-5 col-md-offset-7" style="margin-top: -5px;">
          <form action="?c=Direccion&a=Eliminar" enctype="multipart/form-data" method="post">
            <input  type="hidden" name="idDireccion" id="txtIdDireccion">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </div>
    </div><!--/modal-content--> 
  </div><!--/modal-dialog--> 
</div><!--/modal-fade--> 
<script>
/* ----Funcion para buscar en una tabla------

  function myFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}*/

eliminarDireccion = function(idDireccion){
  $('#txtIdDireccion').val(idDireccion);  
};
</script>
