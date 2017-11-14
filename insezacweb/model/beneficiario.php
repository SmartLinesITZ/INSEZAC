<?php
require_once 'model/database.php';
class Beneficiario
{
	public $pdo;
	public $idBeneficiario;
	public $curp;
	public $primerApellido;
	public $segundoApellido;
	public $nombres;
	public $email;
	public $idIdentificacion;
	public $fechaNacimiento;
	public $genero;
	public $idmunicipio;
	public $perfilSociodemografico;
	public $telefono;
	public $idTipoVialidad;
	public $nombreVialidad;
	public $noExterior;
	public $noInterior;
	public $idAsentamientos;
	public $idLocalidad;
	public $entreVialidades;
	public $descripcionUbicacion;
	public $estudioSocioeconomico;
	public $idEstadoCivil;
	public $jefeFamilia;
	public $idOcupacion;
	public $idIngresoMensual;
	public $integrantesFamilia;
	public $dependientesEconomicos;
	public $idVivienda;
	public $noHabitantes;
	public $viviendaElectricidad;
	public $viviendaAgua;
	public $viviendaDrenaje;
	public $viviendaGas;
	public $viviendaTelefono;
	public $viviendaInternet;
	public $idNivelEstudios;
	public $idSeguridadSocial;
	public $idDiscapacidad;
	public $idGrupoVulnerable;
	public $beneficiarioColectivo;
	public $usuario;
	public $fecha;
	public $hora;
	public $estado;
	public $direccion;
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
				b.idBeneficiario, 
				b.curp, 
				b.primerApellido, 
				b.segundoApellido,
				b.nombres, 
				b.idIdentificacion,
				idOf.identificacion as nomTipoI, 
				tV.tipoVialidad,
				b.nombreVialidad,
				b.idTipoVialidad,
				b.noExterior,
				b.noInterior,
				a.nombreAsentamiento,
				b.idAsentamientos,
				l.localidad,
				b.idLocalidad,
				b.entreVialidades,
				b.descripcionUbicacion,
				b.estudioSocioeconomico,
				eC.estadoCivil, 
				b.idEstadoCivil,
				b.jefeFamilia,
				o.ocupacion, 
				b.idOcupacion,
				iM.ingresoMensual,
				b.idIngresoMensual,
				b.integrantesFamilia,
				b.dependientesEconomicos,
				v.vivienda, 
				b.idVivienda,
				b.noHabitantes,
				b.viviendaElectricidad,
				b.viviendaAgua,
				b.viviendaDrenaje,
				b.viviendaGas,
				b.viviendaTelefono,
				b.viviendaInternet,
				nE.nivelEstudios, 
				b.idNivelEstudios,
				b.idSeguridadSocial,
				sS.seguridadSocial,
				d.discapacidad, 
				d.idDiscapacidad,
				gV.grupoVulnerable,
				b.idGrupoVulnerable,
				b.beneficiarioColectivo,
				b.idmunicipio,
				m.nombreMunicipio,
				b.telefono,
				b.email,
				b.fechaNacimiento,
				b.genero
				FROM identificacionOficial idOf, 
				tipoVialidad tV, estadoCivil eC, 
				ocupacion o, vivienda v, 
				nivelEstudio nE,
				seguridadSocial sS, 
				discapacidad d, 
				grupoVulnerable gV, 
				asentamientos a, 
				localidades l, 
				municipio m,
				ingresoMensual iM, beneficiarios  b
				where  b.idIdentificacion = idOf.idIdentificacion AND   
				b.idTipoVialidad = tV.idTipoVialidad AND 	
				b.idEstadoCivil = eC.idEstadoCivil AND 
				b.idOcupacion = o.idOcupacion AND 
				b.idIngresoMensual = iM.idIngresoMensual AND 
				b.idVivienda =  v.idVivienda AND   
				b.idNivelEstudios = nE.idNivelEstudios AND  
				b.idSeguridadSocial = sS.idSeguridadSocial AND  
				b.idDiscapacidad = d.idDiscapacidad AND  
				b.idGrupoVulnerable =gV.idGrupoVulnerable AND 
				b.idAsentamientos = a.idAsentamientos AND 
				b.idLocalidad = l.idLocalidad AND
				b.idmunicipio = m.idmunicipio AND
				b.idBeneficiario = ?");

