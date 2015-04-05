<?php

namespace spec\App\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AdminSpec extends ObjectBehavior
{
	function let ()
	{
		$_SESSION["user_id"] = "1";
        $_SESSION["user_name"] = "admin";
        $_SESSION["user_admin"] = true;
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('App\Controller\Admin');
    }

    function it_calls_articles()
    {
    	$this->articles()->shouldNotThrow();
    }

    function it_calls_users()
    {
    	$this->users()->shouldNotThrow();
    }
	
	function it_calls_subjects()
    {
    	$this->subjects()->shouldNotThrow();
    }

}
