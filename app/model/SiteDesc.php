<?php

namespace App\Model;

use App\Config;

class SiteDesc extends AbstractModel
{

	protected static $table = "site_desc";
	protected $id;
	public $title;
	public $meta;

	function __construct() 
	{
		if (!isset($this->id)) {
			self::find_by_id(1);
		}
	}

	protected function init ()
	{
	    if (isset($_POST[Config::$forms['site_title']]) && isset($_POST[Config::$forms['site_meta']])) {
    		$this->title = $_POST[Config::$forms['site_title']];
    		$this->meta = $_POST[Config::$forms['site_meta']];
    	}
	}
}
