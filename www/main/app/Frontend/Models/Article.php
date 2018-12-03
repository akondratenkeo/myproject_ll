<?php

namespace App\Frontend\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * @param string $template
     *
     * @return string
     */
    public function formatDate(string $template) : string
    {
        return date($template, strtotime($this->created_at));
    }

    public function getCount()
    {
        return $this->count();
    }

    public function getVisited()
    {
        return $this->visited;
    }

    public function getArticlesData(int $id)
    {
        return $this->select('articles.*', 'authors.name as author_name', 'topics.title as topic_title', 'images.filename as image_filename')
            ->join('authors', 'authors.id', '=', 'articles.author_id')
            ->join('topics', 'topics.id', '=', 'articles.topic_id')
            ->join('images', 'articles.id', '=', 'images.article_id')
            ->where('articles.id', $id)
            ->first();
    }

    public function getArticlesList(int $limit = 30)
    {
        return $this->select('articles.*', 'authors.name as author_name')
                    ->join('authors', 'authors.id', '=', 'articles.author_id')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->get();
    }

    public function incrementVisited()
    {
        $this->visited += 1;

        if (! $this->save()) {
            return false;
        }

        return true;
    }

    public function resetVisited()
    {
        $this->visited = 0;

        if (! $this->save()) {
            return false;
        }

        return true;
    }
}