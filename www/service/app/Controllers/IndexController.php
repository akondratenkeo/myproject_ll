<?php

namespace App\Controllers;

use App\Models\Article;
use Core\Http\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    public function index(Article $article)
    {
        $redis = $this->container->make('redis');

        var_dump($redis->publish('test', json_encode([
            'event' => 'zzz',
            'data' => ['a' => 1],
            'socket' => 'socket',
        ])));

        return $this->view("home.html.php");
    }
}
