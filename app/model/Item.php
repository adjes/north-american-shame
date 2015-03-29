<?php 

namespace App\Model;

Class Item extends AbstractModel
{
	public static $table = "items";

	public $id;
	public $title;
	public $content;

	// function __construct()
	// {
	// 	parent::__construct();
	// }
}