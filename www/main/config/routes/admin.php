<?php

use Core\Http\Router;

Router::addRoute('/', 'App\Admin\Controllers\IndexAdminController@index');

Router::addRoute('/article/new', 'App\Admin\Controllers\ArticlesAdminController@create');
Router::addRoute('/article/store', 'App\Admin\Controllers\ArticlesAdminController@store');

Router::addRoute('/article/{id}', 'App\Admin\Controllers\ArticlesAdminController@show');
Router::addRoute('/article/{id}/store', 'App\Admin\Controllers\ArticlesAdminController@store');

Router::addRoute('/ajax/article/delete', 'App\Admin\Controllers\ArticlesAjaxAdminController@delete');
