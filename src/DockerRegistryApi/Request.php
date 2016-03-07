<?php

namespace Madkom\DockerRegistryApi;

/**
 * Interface Request
 * @package spec\Madkom\DockerRegistryApi
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
interface Request
{

    /**
     * Returns method GET, POST, PUT, DELETE
     *
     * @return string
     */
    public function method();

    /**
     * Endpoint Uri.
     *
     * @return string e.g. /v2/
     */
    public function uri();

    /**
     * List of headers
     *
     * @return array
     */
    public function headers();

    /**
     * Returns request data
     *
     * @return array
     */
    public function data();

    /**
     * Returns authorization scope
     *
     * @return string e.g. "registry:catalog:*"
     */
    public function scope();

}