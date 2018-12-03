<?php

namespace App\Admin\Controllers;

use App\Frontend\Models\Article;
use App\Frontend\Models\Author;
use App\Frontend\Models\Topic;
use App\Frontend\Services\ArticleUpdatedProducer;
use Core\Http\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ArticlesAjaxAdminController extends AbstractController
{
    /**
     * @param Article $article
     * @param Request $request
     * @param ArticleUpdatedProducer $service
     *
     * @return string
     * @throws \Exception
     */
    public function delete(Article $article, Request $request, ArticleUpdatedProducer $service) : string
    {
        $article_id = $request->request->get('article_id');

        if (! $article->destroy($article_id)) {
            return json_encode([
                'status'=> 'FAIL'
            ]);
        };

        $service->publish(['id' => $article_id], 'article.removed');

        return json_encode([
            'status'=> 'OK'
        ]);
    }
}
