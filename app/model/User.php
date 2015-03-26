<?php 

namespace App\Model;

use App\Config;

class User extends AbstractModel
{
	public static $table = "users";

	public $id;
	public $name;
	public $password;

	public $admin = false;

	function __construct()
	{
    	if (!$this->name) {
	    	if (isset($_POST[Config::$forms['login']]) && isset($_POST[Config::$forms['pass']])) {
	    		$this->name = $_POST[Config::$forms['login']];
	    		$this->password = $_POST[Config::$forms['pass']];
	    	}
    	}
		parent::__construct();
	}

    public function auth ()
    {
    	if ($this->name && $this->password) {
	    	$db = $this->get_db();
			$username = $this->name;
			$password = $this->password;
			$q = "SELECT * FROM " . self::$table . " WHERE name = '$username' LIMIT 1";
			// var_dump($q);
			if ($db->sql($q)) {
				$result = $db->fetch_class(get_called_class());
				if (!empty($result)) {
					$result = array_shift($result);
					if (password_verify($password, $result->password)) {
						$this->import($result);
						return true;
					} else return false;
				} else return false;
			} else return false;
		} else return false;
    }

    public function create ()
    {
    	if ($this->name && $this->password) {
    		$this->password = password_hash($this->password, PASSWORD_DEFAULT);
    		return parent::create();
    	}
    }

}
