<?php 

namespace App\Controller;

use App\Model\Article;
use App\Model\Comment;
use App\Model\User;

class Comments extends AbstractController
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

	// public function edit ()
	// {
	// 	// if (self::$session->is_admin()) {
	// 	if (self::$session->user_admin == true) {
	// 		// $paths[] = "article_edit";

	// 		$article = new Article($_POST["article_id"]);
	// 		// echo json_encode($article);
	// 		if ($article -> update()) {
	// 			echo json_encode($article);
	// 		} else echo json_encode("article edit failed");
	// 		// $this->data["article"] = $article;
	// 		// self::render($paths, $this->data);
	// 	}
	// }

	public function add()
	{
		// echo json_encode(self::$session->user_admin);
		if (isset(self::$session->user_id)) {
			// $paths[] = "article_add";

			$comment = new Comment();
			if ($comment -> create()) {
				$user = new User($comment->user_id);
				$comment->name = $user->name;
				echo json_encode($comment);
			} else echo json_encode("comment creation failed");
			// $this->data["article"] = $article;
			// self::render($paths, $this->data);
		} else echo json_encode("user is not logged in");
	}

	public function delete()
	{
		// if (self::$session->is_admin()) {
		if (self::$session->user_admin == true && $_POST["comment_id"]) {

			$comment = new Comment($_POST["comment_id"]);
			if ($comment -> delete()) {
				echo json_encode($comment);
				// redirect_to("index.php");
			} else echo json_encode("error occured while trying to delete comment");
		} else echo json_encode("user is not admin or comment id is not provided");
	}
}