<?php

namespace spec\App\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Model\User');
    }

    function it_auth ()
    {
    	$_POST["username"] = "user";
    	$_POST["password"] = "password";
    	$this->auth()->shouldHaveType('App\Model\User');
    }

    function it_auth_false ()
    {
    	$_POST["username"] = "userrr";
    	$_POST["password"] = "passworddd";
    	$this->auth()->shouldBe(false);
    }

    function it_auth_false_2 ()
    {
    	$_POST["username"] = null;
    	$_POST["password"] = "passworddd";
    	$this->auth()->shouldBe(false);
    }

}
