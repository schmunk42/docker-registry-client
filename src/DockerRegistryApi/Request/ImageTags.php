<?php

namespace Madkom\DockerRegistryApi\Request;

use Madkom\DockerRegistryApi\Request;

/**
 * Class ImageTags
 * @package Madkom\DockerRegistryApi\Request
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class ImageTags implements Request
{

    /** @var  string */
    private $imageName;

    public function __construct($imageName)
    {
        $this->imageName = $imageName;
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
        return '/v2/' . $this->imageName . '/tags/list';
    }

    /**
     * @inheritDoc
     */
    public function headers()
    {
        return [];
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
        return 'repository:' . $this->imageName .':pull';
    }


}
