<?php

namespace spec\App\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

// use App\Model\TestModel;

class TestDBSpec extends ObjectBehavior
{
	// function let()
 //    {
 //        $this->beConstructedWith("App\Model\TestModel");
 //    }

    function it_is_initializable()
    {
        $this->shouldHaveType('App\Model\TestDB');
    }

    function it_adds_item_to_db ()
    {
    	$this->title="it_adds_item_to_db";
    	$this->content="Content test";
    	$this->create()->shouldBe(true);
    }

    function it_finds_by_id ()
    {
    	$this->title="it_finds_by_id";
    	$this->create();
    	$this->find_by_id ($this->id) ->shouldHaveType("App\Model\TestDB");
    }

    function it_updates_item ()
    {
    	$this->title="it_updates_item";
    	$this->create();
    	$this->title="Test_test";
    	$this->update()->shouldBe(true);
    	$this->find_by_id($this->id)->title->shouldBe("Test_test");
    }

    function it_deletes_item () 
    {
    	$this->title="it_deletes_item";
    	$this->create();
    	$this->delete()->shouldBe(true);
    }

    function it_finds_all ()
    {
		$this->find_all()->shouldBeArray();
    }

    function it_counts_items ()
    {	
    	$this->count()->shouldBeString();
    }

    function it_clears_table ()
    {
        $this->clear_table()->shouldBe(true);
    }
}
