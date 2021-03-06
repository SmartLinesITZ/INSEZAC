<?php
require_once 'model/localidad.php';

class LocalidadController{

  private $model;
  private $mensaje;
  private $error;

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
    try {
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
    } catch (Exception $e) {
      $this->error=true;
      $this->mensaje="Ha ocurrido un error al obtener los datos de la localidad";
      $this->Index();
    } 
  }

  public function Upload(){
    try {
      if(!isset($_FILES['file']['name'])){
        header('Location: ./?c=localidad');
      }
      $archivo=$_FILES['file'];
      if($archivo['type']=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
        if($archivo['name']=="localidades.xlsx"){
          $nameArchivo = $archivo['name'];
          $tmp = $archivo['tmp_name'];
          $archivo['type'];
          $src = "./assets/files/".$nameArchivo;
          if(move_uploaded_file($tmp, $src)){
            $this->Importar();
          }  
        }else{
          $this->error=true;
          $this->mensaje="El nombre del archivo es invalido, porfavor verifique que el nombre del archivo sea <strong>localidades.xlsx</strong>";
          $this->Index();
        }
      }else{
        $this->error=true;
        $this->mensaje="El tipo de archivo es invalido, porfavor verifique que el archivo sea <strong>.xlsx</strong>";
        $this->Index();
      }
    } catch (Exception $e) {
     $this->error=true;
     $this->mensaje="Se ha producido un error al intentar subir el archivo";
     $this->Index();
   }
 }

 public function Importar(){
  try {
    if (file_exists("./assets/files/localidades.xlsx")) {
          //Agregamos la librería
      require 'assets/plugins/PHPExcel/Classes/PHPExcel/IOFactory.php';
          //Variable con el nombre del archivo
      $nombreArchivo = './assets/files/localidades.xlsx';
          // Cargo la hoja de cálculo
      $objPHPExcel = PHPExcel_IOFactory::load($nombreArchivo);
          //Asigno la hoja de calculo activa
      $objPHPExcel->setActiveSheetIndex(0);
          //Obtengo el numero de filas del archivo
      $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
      $this->LeerArchivo($objPHPExcel,$numRows);
      $this->mensaje="Se ha leído correctamente el archivo <strong>localidades.xlsx</strong>.<br><i class='fa fa-check'></i> Se han importado correctamente los datos de localidades.";
      $this->Index();
    }
    else {
      $this->error=true;
      $this->mensaje="El archivo <strong>localidades.xlsx</strong> no existe. Seleccione el archivo para poder importar los datos";
      $this->Index();
    }
  } catch (Exception $e) {
   $this->error=true;
   $this->mensaje="Ha ocurrido un error al importar el archivo";
   $this->Index();
 }
}

public function LeerArchivo($objPHPExcel,$numRows){
 try{
  $this->model->Limpiar("localidades");
  $numRow=2;
  do {
    $cat = new Localidad();
    $cat->idLocalidad = $objPHPExcel->getActiveSheet()->getCell('A'.$numRow)->getCalculatedValue();
    $cat->municipio = $objPHPExcel->getActiveSheet()->getCell('B'.$numRow)->getCalculatedValue();
    $cat->localidad = $objPHPExcel->getActiveSheet()->getCell('C'.$numRow)->getCalculatedValue();
    $cat->ambito = $objPHPExcel->getActiveSheet()->getCell('D'.$numRow)->getCalculatedValue();
    $cat->estado='Activo';
    if (!$cat->idLocalidad == null) {
      $this->model->ImportarLocalidad($cat);
    }
    $numRow+=1;
  } while ( !$cat->idLocalidad == null);
} catch (Exception $e) {
  $this->error=true;
  $this->mensaje="Ha ocurrido un error al leer el archivo";
  $this->Index();
}
}
public function Eliminar(){
  try {
   $localidad= new Localidad;
   $localidad->idLocalidad=$_REQUEST['idLocalidad'];
   $localidad->estado='Inactivo';
   $this->model->Eliminar($localidad);
   $this->mensaje="Se ha eliminado correctamente la localidad";
   $this->Index();
 } catch (Exception $e) {
  $this->error=true;
  $this->mensaje="Ha ocurrido un error al intentar guardar la localidad";
  $this->Index();
}
}
public function Guardar(){
  try {
    $localidad = new Localidad();
    $localidad->idLocalidad = $_REQUEST['idLocalidad'];
    $verificaLocalidad = $this->model->verificaLocalidad($localidad->idLocalidad);
    $localidad->municipio = $_REQUEST['municipio'];
    $localidad->localidad = $_REQUEST['localidad'];
    $localidad->ambito = $_REQUEST['ambito'];
    $localidad->estado = "Activo";
    if($verificaLocalidad!=null && isset($_REQUEST['nuevoRegistro'])){
      $localidades = true;
      $catalogos=true;
      $nuevoRegistro=true;
      $this->error=true;
      $this->mensaje="La clave de la localidad que esta intentando registrar ya existe. Pongase en contacto con el administrador de la Unidad de Planeación para que le proporcione correctamente una nueva clave de localidad.";
      $page="view/localidad/localidad.php";
      require_once "view/index.php";
    }else{
      if(!isset($_REQUEST['nuevoRegistro'])){
        $this->model->Actualizar($localidad);
        $this->mensaje="Se ha actualizado correctamente la localidad";
      }else{
        $this->model->Registrar($localidad);
        $this->mensaje="Se ha registrado correctamente la localidad";
      }
    }
    $this->Index();
  } catch (Exception $e) {
    $this->error=true;
    $this->mensaje="Ha ocurrido un error al intentar guardar la localidad";
    $this->Index();
  }
}
}
