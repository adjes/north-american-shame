<?php 

namespace App;

Class Router
{

	public static function init ()
	{
		$ctrl = self::get_controller(); // returns obj;
		$method = self::get_method($ctrl); // returns string;
		return $ctrl->$method();

	}
	public static function get_controller () {
		// var_dump($_GET);
		if (isset($_GET["c"])) {
			$class = "App\\Controller\\".$_GET["c"];
			if (!class_exists($class)) {
				header('HTTP/1.0 404 Not Found');
				include(__DIR__.'/view/404.php');
				die();
				// echo $class." not found"."<br>";
				// return $ctrl = new Controller\Base;
				// redirect_to("index");
			} else {
				return $ctrl = new $class;
			}
		} else {
			return $ctrl = new Controller\Base;
		}
	}

	public static function get_method ($ctrl)
	{
		if (isset($_GET["m"])) {
			if (!method_exists($ctrl, $_GET["m"])){
				return "index";
			} else {
				return $_GET["m"];
			}
		} else return "index";
	}
}

 ?>