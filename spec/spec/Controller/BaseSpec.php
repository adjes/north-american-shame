<?php

namespace spec\App\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BaseSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Controller\Base');
    }

    function it_tests_index ()
    {
    	$this->shouldNotThrow()->during("index");
    }

    function it_tests_index_w_user()
    {
    	$_SESSION["user_id"] = 1;
    	$_SESSION["user_name"] = "Admin";
    	$_SESSION["user_admin"] = true;
    	$this->shouldNotThrow()->during("index");
    	$this->data->shouldHaveKey('user');
    }
}
