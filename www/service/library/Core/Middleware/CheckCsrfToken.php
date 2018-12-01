<?php

namespace Core\Middleware;

use Illuminate\Container\Container;
use Symfony\Component\HttpFoundation\Request;

class CheckCsrfToken
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * AddSecondStage constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @return Request
     */
    public function __invoke(Request $request) : Request
    {
        return $request;
    }
}