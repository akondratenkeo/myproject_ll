<?php

namespace Core\Queue;

use PhpAmqpLib\Message\AMQPMessage;

interface ConsumerInterface
{
    /**
     * Process the message.
     *
     * @param \PhpAmqpLib\Message\AMQPMessage $message
     *
     * @return void
     */
    public function execute(AMQPMessage $message) : void;
}