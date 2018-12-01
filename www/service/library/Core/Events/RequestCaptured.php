<?php

namespace Core\Events;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\Event;

class RequestCaptured extends Event
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * RequestCaptured constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
       $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getData() : Request
    {
        return $this->request;
    }
}
