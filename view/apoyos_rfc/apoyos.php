

<div class="pull-left breadcrumb_admin clear_both">
  <div class="pull-left page_title theme_color">
    <h1>Inicio</h1>
    <h2 class="">Apoyos</h2>
  </div>
  <div class="pull-right">
    <ol class="breadcrumb">
      <li><a href="?c=inicio">Inicio</a></li>
      <li><a href="?c=apoyosrfc">Apoyos</a></li>
      <li class="active"><?php echo $apoyo->idApoyoRFC != null ? 'Actualizar apoyo' : 'Registrar apoyo'; ?></li>
    </ol>
  </div>
</div>
<div class="container clear_both padding_fix">
  <div class="row">
    <div class="col-md-12">
      <div class="block-web">
        <div class="header">
          <div class="row" style="margin-top: 15px; margin-bottom: 12px;">
            <div class="col-sm-8">
              <div class="actions"> </div>
              <h2 class="content-header theme_color" style="margin-top: -5px;"><?php echo $apoyo->idApoyoRFC != null ? '&nbsp; Actualizar apoyo RFC' : '&nbsp; Registrar apoyo RFC'; ?></h2>
            </div>
            <div class="col-md-4">
              <div class="btn-group pull-right">
                <div class="actions">
                </div>
              </div>
            </div>
          </div>
        </div>

        
        <div class="porlets-content">
          <form action="?c=apoyosrfc&a=Guardar" method="POST" class="form-horizontal row-border" parsley-validate novalidate>
            <input type="hidden" name="idApoyoRFC" value="<?php echo $apoyo->idApoyoRFC != null ? $apoyo->idApoyoRFC : 0; ?>">
            <div class="form-group">
              <label class="col-sm-3 control-label">Beneficiario<strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <select name="idBeneficiarioRFC" class="form-control select2" required style="width: 100%">
                  <?php if($apoyo->idApoyoRFC==null){ ?>
                  <option value="">
                    Seleccione el rfc del beneficiario
                  </option>
                  <?php } if($apoyo->idApoyoRFC!=null){ ?>
                  <option value="<?php echo $apoyo->idBeneficiarioRFC?>">
                    <?php echo $apoyo->RFC; ?>
                  </option>
                  <?php } foreach($this->model->ListarBeneficiarios() as $r):
                  if($r->RFC!=$apoyo->RFC){ ?>
                  ?>
                  <option value="<?php echo $r->idBeneficiarioRFC; ?>">
                    <?php echo $r->RFC; ?>
                  </option>
                  <?php } endforeach; ?>
                </select>
              </div>
            </div><!--/form-group-->



            <div class="form-group">
              <label class="col-sm-3 control-label">Origen<strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <select name="idOrigen" class="form-control" required>
                  <?php if($apoyo->idApoyoRFC==null){ ?>
                  <option value="">
                    Seleccione el origen del apoyo
                  </option>
                  <?php } if($apoyo->idApoyoRFC!=null){ ?>
                  <option value="<?php echo $apoyo->idOrigen?>">
                    <?php echo $apoyo->origen; ?>
                  </option>
                  <?php } foreach($this->model->ListarSelects('origen') as $r):
                  if($r->origen!=$apoyo->origen){ ?>
                  ?>
                  <option value="<?php echo $r->idOrigen; ?>">
                    <?php echo $r->origen; ?>
                  </option>
                  <?php } endforeach; ?>
                </select>
              </div>
            </div><!--/form-group-->
            <div class="form-group">
              <label class="col-sm-3 control-label">Programa<strog class="theme_color">*</strog></label>
              <div class="col-sm-6">
                <select name="idPrograma" class="form-control select2" id="selectProgramas" onchange="listarSubprogramas()" required style="width: 100%">
                  <?php if($apoyo->idApoyoRFC==null){ ?>
                  <option value="">
                    Seleccione la subprograma a la que pertenece el beneficiario
                  </option>
                  <?php } if($apoyo->idApoyoRFC!=null){ ?>
                  <option value="<?php echo $apoyo->idPrograma?>">
                    <?php echo $apoyo->programa; ?>
                  </option>
                  <?php } foreach($this->model->ListarSelects('programa') as $r): ?>
                  <option value="<?php echo $r->idPrograma; ?>">
                    <?php echo $r->programa; ?>
                  </option>
                <?php  endforeach; ?>
              </select>
            </div>
          </div><!--/form-group-->

          <div class="form-group">
            <label class="col-sm-3 control-label">Subprograma<strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <select name="idSubprograma" class="form-control select2" required id="selectSubprogramas" style="width: 100%">   <?php if($apoyo->idApoyoRFC==null){  ?>
                <option value="">
                  Seleccione el subprograma a la que pertenece el beneficiario
                </option>
                <?php } if($apoyo->idApoyoRFC!=null){ ?>
                <option value="<?php echo $apoyo->idSubprograma ?>">
                  <?php echo  $apoyo->subprograma ?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div><!--/form-group-->

          <div class="form-group">
            <label class="col-sm-3 control-label">Caracteristica de apoyo<strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <select name="idCaracteristica" class="form-control select2" required style="width: 100%">
                <?php if($apoyo->idApoyoRFC==null){ ?>
                <option value="">
                  Seleccione caracteristica del apoyo
                </option>
                <?php } if($apoyo->idApoyoRFC!=null){ ?>
                <option value="<?php echo $apoyo->idCaracteristicasApoyo?>">
                  <?php echo $apoyo->caracteristicasApoyo; ?>
                </option>
                <?php } foreach($this->model->ListarSelects('caracteristicasapoyo') as $r):
                if($r->caracteristicasApoyo!=$apoyo->caracteristicasApoyo){ ?>
                ?>
                <option value="<?php echo $r->idCaracteristicasApoyo; ?>">
                  <?php echo $r->caracteristicasApoyo; ?>
                </option>
                <?php } endforeach; ?>
              </select>
            </div>
          </div><!--/form-group-->
          <div class="form-group">
            <label class="col-sm-3 control-label">Periodicidad<strog class="theme_color">*</strog></label>
            <div class="col-sm-6">
              <select name="idPeriodicidad" class="form-control" required>
                <?php if($apoyo->idApoyoRFC==null){ ?>
                <option value="">
                  Seleccione la periodicidad del apoyo
                </option>
                <?php } if($apoyo->idApoyoRFC!=null){ ?>
                <option value="<?php echo $apoyo->idPeriodicidad?>">
                  <?php echo $apoyo->periodicidad; ?>
                </option>
                <?php } foreach($this->model->ListarSelects('periodicidad') as $r):
                if($r->periodicidad!=$apoyo->periodicidad){ ?>
                ?>
                <option value="<?php echo $r->idPeriodicidad; ?>">
                  <?php echo $r->periodicidad; ?>
                </option>
                <?php } endforeach; ?>
              </select>
            </div>
          </div><!--/form-group-->
          <div class="form-group">
            <label class="col-sm-3 control-label">Fecha de apoyo<strog class="theme_color">*</strog></label>
            <div class="col-sm-2">
              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input name="fechaApoyo" type="date" value="<?php echo $apoyo->idApoyoRFC!=null ? $apoyo->fechaApoyo : "" ?>" class="form-control" required>
              </div>
            </div>
            <label class="col-sm-2 control-label">Importe de apoyo<strog class="theme_color">*</strog></label>
            <div class="col-sm-2">
              <div class="input-group"> <span class="input-group-addon">$</span>
                <input value="<?php echo $apoyo->idApoyoRFC != null ? $apoyo->importeApoyo : ""; ?>" style="text-align:right;" onkeypress="return soloNumeros(event);" class="form-control" name="importeApoyo" placeholder="0" type="text" required>
                <span class="input-group-addon">.00</span>
              </div>
            </div>
          </div><!--form-group end-->
          <div class="form-group">
            <div class="col-sm-offset-7 col-sm-5">
              <button type="submit" class="btn btn-primary">Guardar</button>
              <a href="?c=Apoyosrfc" class="btn btn-default"> Cancelar</a>
            </div>
          </div><!--/form-group-->
        </form>
      </div><!--/porlets-content-->
    </div><!--/block-web-->
  </div><!--/col-md-12-->
</div><!--/row-->
</div><!--/container clear_both padding_fix-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
  listarSubprogramas = function (){
    var idPrograma = $('#selectProgramas').val();
    datos = {"idPrograma":idPrograma};
    $.ajax({
      url: "index.php?c=Apoyos&a=ListarSubprogramas",
      type: "POST",
      data: datos
    }).done(function(respuesta){
      if (respuesta[0].estado === "ok") {
        console.log(JSON.stringify(respuesta));
        var selector = document.getElementById("selectSubprogramas");
        selector.options[0] = new Option("Seleccione el subprograma al que petenece el beneficiario","");
        for (var i in respuesta) {
          var j=parseInt(i)+1;
          selector.options[j] = new Option(respuesta[i].subprograma,respuesta[i].idSubprograma);
        }
        //$(".respuesta2").html("Asentamientos:<br><pre>"+JSON.stringify(respuesta, null, 2)+"</pre>");
      }
    });
  }
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
  listarSubprogramas = function (){
    var idPrograma = $('#selectProgramas').val();
    datos = {"idPrograma":idPrograma};
    $.ajax({
      url: "index.php?c=Apoyos&a=ListarSubprogramas",
      type: "POST",
      data: datos
    }).done(function(respuesta){
      if (respuesta[0].estado === "ok") {
        console.log(JSON.stringify(respuesta));
        var selector = document.getElementById("selectSubprogramas");
        selector.options[0] = new Option("Seleccione el subprograma al que petenece el beneficiario","");
        for (var i in respuesta) {
          var j=parseInt(i)+1;
          selector.options[j] = new Option(respuesta[i].subprograma,respuesta[i].idSubprograma);
        }
        //$(".respuesta2").html("Asentamientos:<br><pre>"+JSON.stringify(respuesta, null, 2)+"</pre>");
      }
    });
  }
</script>
