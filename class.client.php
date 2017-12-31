<?php

require_once('dbconfig.php');

class CLIENT
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
        }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function register($cnom,$cprenom,$cmail,$cpass,$ctel,$cadresse)
	{
		try
		{
			$new_password = password_hash($cpass, PASSWORD_DEFAULT);
			
			$stmt = $this->conn->prepare("INSERT INTO client(nomclient,prenom,emailclient,passeclient,telclient,adresseclient) 
		                                               VALUES(:cnom, :cprenom, :cmail, :cpass, :ctel, :cadresse)");
												  
			$stmt->bindparam(":cnom", $cnom);
                        $stmt->bindparam(":cprenom", $cprenom);
                        $stmt->bindparam(":cmail", $cmail);
			$stmt->bindparam(":cpass", $new_password);	
                        $stmt->bindparam(":ctel", $ctel);
                        $stmt->bindparam(":cadresse", $cadresse);
				
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	
	
	public function doLogin($cmail,$cpass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT idclient, emailclient, passeclient FROM client WHERE emailclient=:cmail ");
			$stmt->execute(array(':cmail'=>$cmail));
			$clientRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if(password_verify($cpass, $clientRow['passeclient']))
				{
					$_SESSION['client_session'] = $clientRow['idclient'];
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function is_loggedin()
	{
		if(isset($_SESSION['client_session']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['client_session']);
		return true;
	}
}
?>