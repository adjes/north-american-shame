<?php

namespace App\Controller;

use App\Model\User;

class Users extends AbstractController
{

    public function login()
    {
        if (!self::$session->login()) {
            return false;
        } else redirect_to(__DIR__ . "/../../public/index.php");
        	
    }
}
