<?php 

namespace App\Controller;

use App\Model\Item;

class Test extends AbstractController
{
	// function __construct()
	// {
	// 	echo "Test active";
	// }
	private $path = array (
		"index" => "IndexView",
		"test" => "TestView"
		);
	private $data;

	public function index()
	{
		//get data to $data
		$this->data = ["index" => "index"];
		//render view
		self::render($this->path["index"], $this->data); 
	}

	public function find_all()
	{
		//get data to $data
		$items = new Item;
		$data = $items->find_all();
		// $this->data = Item::find_all();
		// $this->data = PhotoModel::find_by_id();

		// var_dump($this->data);
		//render view
		return self::render($this->path["test"], $this->data);

		// return false;
	}
}