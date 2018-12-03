<?php

namespace Core\Base;

use Core\Exceptions\ExceptionHandler;
use Core\Http\Router;
use Core\Events\RequestCaptured;
use Core\Events\RequestHandled;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class Kernel implements HttpKernelInterface
{
    /**
     * @var \Core\Base\Application
     */
    protected $app;

    /**
     * @var \Core\Http\Router
     */
    protected $router;

    /**
     * @var array
     */
    protected $bootstrappers = [
        \Core\Base\Bootstrap\LoadEnvironment::class,
        \Core\Base\Bootstrap\LoadConfiguration::class,
        \Core\Base\Bootstrap\HandleExceptions::class,
        \Core\Base\Bootstrap\RegisterLogger::class,
        \Core\Base\Bootstrap\RegisterDatabase::class,
        \Core\Base\Bootstrap\RegisterRedis::class,
        \Core\Base\Bootstrap\RegisterView::class,
        \Core\Base\Bootstrap\RegisterQueueConnection::class,
        \Core\Base\Bootstrap\RegisterBroadcaster::class,
    ];

    /**
     * @var array
     */
    protected $middleware = [
        \Core\Middleware\CheckCsrfToken::class,
        \Core\Middleware\ParseJsonRequest::class
    ];

    /**
     * Kernel constructor.
     * @param Application $app
     * @param Router $router
     */
    public function __construct(Application $app, Router $router)
    {
        $this->app = $app;
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @param int $type
     * @param bool $catch
     * @return Response
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true) : Response
    {
        $this->app['event']->dispatch(
            RequestCaptured::class,
            new RequestCaptured($request)
        );

        try {
            $response = $this->dispatchToRouter($request);

        } catch (\Exception $e) {
            $this->reportException($e);

            $response = $this->renderException($request, $e);
        } catch (\Throwable $e) {
            $this->reportException($e);

            $response = $this->renderException($request, $e);
        }

        $this->app['event']->dispatch(
            RequestHandled::class,
            new RequestHandled($request, $response)
        );

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    protected function dispatchToRouter(Request $request) : Response
    {
        $this->app->instance(Request::class, $request);

        $this->bootstrap();

        $pipeline = $this->app->make(Pipeline::class);

        return $pipeline
            ->send($request)
            ->trough($this->middleware)
            ->then(function ($request) {
                return $this->router->dispatch($request);
            });
    }

    /**
     *
     */
    protected function bootstrap() : void
    {
        $this->app->bootstrapWith($this->bootstrappers);
    }

    /**
     * @param \Exception $e
     */
    protected function reportException(\Exception $e)
    {
        $this->app[ExceptionHandler::class]->report($e);
    }

    /**
     * @param Request $request
     * @param \Exception $e
     * @return Response
     */
    protected function renderException(Request $request, \Exception $e) : Response
    {
        return $this->app[ExceptionHandler::class]->render($request, $e);
    }
}
