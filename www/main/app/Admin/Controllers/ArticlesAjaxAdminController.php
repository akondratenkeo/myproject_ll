<?php

namespace App\Admin\Controllers;

use App\Frontend\Models\Article;
use App\Frontend\Models\Author;
use App\Frontend\Models\Topic;
use Core\Http\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ArticlesAjaxAdminController extends AbstractController
{
    /**
     * @param Article $article
     * @param Request $request
     *
     * @return string
     * @throws \Exception
     */
    public function delete(Article $article, Request $request) : string
    {
        $article_id = $request->request->get('article_id');

        if (! $article->destroy($article_id)) {
            return json_encode(['status'=> 'FAIL']);
        };

        return json_encode(['status'=> 'OK']);
    }
}
