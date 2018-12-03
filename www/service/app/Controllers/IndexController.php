<?php

namespace App\Controllers;

use Core\Http\AbstractController;

class IndexController extends AbstractController
{
    public function index()
    {
        return $this->view("home.html.php");
    }
}
