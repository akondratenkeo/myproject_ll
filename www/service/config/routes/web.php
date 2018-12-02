<?php

use Core\Http\Router;

Router::addRoute('/api/article/top', 'App\Controllers\Api\ArticlesController@top');

Router::addRoute('/', 'App\Controllers\IndexController@index');
