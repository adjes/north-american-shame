<?php

namespace App\Model;

use App\Config;


class Comment extends AbstractModel
{
	protected static $table = "comments";

	public $id;
	public $content;
	public $user_id;
	public $article_id;

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
		if (isset($_POST[Config::$forms['comment_content']]) && isset($_POST[Config::$forms['comment_user_id']]) && isset($_POST[Config::$forms['comment_article_id']])) {
	    		$this->content = $_POST[Config::$forms['comment_content']];
	    		$this->user_id = $_POST[Config::$forms['comment_user_id']];
	    		$this->article_id = $_POST[Config::$forms['comment_article_id']];
    	} else return false;
	}
}