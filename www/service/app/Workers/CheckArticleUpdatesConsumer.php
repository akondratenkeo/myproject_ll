<?php

namespace App\Workers;

use App\Models\ArticleTopVisited;
use Core\Broadcasting\RedisBroadcaster;
use Core\Queue\AbstractConsumer;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class CheckArticleUpdatesConsumer extends AbstractConsumer
{
    protected $exchangeName = 'app_exchange';

    protected $queueName = 'articles_queue';

    protected $broadcaster;

    /**
     * CheckArticleUpdatesConsumer constructor.
     *
     * @param AMQPStreamConnection $connection
     */
    public function __construct(AMQPStreamConnection $connection, RedisBroadcaster $broadcaster)
    {
        parent::__construct($connection);

        $this->exchangeDeclare($this->exchangeName, 'direct')
            ->queueDeclare($this->queueName, ['article.updated', 'article.removed']);

        $this->broadcaster = $broadcaster;
    }

    /**
     * @param AMQPMessage $message
     *
     * @return bool
     */
    protected function process(AMQPMessage $message): bool
    {
        $messageBody = $this->parseMessage($message->body);

        if ('article.updated' === $message->delivery_info['routing_key']) {

            if (! $article = ArticleTopVisited::find($messageBody['id'])) {
                $article = new ArticleTopVisited();
                $article->id = $messageBody['id'];
            }

            $article->title = $messageBody['title'];
            $article->topic_id = $messageBody['topic_id'];
            $article->visited = $messageBody['visited'];

            if ($article->save()) {
                $this->broadcaster->broadcast(['topic-top-'.$article->topic_id], 'visited-changed');

                unset($article);
                return true;
            }

        } elseif ('article.removed' === $message->delivery_info['routing_key']) {

            if ($article = ArticleTopVisited::find($messageBody['id'])) {
                $topic_id = $article->topic_id;

                if ($article->destroy($messageBody['id'])) {
                    $this->broadcaster->broadcast(['topic-top-'.$topic_id], 'visited-changed');

                    unset($article);
                    return true;
                };
            }
        }

        return false;
    }
}