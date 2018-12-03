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
            'data' => [
                [
                    'id' => 801,
                    'title' => 'Lorem ipsum dolor sit amet, consectetur.',
                    'topic_id' => 15,
                    'visited' => 8,
                ], [
                    'id' => 809,
                    'title' => 'Lorem ipsum dolor sit amet, consectetur.',
                    'topic_id' => 15,
                    'visited' => 6
                ], [
                    'id' => 544,
                    'title' => 'Lorem ipsum dolor sit amet, consectetur.',
                    'topic_id' => 15,
                    'visited' => 5
                ]
            ]
        ]);
    }
}
