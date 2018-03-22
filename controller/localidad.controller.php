<?php
require_once 'model/localidad.php';

class LocalidadController{

 public function __CONSTRUCT(){
  $this->model = new Localidad();
}

public function Index(){
  $catalogos=true;
  $localidades=true;
  $page="view/localidad/index.php";
  require_once 'view/index.php';
}

public function Crud(){
  if(isset($_REQUEST['nuevoRegistro'])){
    $nuevoRegistro=true;
  }
  $localidad = new Localidad();
  if(isset($_REQUEST['idLocalidad'])){
    $localidad = $this->model->Obtener($_REQUEST['idLocalidad']);
  }
  $catalogos=true;
  $localidades=true;
  $page="view/localidad/localidad.php";
  require_once 'view/index.php';
}

public function UploadLocalidades(){
  if(!isset($_FILES['file']['name'])){
    header('Location: ./?c=localidad&a=Index');
  }
  $archivo=$_FILES['file'];
  if($archivo['type']=="application/vnd.ms-excel"){
    $nameArchivo = $archivo['name'];
    $tmp = $archivo['tmp_name'];
    echo $archivo['type'];
    $src = "./assets/files/".$nameArchivo;
    if(move_uploaded_file($tmp, $src)){
      $this->ImportarLocalidades($archivo);
    }  
  }else{
    $error=true;
    $mensaje="El tipo de archivo es invalido, porfavor verifique que el archivo sea <strong>.csv</strong>";
    $page="view/localidad/localidad.php";
    $localidades = true;
    $catalogos=true;
    require_once 'view/index.php';
  }
}
public function ImportarLocalidades(){
  if (file_exists("./assets/files/localidades.csv")) {
          //Agregamos la librería
    require 'assets/plugins/PHPExcel/Classes/PHPExcel/IOFactory.php';
          //Variable con el nombre del archivo
    $nombreArchivo = './assets/files/localidades.csv';
          // Cargo la hoja de cálculo
    $objPHPExcel = PHPExcel_IOFactory::load($nombreArchivo);
          //Asigno la hoja de calculo activa
    $objPHPExcel->setActiveSheetIndex(0);
          //Obtengo el numero de filas del archivo
    $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
    $this->Localidades($objPHPExcel,$numRows);
    $mensaje="Se ha leído correctamente el archivo <strong>localidades.csv</strong>.<br><i class='fa fa-check'></i> Se han importado correctamente los datos de localidades.";
    $page="view/localidad/index.php";
    $localidades=true;
    $catalogos=true;
    require_once 'view/index.php';
  }
        //si por algo no cargo el archivo bak_
  else {
    $error=true;
    $mensaje="El archivo <strong>localidades.csv</strong> no existe. Seleccione el archivo para poder importar los datos";
    $page="view/localidad/index.php";
    $localidades = true;
    $catalogos=true;
    require_once 'view/index.php';
  }
}

public function Localidades($objPHPExcel,$numRows){
 try{
  $this->model->Limpiar("localidades");
  $numRow=2;
  do {
    $cat = new Localidad();
    $cat->idLocalidad = $objPHPExcel->getActiveSheet()->getCell('A'.$numRow)->getCalculatedValue();
    $cat->municipio = $objPHPExcel->getActiveSheet()->getCell('B'.$numRow)->getCalculatedValue();
    $cat->localidad = $objPHPExcel->getActiveSheet()->getCell('C'.$numRow)->getCalculatedValue();
    $cat->ambito = $objPHPExcel->getActiveSheet()->getCell('D'.$numRow)->getCalculatedValue();
    if (!$cat->idLocalidad == null) {
      $this->model->ImportarLocalidad($cat);
    }
    $numRow+=1;
  } while ( !$cat->idLocalidad == null);
} catch (Exception $e) {
 $mensaje="error";
 $page="view/localidad/index.php";
 $localidades=true;
 $catalogos=true;
 require_once 'view/index.php';
}
}
public function Eliminar(){
  $this->model->Eliminar($_REQUEST['idLocalidad']);
  $localidades = true;
  $catalogos=true;
  $page="view/localidad/index.php";
  $mensaje="Se ha eliminado correctamente la localidad";
  require_once 'view/index.php';
}
public function Guardar(){
  $localidad= new Localidad();
  $localidad->idLocalidad = $_REQUEST['idLocalidad'];
  $verificaLocalidad = $this->model->verificaLocalidad($localidad->idLocalidad);
  $localidad->municipio = $_REQUEST['municipio'];
  $localidad->localidad = $_REQUEST['localidad'];
  $localidad->ambito = $_REQUEST['ambito'];
  if($verificaLocalidad!=null && isset($_REQUEST['nuevoRegistro'])){

    $error=true;
    $localidad = true;
    $catalogos=true;
    $nuevoRegistro=true;
    $mensaje="La clave de la localidad <b>$localidad->idLocalidad</b> ya existe. Pongase en contacto con el administrador de la Unidad de Planeación para que le proporcione correctamente una nueva clave de localidad.";
    $page="view/localidad/localidad.php";
    require_once "view/index.php";
  }else{
    if(!isset($_REQUEST['nuevoRegistro'])){
      $this->model->Actualizar($localidad);
      $mensaje="Se han actualizado correctamente la localidad";
    }else{
      $this->model->Registrar($localidad);
      $mensaje="Se ha registrado correctamente la localidad";
    }
  }
  $localidades = true;
  $catalogos=true;
  $page="view/localidad/index.php";
  require_once 'view/index.php';
}
}