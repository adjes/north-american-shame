<?php 

namespace App\Controller;

abstract class AbstractController
{

	public static function render ($path, $data=[])
	{
		if (@include_once(__DIR__.'/../view/'.$path.".php")) {
			return true;
		} else return false;

	}
}