<?php 

namespace App\Controller;

use App\Model\Subject;
// use App\Model\Comment;

class Subjects extends AbstractController
{
	
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
		if (self::$session->user_admin == true && $_POST["subject_id"]) {
			// $paths[] = "article_edit";

			$subject = new Subject($_POST["subject_id"]);
			// echo json_encode($subject);
			if ($subject -> update()) {
				echo json_encode($subject);
			} else echo json_encode("subject edit failed");
			// $this->data["article"] = $article;
			// self::render($paths, $this->data);
		}
	}

	public function add()
	{
		if (self::$session->user_admin == true && $_POST["subject_name"]) {

			$subject = new Subject();
			if ($subject -> create ()) {
				echo json_encode($subject);
				// redirect_to("index.php");
			} else echo json_encode("error occured while trying to create subject");
		} else echo json_encode("user is not admin or subject id is not provided");
	}
	

	public function delete()
	{
		// if (self::$session->is_admin()) {
		if (self::$session->user_admin == true && $_POST["subject_id"]) {

			$subject = new Subject($_POST["subject_id"]);
			if ($subject -> delete()) {
				echo json_encode("subject deleted");
				// redirect_to("index.php");
			} else echo json_encode("error occured while trying to delete subject");
		} else echo json_encode("user is not admin or subject id is not provided");
	}
}