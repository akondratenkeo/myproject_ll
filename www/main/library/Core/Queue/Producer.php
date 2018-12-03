<?php

namespace Core\Queue;

use PhpAmqpLib\Message\AMQPMessage;

class Producer extends AbstractAMQP implements ProducerInterface
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
    public function publish($messageBody, string $routingKey = '') : void
    {
        $message = new AMQPMessage($this->prepareMessage($messageBody), $this->getBasicProperties());

        $this->getChannel()->basic_publish($message, $this->exchangeName, (string) $routingKey);

        if ($this->logger) {
            $this->logger->debug('AMQP message published', [
                'amqp' => [
                    'body' => $messageBody,
                    'routingkeys' => $routingKey
                ]
            ]);
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