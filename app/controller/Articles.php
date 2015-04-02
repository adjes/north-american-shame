<?php 

namespace App\Controller;

use App\Model\Article;
use App\Model\Comment;

class Articles extends AbstractController
{
	
	// function __construct()
	// {
	// 	echo "Homepage";
	// }

	public $data=[];

	public function index ()
	{
		redirect_to("index.php");
	}

	public function show ()
	{
		// self::session();

		$paths[] = "article_show";

		// $subjects = Subject::find_all();
		// $this->data["subjects"] = $subjects;

		$article = new Article($_GET["id"]);
		$this->data["article"] = $article;

		if (isset($article->id)) {
			if ($comments = Comment::find_by_article($article->id)) {
				$this->data["comments"] = $comments;
			}
			
		}

		// $this->data["menu"] = $this->menu;

		self::render($paths, $this->data);
	}
}