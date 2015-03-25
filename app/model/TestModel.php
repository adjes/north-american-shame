<?php 

namespace App\Model;

Class TestModel extends AbstractModel
{
	public static $table = "test";

	public $id;
	public $title;
	public $content;

	public function __construct()
	{

	}
}