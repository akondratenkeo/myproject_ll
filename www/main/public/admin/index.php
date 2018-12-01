<?php

require __DIR__.'/../../vendor/autoload.php';

$app = new \Core\Base\Application(
    realpath(__DIR__ . '/../../')
);

$app->loadRoutes($app->configPath() .'/routes/admin.php');

$kernel = $app->make(\Core\Base\Kernel::class);

$response = $kernel->handle(
    $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals()
);

$response->send();