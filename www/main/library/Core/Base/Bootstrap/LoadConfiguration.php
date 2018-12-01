<?php

namespace Core\Base\Bootstrap;

use Core\Base\Application;
use Illuminate\Config\Repository;

class LoadConfiguration implements BootstrapperInterface
{
    /**
     * @param \Core\Base\Application $app
     */
    public function bootstrap(Application $app): void
    {
        $app->instance('config', $config = new Repository());

        $this->loadConfigFile($app, $config);

        $app->instance('env', $config->get('app.env', 'production'));

        date_default_timezone_set($config->get('app.timezone', 'UTC'));

        mb_internal_encoding('UTF-8');
    }

    protected function loadConfigFile(Application $app, Repository $repository)
    {
        $items = $this->getConfigFile($app);

        foreach ($items as $key => $value) {
            $repository->set($key, $value);
        }
    }

    protected function getConfigFile(Application $app)
    {
        return require_once($app->configPath().DIRECTORY_SEPARATOR.'app.php');
    }
}