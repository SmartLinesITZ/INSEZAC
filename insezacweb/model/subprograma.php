<?php
require_once 'model/database.php';
class Subprograma
{
	private $pdo;
	public $idSubprograma;
	public $subprograma;
	public $idPrograma;
	public $programa;
	public $techoPresupuestal;

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
	public function ImportarSubprograma(Subprograma $data){
		try
		{
			$sql= $this->pdo->prepare("INSERT INTO subprograma VALUES(?,?,?,?,?)");
			$resultado=$sql->execute(
				array(
					$data->idSubprograma,
					$data->subprograma,
					$data->idPrograma,
					$data->programa,
					null
				)
			);
		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function Limpiar($nomTabla)
	{
		try
		{

			$stm = $this->pdo->prepare("DELETE FROM $nomTabla");
			$stm->execute();
		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function Listar()
	{
		try
		{

			$stm = $this->pdo->prepare("SELECT * from subprograma");

			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function Obtener($id)
	{
		try
		{
			$stm = $this->pdo
			->prepare("SELECT * FROM subprograma WHERE idSubprograma = ?");


			$stm->execute(array($id));
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	// select * from programa WHERE programa like '%TRA%';

	public function Eliminar($id)
	{
		try
		{
			$stm = $this->pdo
			->prepare("DELETE FROM subprograma WHERE idSubprograma = ?");

			$stm->execute(array($id));
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
			$sql = "UPDATE subprograma SET techoPresupuestal=?
			WHERE idSubprograma = ?";

			$this->pdo->prepare($sql)
			->execute(
				array(
					$data->techoPresupuestal,
					$data->idSubprograma
				)
			);
		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	//Metdod para registrar
	public function Registrar(Subprograma $data)
	{
		try
		{
			$sql = "INSERT INTO subprograma
			VALUES (?,?,?,?,?)";

			$this->pdo->prepare($sql)
			->execute(
				array(
					null,
					$data->subprograma,
					$data->programa,
					$data->idPrograma,
					$data->techoPresupuestal
				)
			);
		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function ConsultaProgramas()
	{
		try
		{
			$stm = $this->pdo->prepare("SELECT * FROM programa");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
	//Método para consultar el programa especifico de el id en el combo seleccionado.
	public function ConsultaPrograma($idPrograma)
	{
		try
		{
			$stm = $this->pdo
			->prepare("SELECT * FROM programa WHERE idPrograma = ?");
			$stm->execute(array($idPrograma));
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function ConsultaSubprogramas($valor)
	{
		try
		{
			$stm = $this->pdo->prepare("SELECT * FROM subprograma WHERE programa like '%$valor%' || subprograma like '%$valor%'");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function ListarBeneficiarios($idSubprograma)
	{
		try
		{

			$stm = $this->pdo->prepare("SELECT * from beneficiarios, apoyos WHERE idSubprograma=? AND apoyos.idBeneficiario=beneficiarios.idBeneficiario");

			$stm->execute(array($idSubprograma));

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
}
