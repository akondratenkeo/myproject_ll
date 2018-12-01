<?php

namespace Core\Base\Bootstrap;

use Core\Base\Application;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

class RegisterView implements BootstrapperInterface
{
    /**
     * @param \Core\Base\Application $app
     */
    public function bootstrap(Application $app): void
    {
        $app->bind('view', function () use ($app) {
            return new PhpEngine(
                new TemplateNameParser(),
                new FilesystemLoader($app->basePath().'/templates/%name%')
            );
        });
    }
}