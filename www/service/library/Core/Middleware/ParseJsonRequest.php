<?php

namespace Core\Middleware;

use Illuminate\Container\Container;
use Symfony\Component\HttpFoundation\Request;

class ParseJsonRequest
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * AddOneStage constructor.
     *
     * @param $container
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
        if (strpos($request->headers->get('Content-Type'), 'application/json') === 0) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
        }

        return $request;
    }
}