			$stm->execute(array($id));
			return $stm->fetch(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function ListarDatosPersonales()
	{
		try
		{
			$stm = $this->pdo->prepare("
				SELECT
				b.idBeneficiario, 
				b.curp, 
				b.primerApellido, 
				b.segundoApellido,
				b.nombres, 
				idOf.identificacion as nomTipoI
				FROM identificacionOficial idOf, 
				tipoVialidad tV, estadoCivil eC, 
				ocupacion o, vivienda v, 
				nivelEstudio nE,
				seguridadSocial sS, 
				discapacidad d, 
				grupoVulnerable gV, 
				asentamientos a, 
				localidades l, 
				ingresoMensual iM, 
				beneficiarios  b
				where  b.idIdentificacion = idOf.idIdentificacion AND
				b.idTipoVialidad = tV.idTipoVialidad AND 
				b.idEstadoCivil = eC.idEstadoCivil AND  
				b.idOcupacion = o.idOcupacion AND  
				b.idIngresoMensual = iM.idIngresoMensual AND 
				b.idVivienda =  v.idVivienda AND  
				b.idNivelEstudios = nE.idNivelEstudios AND  
				b.idSeguridadSocial = sS.idSeguridadSocial AND   
				b.idDiscapacidad = d.idDiscapacidad AND
				b.idGrupoVulnerable =gV.idGrupoVulnerable AND 
				b.idAsentamientos = a.idAsentamientos AND  
				b.idLocalidad = l.idLocalidad
				WHERE idBeneficiario = ?");
			
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Registrar(Beneficiario $data)
	{
		try 
		{

			$sql = "INSERT INTO beneficiarios 
			(curp, primerApellido, segundoApellido, nombres, idIdentificacion,
			idNivelEstudios,idSeguridadSocial,idDiscapacidad,beneficiarioColectivo,idTipoVialidad,
			nombreVialidad,noExterior,noInterior,idAsentamientos,idLocalidad,
			entreVialidades,descripcionUbicacion,estudioSocioeconomico,idEstadoCivil,jefeFamilia,
			idOcupacion,idIngresoMensual,integrantesFamilia,dependientesEconomicos,idGrupoVulnerable,
			idVivienda,noHabitantes,viviendaElectricidad,viviendaAgua,viviendaDrenaje,
			viviendaGas,viviendaTelefono,viviendaInternet,idRegistro,fechaNacimiento,
			genero,perfilSociodemografico,email,telefono,idmunicipio) values 
		  (?,?,?,?,?,
		   ?,?,?,?,?,
		   ?,?,?,?,?,
		   ?,?,?,?,?,
		   ?,?,?,?,?,
		   ?,?,?,?,?,
		   ?,?,?,?,?,
		   ?,?,?,?,?)";
			$this->pdo->prepare($sql)
			->execute(
				array(
					$data->curp,
					$data->primerApellido,
					$data->segundoApellido,
					$data->nombres,
					$data->idIdentificacion,
					$data->idNivelEstudios,
					$data->idSeguridadSocial,
					$data->idDiscapacidad,
					$data->beneficiarioColectivo,//9
					//vialidad
						$data->idTipoVialidad, 
						$data->nombreVialidad,
						$data->noExterior,
						$data->noInterior,
						$data->idAsentamientos,
						$data->idLocalidad,
						$data->entreVialidades,
						$data->descripcionUbicacion,//8
					//estudio
						$data->estudioSocioeconomico,
						$data->idEstadoCivil,
						$data->jefeFamilia,
						$data->idOcupacion,
						$data->idIngresoMensual,
						$data->integrantesFamilia,
						$data->dependientesEconomicos,
						$data->idGrupoVulnerable,//8
					//vivienda
						$data->idVivienda,
						$data->noHabitantes,				
						$data->viviendaElectricidad,
						$data->viviendaAgua,
						$data->viviendaDrenaje,
						$data->viviendaGas,
						$data->viviendaTelefono,
						$data->viviendaInternet,//8
						$data->idRegistro,
					//Ultimos campos
						$data->fechaNacimiento,
						$data->genero,
						$data->perfilSociodemografico,
						$data->email,
						$data->telefono,
						$data->idmunicipio
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
			->prepare("UPDATE registro r INNER JOIN beneficiarios b
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
			$sql = "UPDATE beneficiarios SET 
			curp = ?,
			primerApellido = ?,
			segundoApellido = ?,
			nombres = ?,
			idIdentificacion = ?,
			idNivelEstudios = ?,
			idSeguridadSocial = ?,
			idDiscapacidad = ?,
			beneficiarioColectivo =?,
			idTipoVialidad = ?,
			nombreVialidad = ?,
			noExterior = ?,
			noInterior = ?,
			idAsentamientos = ?,
			idLocalidad = ?,
			entreVialidades = ?,
			descripcionUbicacion = ?,
			estudioSocioeconomico = ?,
			idEstadoCivil = ?,
			jefeFamilia = ?,
			idOcupacion = ?,
			idIngresoMensual = ?,
			integrantesFamilia = ?,
			dependientesEconomicos = ?,
			idGrupoVulnerable = ?,
			idVivienda = ?,
			noHabitantes = ?,
			viviendaElectricidad = ?,
			viviendaAgua = ?,
			viviendaDrenaje = ?,
			viviendaGas = ?,
			viviendaTelefono = ?,
			viviendaInternet = ?,
			fechaNacimiento = ?,
			genero = ?,
			perfilSociodemografico = ?,
			email = ?,
			telefono = ?,
			idmunicipio = ?
			WHERE idBeneficiario = ?";

			$this->pdo->prepare($sql)
			->execute(
				array(
					$data->curp,
					$data->primerApellido,
					$data->segundoApellido,
					$data->nombres,
					$data->idIdentificacion,
					$data->idNivelEstudios,
					$data->idSeguridadSocial,
					$data->idDiscapacidad,
					$data->beneficiarioColectivo,
					$data->idTipoVialidad,
					$data->nombreVialidad,
					$data->noExterior,
					$data->noInterior,
					$data->idAsentamientos,
					$data->idLocalidad,
					$data->entreVialidades,
					$data->descripcionUbicacion,
					$data->estudioSocioeconomico,
					$data->idEstadoCivil,
					$data->jefeFamilia,
					$data->idOcupacion,
					$data->idIngresoMensual,
					$data->integrantesFamilia,
					$data->dependientesEconomicos,
					$data->idGrupoVulnerable,
					$data->idVivienda,
					$data->noHabitantes,
					$data->viviendaElectricidad,
					$data->viviendaAgua,
					$data->viviendaDrenaje,
					$data->viviendaGas,
					$data->viviendaTelefono,
					$data->viviendaInternet,


					//Ultimos campos
					$data->fechaNacimiento,
					$data->genero,
					$data->perfilSociodemografico,
					$data->email,
					$data->telefono,
					$data->idmunicipio,
					$data->idBeneficiario

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
				(curp,primerApellido,segundoApellido,nombres,email,idIdentificacion,idTipoVialidad,nombreVialidad,noExterior,
				noInterior,idAsentamientos,idLocalidad,entreVialidades,descripcionUbicacion,estudioSocioeconomico,idEstadoCivil,
				jefeFamilia,idOcupacion,idIngresoMensual,integrantesFamilia,dependientesEconomicos,idVivienda,noHabitantes,
				viviendaElectricidad,viviendaAgua,viviendaDrenaje,viviendaGas,viviendaTelefono,viviendaInternet,
				idNivelEstudios,idSeguridadSocial,idDiscapacidad,idGrupoVulnerable,beneficiarioColectivo,fechaNacimiento,
				genero,perfilSociodemografico,telefono,idmunicipio) values 
				(?,?,?,?,?,
				?,?,?,?,?,
				?,?,?,?,?,
				?,?,?,?,?,
				?,?,?,?,?,
				?,?,?,?,?,
				?,?,?,?,?,
				?,?,?,?)");
			$resultado=$sql->execute(
				array(
					$data->curp,
					$data->primerApellido,
					$data->segundoApellido,
					$data->nombres,
					$data->email,
					$data->idIdentificacion,
					$data->idNivelEstudios,
					$data->idSeguridadSocial,
					$data->idDiscapacidad,
					$data->beneficiarioColectivo,//9
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
					$data->idGrupoVulnerable,//8
					$data->idVivienda,
					$data->noHabitantes,				
					$data->viviendaElectricidad,
					$data->viviendaAgua,
					$data->viviendaDrenaje,
					$data->viviendaGas,
					$data->viviendaTelefono,
					$data->viviendaInternet,//8
					$data->fechaNacimiento,
					$data->genero,
					$data->perfilSociodemografico,
					$data->telefono,
					$data->idmunicipio
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

			$stm = $this->pdo->prepare("SELECT idBeneficiario,
				b.idRegistro,
				curp,
				primerApellido,
				segundoApellido,
				nombres
				FROM beneficiarios b
				INNER JOIN 
				registro r
				ON r.idRegistro= b.idRegistro
				where estado='Activo'");
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

			$stm = $this->pdo->prepare("SELECT * FROM beneficiarios, registro WHERE registro.idRegistro=beneficiarios.idRegistro and registro.estado='Activo';");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

//Funciones para registrar los detalles de cada registro de beneficiarios.

	public function RegistraDatosRegistro(Beneficiario $data){

		try 
		{

			$sql = "INSERT INTO registro VALUES (?,?,?,?,?)";
			$this->pdo->prepare($sql)
			->execute(
				array(
					null,
					$data->usuario,
					$data->direccion,
					$data->fecha,
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
					$data->fecha,
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

}

/*
+------------------------+--------------+------+-----+---------+----------------+
| Field                  | Type         | Null | Key | Default | Extra          |
+------------------------+--------------+------+-----+---------+----------------+
| idBeneficiario         | int(11)      | NO   | PRI | NULL    | auto_increment |
| curp                   | varchar(18)  | YES  |     | NULL    |                |
| primerApellido         | varchar(20)  | YES  |     | NULL    |                |
| segundoApellido        | varchar(25)  | YES  |     | NULL    |                |
| nombres                | varchar(25)  | YES  |     | NULL    |                |
| email                  | varchar(128) | YES  |     | NULL    |                |
| idIdentificacion       | int(11)      | YES  | MUL | NULL    |                |
| idTipoVialidad         | int(11)      | YES  | MUL | NULL    |                |
| nombreVialidad         | varchar(65)  | YES  |     | NULL    |                |
| noExterior             | varchar(8)   | YES  |     | NULL    |                |
| noInterior             | varchar(8)   | YES  |     | NULL    |                |
| idAsentamientos        | varchar(45)  | YES  | MUL | NULL    |                |
| idLocalidad            | varchar(10)  | YES  | MUL | NULL    |                |
| entreVialidades        | varchar(100) | YES  |     | NULL    |                |
| descripcionUbicacion   | text         | YES  |     | NULL    |                |
| estudioSocioeconomico  | tinyint(1)   | YES  |     | NULL    |                |
| idEstadoCivil          | int(11)      | YES  | MUL | NULL    |                |
| jefeFamilia            | varchar(2)   | YES  |     | NULL    |                |
| idOcupacion            | int(11)      | YES  | MUL | NULL    |                |
| idIngresoMensual       | int(11)      | YES  | MUL | NULL    |                |
| integrantesFamilia     | varchar(2)   | YES  |     | NULL    |                |
| dependientesEconomicos | varchar(2)   | YES  |     | NULL    |                |
| idVivienda             | int(11)      | YES  | MUL | NULL    |                |
| noHabitantes           | varchar(2)   | YES  |     | NULL    |                |
| viviendaElectricidad   | tinyint(1)   | YES  |     | NULL    |                |
| viviendaAgua           | tinyint(1)   | YES  |     | NULL    |                |
| viviendaDrenaje        | tinyint(1)   | YES  |     | NULL    |                |
| viviendaGas            | tinyint(1)   | YES  |     | NULL    |                |
| viviendaTelefono       | tinyint(1)   | YES  |     | NULL    |                |
| viviendaInternet       | tinyint(1)   | YES  |     | NULL    |                |
| idNivelEstudios        | int(11)      | YES  | MUL | NULL    |                |
| idSeguridadSocial      | int(11)      | YES  | MUL | NULL    |                |
| idDiscapacidad         | int(11)      | YES  | MUL | NULL    |                |
| idGrupoVulnerable      | int(11)      | YES  | MUL | NULL    |                |
| beneficiarioColectivo  | tinyint(1)   | YES  |     | NULL    |                |
| idRegistro             | int(11)      | YES  | MUL | NULL    |                |
| fechaNacimiento        | date         | YES  |     | NULL    |                |
| genero                 | tinyint(1)   | YES  |     | NULL    |                |
| perfilSociodemografico | tinyint(3)   | YES  |     | NULL    |                |
| telefono               | char(11)     | YES  |     | NULL    |                |
| idmunicipio            | tinyint(3)   | NO   | MUL | NULL    |                |
*/