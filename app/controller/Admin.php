<?php 

namespace App\Controller;

use App\Model\Article;
use App\Model\User;

class Admin extends AbstractController
{
	
	function __construct()
	{
		parent::__construct();
		if (!self::$session->is_admin() ) {
			redirect_to("index.php");
		}
	}

	function index ()
	{
		echo "this is admin index page";
	}

    public function articles()
    {
    	$paths[]= "admin_list_articles";
        $articles = Article::find_all();
        $this->data["articles"] = $articles;
        self::render($paths, $this->data);
    }

    public function users()
    {
    	$paths[]= "admin_list_users";
        $users = User::find_all();
        $this->data["users"] = $users;
        self::render($paths, $this->data);
    }

    public function subjects()
    {
    	$paths[]= "admin_list_subjects";
        $subjects = User::find_all();
        $this->data["subjects"] = $subjects;
        self::render($paths, $this->data);
    }
}
