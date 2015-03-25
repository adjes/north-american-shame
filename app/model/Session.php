<?php

namespace App\Model;

class Session
{
	private $logged_in = false;

	function __construct () {
		if (!isset($_SESSION)) {
			session_start();
		}
		$this->check_login();
	}

	public function logged_in()
	{
		return $this->logged_in;
	}

    public function check_login()
    {
        if (isset($_SESSION["user_id"])) {
        	$this->logged_in = true;
        }
    }

    public function login($user)
    {
        $this->logged_in = true;
    }
}
