<?php 

namespace App\Model;

use App\Database\MySqlDatabase;

// + use App\Database\$class.Database;

abstract class AbstractModel

{

	private static function return_db ()
	{
		$map = require __DIR__."/../config/db_class_routing.cfg.php";
		$class = get_called_class();
		if (!isset($map[$class])) {
			$class = "default";
		}
		$db_class = "App\\Database\\".$map[$class]."Database";
		$db = new $db_class(get_called_class());
		return $db;
	}

	public function count () 
	{
		$db = static::return_db();
		return $db -> count();
	}

	public static function find_all()
	{
		$db = static::return_db();
		return $db -> find_all();
	}

    public function find_by_id($id)
    {
		$db = static::return_db();
		return $db -> find_by_id($id);
    }

    public function create($obj)
    {
		$db = static::return_db();
		return $db -> create($obj);
    }

    public function update($obj)
    {
		$db = static::return_db();
		return $db -> update($obj);
    }

    public function delete($obj)
    {
		$db = static::return_db();
		return $db -> delete($obj);
    }

    public function auth ()
    {
		$db = static::return_db();
		return $db -> auth();
    }
}