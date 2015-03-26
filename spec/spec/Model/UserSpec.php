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
    	$_POST["name"] = "user";
    	$_POST["password"] = "password";
        // $this->create();
    	$this->auth()->shouldBe(true);
    }

    function it_auth_false ()
    {
    	$_POST["name"] = "userrr";
    	$_POST["password"] = "passworddd";
    	$this->auth()->shouldBe(false);
    }

    function it_auth_false_2 ()
    {
    	$_POST["name"] = null;
    	$_POST["password"] = "passworddd";
    	$this->auth()->shouldBe(false);
    }

    function it_creates_admin_record ()
    {
        $this->name = "lol";
        $this->password = "lol";
        $this->admin = true;
        $this->create()->shouldBe(true);
        $this->delete()->shouldBe(true);
    }

}
