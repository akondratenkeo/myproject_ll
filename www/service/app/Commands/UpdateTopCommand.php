<?php

namespace App\Commands;

use Core\Base\Application;
use App\Workers\CheckArticleUpdatesConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateTopCommand extends Command
{
    /**
     * @var \Core\Base\Application
     */
    protected $container;

    /**
     * SetupCommand constructor.
     *
     * @param \Core\Base\Application $container
     */
    public function __construct(Application $container)
    {
        $this->container = $container;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:update-top');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $consumer = $this->container->make(CheckArticleUpdatesConsumer::class);

        $output->writeln(" [*] Waiting for messages. To exit press CTRL+C\n");
        $consumer->execute();
    }
}
