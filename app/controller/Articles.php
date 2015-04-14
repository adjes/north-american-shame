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

	public function edit ()
	{
		if (self::$session->is_admin()) {
			$paths[] = "article_edit";

			$article = new Article($_GET["id"]);
			$article -> update();
			$this->data["article"] = $article;
			self::render($paths, $this->data);
		}
	}

	public function add()
	{
		if (self::$session->is_admin()) {
			$paths[] = "article_add";

			$article = new Article();
			if (isset($_POST["submit"])) {
				$article -> create();
			}
			$this->data["article"] = $article;
			self::render($paths, $this->data);
		}
	}

	public function delete()
	{
		if (self::$session->is_admin()) {

			$article = new Article($_GET["id"]);
			if (isset($_POST["submit"]) && $article -> delete()) {
				redirect_to("index.php");
			}
		}
	}
}