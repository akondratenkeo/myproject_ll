<?php

namespace App\Frontend\Services;

use App\Frontend\Models\Article;
use Core\Queue\Producer;

class SyncOnStartUpProducer
{
    protected $exchangeName = 'app_exchange';

    protected $queueName = 'sync_articles';

    protected $producer;

    protected $articleModel;

    public function __construct(Producer $producer, Article $articleModel)
    {
        $this->producer = $producer->setRoutingKey($this->queueName)
            ->exchangeDeclare($this->exchangeName, 'direct')
            ->queueDeclare($this->queueName);

        $this->articleModel = $articleModel;
    }

    public function run()
    {
        $last_id = 1;
        $max = $this->articleModel->max('id');

        while ($last_id <= $max) {
            $articles = $this->articleModel
                ->select('id', 'title', 'topic_id', 'visited')
                ->where('id', '>=', $last_id)
                ->limit(500)
                ->orderBy('id')
                ->get();

            if ($articles !== null && count($articles)) {
                $this->producer->publish($articles->toArray());
            }

            $last_id += 500;
        }
    }
}