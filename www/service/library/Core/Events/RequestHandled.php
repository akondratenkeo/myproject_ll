<?php

namespace Core\Events;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\Event;

class RequestHandled extends Event
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var \Symfony\Component\HttpFoundation\Response
     */
    protected $response;

    /**
     * RequestCaptured constructor.
     *
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
       $this->request = $request;
       $this->response = $response;
    }

    /**
     * @return array
     */
    public function getData() : array
    {
        return [
            $this->request,
            $this->response
        ];
    }
}
