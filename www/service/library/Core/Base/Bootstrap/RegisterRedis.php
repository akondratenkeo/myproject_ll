<?php

namespace Core\Base\Bootstrap;

use Core\Base\Application;
use Predis\Client;

class RegisterRedis implements BootstrapperInterface
{
    /**
     * @param \Core\Base\Application $app
     */
    public function bootstrap(Application $app): void
    {
        $redis = new Client($app['config']->get('redis'));

        $app->instance('redis', $redis);
    }
}