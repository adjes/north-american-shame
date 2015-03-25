<?php

namespace App\Controller;

use App\Model\UserModel;

class User extends AbstractController
{
	private $path = array (
	"login_form" => "LoginForm"
	);

    public function login()
    {
        $user = new UserModel();
        if ($user->logged_in()) {
        	redirect_to(__dir__ . "../../public/index.php");
        } else {
        	return self::render($this->path["login_form"]);
    	}
        	
    }
}
