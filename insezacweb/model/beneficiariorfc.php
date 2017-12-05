<?php
require_once 'model/database.php';
class Beneficiariorfc
{

	public $usuario;
	public $fechaAlta;
	public $hora;
	public $estado;
	public $direccion;
	public $pdo;


	public $idBeneficiarioRFC;
	public $RFC;
	public $curp;
	public $primerApellido;
	public $segundoApellido;
	public $nombres;
	
	public $fechaAltaSat;
	public $sexo;
	public $idAsentamientos;
	public $idLocalidad;
	public $idTipoVialidad;
	public $nombreVialidad;
	public $numeroExterior;
	public $numeroInterior;
	public $entreVialidades;
	public $descripcionUbicacion;
	public $actividad;
	public $cobertura;
	public $idRegistro;



	public function __CONSTRUCT()
	{
		try
		{
			$this->pdo = Database::StartUp();     
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}



	public function Listar($id)
	{
		try
		{
			$stm = $this->pdo->prepare("SELECT
				b.idbeneficiarioRFC, 
				b.RFC, 
				b.primerApellido, 
				b.segundoApellido,
				b.nombres, 
				b.fechaAltaSat,
				b.sexo,
				a.nombreAsentamiento,
				b.idAsentamientos,
				l.localidad,
				b.idLocalidad,
				tV.tipoVialidad,
				b.nombreVialidad,
				b.idTipoVialidad,
				b.entreVialidades,
				b.descripcionUbicacion,
				b.actividad,
				b.cobertura
				FROM 
				tipoVialidad tV, 
				asentamientos a, 
				localidades l, 
				beneficiarioRFC  b
				where   
				b.idTipoVialidad = tV.idTipoVialidad AND 	
				b.idAsentamientos = a.idAsentamientos AND 
				b.idLocalidad = l.idLocalidad AND
				b.idbeneficiarioRFC = ?");

			$stm->execute(array($id));
			return $stm->fetch(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
//499 105 55 66
	public function ListarDatosPersonales()
	{
		try
		{
			$stm = $this->pdo->prepare("
				SELECT
				b.idbeneficiarioRFC, 
				b.RFC,
				b.curp, 
				b.primerApellido, 
				b.segundoApellido,
				b.nombres, 
				b.actividad,
				b.cobertura
				FROM  
				beneficiarioRFC");
			
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


	public function Registrar(Beneficiariorfc $data)
	{
		try 
		{

			$sql = "INSERT INTO beneficiarioRFC
			(RFC,curp,primerApellido,segundoApellido,nombres,
			fechaAltaSat,sexo,idAsentamientos,idLocalidad,idTipoVialidad,
			nombreVialidad,numeroExterior,numeroInterior,entreVialidades,descripcionUbicacion,
	        actividad,cobertura,idRegistro) values 
		   (?,?,?,?,?,
			?,?,?,?,?,
			?,?,?,?,?,
			?,?,?)";
			$this->pdo->prepare($sql)
			->execute(
				array(
					$data->RFC,
					$data->curp,
					$data->primerApellido,
					$data->segundoApellido,
					$data->nombres,
					$data->fechaAltaSat,
					$data->sexo,
					$data->idAsentamientos,
					$data->idLocalidad,
					$data->idTipoVialidad,
					$data->nombreVialidad,
					$data->numeroExterior,
					$data->numeroInterior,
					$data->entreVialidades,
					$data->descripcionUbicacion,
					$data->actividad,
					$data->cobertura,
					$data->idRegistro
					)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	

	public function Obtener($idBeneficiario)
	{
		try
		{
			$stm = $this->pdo
			->prepare("SELECT * FROM beneficiarios WHERE idBeneficiario = ?");


			$stm->execute(array($idBeneficiario));
			return $stm->fetch(PDO::FETCH_OBJ);

			
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($data)
	{
		try 
		{
			$stm = $this->pdo
			->prepare("UPDATE registro r INNER JOIN beneficiarioRFC b
				ON r.idRegistro = b.idRegistro
				SET estado = ?
				WHERE r.idRegistro = ?");			          

			$stm->execute(array(
				$data->estado,
				$data->idRegistro
			));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	//Metodo para actualizar
	public function Actualizar($data)
	{
		try 
		{
			$sql = "UPDATE beneficiarioRFC SET 
			RFC =?,
			curp = ?,
			primerApellido = ?,
			segundoApellido = ?,
			nombres = ?,
			fechaAltaSat =?,
			sexo =?,
			idAsentamientos =?,
			idLocalidad = ?,
			idTipoVialidad =?,
			nombreVialidad =?,
			numeroExterior = ?,
			numeroInterior = ?,
			entreVialidades = ?,
			descripcionUbicacion = ?,
			actividad = ?,
			cobertura = ?
			WHERE idBeneficiarioRFC = ?";

			$this->pdo->prepare($sql)
			->execute(
				array(
					$data->RFC,
					$data->curp,
					$data->primerApellido,
					$data->segundoApellido,
					$data->nombres,
					$data->fechaAltaSat,
					$data->sexo,
					$data->idAsentamientos,
					$data->idLocalidad,
					$data->idLocalidad,
					$data->idTipoVialidad,
					$data->nombreVialidad,
					$data->numeroExterior,
					$data->numeroInterior,
					$data->entreVialidades,
					$data->descripcionUbicacion,
					$data->actividad,
					$data->cobertura,
					$data->idRegistro,
					$data->idBeneficiarioRFC

				)
			);
			
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function ImportarBeneficiario(Beneficiario $data){
		try 
		{
			$sql =$this->pdo->prepare("INSERT INTO beneficiarios 
				(curp,primerApellido,segundoApellido,nombres,email,idIdentificacion,idTipoVialidad,
				nombreVialidad,noExterior,noInterior,idAsentamientos,idLocalidad,entreVialidades,
				descripcionUbicacion,estudioSocioeconomico,idEstadoCivil,jefeFamilia,idOcupacion,
				idIngresoMensual, integrantesFamilia, dependientesEconomicos,idVivienda,noHabitantes,
				viviendaElectricidad,viviendaAgua,viviendaDrenaje,viviendaGas,viviendaTelefono,viviendaInternet,
				idNivelEstudios,idSeguridadSocial,idDiscapacidad,idGrupoVulnerable,beneficiarioColectivo,
				idRegistro,fechaNacimiento,genero,perfilSociodemografico,telefono,idMunicipio) values 
				(?,?,?,?,?,
				?,?,?,?,?,
				?,?,?,?,?,
				?,?,?,?,?,
				?,?,?,?,?,
				?,?,?,?,?,
				?,?,?,?,?,
				?,?,?,?,?)");
			$resultado=$sql->execute(
				array(
					$data->curp,
					$data->primerApellido,
					$data->segundoApellido,
					$data->nombres,
					$data->email,
					$data->idIdentificacion,
					$data->idTipoVialidad, 
					$data->nombreVialidad,
					$data->noExterior,
					$data->noInterior,
					$data->idAsentamientos,
					$data->idLocalidad,
					$data->entreVialidades,
					$data->descripcionUbicacion,//8
					$data->estudioSocioeconomico,
					$data->idEstadoCivil,
					$data->jefeFamilia,
					$data->idOcupacion,
					$data->idIngresoMensual,
					$data->integrantesFamilia,
					$data->dependientesEconomicos,
					
					$data->idVivienda,
					$data->noHabitantes,				
					$data->viviendaElectricidad,
					$data->viviendaAgua,
					$data->viviendaDrenaje,
					$data->viviendaGas,
					$data->viviendaTelefono,
					$data->viviendaInternet,//8
					$data->idNivelEstudios,
					$data->idSeguridadSocial,
					$data->idDiscapacidad,
					$data->idGrupoVulnerable,//8
					$data->beneficiarioColectivo,//9
					$data->idRegistro,
					$data->fechaNacimiento,
					$data->genero,
					$data->perfilSociodemografico,
					$data->telefono,
					$data->idMunicipio
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Listar1()
	{
		try
		{
			//$result = array();
			$stm = $this->pdo->prepare("SELECT 				
				*
				FROM beneficiarioRFC b, registro r, localidades l
				WHERE r.idRegistro= b.idRegistro  AND r.estado='Activo'
				AND b.idLocalidad=l.idLocalidad");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
	
	public function Listar2()
	{
		try
		{
			//$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM beneficiarios, registro, municipio WHERE registro.idRegistro=beneficiarios.idRegistro and registro.estado='Activo'");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

//Funciones para registrar los detalles de cada registro de beneficiarios.

	public function RegistraDatosRegistro(Beneficiariorfc $data){

		try 
		{

			$sql = "INSERT INTO registro VALUES (?,?,?,?,?)";
			$this->pdo->prepare($sql)
			->execute(
				array(
					null,
					$data->usuario,
					$data->direccion,
					$data->fechaAlta,
					$data->estado
				)
			);
			return $this->pdo->lastInsertId();
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function ObtenerIdRegistro($idBeneficiario)
	{
		try 
		{
			$sql= $this->pdo->prepare("SELECT registro.idRegistro from registro, beneficiarios where registro.idregistro=beneficiarios.idregistro and idBeneficiario=$idBeneficiario");
			$resultado=$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ,PDO::FETCH_ASSOC);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
	public function ObtenerIdMunicipio($claveMunicipio)
	{
		try 
		{
			$sql= $this->pdo->prepare("SELECT idMunicipio from municipio where claveMunicipio=$claveMunicipio");
			$resultado=$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ,PDO::FETCH_ASSOC);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
	public function RegistraActualizacion(Beneficiario $data){
		try 
		{
			$sql = "INSERT INTO actualizacion VALUES (?,?,?,?,?)";
			$this->pdo->prepare($sql)
			->execute(
				array(
					null,
					$data->usuario,
					$data->direccion,
					$data->fechaAlta,
					$data->idRegistro
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function ObtenerInfoRegistro($idBeneficiario)
	{
		try 
		{
			$sql= $this->pdo->prepare("SELECT * FROM registro, beneficiarios WHERE beneficiarios.idregistro=registro.idregistro AND beneficiarios.idbeneficiario=?;");
			$resultado=$sql->execute(array($idBeneficiario));
			return $sql->fetch(PDO::FETCH_OBJ,PDO::FETCH_ASSOC);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
	public function ListarActualizacion($idRegistro)
	{
		try
		{
			$stm = $this->pdo->prepare("SELECT * FROM actualizacion WHERE idRegistro=?");
			$stm->execute(array($idRegistro));

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function ObtenerInfoActualizacion2()
	{
		try 
		{
			$sql= $this->pdo->prepare("SELECT * FROM actualizacion;");
			$stm->execute(array($id));
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function ObtenerInfoApoyo($idBeneficiario)
	{
		try
		{
			$stm = $this->pdo->prepare("SELECT * FROM apoyos,beneficiarios,origen,registroApoyo,subprograma,programa,periodicidad,tipoApoyo,caracteristicasApoyo WHERE apoyos.idBeneficiario=beneficiarios.idBeneficiario AND apoyos.idRegistroApoyo=registroApoyo.idRegistroApoyo AND apoyos.idSubprograma=subprograma.idSubprograma AND subprograma.idPrograma=programa.idPrograma AND apoyos.idPeriodicidad=periodicidad.idPeriodicidad AND apoyos.idOrigen=origen.idOrigen AND caracteristicasApoyo.idTipoApoyo=tipoApoyo.idTipoApoyo AND apoyos.idCaracteristica=caracteristicasApoyo.idCaracteristicasApoyo AND beneficiarios.idBeneficiario=? ORDER BY apoyos.idApoyo;");
			
			$stm->execute(array($idBeneficiario));

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	
}

/*


mysql> describe beneficiarioRFC;
+----------------------+--------------+------+-----+---------+----------------+
| Field                | Type         | Null | Key | Default | Extra          |
+----------------------+--------------+------+-----+---------+----------------+
| idbeneficiarioRFC    | int(11)      | NO   | PRI | NULL    | auto_increment |
| RFC                  | varchar(13)  | YES  |     | NULL    |                |
| curp                 | varchar(18)  | YES  |     | NULL    |                |
| primerApellido       | varchar(20)  | YES  |     | NULL    |                |
| segundoApellido      | varchar(25)  | YES  |     | NULL    |                |
| nombres              | varchar(25)  | YES  |     | NULL    |                |
| fechaAltaSat         | date         | YES  |     | NULL    |                |
| sexo                 | tinyint(1)   | YES  |     | NULL    |                |
| idAsentamientos      | varchar(45)  | YES  | MUL | NULL    |                |
| idLocalidad          | varchar(10)  | YES  | MUL | NULL    |                |
| idTipoVialidad       | int(11)      | YES  | MUL | NULL    |                |
| nombreVialidad       | varchar(65)  | YES  |     | NULL    |                |
| numeroExterior       | varchar(8)   | YES  |     | NULL    |                |
| numeroInterior       | varchar(8)   | YES  |     | NULL    |                |
| entreVialidades      | varchar(100) | YES  |     | NULL    |                |
| descripcionUbicacion | text         | YES  |     | NULL    |                |
| actividad            | varchar(45)  | YES  |     | NULL    |                |
| cobertura            | int(11)      | YES  |     | NULL    |                |
| idRegistro           | int(11)      | YES  | MUL | NULL    |                |
+----------------------+--------------+------+-----+---------+----------------+


*/