<?php

namespace spec\App\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use App\Model\User;

class SessionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Model\Session');
    }

    function it_checks_if_logged_in()
    {
    	$this->logged_in()->shouldBeBoolean();
    }

    function it_checks_user_session_true ()
    {
    	$_SESSION["user_id"] = null;
    	$this->check_login();
    	$this->logged_in()->shouldReturn(false);
    }

    function it_checks_user_session_false ()
    {
    	$_SESSION["user_id"] = "1";
    	$this->check_login();
    	$this->logged_in()->shouldReturn(true);
    }

    function it_logges_in (User $user)
    {
    	$_SESSION["user_id"] = null;
    	$this->login($user);
    	$this->logged_in()->shouldBe(true);
    }
}
