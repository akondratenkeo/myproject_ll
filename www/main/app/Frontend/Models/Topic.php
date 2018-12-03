<?php

namespace App\Frontend\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public function getCount()
    {
        return $this->count();
    }

    public function getTopicsListWithCount()
    {
        return $this->selectRaw('topics.title, count(articles.id) as count_in')
                    ->leftJoin('articles', 'articles.topic_id', '=', 'topics.id')
                    ->groupBy('topics.title')
                    ->get();
    }
}