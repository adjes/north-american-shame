<?php

namespace spec\App\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArticleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Model\Article');
    }

    function it_finds_by_constr()
    {
        $this->beConstructedWith(1);
        $this->title->shouldBe("Article title");
    }

    function it_finds_by_constr_nothing()
    {
        $this->beConstructedWith(-1);
        $this->title->shouldBe(null);
    }      

    function it_creates()
    {
        $_POST["article_title"] = "title";
        $_POST["article_content"] = "content";
        $_POST["article_subject_id"] = "1";
    	// $this->beConstructedWith();
        $this->create()->shouldBe(true);
        $this->delete()->shouldBe(true);
    }

    function it__fails_to_create()
    {
        $_POST["article_title"] = "title";
        $_POST["article_content"] = null;
        $_POST["article_subject_id"] = null;
    	// $this->beConstructedWith();
    	$this->shouldThrow('PDOException')->during("create");
        // $this->create()->shouldBe(false);
    }

    function it_updates()
    {
        $_POST["article_title"] = "title";
        $_POST["article_content"] = "content";
        $_POST["article_subject_id"] = "1";
        $this->create()->shouldBe(true);
        $this->find_by_id($this->id)->shouldHaveType('App\Model\Article');
        $_POST["article_title"] = "fuego";
        $this->update()->shouldBe(true);
        $this->title->shouldBe("fuego");
        $this->delete()->shouldBe(true);
    }
}
