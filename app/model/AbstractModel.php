<?php 

namespace App\Model;

use App\Database\PDOLayer;
use App\Config;

abstract class AbstractModel

{

	private static $db;

	function __construct () {
		self::$db = $this->get_db();		
	}

	protected function import($object) {
        foreach (get_object_vars($object) as $key => $value) {
            $this->$key = $value;
        }
	}

	protected function get_db ()
	{
		// $map = require __DIR__."/../config/db_class_routing.cfg.php";
		$map = Config::$db_class_routing;
		$class = get_called_class();
		if (!$class = array_search($class, $map)) {
			$class = "MySql";
		}
		return new PDOLayer ($class);
	}

	public function count () 
	{
		$db = self::$db;
		// $class = $this->called_class;
		$q = "SELECT COUNT(*) FROM " . static::$table;
		if ($result = $db->sql($q)) {
			$result = $db->fetch_assoc();
			$result = ($result) ? array_shift($result) : false;
		}
		// gettype($result);
		return ($result) ? array_shift($result) : false;

	}

    public function find_by_id($id)
    {
        $db = self::$db;
		// $class = $this->called_class;
		$q = "SELECT * FROM " . static::$table . " WHERE id = '{$id}'";
		if ($result = $db->sql($q)) {
			$result = $db->fetch_class(get_called_class());
		return array_shift($result);
		}
    }

	public function find_all () 
	{
		$db = self::$db;
		// $class = $this->called_class;
		$q = "SELECT * FROM " . static::$table;
		if ($result = $db->sql($q)) {
			$result = $db->fetch_class(get_called_class());
		return $result;
		}
	}

    public function create()
    {
		$db = self::$db;
		// $class = $this->called_class;
		$arr = get_object_vars($this);
		$q = "INSERT INTO " . static::$table . " (" . join(", ", array_keys($arr)) . ") VALUES ('" . join("', '", array_values($arr)). "')";
		if ($db->sql($q)) {
			$this->id = $db->last_id();
			return true;
		} 
    }

    public function update()
    {
		$db = self::$db;
		// $class = $this->called_class;
		$arr = get_object_vars($this);
		$arr2 = [];
		foreach ($arr as $key => $value) {
			if ($key!="id") {
				$arr2[] = $key."= '".$value."'";
			}
		}
		$q = "UPDATE " . static::$table . " SET " . join(",", array_values($arr2)) . " WHERE id = '{$arr["id"]}'"; 
		if ($db->sql($q) && $db->affected_rows() == 1) {
			return true;
		}
    }

    public function delete()
    {
		$db = self::$db;
		// $class = $this->called_class;
		$arr = get_object_vars($this);
		$q = "DELETE FROM " . static::$table . " WHERE id =" . $arr["id"] . " LIMIT 1";
		if ($db->sql($q) && $db->affected_rows() == 1) {
			return true;
		}
    }

    public function clear_table()
    {
		$db = self::$db;
    	$q = "TRUNCATE table " . static::$table;
    	if ($db->sql($q)) {
			return true;
		}
    }

}