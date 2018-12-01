<?php

require __DIR__.'/../vendor/autoload.php';

$app = new \Core\Base\Application(
    realpath(__DIR__ . '/../')
);

$app->loadRoutes($app->configPath() .'/routes/frontend.php');

//$app->on(
//    \Core\Events\RequestCaptured::class,
//    new \App\Listeners\TestHandler
//);

$kernel = $app->make(\Core\Base\Kernel::class);

$response = $kernel->handle(
    $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals()
);

$response->send();

/*
- Пагинация
- Развернуть сервис
*/
