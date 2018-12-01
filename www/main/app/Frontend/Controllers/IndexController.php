<?php

namespace App\Frontend\Controllers;

use App\Frontend\Models\Article;
use App\Frontend\Models\User;
use Core\Http\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    public function index(Article $article)
    {
        return $this->view('frontend/home.html.php', [
            'articles' => $article->getArticlesList(30)
        ]);
    }
}
