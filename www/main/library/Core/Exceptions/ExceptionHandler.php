<?php

namespace Core\Exceptions;

use Illuminate\Container\Container;
use Psr\Log\LoggerInterface;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExceptionHandler
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * ExceptionHandler constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param \Exception $e
     *
     * @throws \Exception
     */
    public function report(\Exception $e)
    {
        try {
            $logger = $this->container->make('logger');
        } catch (\Exception $ex) {
            throw $e;
        }

        $logger->error($e->getMessage(), ['exception' => $e]);
    }

    /**
     * @param Request $request
     * @param \Exception $e
     * @return Response
     */
    public function render(Request $request, \Exception $e) : Response
    {
        return $this->convertExceptionToResponse($e);
    }

    /**
     * @param \Exception $e
     * @return Response
     */
    protected function convertExceptionToResponse(\Exception $e) : Response
    {
        return Response::create(
            $this->renderExceptionWithSymfony($e),
            500,
            []
        );
    }

    /**
     * @param \Exception $e
     * @return string
     */
    protected function renderExceptionWithSymfony(\Exception $e) : string
    {
        return (new SymfonyExceptionHandler())->getHtml(
            FlattenException::create($e)
        );
    }
}
