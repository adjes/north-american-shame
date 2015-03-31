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
}
