<?php 


namespace App\Database;

use \PDO;
use App\Config;

class PDOLayer
{

	public $pdo;

	public $state;


	function __construct($db)
	{
		$this->connect($db);
	}

	private function connect($db) {

		// $cfg = require __DIR__."/../config/db_vars.cfg.php";
		$cfg = Config::$dbs;

		$out  = $cfg[$db]["driver"].":";
		$out .= "host=".$cfg[$db]["host"].";";
		$out .= "dbname=".$cfg[$db]["database"];
		$user = $cfg[$db]["user"];
		$pass = $cfg[$db]["pass"];

		$opt = array(
		    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);

		// var_dump($out);

		// $this->pdo = new PDO($out, $user, $pass, $opt);
		$this->pdo = new PDO($out, $user, $pass, $opt);

	}

	public function sql ($q) 
	{
		// var_dump($q);
		$this->state = $this->pdo->prepare($q);
		return $this->state->execute();
	}

	public function fetch_class($class) 
	{
		return $this->state->fetchAll(PDO::FETCH_CLASS, $class);
	}

	public function fetch_assoc()
	{
		return $this->state->fetchAll();
	}

	public function affected_rows() 
	{
		return $this->state->rowCount();
	}

	public function last_id() 
	{
		return $this->pdo->lastInsertId();
	}

}

