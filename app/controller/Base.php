<?php 

namespace App\Controller;

use App\Model\Subject;
use App\Model\Article;

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

		self::render($paths, $this->data);

	}

	public function test ()
	{
		echo "Test";
		return true;
	}
}