<?php 

namespace App\Controller;

use App\Session;
use App\Model\User;

abstract class AbstractController
{

	protected function session ()
	{
		$session = new Session();
		if ($session->is_logged_in()) {
			$user = new User($session->user_id);
			$this->data["user"] = $user;
		}
	}

	public static function render ($paths=[], $data=[])
	{
		include_once(__DIR__.'/../view/header.php');

		foreach ($paths as $path) {
			if (!@include_once(__DIR__.'/../view/'.$path.".php")) {
				return false;
			}
		}

		include_once(__DIR__.'/../view/footer.php');

	}
}