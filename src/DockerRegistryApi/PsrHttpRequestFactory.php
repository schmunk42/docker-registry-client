<?php

namespace Madkom\DockerRegistryApi;

use GuzzleHttp\Psr7;
use Psr\Http\Message\RequestInterface;

/**
 * Class PsrHttpRequestFactory
 * @package Madkom\DockerRegistryApi
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class PsrHttpRequestFactory
{

    /** @var  string */
    private $host;

    /**
     * PsrHttpRequestFactory constructor.
     *
     * @param string $host
     */
    public function __construct($host)
    {
        $this->host = $host;
    }

    /**
     * @param Request $request
     *
     * @return RequestInterface
     */
    public function toPsrRequest(Request $request)
    {
        return new Psr7\Request($request->method(), $this->host . $request->uri(), $request->headers(), json_encode($request->data()));
    }

    /**
     * @return string
     */
    public function host()
    {
        return $this->host;
    }

}
