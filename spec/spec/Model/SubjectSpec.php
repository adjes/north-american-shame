<?php

namespace spec\App\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SubjectSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Model\Subject');
    }

    function it_finds_by_constr()
    {
        $this->beConstructedWith(47);
        $this->name->shouldBe("test");
    }

    function it_finds_by_constr_nothing()
    {
        $this->beConstructedWith(45);
        $this->name->shouldBe(null);
    }      

    function it_creates()
    {
        $_POST["subject_name"] = "subject";
        $this->create()->shouldBe(true);
        $this->delete()->shouldBe(true);
    }

    function it_updates()
    {
        $_POST["subject_name"] = "subject";
        $this->create()->shouldBe(true);
        $this->find_by_id($this->id)->shouldHaveType('App\Model\Subject');
        $_POST["subject_name"] = "fuego";
        $this->update()->shouldBe(true);
        $this->name->shouldBe("fuego");
        $this->delete()->shouldBe(true);
    }


}


