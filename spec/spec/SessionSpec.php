<?php

namespace spec\App;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use App\Model\User;

class SessionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Session');
    }

    function it_checks_if_logged_in()
    {
    	$this->is_logged_in()->shouldBeBoolean();
    }

    function it_checks_user_session_false ()
    {
    	$_SESSION["user_id"] = null;
        $_SESSION["user_name"] = null;
    	$_SESSION["user_admin"] = null;
    	$this->check_login();
    	$this->is_logged_in()->shouldReturn(false);
    }

    function it_checks_user_session_true ()
    {
    	$_SESSION["user_id"] = "1";
        $_SESSION["user_name"] = "admin";
        $_SESSION["user_admin"] = null;
    	$this->check_login();
    	$this->is_logged_in()->shouldReturn(true);
    }

    function it_log_in ()
    {
    	$_POST["name"] = "user";
    	$_POST["password"] = "password";
    	$this->login();
        $this->check_login();
    	$this->is_logged_in()->shouldBe(true);
    	$this->is_admin()->shouldBe(false);
    }

    function it_log_out ()
    {
    	$this->logout();
    	$this->is_logged_in()->shouldBe(false);
    }

    function it_fails_login () {
    	$_POST["name"] = "userrr";
    	$_POST["password"] = "passworddd";
    	$this->login()->shouldBe(false);
    }

    function it_log_in_admin () {
    	$_POST["name"] = "admin";
    	$_POST["password"] = "admin";
    	$this->login();
        $this->check_login();
    	$this->is_admin()->shouldBe(true);
    }

    function it_checks_name () {
    	$_SESSION["user_id"] = "1";
    	$_SESSION["user_name"] = "admin";
        $_SESSION["user_admin"] = true;
    	$this->check_login();
    	$this->user_name->shouldBe("admin");
    }
}
