<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleTopVisited extends Model
{
    protected $table = 'articles_top_visited';

    public $timestamps = false;

    public function getTopVisited($topic_id, $limit = 15)
    {
        return $this->select('*')
            ->where('topic_id', $topic_id)
            ->orderBy('visited', 'DESC')
            ->limit($limit)
            ->get();
    }
}