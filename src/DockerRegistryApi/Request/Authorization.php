<?php

namespace Madkom\DockerRegistryApi\Request;

use Madkom\DockerRegistryApi\Request;

/**
 * Class Authorization
 * @package Madkom\DockerRegistryApi\Request
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Authorization implements Request
{
    /**
     * @var string
     */
    private $registryHost;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;
    /**
     * @var string
     */
    private $scope;

    /**
     * Authorization constructor.
     *
     * @param string $registryHost
     * @param string $username
     * @param string $password
     * @param string $scope
     */
    public function __construct($registryHost, $username, $password, $scope)
    {
        $this->registryHost = $registryHost;
        $this->username = $username;
        $this->password = $password;
        $this->scope = $scope;
    }

    /**
     * @inheritDoc
     */
    public function method()
    {
        return 'GET';
    }

    /**
     * @inheritDoc
     */
    public function uri()
    {
        $parsedUrl = parse_url($this->registryHost);
        return '/v2/token?service=' . $parsedUrl['host'] . '&scope=' . $this->scope();
    }

    /**
     * @inheritDoc
     */
    public function headers()
    {
        return [
            'Authorization' => 'Basic ' . base64_encode($this->username . ':' . $this->password)
        ];
    }

    /**
     * @inheritDoc
     */
    public function data()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function scope()
    {
        return $this->scope;
    }


}
