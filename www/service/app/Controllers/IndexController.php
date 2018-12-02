<?php

namespace App\Controllers;

use Core\Broadcasting\RedisBroadcaster;
use Core\Http\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    public function index(RedisBroadcaster $broadcaster)
    {
        $broadcaster->broadcast(['test'], 'zzz', ['a' => 100]);

        return $this->view("home.html.php");
    }
}
