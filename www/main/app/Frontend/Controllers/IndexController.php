<?php

namespace App\Frontend\Controllers;

use App\Frontend\Models\Article;
use App\Frontend\Models\Author;
use App\Frontend\Models\Topic;
use App\Frontend\Models\User;
use Core\Http\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    public function index(
        Article $article,
        Author $author,
        Topic $topic
    ) {
        $topics = $topic->all()->keyBy('id')->all();
        $aggregation = $article->getCountInTopic()->toArray();

        return $this->view('frontend/home.html.php', [
            'articles' => $article->getArticlesList(30),
            'seo_articles' => $article->getArticlesListByDate(100),
            'seo_authors' => $author->getAuthorsList(),
            'topics' => $topics,
            'aggregation' => $aggregation
        ]);
    }
}
