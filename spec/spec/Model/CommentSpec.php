<?php

namespace spec\App\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Model\Comment');
    }

    function it_finds_by_constr()
    {
        $this->beConstructedWith(1);
        $this->content->shouldBe("Comment text");
    }

    function it_finds_by_constr_nothing()
    {
        $this->beConstructedWith(-1);
        $this->content->shouldBe(null);
    }      

    function it_creates()
    {
        $_POST["comment_content"] = "content";
        $_POST["comment_user_id"] = "1";
        $_POST["comment_article_id"] = "1";
    	// $this->beConstructedWith();
        $this->create()->shouldBe(true);
        $this->delete()->shouldBe(true);
    }

    function it__fails_to_create()
    {
     	$_POST["comment_content"] = "content2";
        $_POST["comment_user_id"] = null;
        $_POST["comment_article_id"] = null;
    	// $this->beConstructedWith();
    	$this->shouldThrow('PDOException')->during("create");
        // $this->create()->shouldBe(false);
    }

    function it_updates()
    {
        $_POST["comment_content"] = "content3";
        $_POST["comment_user_id"] = "1";
        $_POST["comment_article_id"] = "1";
        $this->create()->shouldBe(true);
        $this->find_by_id($this->id)->shouldHaveType('App\Model\Comment');
        $_POST["comment_content"] = "fuego";
        $this->update()->shouldBe(true);
        $this->content->shouldBe("fuego");
        $this->delete()->shouldBe(true);
    }

    function it_returns_article_comments()
    {
    	$this->find_by_article(1)->shouldBeArray();
    }
}
