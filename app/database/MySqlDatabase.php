<?php 

namespace App\Database;

use App\Database\PDOLayer;

class MySqlDatabase
{

	private static $prefix = "MySql";

	public $called_class;
	
	public $db;

	function __construct ($class)
	{
		$this->called_class = $class;
		$this->db = new PDOLayer(self::$prefix);
	}

	public function count () 
	{
		$db = $this->db;
		$class = $this->called_class;
		$q = "SELECT COUNT(*) FROM " . $class::$table;
		if ($result = $db->sql($q)) {
			$result = $db->fetch_assoc();
			$result = ($result) ? array_shift($result) : false;
		}
		gettype($result);
		return ($result) ? array_shift($result) : false;

	}

    public function find_by_id($id)
    {
        $db = $this->db;
		$class = $this->called_class;
		$q = "SELECT * FROM " . $class::$table . " WHERE id = '{$id}'";
		if ($result = $db->sql($q)) {
			$result = $db->fetch_class($class);
		return array_shift($result);
		}
    }

	public function find_all () 
	{
		$db = $this->db;
		$class = $this->called_class;
		$q = "SELECT * FROM " . $class::$table;
		if ($result = $db->sql($q)) {
			$result = $db->fetch_class($class);
		return $result;
		}
	}

    public function create($obj)
    {
		$db = $this->db;
		$class = $this->called_class;
		$arr = get_object_vars($obj);
		$q = "INSERT INTO " . $class::$table . " (" . join(", ", array_keys($arr)) . ") VALUES ('" . join("', '", array_values($arr)). "')";
		if ($db->sql($q)) {
			return true;
		}
    }

    public function update($obj)
    {
    	$db = $this->db;
		$class = $this->called_class;
		$arr = get_object_vars($obj);
		$arr2 = [];
		foreach ($arr as $key => $value) {
			if ($key!="id") {
				$arr2[] = $key."= '".$value."'";
			}
		}
		$q = "UPDATE " . $class::$table . " SET " . join(",", array_values($arr2)) . " WHERE id = '{$arr["id"]}'"; 
		if ($db->sql($q) && $db->affected_rows() == 1) {
			return true;
		}
    }

    public function delete($obj)
    {
		$db = $this->db;
		$class = $this->called_class;
		$arr = get_object_vars($obj);
		$q = "DELETE FROM " . $class::$table . " WHERE id =" . $arr["id"] . " LIMIT 1";
		if ($db->sql($q) && $db->affected_rows() == 1) {
			return true;
		}
    }

    public function auth ()
    {
    	if (isset($_POST["username"]) && isset($_POST["password"])) {
	    	$db = $this->db;
			$class = $this->called_class;
			$username = $_POST["username"];
			$password = $_POST["password"];
			$q = "SELECT * FROM " . $class::$table . " WHERE username = '$username' AND password = '$password' LIMIT 1";
			if ($db->sql($q)) {
				$result = $db->fetch_class($class);
			return empty($result) ? false : array_shift($result);
			} else return false;
		} else return false;
    }

}

