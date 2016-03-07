<?php
require __DIR__ . '/../vendor/autoload.php';

$registryFactory      = new \Madkom\DockerRegistryApi\PsrHttpRequestFactory('https://registry.com');
$authorizationFactory = new \Madkom\DockerRegistryApi\PsrHttpRequestFactory('https://portus.com');

$client = new \Madkom\DockerRegistryApi\HttpDockerRegistryClient('login', 'password', new \Http\Adapter\Guzzle6\Client(), $registryFactory, $authorizationFactory);


$response = $client->handle(new \Madkom\DockerRegistryApi\Request\ImageTags('ubuntu'));

dump($response->getBody()->getContents());