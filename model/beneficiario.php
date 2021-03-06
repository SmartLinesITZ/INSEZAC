<?php
class Beneficiario
{
	public $usuario;
	public $fechaAlta;
	public $hora;
	public $estado;
	public $direccion;
	public $pdo;
	public $idBeneficiario;
	public $curp;
	public $primerApellido;
	public $segundoApellido;
	public $nombres;
	public $email;
	public $idIdentificacion;
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
	public $idRegistro;
	public $fechaNacimiento;
	public $genero;
	public $claveMunicipio;
	public $perfilSociodemografico;
	public $telefono;
	public $idMunicipio;

	public function __CONSTRUCT()
	{
		$this->pdo = Database::StartUp();
	}


	//Metodo para obtener todos los registros de un beneficiario en especifico, utilizado para editar y par ver detallse
	public function Listar($id)
	{
		$stm = $this->pdo->prepare("SELECT
			b.idBeneficiario,
			b.curp,
			b.primerApellido,
			b.segundoApellido,
			b.nombres,
			b.idMunicipio,
			m.nombreMunicipio,
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
			b.telefono,
			b.email,
			b.fechaNacimiento,
			b.genero
			FROM identificacionoficial idOf,
			tipovialidad tV, estadocivil eC,
			ocupacion o, vivienda v,
			nivelestudio nE,
			seguridadsocial sS,
			discapacidad d,
			grupovulnerable gV,
			asentamientos a,
			localidades l,
			ingresomensual iM,
			beneficiarios  b,
			municipio m
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
			b.idMunicipio = m.idMunicipio AND
			b.idBeneficiario = ?");

		$stm->execute(array($id));
		return $stm->fetch(PDO::FETCH_OBJ);
	}

	public function ListarDatosPersonales()
	{
		$stm = $this->pdo->prepare("
			SELECT
			b.idBeneficiario,
			b.curp,
			b.primerApellido,
			b.segundoApellido,
			b.nombres,
			idOf.idIdentificacion as nomTipoI
			FROM identificacionoficial idOf,
			tipovialidad tV, estadocivil eC,
			ocupacion o, vivienda v,
			nivelestudio nE,
			seguridadsocial sS,
			discapacidad d,
			grupovulnerable gV,
			asentamientos a,
			localidades l,
			ingresomensual iM,
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

	public function Registrar(Beneficiario $data)
	{
		$sql = "INSERT INTO beneficiarios
		(curp, primerApellido, segundoApellido, nombres, idIdentificacion,
		idNivelEstudios,idSeguridadSocial,idDiscapacidad,beneficiarioColectivo,idTipoVialidad,
		nombreVialidad,noExterior,noInterior,idAsentamientos,idLocalidad,
		entreVialidades,descripcionUbicacion,estudioSocioeconomico,idEstadoCivil,jefeFamilia,
		idOcupacion,idIngresoMensual,integrantesFamilia,dependientesEconomicos,idGrupoVulnerable,
		idVivienda,noHabitantes,viviendaElectricidad,viviendaAgua,viviendaDrenaje,
		viviendaGas,viviendaTelefono,viviendaInternet,idRegistro,fechaNacimiento,
		genero,perfilSociodemografico,email,telefono,idMunicipio) values
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
						$data->idMunicipio
						)
			);
		return $this->pdo->lastInsertId();
	}

	public function Obtener($idBeneficiario)
	{
		$stm = $this->pdo
		->prepare("SELECT * FROM beneficiarios WHERE idBeneficiario = ?");
		$stm->execute(array($idBeneficiario));
		return $stm->fetch(PDO::FETCH_OBJ);
	}

	public function ObtenerIdBeneficiario($curp)
	{
		$stm = $this->pdo
		->prepare("SELECT * FROM beneficiarios WHERE curp = ?");
		$stm->execute(array($curp));
		return $stm->fetch(PDO::FETCH_OBJ);
	}

	public function Eliminar($data)
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
	}

