<?php

namespace spec\App;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use App\Controller\Test;

class RouterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Router');
    }

    function it_returns_ctrl_base ()
    {
    	$_GET["c"] = null;
    	$this->get_controller()->shouldHaveType("App\Controller\Base");
    }

    function it_returns_find_all_method(Test $test)
    {
    	$_GET["m"] = "find_all";
        $this->get_method($test)->shouldReturn("find_all");
    }

    function it_returns_ctrl_with_index_method(Test $test)
    {
        $_GET["m"] = "some_method";
        $this->get_method($test)->shouldReturn("index");
    }

}
