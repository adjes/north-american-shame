<?php 

namespace App\Model;

use App\Database\PDOLayer;
use App\Config;

abstract class AbstractModel

{


	protected function import($object) 
	{
        foreach (get_object_vars($object) as $key => $value) {
            $this->$key = $value;
        }
        return $this;
	}

	private function table_columns($db) 
	{
		$q = "SELECT * FROM " . static::$table . " LIMIT 0";
		if ($result = $db->sql($q)) {
			$result = $db->get_columns();
			foreach ($result as $key) {
			if (property_exists($this, $key)) {
				$arr[$key] = $this->$key;
			}
			// var_dump($result, $arr);
		}
			return $arr;
		} 
	}

	protected function get_db ()
	{
		$map = Config::$db_class_routing;
		$class = get_called_class();
		if (!$class = array_search($class, $map)) {
			$class = "MySql";
		}
		return new PDOLayer ($class);
	}

	public static function count () 
	{
		$db = static::get_db();
		$q = "SELECT COUNT(*) FROM " . static::$table;
		if ($result = $db->sql($q)) {
			$result = $db->fetch_assoc();
			$result = ($result) ? array_shift($result) : false;
		}
		return ($result) ? array_shift($result) : false;

	}

	public static function find_all () 
	{
		$db = static::get_db();
		$q = "SELECT * FROM " . static::$table;
		if ($result = $db->sql($q)) {
			$result = $db->fetch_class(get_called_class());
		return $result;
		}
	}

    public function find_by_id($id)
    {
        $db = static::get_db();
		$q = "SELECT * FROM " . static::$table . " WHERE id = '{$id}'";
		if ($result = $db->sql($q)) {
			$result = $db->fetch_class(get_called_class());
			$result = array_shift($result);
			if (!empty($result)) {
				return static::import($result);
			} else return false;
		}
    }

    public function create()
    {
		$db = static::get_db();
		$arr = self::table_columns($db);
		// $arr = get_object_vars($this);
		$q = "INSERT INTO " . static::$table . " (" . join(", ", array_keys($arr)) . ") VALUES ('" . join("', '", array_values($arr)). "')";
		if ($db->sql($q)) {
			$this->id = $db->last_id();
			return true;
		} else return false;
    }

    public function update()
    {
    	static::init();
		$db = static::get_db();
		$arr = self::table_columns($db);
		$arr2 = [];
		foreach ($arr as $key => $value) {
			if ($key!="id") {
				$arr2[] = $key."= '".$value."'";
			}
		}
		$q = "UPDATE " . static::$table . " SET " . join(",", array_values($arr2)) . " WHERE id = '{$arr["id"]}'"; 
		if ($db->sql($q) && $db->affected_rows() == 1) {
			return true;
		} else return false;
    }

    public function delete()
    {
		$db = static::get_db();
		$arr = get_object_vars($this);
		$q = "DELETE FROM " . static::$table . " WHERE id =" . $arr["id"] . " LIMIT 1";
		if ($db->sql($q) && $db->affected_rows() == 1) {
			return true;
		} else return false;
    }

    public function clear_table() // wipe for dummydata upload
    {
		$db = static::get_db();
    	$q = "SET FOREIGN_KEY_CHECKS = 0;
    	TRUNCATE table " . static::$table .";
    	SET FOREIGN_KEY_CHECKS = 1";
    	if ($db->sql($q)) {
			return true;
		}
    }

}