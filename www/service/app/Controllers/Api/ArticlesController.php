<?php

namespace App\Controllers\Api;

use App\Models\ArticleTopVisited;
use Core\Http\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ArticlesController extends AbstractController
{
    public function top(
        Request $request,
        ArticleTopVisited $articleTop
    ) {
        $inputs = $request->request->all();

        $articles = $articleTop->getTopVisited($inputs['topic_id'])->toArray();

        return json_encode([
            'status' => 'OK',
            'data' => $articles
        ]);
    }
}
