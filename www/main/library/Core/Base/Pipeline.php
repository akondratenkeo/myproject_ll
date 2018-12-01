<?php

namespace Core\Base;

use Illuminate\Container\Container;
use League\Pipeline\PipelineBuilder;

class Pipeline
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var mixed
     */
    protected $payload;

    /**
     * @var array
     */
    protected $pipes = [];

    /**
     * Pipeline constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param mixed ...$payload
     * @return Pipeline
     */
    public function send($payload) : self
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @param array $pipes
     * @return Pipeline
     */
    public function trough(array $pipes) : self
    {
        $this->pipes = $pipes;

        return $this;
    }

    /**
     * @param \Closure $callback
     * @return mixed
     */
    public function then(\Closure $callback)
    {
        $pipeline = $this->buildPipeline();

        return $callback(
            $pipeline->process($this->payload)
        );
    }

    /**
     * @return \League\Pipeline\Pipeline
     */
    protected function buildPipeline() : \League\Pipeline\Pipeline
    {
        $pipelineBuilder = $this->container->make(PipelineBuilder::class);

        foreach ($this->pipes as $pipe) {
            $pipelineBuilder->add($this->container->make($pipe));
        }

        return $pipelineBuilder->build();
    }
}
