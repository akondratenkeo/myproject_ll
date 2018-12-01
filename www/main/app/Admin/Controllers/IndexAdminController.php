<?php

namespace App\Admin\Controllers;

use App\Frontend\Models\Article;
use App\Frontend\Models\Author;
use App\Frontend\Models\Topic;
use Core\Http\AbstractController;

class IndexAdminController extends AbstractController
{
    /**
     * Index action.
     *
     * @param Topic $topic
     * @param Author $author
     * @param Article $article
     *
     * @return string
     */
    public function index(
        Topic $topic,
        Author $author,
        Article $article
    ) {
        return $this->view('admin/dashboard/index.html.php', [
            'articles' => $article->getArticlesList(20),
            'articles_count' => $article->getCount(),
            'topics_count' => $topic->getCount(),
            'authors_count' => $author->getCount(),
        ]);
    }
}
