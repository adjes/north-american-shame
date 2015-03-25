<?php

namespace spec\App\Database;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use App\Model\TestModel;

class MySqlDatabaseSpec extends ObjectBehavior
{
	function let()
    {
        $this->beConstructedWith("App\Model\TestModel");
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('App\Database\MySqlDatabase');
    }

    function it_adds_item_to_db (TestModel $test)
    {
    	$test->title="it_adds_item_to_db";
    	$test->content="Content test";
    	$this->create($test)->shouldBe(true);
    }

    function it_finds_by_id (TestModel $test)
    {
    	$test->title="it_finds_by_id";
    	$this->create($test);
    	$id = $this->db->last_id();
    	$this->find_by_id ($id) ->shouldHaveType("App\Model\TestModel");
    }

    function it_updates_item (TestModel $test)
    {
    	$test->title="it_updates_item";
    	$this->create($test);
		$test->id = $this->db->last_id();
    	$test->title="Test_test";
    	$this->update($test)->shouldBe(true);
    	$this->find_by_id($test->id)->title->shouldBe("Test_test");
    }

    function it_deletes_item (TestModel $test) 
    {
    	$test->title="it_deletes_item";
    	$this->create($test);
    	$test->id = $this->db->last_id();
    	$this->delete($test)->shouldBe(true);
    }

    function it_finds_all ()
    {
		$this->find_all()->shouldBeArray();
    }

    function it_counts_items ()
    {	
    	$this->count()->shouldBeString();
    }
}
