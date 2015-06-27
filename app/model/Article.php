<?php

namespace App\Model;

use App\Config;


class Article extends AbstractModel
{
	public static $table = "articles";

	public $id;
	public $title;
	public $content;
	public $subject_id;
	public $user_id;

	// public $created_at;

	// public $updated_at;

	public $user_name;

	public $comments_count;

	public $comments;

	function __construct($id="")
	{
    	if (!empty($id)) {
    		self::find_by_id($id);

    	} elseif (!$id && !$this->id) {
	    	return $this->init();
    	}
	}

	protected function init ()
	{
		if (isset($_POST[Config::$forms['article_title']]) && isset($_POST[Config::$forms['article_content']]) && isset($_POST[Config::$forms['article_subject_id']])) {
	    		$this->title = $_POST[Config::$forms['article_title']];
	    		$this->content = $_POST[Config::$forms['article_content']];
	    		$this->subject_id = $_POST[Config::$forms['article_subject_id']];
	    		$this->user_id = $_POST[Config::$forms['article_user_id']];
	    		$this->created_at = date("d.m.Y");
	    		if (isset($_POST["article_updated"])) {
	    			unset($this->created_at);
	    			$this->updated_at = date("H:i, d.m.Y");
	    		}
    	} else return false;
	}

	public function create ()
	{
			parent::create();
    		$user = new User ($this->user_id);
    		$this->user_name = $user->name;
    		$this->comments = Comment::find_by_article($this->id);
    		return $this;
	}

	public static function find_all() 
	{
		$result_set = parent::find_all();
		foreach ($result_set as $key) {
			 $user = new User($key->user_id);
			 $key->user_name = $user->name;
			 $key->comments = Comment::find_by_article($key->id);
			 // $key->comments_count = count($key->comments);
		}
		return $result_set;
	}
}
