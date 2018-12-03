<?php

namespace Core\Queue;

use PhpAmqpLib\Message\AMQPMessage;

abstract class AbstractConsumer extends AbstractAMQP implements ConsumerInterface
{
    protected $deliveryMode = 2;

    /**
     * @param $deliveryMode
     *
     * @return self
     */
    public function setDeliveryMode($deliveryMode) : self
    {
        $this->deliveryMode = $deliveryMode;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(AMQPMessage $message) : void
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
     * @return array
     */
    protected function getBasicProperties() : array
    {
        return ['delivery_mode' => $this->deliveryMode];
    }

    /**
     * @param $message
     * @return string
     */
    protected function prepareMessage($message) : string
    {
        return (string) (! is_scalar($message)) ? json_encode($message) : $message;
    }
}