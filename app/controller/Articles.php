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

	// public function show ()
	// {
	// 	// self::session();

	// 	$paths[] = "article_show";

	// 	// $subjects = Subject::find_all();
	// 	// $this->data["subjects"] = $subjects;

	// 	$article = new Article($_GET["id"]);
	// 	$this->data["article"] = $article;

	// 	if (isset($article->id)) {
	// 		if ($comments = Comment::find_by_article($article->id)) {
	// 			$this->data["comments"] = $comments;
	// 		}
			
	// 	}

	// 	// $this->data["menu"] = $this->menu;

	// 	self::render($paths, $this->data);
	// }

	public function edit ()
	{
		// if (self::$session->is_admin()) {
		if (self::$session->user_admin == true) {
			// $paths[] = "article_edit";

			$article = new Article($_POST["article_id"]);
			// echo json_encode($article);
			if ($article -> update()) {
				echo json_encode($article);
			} else echo json_encode("article edit failed");
			// $this->data["article"] = $article;
			// self::render($paths, $this->data);
		}
	}

	public function add()
	{
		// echo json_encode(self::$session->user_admin);
		if (self::$session->user_admin == true) {
			// $paths[] = "article_add";

			$article = new Article();
			if ($article -> create()) {
				echo json_encode($article);
			} else echo json_encode("article creation failed");
			// $this->data["article"] = $article;
			// self::render($paths, $this->data);
		} else echo json_encode("user is not admin");
	}

	public function delete()
	{
		// if (self::$session->is_admin()) {
		if (self::$session->user_admin == true && $_POST["article_id"]) {

			$article = new Article($_POST["article_id"]);
			if ($article -> delete()) {
				echo json_encode("article deleted");
				// redirect_to("index.php");
			} else echo json_encode("error occured while trying to delete article");
		} else echo json_encode("user is not admin or article id is not provided");
	}
}