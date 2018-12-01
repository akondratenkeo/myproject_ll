<?php

namespace Core\Http;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Container\Container;
use Core\Exceptions\HttpResponseException;

class Router
{
    /**
     * @var array
     */
    protected static $routes = [];

    /**
     * @var \Core\Base\Application
     */
    protected $container;

    /**
     * @var \Symfony\Component\Routing\RouteCollection
     */
    protected $collection;

    /**
     * @var \Symfony\Component\Routing\Matcher\UrlMatcher
     */
    protected $matcher;

    /**
     * @var \Symfony\Component\Routing\RequestContext
     */
    protected $context;

    /**
     * @var \Symfony\Component\Routing\Route
     */
    protected $current;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $currentRequest;

    /**
     * Router constructor.
     *
     * @param RequestContext $context
     * @param RouteCollection $collection
     * @param Container $container
     */
    public function __construct(RequestContext $context, RouteCollection $collection, Container $container)
    {
        $this->context = $context;
        $this->collection = $collection;
        $this->container = $container;

        foreach (self::$routes as $route => $resolver) {
            $this->collection->add(
                $route,
                new Route($route, ['resolver' => $resolver])
            );
        }
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @throws \ReflectionException
     */
    public function dispatch($request) : Response
    {
        $this->container->instance(Request::class, $request);
        $this->currentRequest = $request;

        $attributes = $this->match();

        $this->current = $route = $this->collection->get($attributes['_route']);
        unset($attributes['resolver'], $attributes['_route']);

        $this->current->parameters = $attributes;

        $response = $this->run();

        return $response;
    }

    /**
     * @return array
     */
    public function match() : array
    {
        $this->context->fromRequest($this->currentRequest);
        $this->matcher = $this->container->make(
            UrlMatcher::class,
            ['routes' => $this->collection, 'context' => $this->context]
        );

        return $this->matcher->match($this->currentRequest->getPathInfo());
    }

    /**
     * @param string $route
     * @param string $resolver
     */
    public static function addRoute(string $route, string $resolver) : void
    {
        self::$routes[$route] = $resolver;
    }

    /**
     * Run the route action and return the response.
     *
     * @return Response
     * @throws \ReflectionException
     */
    protected function run()
    {
        try {
            return $this->toResponse($this->currentRequest, $this->runController());

        } catch (HttpResponseException $e) {
            return $e->getResponse();
        }
    }

    /**
     * Run the route action and return the response.
     *
     * @return mixed
     *
     * @throws \ReflectionException
     */
    protected function runController()
    {
        return $this->controllerDispatcher()->dispatch(
            $this->current, $this->getController(), $this->getControllerMethod()
        );
    }

    /**
     * Get the controller instance for the route.
     *
     * @return mixed
     */
    public function getController()
    {
        $class = $this->parseControllerCallback()[0];

        return $this->container->make(ltrim($class, '\\'));
    }

    /**
     * Get the controller method used for the route.
     *
     * @return string
     */
    public function getControllerMethod()
    {
        return $this->parseControllerCallback()[1];
    }

    /**
     * Parse the controller.
     *
     * @return array
     */
    protected function parseControllerCallback()
    {
        return explode('@', $this->current->getDefaults()['resolver']);
    }

    /**
     * Get the dispatcher for the route's controller.
     *
     * @return \Core\Http\ControllerDispatcher
     */
    protected function controllerDispatcher() : ControllerDispatcher
    {
        return $this->container->make(ControllerDispatcher::class);
    }

    /**
     * @param Request $request
     * @param string $response
     * @return Response
     */
    protected function toResponse(Request $request, $response) : Response
    {
        if (! $response instanceof Response) {
            $response = new Response($response);
        }

        if ($response->getStatusCode() === Response::HTTP_NOT_MODIFIED) {
            $response->setNotModified();
        }

        return $response->prepare($request);
    }
}
