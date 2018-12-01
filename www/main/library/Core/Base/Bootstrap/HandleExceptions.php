<?php

namespace Core\Base\Bootstrap;

use Core\Base\Application;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;

class HandleExceptions implements BootstrapperInterface
{
    /**
     * @param \Core\Base\Application $app
     */
    public function bootstrap(Application $app): void
    {
        if (! $app->environment('production')) {

            Debug::enable();

            ErrorHandler::register();

            SymfonyExceptionHandler::register();
        }
    }
}