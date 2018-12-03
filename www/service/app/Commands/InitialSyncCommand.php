<?php

namespace App\Commands;

use Core\Base\Application;
use App\Workers\SyncOnStartUpConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitialSyncCommand extends Command
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
        $this->setName('app:initial-sync');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $consumer = $this->container->make(SyncOnStartUpConsumer::class);

        $output->writeln(" [*] Waiting for messages. To exit press CTRL+C\n");
        $consumer->execute();
    }
}
