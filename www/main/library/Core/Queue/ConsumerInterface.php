<?php

namespace Core\Queue;

use PhpAmqpLib\Message\AMQPMessage;

interface ConsumerInterface
{
    /**
     * Process the message.
     *
     * @return void
     */
    public function execute() : void;
}