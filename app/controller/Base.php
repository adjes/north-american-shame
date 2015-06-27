<?php 

namespace App\Controller;

use App\Model\Subject;
use App\Model\Article;
use App\Model\User;

class Base extends AbstractController
{
	
	// function __construct()
	// {
	// 	echo "Homepage";
	// }

	public $data=[];

	public function index ()
	{
		self::session();

		$paths[] = "main";

		$subjects = Subject::find_all();
		$this->data["subjects"] = $subjects;

		$articles = Article::find_all();
		$this->data["articles"] = $articles;

		// if (self::$session->user_admin) {
            $users = User::find_all();
            foreach ($users as $user) {
                if ($user->password) {
                    unset($user->password);
                }
            }
            $this->data["users"] = $users;
        // } 

		$this->data["session"] = self::$session;


		echo json_encode($this->data);

		// self::render($paths, $this->data);

	}

	public function test ()
	{
		echo "Test";
		return true;
	}
}