	//Metodo para actualizar
	public function Actualizar($data)
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
		idMunicipio = ?
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
				$data->idMunicipio,
				$data->idBeneficiario

				)
			);
	}

	public function ImportarBeneficiario(Beneficiario $data){
		$sql= $this->pdo->prepare("INSERT INTO beneficiarios
			(curp,primerApellido,segundoApellido,nombres,email,
			idIdentificacion,idTipoVialidad,nombreVialidad,noExterior,noInterior,
			idAsentamientos,idLocalidad,entreVialidades,descripcionUbicacion,estudioSocioeconomico,
			idEstadoCivil,jefeFamilia,idOcupacion,idIngresoMensual, integrantesFamilia,
			dependientesEconomicos,idVivienda,noHabitantes,viviendaElectricidad,viviendaAgua,
			viviendaDrenaje,viviendaGas,viviendaTelefono,viviendaInternet,idNivelEstudios,
			idSeguridadSocial,idDiscapacidad,idGrupoVulnerable,beneficiarioColectivo,idRegistro,
			fechaNacimiento,genero,perfilSociodemografico,telefono,idMunicipio) VALUES
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
	}

	//Metodo para actualizar
	public function Activar($idRegistro)
	{
		$sql = "UPDATE registro SET	estado = 'Activo' WHERE idRegistro = ?";

		$this->pdo->prepare($sql)
		->execute(
			array($idRegistro)
			);
	}

	public function VerificaBeneficiario($curp)
	{
		$sql= $this->pdo->prepare("SELECT * FROM beneficiarios, registro WHERE curp=? AND beneficiarios.idRegistro=registro.idRegistro");
		$resultado=$sql->execute(
			array($curp)
			);
		return $sql->fetch(PDO::FETCH_OBJ,PDO::FETCH_ASSOC);
	}

	public function Listar1($periodo)
	{
		$fechaInicio=$periodo.'-01-01';
		$fechaFin=$periodo.'-12-31';
		$stm = $this->pdo->prepare("SELECT * FROM beneficiarios b, registro r, municipio m WHERE b.idRegistro= r.idRegistro AND b.idMunicipio=m.idMunicipio AND r.estado='Activo' AND DATE(r.fechaAlta) BETWEEN ? AND ?");
		$stm->execute(array($fechaInicio, $fechaFin));

		return $stm->fetchAll(PDO::FETCH_OBJ);
	}

	public function Listar2($periodo)
	{
		$fechaInicio=$periodo.'-01-01';
		$fechaFin=$periodo.'-12-31';
		$stm = $this->pdo->prepare("SELECT * FROM beneficiarios b, registro r, municipio m, actualizacion a WHERE b.idRegistro= r.idRegistro AND b.idMunicipio=m.idMunicipio AND r.idRegistro=a.idRegistro AND r.estado='Activo' AND DATE(a.fechaActualizacion) BETWEEN ? AND ?");
		$stm->execute(array($fechaInicio, $fechaFin));
		return $stm->fetchAll(PDO::FETCH_OBJ);
	}

	public function ListarTodos()
	{
		$stm = $this->pdo->prepare("SELECT 	* FROM beneficiarios b, registro r, municipio m WHERE b.idRegistro= r.idRegistro AND b.idMunicipio=m.idMunicipio AND r.estado='Activo'");
		$stm->execute(array());

		return $stm->fetchAll(PDO::FETCH_OBJ);
	}
	
//Funciones para registrar los detalles de cada registro de beneficiarios.

	public function RegistraDatosRegistro(Beneficiario $data){
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
	}

	public function ObtenerIdRegistro($idBeneficiario)
	{
		$sql= $this->pdo->prepare("SELECT registro.idRegistro from registro, beneficiarios where registro.idregistro=beneficiarios.idregistro and idBeneficiario=$idBeneficiario");
		$resultado=$sql->execute();
		return $sql->fetch(PDO::FETCH_OBJ,PDO::FETCH_ASSOC);
	}

	public function ObtenerIdMunicipio($claveMunicipio)
	{
		$sql= $this->pdo->prepare("SELECT idMunicipio FROM municipio WHERE claveMunicipio=$claveMunicipio");
		$resultado=$sql->execute();
		return $sql->fetch(PDO::FETCH_OBJ,PDO::FETCH_ASSOC);
	}

	public function RegistraActualizacion(Beneficiario $data){
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
	}

	public function ObtenerInfoRegistro($idBeneficiario)
	{
		$sql= $this->pdo->prepare("SELECT * FROM registro, beneficiarios WHERE beneficiarios.idregistro=registro.idregistro AND beneficiarios.idbeneficiario=?;");
		$resultado=$sql->execute(array($idBeneficiario));
		return $sql->fetch(PDO::FETCH_OBJ,PDO::FETCH_ASSOC);
	}

	public function ListarActualizacion($idRegistro)
	{
		$stm = $this->pdo->prepare("SELECT * FROM actualizacion WHERE idRegistro=?");
		$stm->execute(array($idRegistro));

		return $stm->fetchAll(PDO::FETCH_OBJ);
	}

	public function ObtenerInfoActualizacion2()
	{
		$sql= $this->pdo->prepare("SELECT * FROM actualizacion;");
		$stm->execute(array($id));
		return $stm->fetch(PDO::FETCH_OBJ);
	}

	public function ObtenerInfoApoyo($idBeneficiario)
	{
		$stm = $this->pdo->prepare("SELECT * FROM apoyos,beneficiarios,origen,registroapoyo,subprograma,programa,periodicidad,tipoapoyo,caracteristicasapoyo WHERE apoyos.idBeneficiario=beneficiarios.idBeneficiario AND apoyos.idRegistroApoyo=registroapoyo.idRegistroApoyo AND apoyos.idSubprograma=subprograma.idSubprograma AND subprograma.idPrograma=programa.idPrograma AND apoyos.idPeriodicidad=periodicidad.idPeriodicidad AND apoyos.idOrigen=origen.idOrigen AND caracteristicasapoyo.idTipoApoyo=tipoapoyo.idTipoApoyo AND apoyos.idCaracteristica=caracteristicasapoyo.idCaracteristicasApoyo AND beneficiarios.idBeneficiario=? ORDER BY apoyos.idApoyo;");

		$stm->execute(array($idBeneficiario));

		return $stm->fetchAll(PDO::FETCH_OBJ);
	}

	public function ListarLocalidades($municipio)
	{
		$stm = $this->pdo->prepare("SELECT * FROM localidades WHERE municipio=? AND estado='Activo';");
		$stm->execute(array($municipio));

		return $stm->fetchAll(PDO::FETCH_OBJ);
	}

	public function ListarAsentamientos($localidad)
	{
		$stm = $this->pdo->prepare("SELECT * FROM asentamientos WHERE localidad=?");
		$stm->execute(array($localidad));

		return $stm->fetchAll(PDO::FETCH_OBJ);
	}

	public function ObtenerMunicipio($idMunicipio)
	{
		$sql= $this->pdo->prepare("SELECT * FROM municipio WHERE idMunicipio=?");
		$resultado=$sql->execute(
			array($idMunicipio)
			);
		return $sql->fetch(PDO::FETCH_OBJ,PDO::FETCH_ASSOC);
	}

	public function ObtenerLocalidad($idLocalidad)
	{
		$sql= $this->pdo->prepare("SELECT localidad FROM localidades WHERE idLocalidad=?");
		$resultado=$sql->execute(
			array($idLocalidad)
			);
		return $sql->fetch(PDO::FETCH_OBJ,PDO::FETCH_ASSOC);
	}
}


