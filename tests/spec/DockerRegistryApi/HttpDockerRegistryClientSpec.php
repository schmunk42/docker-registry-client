<?php

namespace spec\Madkom\DockerRegistryApi;

use Http\Client\HttpClient;
use Madkom\DockerRegistryApi\DockerRegistryException;
use Madkom\DockerRegistryApi\HttpDockerRegistryClient;
use Madkom\DockerRegistryApi\PsrHttpRequestFactory;
use Madkom\DockerRegistryApi\Request;
use \GuzzleHttp\Psr7;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class HttpDockerRegistryClientSpec
 * @package spec\Madkom\DockerRegistryApi
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin HttpDockerRegistryClient
 */
class HttpDockerRegistryClientSpec extends ObjectBehavior
{

    /** @var  HttpClient */
    private $client;
    /** @var  string */
    private $registryHost;
    /** @var  string */
    private $authorizationHost;
    /** @var  PsrHttpRequestFactory */
    private $registryFactory;
    /** @var  PsrHttpRequestFactory */
    private $authorizationFactory;

    function let(HttpClient $client, PsrHttpRequestFactory $httpRequestFactoryAuthorization, PsrHttpRequestFactory $psrHttpRequestFactoryRegistry)
    {
        $username     = 'test';
        $password     = 'pass';
        $this->client = $client;
        $this->registryHost = 'localhost:812';
        $this->authorizationHost = 'auth.com';
        $this->registryFactory = $psrHttpRequestFactoryRegistry;
        $this->registryFactory->host()->willReturn('registry.com');
        $this->authorizationFactory = $httpRequestFactoryAuthorization;

        $this->beConstructedWith($username, $password, $client, $this->registryFactory, $this->authorizationFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\DockerRegistryApi\HttpDockerRegistryClient');
    }

    function it_should_handle_request(Request $request, Psr7\Request $psrRequest, Psr7\Request $updatedPsrRequest, Psr7\Request $authorizationRequest, ResponseInterface $response, ResponseInterface $authorizationResponse, StreamInterface $streamInterface)
    {
        $this->authorizationFactory->toPsrRequest(Argument::type(Request\Authorization::class))->willReturn($authorizationRequest);
        $this->registryFactory->toPsrRequest($request)->willReturn($psrRequest);

        $authorizationResponse->getBody()->willReturn($streamInterface);
        $authorizationResponse->getStatusCode()->willReturn(200);
        $streamInterface->getContents()->willReturn(json_encode(["token" => 'SomeToken']));
        $this->client->sendRequest($authorizationRequest)->willReturn($authorizationResponse);

        $psrRequest->withHeader('Authorization', 'Bearer SomeToken')->willReturn($updatedPsrRequest);
        $this->client->sendRequest($updatedPsrRequest)->willReturn($response);

        $this->handle($request)->shouldReturn($response);
    }

    function it_should_throw_exception_if_authorization_failed(RequestInterface $authorizationRequest, ResponseInterface $authorizationResponse, Request $request, StreamInterface $streamInterface)
    {
        $request->scope()->willReturn('');

        $this->authorizationFactory->toPsrRequest(Argument::type(Request\Authorization::class))->willReturn($authorizationRequest);
        $this->client->sendRequest($authorizationRequest)->willReturn($authorizationResponse);

        $authorizationResponse->getStatusCode()->willReturn(401);
        $authorizationResponse->getBody()->willReturn($streamInterface);
        $streamInterface->getContents()->willReturn('some');

        $this->shouldThrow(DockerRegistryException::class)->during('handle', [$request]);
    }

}
