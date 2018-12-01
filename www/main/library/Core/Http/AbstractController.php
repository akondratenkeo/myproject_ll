<?php

namespace Core\Http;

use BadMethodCallException;
use Illuminate\Container\Container;
use Rakit\Validation\Validator;
use Symfony\Component\Templating\Helper\SlotsHelper;

abstract class AbstractController
{
    /**
     * The container instance.
     *
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Rakit\Validation\Validator
     */
    protected $validator;

    protected $viewEngine;

    /**
     * AbstractController constructor.
     *
     * @param Container $container
     * @param Validator $validator
     */
    public function __construct(Container $container, Validator $validator)
    {
        session_start();

        $this->container = $container;
        $this->validator = $validator;

        $this->viewEngine = $this->container->make('view');
        $this->viewEngine->set($this->container->make(SlotsHelper::class));

        $this->viewEngine->addGlobal('errors', $_SESSION['_errors'] ?? null);
        unset($_SESSION['_errors']);
    }

    /**
     * @param string $name
     * @param array $parameters
     * @return string
     */
    public function view(string $name, array $parameters = []) : string
    {
        return $this->viewEngine->render($name, $parameters);
    }

    public function validate(array $inputs, array $rules) : bool
    {
        $validation = $this->validator->validate($inputs, $rules);

        if ($validation->fails()) {
            session_start();

            $_SESSION['_errors'] = $validation->errors();
            unset($validation);

            return false;
        }

        unset($validation);

        return true;
    }

    /**
     * Execute an action on the controller.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters);
    }

    /**
     * Handle calls to missing methods on the controller.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        throw new BadMethodCallException(sprintf(
            'Method %s::%s does not exist.', static::class, $method
        ));
    }
}
