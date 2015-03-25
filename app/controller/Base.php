<?php 

namespace App\Controller;

class Base extends AbstractController
{
	
	// function __construct()
	// {
	// 	echo "Homepage";
	// }

	public function index ()
	{
		echo "Homepage";
		return true;
	}

	public function test ()
	{
		echo "Test";
		return true;
	}
}