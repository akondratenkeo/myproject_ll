<?php

namespace Core\Base;

use Core\Exceptions\ExceptionHandler;
use Core\Http\Router;
use Illuminate\Container\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class Application extends Container
{
    /**
     * The Core version.
     *
     * @var string
     */
    const VERSION = '0.1.0';

    /**
     * The base path for the application.
     *
     * @var string
     */
    protected $basePath;

    /**
     * The environment file to load during bootstrapping.
     *
     * @var string
     */
    protected $environmentFile = '.env';

    /**
     * Application constructor.
     *
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        $this->setBasePath($basePath);

        $this->registerBaseBindings();
    }

    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version() : string
    {
        return static::VERSION;
    }

    /**
     * Register the basic bindings into the container.
     *
     * @return void
     */
    protected function registerBaseBindings() : void
    {
        static::setInstance($this);

        $this->instance(Application::class, $this);

        $this->instance(Container::class, $this);

        $this->singleton('event', function () {
            return new EventDispatcher();
        });

        $this->singleton(ExceptionHandler::class, function () {
            return new ExceptionHandler($this);
        });

    }

    /**
     * @param string $routesFilePath
     */
    public function loadRoutes(string $routesFilePath) : void
    {
        $this->singleton(Router::class, function () use ($routesFilePath) {

            require_once $routesFilePath;

            return new Router(
                new RequestContext(),
                new RouteCollection(),
                $this
            );
        });
    }

    /**
     * @param array $bootstrappers
     */
    public function bootstrapWith(array $bootstrappers) : void
    {
        foreach ($bootstrappers as $bootstrapper) {
            $this->make($bootstrapper)->bootstrap($this);
        }
    }

    /**
     * Set the base path for the application.
     *
     * @param string $basePath
     */
    protected function setBasePath($basePath) : void
    {
        $this->basePath = rtrim($basePath, '\/');

        $this->bindPathsInContainer();
    }

    /**
     * Set the path to routes file.
     *
     * @param $routesFilePath
     */
    protected function setRoutesFilePath($routesFilePath) : void
    {
        $this->routesFilePath = rtrim($routesFilePath, '\/');
    }

    /**
     * Bind all of the application paths in the container.
     *
     * @return void
     */
    protected function bindPathsInContainer() : void
    {
        $this->instance('path', $this->basePath);
        $this->instance('path.app', $this->appPath());
        $this->instance('path.bootstrap', $this->bootstrapPath());
        $this->instance('path.assets', $this->assetsPath());
        $this->instance('path.config', $this->configPath());
        $this->instance('path.database', $this->databasePath());
        $this->instance('path.public', $this->publicPath());
        $this->instance('path.var', $this->varPath());
    }

    /**
     * Get the root directory path.
     *
     * @return string
     */
    public function basePath() : string
    {
        return $this->basePath;
    }

    /**
     * Get the path to the application "app" directory.
     *
     * @return string
     */
    public function appPath() : string
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'app';
    }

    /**
     * Get the path to the bootstrap file directory.
     *
     * @return string
     */
    public function bootstrapPath() : string
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'app';
    }

    /**
     * Get the path to the assets directory.
     *
     * @return string
     */
    public function assetsPath() : string
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'assets';
    }

    /**
     * Get the path to the app configuration files.
     *
     * @return string
     */
    public function configPath() : string
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'config';
    }

    /**
     * Get the path to the database directory.
     *
     * @return string
     */
    public function databasePath() : string
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'database';
    }

    /**
     * Get the path to the public directory.
     *
     * @return string
     */
    public function publicPath() : string
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'public';
    }

    /**
     * Get the path to the temporary files directory.
     *
     * @return string
     */
    public function varPath() : string
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'var';
    }

    /**
     * Get the path to the environment file directory.
     *
     * @return string
     */
    public function environmentPath() : string
    {
        return $this->basePath;
    }

    /**
     * Get the environment file.
     *
     * @return string
     */
    public function environmentFile() : string
    {
        return $this->environmentFile;
    }

    /**
     * Get the fully qualified path to the environment file.
     *
     * @return string
     */
    public function environmentFilePath() : string
    {
        return $this->environmentPath().DIRECTORY_SEPARATOR.$this->environmentFile();
    }

    /**
     * @param string $env
     * @return bool
     */
    public function environment(string $env) : bool
    {
        return $env === $this['env'];
    }

    /**
     * @param string $event
     * @param callable $callback
     */
    public function on(string $event, callable $callback) : void
    {
        $this['event']->addListener($event, $callback);
    }
}
