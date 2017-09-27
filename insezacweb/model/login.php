<?php
class Login

{
	private $pdo;
	public $usuario;
	public $password;
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
	public function verificar(Login $data)
	{
		try 
		{
			$sql= $this->pdo->prepare("SELECT * FROM usuarios WHERE usuario=?");
			$resultado=$sql->execute(
				array(
                    $data->usuario,
                )
			);
			return $sql->fetch(PDO::FETCH_OBJ,PDO::FETCH_ASSOC);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}