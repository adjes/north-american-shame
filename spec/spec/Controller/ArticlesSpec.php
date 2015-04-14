<?php

namespace spec\App\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArticlesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Controller\Articles');
    }

    function it_returns_article_from_Get()
    {
    	$_GET["id"] = 1;
    	$this->show(1);
    	$this->data->shouldHaveKey("article");
    	$this->data["article"]->title->shouldBe("Article title");
    }

    function it_edits_article()
    {
        $_SESSION["user_id"] = "1";
        $_SESSION["user_name"] = "admin";
        $_SESSION["user_admin"] = true;
        $_GET["id"] = 1;
        $this->edit();
        $this->data["article"]->title->shouldBe("Article title");
        $_POST["article_title"] = "Changed article title";
        $_POST["article_content"] = "Article content";
        $_POST["article_subject_id"] = "1";
        $this->edit();
        $this->data["article"]->title->shouldBe("Changed article title");
        $_POST["article_title"] = "Article title";
        $_POST["article_content"] = "Article content";
        $_POST["article_subject_id"] = "1";
        $this->edit();
        $this->data["article"]->title->shouldBe("Article title");
    }

    // function it_adds_new_article()
    // {
    //     $_SESSION["user_id"] = "1";
    //     $_SESSION["user_name"] = "admin";
    //     $_SESSION["user_admin"] = true;
    //     $_POST["article_title"] = null;
    //     $this->add()->shouldNotThrow();
    //     $_POST["submit"] = true;
    //     $_POST["article_title"] = "Changed article title";
    //     $_POST["article_content"] = "Article content";
    //     $_POST["article_subject_id"] = "1";
    //     $this->add()->shouldNotThrow();
    //     $this->data["article"]->title->shouldBe("Changed article title");

    // }
}
