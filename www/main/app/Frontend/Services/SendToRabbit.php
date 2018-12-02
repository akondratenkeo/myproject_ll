<?php

namespace App\Frontend\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class SendToRabbit
{
    protected $connection;

    protected $message;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection('shared-rebbitmq', 5672, 'guest', 'guest');
        $this->message = new AMQPMessage();
    }

    public function send()
    {
        $channel = $this->connection->channel();
        $channel->queue_declare('hello', false, false, false, false);

        $this->message->setBody('Hello World!');
        $channel->basic_publish($this->message, '', 'hello');

        $channel->close();
        $this->connection->close();
    }
}