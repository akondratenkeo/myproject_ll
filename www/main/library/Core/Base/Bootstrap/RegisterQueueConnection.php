<?php

namespace Core\Base\Bootstrap;

use Core\Base\Application;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RegisterQueueConnection implements BootstrapperInterface
{
    /**
     * @param \Core\Base\Application $app
     */
    public function bootstrap(Application $app): void
    {
        $app->singleton(AMQPStreamConnection::class, function () use ($app) {
            $rebbitmq = $app['config']->get('rebbitmq');

            return new AMQPStreamConnection($rebbitmq['host'], $rebbitmq['port'], $rebbitmq['user'], $rebbitmq['password']);
        });
    }
}