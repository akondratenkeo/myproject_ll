<?php

namespace Core\Broadcasting;

use Predis\Client as Redis;

class RedisBroadcaster
{
    /**
     * The Redis instance.
     *
     * @var \Predis\Client
     */
    protected $redis;

    /**
     * The Redis connection to use for broadcasting.
     *
     * @var string
     */
    protected $connection;

    /**
     * RedisBroadcaster constructor.
     *
     * @param \Predis\Client $redis
     * @param null $connection
     */
    public function __construct(Redis $redis, $connection = null)
    {
        $this->redis = $redis;
        $this->connection = $connection;
    }

    /**
     * Broadcast the given event.
     *
     * @param  array  $channels
     * @param  string  $event
     * @param  array  $payload
     *
     * @return void
     */
    public function broadcast(array $channels, $event, array $payload = []) : void
    {
        $payload = $this->preparePayload($event, $payload);

        foreach ($channels as $channel) {
            $this->redis->publish($channel, $payload);
        }
    }

    /**
     * @param $event
     * @param array $payload
     *
     * @return string
     */
    protected function preparePayload($event, array $payload = []) : string
    {
        return json_encode([
            'event' => $event,
            'data' => $payload,
            'socket' => null,
        ]);
    }
}
