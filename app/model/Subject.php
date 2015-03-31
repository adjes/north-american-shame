<?php

namespace App\Model;

use App\Config;

class Subject extends AbstractModel
{
	protected static $table = "subjects";

	public $id;
	public $name;

	function __construct($id="")
	{
    	if (!empty($id)) {
    		self::find_by_id($id);
    	} elseif (!$id && !$this->id) {
	    	$this->init();
    	}
	}

	protected function init ()
	{
		if (isset($_POST[Config::$forms['subject_name']])) {
	    		$this->name = $_POST[Config::$forms['subject_name']];
	    	}
	}
}
