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

    public function execute() : void
    {
        $this->getChannel()->basic_qos(null, 1, null);
        $this->getChannel()->basic_consume($this->queueName, '', false, false, false, false, [$this, 'callback']);

        try {
            while (count($this->getChannel()->callbacks)) {
                $this->getChannel()->wait(null, false, 3600);
            }
        } catch(AMQPTimeoutException $e) {
            //catch timeout exception
        }
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