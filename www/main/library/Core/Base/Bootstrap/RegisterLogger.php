<?php

namespace Core\Base\Bootstrap;

use Core\Base\Application;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class RegisterLogger implements BootstrapperInterface
{
    /**
     * @param \Core\Base\Application $app
     */
    public function bootstrap(Application $app): void
    {
        $app->singleton('logger', function () use ($app) {
            $logger = new Logger(
                $app['config']->get('log.name'), [
                    new RotatingFileHandler($app->varPath().DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR.$app['config']->get('log.filename'), 5, Logger::DEBUG)
                ]
            );

            return $logger;
        });
    }
}