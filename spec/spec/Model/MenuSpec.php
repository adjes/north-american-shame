<?php

namespace spec\App\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MenuSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Model\Menu');
    }

    function it_forms_menu ()
    {
    	$this->get_menu_items()->shouldBeArray();
    }
}
