<?php

namespace spec\Madkom\DockerRegistryApi;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RequestBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\DockerRegistryApi\RequestBuilder');
    }
}
