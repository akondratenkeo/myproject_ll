<?php

use Core\Http\Router;

Router::addRoute('/', 'App\Frontend\Controllers\IndexController@index');

Router::addRoute('/article/{id}', 'App\Frontend\Controllers\ArticlesController@show');
