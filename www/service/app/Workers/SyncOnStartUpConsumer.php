<?php

namespace App\Workers;

use Core\Queue\AbstractConsumer;
use Illuminate\Database\Capsule\Manager as Capsule;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPTimeoutException;

class SyncOnStartUpConsumer extends AbstractConsumer
{
    protected $exchangeName = 'app_exchange';

    protected $queueName = 'sync_articles';

    protected $articleTop;

    public function __construct(AMQPStreamConnection $connection)
    {
        parent::__construct($connection);

        $this->exchangeDeclare($this->exchangeName, 'direct')
            ->queueDeclare($this->queueName, [$this->queueName]);
    }

    /**
     * @param AMQPMessage $message
     *
     * @return bool
     */
    protected function process(AMQPMessage $message): bool
    {
        $messageBody = $this->parseMessage($message->body);

        if (Capsule::table('articles_top_visited')->insert($messageBody)) {
            return true;
        }

        return false;
    }
}