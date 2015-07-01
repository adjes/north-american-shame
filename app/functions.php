<?php

	function redirect_to($new_location) {
		header("Location: " . $new_location);
		die;
	}

	function check_json() {
		if(strpos($_SERVER["HTTP_ACCEPT"], "application/json") !== false){
			return true;
		} else return false;
	}

	// function console_log($data) {
	// 	if(is_array($data) || is_object($data)) {
	// 		echo("<script>console.log('PHP: ".json_encode($data)."');</script>");
	// 	} else {
	// 		echo("<script>console.log('PHP: ".$data."');</script>");
	// 	}
	// }

	function translit($string){
		$table = array( 
		               'А' => 'A', 
		               'Б' => 'B', 
		               'В' => 'V', 
		               'Г' => 'G', 
		               'Д' => 'D', 
		               'Е' => 'E', 
		               'Ё' => 'YO', 
		               'Ж' => 'ZH', 
		               'З' => 'Z', 
		               'И' => 'I', 
		               'Й' => 'J', 
		               'К' => 'K', 
		               'Л' => 'L', 
		               'М' => 'M', 
		               'Н' => 'N', 
		               'О' => 'O', 
		               'П' => 'P', 
		               'Р' => 'R', 
		               'С' => 'S', 
		               'Т' => 'T', 
		               'У' => 'U', 
		               'Ф' => 'F', 
		               'Х' => 'H', 
		               'Ц' => 'C', 
		               'Ч' => 'CH', 
		               'Ш' => 'SH', 
		               'Щ' => 'CSH', 
		               'Ь' => '', 
		               'Ы' => 'Y', 
		               'Ъ' => '', 
		               'Э' => 'E', 
		               'Ю' => 'YU', 
		               'Я' => 'YA', 

		               'а' => 'a', 
		               'б' => 'b', 
		               'в' => 'v', 
		               'г' => 'g', 
		               'д' => 'd', 
		               'е' => 'e', 
		               'ё' => 'yo', 
		               'ж' => 'zh', 
		               'з' => 'z', 
		               'и' => 'i', 
		               'й' => 'j', 
		               'к' => 'k', 
		               'л' => 'l', 
		               'м' => 'm', 
		               'н' => 'n', 
		               'о' => 'o', 
		               'п' => 'p', 
		               'р' => 'r', 
		               'с' => 's', 
		               'т' => 't', 
		               'у' => 'u', 
		               'ф' => 'f', 
		               'х' => 'h', 
		               'ц' => 'c', 
		               'ч' => 'ch', 
		               'ш' => 'sh', 
		               'щ' => 'csh', 
		               'ь' => '', 
		               'ы' => 'y', 
		               'ъ' => '', 
		               'э' => 'e', 
		               'ю' => 'yu', 
		               'я' => 'ya',

		               ' ' => '_' 
		); 

		$output = str_replace(array_keys($table), array_values($table), $string); 

		return $output;
	}