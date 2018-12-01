<?php

namespace Core\Base\Bootstrap;

use Core\Base\Application;
use Illuminate\Database\Capsule\Manager as Capsule;

class RegisterDatabase implements BootstrapperInterface
{
    /**
     * @param \Core\Base\Application $app
     */
    public function bootstrap(Application $app): void
    {
        $capsule = new Capsule();
        $capsule->addConnection($app['config']->get('database'));

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $app->instance(Capsule::class, $capsule);
    }
}