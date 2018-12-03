<?php

namespace Core\Queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use Psr\Log\LoggerInterface;

abstract class AbstractAMQP
{
    protected $conn;

    protected $channel;

    protected $exchangeName;

    protected $exchangeDeclared = false;

    protected $exchangeTypes = ['fanout', 'direct', 'headers', 'topic'];

    protected $queueName;

    protected $queueDeclared = false;

    protected $bindingKey = '';

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * AbstractProducer constructor.
     *
     * @param \PhpAmqpLib\Connection\AMQPStreamConnection $conn
     */
    public function __construct(AMQPStreamConnection $conn)
    {
        $this->conn = $conn;

        if ($conn->connectOnConstruct()) {
            $this->getChannel();
        }
    }

    /**
     * AbstractProducer destructor.
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * Close all.
     *
     * @return void
     */
    public function close() : void
    {
        if ($this->channel) {
            $this->channel->close();
        }

        if ($this->conn && $this->conn->isConnected()) {
            $this->conn->close();
        }
    }

    /**
     * Reconnect.
     *
     * @return void
     */
    public function reconnect() : void
    {
        if (! $this->conn->isConnected()) {
            return;
        }

        $this->conn->reconnect();
    }

    /**
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    public function getChannel() : AMQPChannel
    {
        if (empty($this->channel) || null === $this->channel->getChannelId()) {
            $this->channel = $this->conn->channel();
        }

        return $this->channel;
    }

    /**
     * @param \PhpAmqpLib\Channel\AMQPChannel $channel
     */
    public function setChannel(AMQPChannel $channel) : void
    {
        $this->channel = $channel;
    }

    /**
     * @param string $bindingKey
     *
     * @return self
     */
    public function setRoutingKey(string $bindingKey) : self
    {
        $this->bindingKey = $bindingKey;

        return $this;
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(LoggerInterface $logger) : void
    {
        $this->logger = $logger;
    }

    /**
     * Declares exchange.
     *
     * @param string $name
     * @param string $type
     *
     * @return self
     */
    public function exchangeDeclare(string $name, string $type) : self
    {
        if (! in_array($type, $this->exchangeTypes, true)) {
            throw new \InvalidArgumentException('You must provide a valid exchange type');
        }

        if (! $this->exchangeDeclared) {
            $this->getChannel()->exchange_declare($name, $type, false, true, false);

            $this->exchangeDeclared = true;
            $this->exchangeName = $name;
        }

        return $this;
    }

    /**
     * Declares queue, creates if needed.
     *
     * @param string $name
     * @param array $bindingKeys
     *
     * @return self
     */
    public function queueDeclare(string $name = '', array $bindingKeys = []) : self
    {
        if (! $this->exchangeDeclared) {
            throw new \InvalidArgumentException('You must declare exchange first');
        }

        if (! $this->queueDeclared) {
            list($queueName, ,) = $this->getChannel()->queue_declare($name, false, true, false, false);

            if (isset($bindingKeys) && count($bindingKeys) > 0) {
                foreach ($bindingKeys as $bindingKey) {
                    $this->queueBind($queueName, $this->exchangeName, $bindingKey);
                }
            } else {
                $this->queueBind($queueName, $this->exchangeName, $this->bindingKey);
            }

            $this->queueDeclared = true;
            $this->queueName = $name ?: $queueName;
        }

        return $this;
    }

    /**
     * Binds queue to an exchange.
     *
     * @param string $queue
     * @param string $exchange
     * @param string $bindingKey
     *
     * @return void
     */
    protected function queueBind(string $queue, string $exchange, string $bindingKey) : void
    {
        if ('' !== $exchange) {
            $this->getChannel()->queue_bind($queue, $exchange, $bindingKey);
        }
    }
}