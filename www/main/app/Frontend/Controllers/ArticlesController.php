<?php

namespace App\Frontend\Controllers;

use App\Frontend\Models\Article;
use App\Frontend\Services\ArticleUpdatedProducer;
use Core\Http\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticlesController extends AbstractController
{
    public function show(Article $article, ArticleUpdatedProducer $service, $id)
    {
        $article = $article->getArticlesData($id);

        if (! $article) {
            throw new NotFoundHttpException('Model not found.');
        }

        if ($article->incrementVisited()) {
            $service->publish($article->toArray(), 'article.updated');
        }

        return $this->view('frontend/articles/show.html.php', [
            'article' => $article
        ]);
    }
}
