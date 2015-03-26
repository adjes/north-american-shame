<?php 

namespace App;

class Config
{
	public static $dbs = array(

		"MySql" => array(
			"driver" => "mysql",
			"host" => "localhost",
			"database" => "imgsz",
			"user" => "imgsz",
			"pass" => "qwerty"
			)

		);

	public static $db_class_routing = array(


		);

	public static $forms = array (
		
		"login" => "name",
		"pass" => "password"

		);

}