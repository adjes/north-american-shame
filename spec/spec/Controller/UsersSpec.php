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
}
