<?php

namespace App\Model;

use App\Config;
use App\Model\User;


class Comment extends AbstractModel
{
	protected static $table = "comments";

	public $id;
	public $content;
	public $user_id;
	public $article_id;

	// public $name;

	function __construct($id="")
	{
    	if (!empty($id)) {
    		self::find_by_id($id);
    		var_dump($this);
    	} elseif (!$id && !$this->id) {
	    	return $this->init();
    	} 
    	// elseif ($this->id) {
		// 	$this->user = new User($this->user_id);
		// }
	}

	protected function init ()
	{
		if (isset($_POST[Config::$forms['comment_content']]) && isset($_POST[Config::$forms['comment_user_id']]) && isset($_POST[Config::$forms['comment_article_id']])) {
	    		$this->content = $_POST[Config::$forms['comment_content']];
	    		$this->user_id = $_POST[Config::$forms['comment_user_id']];
	    		$this->article_id = $_POST[Config::$forms['comment_article_id']];
    	} else return false;
	}

    public static function find_by_article($id)
    {
        $db = self::get_db();
		$q = "SELECT " . self::$table . ".*, " . User::$table. ".name FROM " . self::$table . " 
			LEFT JOIN " . User::$table . " 
			ON " . self::$table . ".article_id = '$id' AND " . self::$table . ".user_id =" . User::$table . ".id";
		if ($result = $db->sql($q)) {
			$result = $db->fetch_class(get_called_class());
		return $result;
		} else return false;
    }
}
