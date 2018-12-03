<?php

namespace Core\Queue;

interface ConsumerInterface
{
    /**
     * Process the message.
     *
     * @return void
     */
    public function execute() : void;
}