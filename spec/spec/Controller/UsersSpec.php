<?php

namespace spec\App\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UsersSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Controller\Users');
    }

    function it_checks_login()
    {
    	$this->login()->shouldBe(false);
    }

    function it_checks_login_true()
    {
    	$_POST["name"] = "user";
    	$_POST["password"] = "password";
    	$this->login()->shouldNotBe(false);
    }
}
