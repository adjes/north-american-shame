<?php 

namespace App\Controller;

use App\Session;
use App\Model\User;
use App\Model\Menu;

abstract class AbstractController
{

	protected static $session;

	function __construct()
	{
		static::session();
		// static::get_menu();
	}

	protected function session ()
	{
		self::$session = new Session();
		if (self::$session->is_logged_in()) {
			$user = new User(self::$session->user_id);
			$this->data["user"] = $user;
		}
	}

	protected static function get_menu()
	{
		$menu = Menu::get_menu_items();
		include_once(__DIR__.'/../view/menu.php');
	}

	protected static function get_admin_panel()
	{
		if (self::$session->is_admin()) {
			include_once(__DIR__.'/../view/admin_panel.php');
		}
	}

	protected static function render ($paths=[], $data=[])
	{
		include_once(__DIR__.'/../view/header.php');

		static::get_menu();

		static::get_admin_panel();

		foreach ($paths as $path) {
			if (!@include_once(__DIR__.'/../view/'.$path.".php")) {
				return false;
			}
		}

		include_once(__DIR__.'/../view/footer.php');

	}
}