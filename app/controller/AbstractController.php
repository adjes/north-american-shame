<?php 

namespace App\Controller;

use App\Session;
use App\Model\User;

abstract class AbstractController
{

	protected static $session;

	function __construct()
	{
		// if (!isset(self::$session)) {
			static::session();
		// }
	}

	protected function session ()
	{
		self::$session = new Session();
	}

	// protected static function render ($paths=[], $data=[])
	// {
	// 	include_once(__DIR__.'/../view/header.php');

	// 	foreach ($paths as $path) {
	// 		if (!@include_once(__DIR__.'/../view/'.$path.".php")) {
	// 			return false;
	// 		}
	// 	}

	// 	include_once(__DIR__.'/../view/footer.php');

	// }
}