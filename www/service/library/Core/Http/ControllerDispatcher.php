<?php

namespace Core\Http;

use Illuminate\Container\Container;
use Symfony\Component\Routing\Route;

class ControllerDispatcher
{
    use DependencyResolverTrait;

    /**
     * The container instance.
     *
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * Create a new controller dispatcher instance.
     *
     * @param \Illuminate\Container\Container $container
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Dispatch a request to a given controller and method.
     *
     * @param \Symfony\Component\Routing\Route $route
     * @param mixed $controller
     * @param string $method
     * @return mixed
     *
     * @throws \ReflectionException
     */
    public function dispatch(Route $route, $controller, $method)
    {
        $parameters = $this->resolveClassMethodDependencies(
            $route->parameters, $controller, $method
        );

        if (method_exists($controller, 'callAction')) {
            return $controller->callAction($method, $parameters);
        }

        return $controller->{$method}(...array_values($parameters));
    }
}
