<?php

namespace App\Model;

use App\Config;


class Article extends AbstractModel
{
	protected static $table = "articles";

	public $id;
	public $title;
	public $content;
	public $subject_id;

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
    	} else return false;
	}
}
