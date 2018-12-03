<?php

namespace App\Admin\Controllers;

use App\Frontend\Models\Article;
use App\Frontend\Models\Author;
use App\Frontend\Models\Topic;
use App\Frontend\Services\ArticleUpdatedProducer;
use Core\Http\AbstractController;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticlesAdminController extends AbstractController
{
    public function show(
        Topic $topic,
        Author $author,
        Article $article,
        $id
    ) {
        $article = $article->find($id);

        if (! $article) {
            throw new NotFoundHttpException('Model not found.');
        }

        return $this->view('admin/articles/show.html.php', [
            'article' => $article,
            'topics' => $topic->all(),
            'authors' => $author->all(),
        ]);
    }

    public function create(Topic $topic, Author $author)
    {
        return $this->view('admin/articles/create.html.php', [
            'topics' => $topic->all(),
            'authors' => $author->all(),
        ]);
    }

    public function store(Request $request, Article $article, ArticleUpdatedProducer $service, $id = null)
    {
        $inputs = $request->request->all();
        $rules = [
            'title'         => 'required',
            'topic_id'      => 'required',
            'author_id'     => 'required',
            'description'   => 'required',
            'body'          => 'required',
        ];

        if (! $this->validate($inputs, $rules)) {
            return new RedirectResponse($id ? "/article/{$id}" : "/article/new", 301);
        }

        if ($id !== null) {
            $article = $article->find($id);
        }

        $article->title = $inputs['title'];
        $article->topic_id = $inputs['topic_id'];
        $article->author_id = $inputs['author_id'];
        $article->description = $inputs['description'];
        $article->body = $inputs['body'];

        if (! $article->save()) {
            throw new QueryException("Model wasn\'t saved.");
        }

        if ($article->resetVisited()) {
            $service->publish($article->toArray(), 'article.updated');
        }

        return new RedirectResponse("/article/{$article->id}", 301);
    }
}
