<?php 

namespace App\Controller;

// use App\Model\Article;
// use App\Model\Comment;

class Admin extends AbstractController
{
	
	function __construct()
	{
		if (!isset(self::$session->is_admin) || !self::$session->is_admin() ) {
			redirect_to("index.php");
		}
	}

	function index ()
	{
		echo "this is admin index page";
	}
}