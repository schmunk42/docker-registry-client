<?php

namespace spec\Madkom\DockerRegistryApi;

use Madkom\DockerRegistryApi\DockerRegistryException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class DockerRegistryExceptionSpec
 * @package spec\Madkom\DockerRegistryApi
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin DockerRegistryException
 */
class DockerRegistryExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(\Exception::class);
    }
}
