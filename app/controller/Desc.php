<?php 

namespace App\Controller;

use \DOMDocument;

class Desc extends AbstractController
{

	public function set_title () {
		if (self::$session->user_admin == true && $_POST["site_title"]) {
			
			$dom = new DOMDocument;	
			libxml_use_internal_errors(true);
			$dom->loadHTMLFile(__DIR__ . "/../../public/index.html");
			libxml_clear_errors();
			$dom->preserveWhiteSpace = true;
			$elements = $dom->getElementsByTagName('title');
			$elements[0]->nodeValue = $_POST["site_title"];
			echo $dom->saveHTMLFile(__DIR__ . "/../../public/index.html");

		}
	}


}