<?php

namespace Core\Queue;

use PhpAmqpLib\Message\AMQPMessage;

abstract class AbstractConsumer extends AbstractAMQP implements ConsumerInterface
{
    /**
     * {@inheritdoc}
     */
    public function execute() : void
    {
        $this->getChannel()->basic_qos(null, 1, null);
        $this->getChannel()->basic_consume($this->queueName, '', false, false, false, false, [$this, 'callback']);

        while (count($this->getChannel()->callbacks)) {
            $this->getChannel()->wait();
        }
    }

    /**
     * @param AMQPMessage $message
     *
     * @return bool
     */
    abstract protected function process(AMQPMessage $message) : bool;

    /**
     * @param AMQPMessage $message
     */
    final function callback(AMQPMessage $message)
    {
        if (! $this->process($message)) {
            $message->delivery_info['channel']->basic_nack($message->delivery_info['delivery_tag'], false, true);
        } else {
            $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
        }
    }

    /**
     * @param $message
     *
     * @return array
     */
    protected function parseMessage($message) : array
    {
        return json_decode($message, true);
    }
}