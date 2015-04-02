<?php 

namespace App\Model;

class Menu extends AbstractModel
{

	public static function get_menu_items () {

		$subj = Subject::find_all();
		$art = Article::find_all();

		$menu["subj"] = $subj;
		$menu["art"] = $art;

		return $menu;

		// $q = "SELECT $subj.name, $art.title FROM $subj 
		// 	LEFT JOIN $art 
		// 	ON $art.subject_id = $subj.id";
		// if ($result = $db->sql($q)) {
		// 	$result = $db->fetch_assoc();

		// 	return $result;
		// }
	}

}