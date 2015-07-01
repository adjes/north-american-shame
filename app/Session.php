<?php

namespace App;

use App\Model\User;

class Session
{
	private $logged_in = false;

	public $user_id;
	public $user_name;

	public $user_admin = false; // public for front-side requests


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

	// public function is_admin ()
	// {
	// 	return $this->user_admin;
	// }

    public function check_login()
    {
        if (isset($_SESSION["user_id"])) {
            $user = new User($_SESSION["user_id"]);
            if (!empty($user->id)) {
        	   $this->logged_in = true;
        	   $this->user_id = $user->id;
        	   $this->user_name = $user->name;
               $this->user_admin = $user->admin;
           }
        }
    }

    public function login()
    {
		$user = new User;
        if ($user->auth()) {
        	$_SESSION['user_id'] = $user->id;
            $this->check_login();

            return true;
        } else return false;
    }


    public function logout()
    {
        if ($this->is_logged_in()) {
        	$this->logged_in = false;
        	$this->user_admin = false;
        	$this->user_id = null;
        	$this->user_name = null;
        	session_unset();
            return "logged out";
        } else return "was not logged in";
    }
}
