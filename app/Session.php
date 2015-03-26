<?php

namespace App;

use App\Model\User;

class Session
{
	private $logged_in = false;

	public $user_id;
	public $user_name;

	private $admin = false;


	function __construct () {
		if (!isset($_SESSION)) {
			session_start();
		}
		$this->check_login();
	}

	public function is_logged_in()
	{
		return $this->logged_in;
	}

	public function is_admin ()
	{
		return $this->admin;
	}

    public function check_login()
    {
        if (isset($_SESSION["user_id"])) {
        	$this->logged_in = true;
        	$this->user_id = $_SESSION["user_id"];
        	$this->user_name = $_SESSION["user_name"];
        }
    }

    public function login()
    {
		$user = new User;
        if ($user->auth()) {
        	$this->logged_in = true;
        	$_SESSION['user_id'] = $user->id;
        	$_SESSION['user_name'] = $user->name;
        	if ($user->admin) {
        		$this->admin = true;
        	}
        } else return false;
    }


    public function logout()
    {
        if ($this->is_logged_in()) {
        	$this->logged_in = false;
        	$this->admin = false;
        	$this->user_id = null;
        	$this->user_name = null;
        	session_unset();
        }
    }
}
