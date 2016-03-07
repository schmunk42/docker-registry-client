<?php

namespace spec\Madkom\DockerRegistryApi\Request;

use Madkom\DockerRegistryApi\Request;
use Madkom\DockerRegistryApi\Request\ImageTags;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ImageTagsSpec
 * @package spec\Madkom\DockerRegistryApi\Request
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin ImageTags
 */
class ImageTagsSpec extends ObjectBehavior
{

    private $imageName;

    function let()
    {
        $this->imageName = 'ubuntu';
        $this->beConstructedWith($this->imageName);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Request::class);
    }

    function it_should_return_values_it_was_constructed_with()
    {
        $this->uri()->shouldReturn('/v2/' . $this->imageName .'/tags/list');
        $this->headers()->shouldReturn([]);
        $this->scope()->shouldReturn('repository:ubuntu:pull');
    }

}
