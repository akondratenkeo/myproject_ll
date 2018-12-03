<?php

namespace Core\Queue;

class ProducerBuilder
{
    private $producer;

    /**
     * ProducerBuilder constructor.
     *
     * @param Producer $producer
     */
    public function __construct(Producer $producer)
    {
        $this->producer = $producer;
    }
}