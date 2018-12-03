<?php

namespace App\Frontend\Services;

use Core\Queue\Producer;

class ArticleUpdatedProducer
{
    protected $exchangeName = 'app_exchange';

    protected $queueName = 'articles_queue';

    protected $producer;

    public function __construct(Producer $producer)
    {
        $this->producer = $producer->exchangeDeclare($this->exchangeName, 'direct')
            ->queueDeclare($this->queueName, ['article.updated', 'article.removed']);
    }

    public function publish($messageBody, string $routingKey) : void
    {
        $this->producer->publish($messageBody, $routingKey);
    }
}