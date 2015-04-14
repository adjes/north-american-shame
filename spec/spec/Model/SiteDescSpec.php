<?php

namespace spec\App\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SiteDescSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Model\SiteDesc');
    }

    function it_returns_title_content_on_init ()
    {
    	$this->title->shouldBeString();
    	$this->meta->shouldBeString();
    }

    function it_updates_title_content_on_init ()
    {
    	$_POST["site_title"] = "Changed title";
    	$_POST["site_meta"] = "Changed meta";
    	$this->update();
    	$this->title->shouldBe("Changed title");
    	$_POST["site_title"] = "Site title";
    	$_POST["site_meta"] = "Site meta";
    	$this->update()->shouldBe(true);
    }
}
