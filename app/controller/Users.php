<?php

namespace App\Controller;

use App\Model\User;

class Users extends AbstractController
{

    public function login()
    {
        if (!self::$session->login()) {
        	echo json_encode("login failed");
            return false;
        } else 
        // redirect_to(__DIR__ . "/../../public/index.php");
        	echo json_encode(self::$session);
    }

    public function logout()
    {
    	echo json_encode(self::$session->logout());
    }

    public function add()
    {
    	$user = new User();
    	$user->create();
    	echo json_encode($user);
    }

    public function get_users()
    {
        if (self::$session->user_admin) {
            $users = User::find_all();
            foreach ($users as $user) {
                if ($user->password) {
                    unset($user->password);
                }
            }
            echo json_encode($users);
        } else echo "forbidden";
    }

    public function delete()
    {
        // if (self::$session->is_admin()) {
        if (self::$session->user_admin == true && $_POST["user_id"] && self::$session->user_id != $_POST["user_id"] ) {

            $user = new user($_POST["user_id"]);
            if ($user -> delete()) {
                if ($user->password) {
                    unset($user->password);
                }
                echo json_encode($user);
                // redirect_to("index.php");
            } else echo json_encode("error occured while trying to delete user");
        } else echo json_encode("forbidden or user_id is not provided");
    }

    public function set_admin ()
    {
          if (self::$session->user_admin == true && $_POST["user_id"] && isset($_POST["user_admin"]) && self::$session->user_id != $_POST["user_id"] ) {

            $user = new user($_POST["user_id"]);
            $user->admin = $_POST["user_admin"];
            if ($user -> update()) {
                if ($user->password) {
                    unset($user->password);
                }
                echo json_encode($user);
                // redirect_to("index.php");
            } else echo json_encode("error occured while trying to edit user");
        } else echo json_encode("forbidden or user_id is not provided");
    }
}
