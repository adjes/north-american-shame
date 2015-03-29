<?php 

namespace App\Model;

Class TestDB extends AbstractModel
{
	public static $table = "test";

	public $id;
	public $title;
	public $content;

	// public function __construct()
	// {
	// 	parent::__construct();
	// }
	protected function init() 
	{
		
	}
}