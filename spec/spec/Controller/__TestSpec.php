<?php

namespace spec\App\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Controller\Test');
    }

    function it_checks_if_file_included()
    {
    	$this->find_all()->shouldBe(True);
    }
}
