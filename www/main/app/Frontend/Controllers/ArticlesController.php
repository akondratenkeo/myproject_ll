<?php

namespace App\Frontend\Controllers;

use App\Frontend\Models\Article;
use App\Frontend\Models\User;
use App\Frontend\Services\SendToRabbit;
use Core\Http\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticlesController extends AbstractController
{
    public function show(Article $article, SendToRabbit $service, $id)
    {
        $article = $article->getArticlesData($id);

        if (! $article) {
            throw new NotFoundHttpException('Model not found.');
        }

        $article->incrementVisited();

        $service->send();

        return $this->view('frontend/articles/show.html.php', [
            'article' => $article
        ]);
    }
}
