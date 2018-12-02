<?php

namespace Core\Base\Bootstrap;

use Core\Base\Application;
use Core\Broadcasting\RedisBroadcaster;
use Predis\Client as Redis;

class RegisterBroadcaster implements BootstrapperInterface
{
    /**
     * @param \Core\Base\Application $app
     */
    public function bootstrap(Application $app): void
    {
        $app->bind(RedisBroadcaster::class, function() use ($app) {
            return new RedisBroadcaster($app->make(Redis::class));
        });
    }
}