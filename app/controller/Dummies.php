<?php

namespace App\Controller;

use App\Model\Dummy;

class Dummies extends AbstractController
{

public function get_dummy()
    {
        $dummy = new Dummy ();
        $dummy->upload_users();
        $dummy->upload_subjects();
        $dummy->upload_articles();
        $dummy->upload_comments();
        // var_dump($arr);
    } 

}
