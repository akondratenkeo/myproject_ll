<?php

namespace Core\Queue;

interface ProducerInterface
{
    /**
     * Publish a message.
     *
     * @param $messageBody
     * @param string $routingKey
     *
     * @return void
     */
    public function publish($messageBody, string $routingKey = '') : void;
}