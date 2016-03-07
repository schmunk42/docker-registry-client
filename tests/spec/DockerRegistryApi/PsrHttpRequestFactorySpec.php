<?php

namespace spec\Madkom\DockerRegistryApi;

use Madkom\DockerRegistryApi\PsrHttpRequestFactory;
use Madkom\DockerRegistryApi\Request;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;

/**
 * Class PsrHttpRequestFactorySpec
 * @package spec\Madkom\DockerRegistryApi
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin PsrHttpRequestFactory
 */
class PsrHttpRequestFactorySpec extends ObjectBehavior
{

    function let()
    {
        $host = 'http://localhost:812';
        $this->beConstructedWith($host);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\DockerRegistryApi\PsrHttpRequestFactory');
    }

    function it_should_create_psr_request(Request $request)
    {
        $request->uri()->willReturn('/v2/Something');
        $request->headers()->willReturn(['Content-Type' => 'application/json']);
        $request->method()->willReturn('GET');
        $request->data()->willReturn([]);

        $psrRequest = $this->toPsrRequest($request);
        $psrRequest->shouldHaveType(RequestInterface::class);
        $psrRequest->getRequestTarget()->shouldReturn('/v2/Something');
        $psrRequest->getUri()->getHost()->shouldReturn('localhost');
        $psrRequest->getUri()->getPort()->shouldReturn(812);
        $psrRequest->getMethod()->shouldReturn('GET');
        $psrRequest->getHeaders()->shouldReturn([
            'Host' => ['localhost:812'],
            'Content-Type' => ['application/json']
        ]);
    }

    function it_should_return_host()
    {
        $this->host()->shouldReturn('http://localhost:812');
    }

}
