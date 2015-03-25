<?php

namespace spec\App\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AbstractControllerSpec extends ObjectBehavior
{
	function let()
	{
	    $this->beAnInstanceOf("App\Controller\Base");
	}
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Controller\Base');
    }

    function it_renders_view_test()
    {
    	$this->render("TestView")->shouldBe(true);
    }

    function it_renders_view_index()
    {
    	$this->render("IndexView")->shouldBe(true);
    }

    function it_renders_nothing()
    {
    	$this->render("SomeView")->shouldBe(false);
    }
}
