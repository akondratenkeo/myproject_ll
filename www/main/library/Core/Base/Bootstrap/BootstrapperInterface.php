<?php

namespace Core\Base\Bootstrap;

use Core\Base\Application;

interface BootstrapperInterface
{
    public function bootstrap(Application $app) : void;
}