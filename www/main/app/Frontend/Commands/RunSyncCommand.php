<?php

namespace App\Frontend\Commands;

use App\Frontend\Services\SyncOnStartUpProducer;
use Core\Base\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunSyncCommand extends Command
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
        $this->setName('app:run-sync');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $syncProducer = $this->container->make(SyncOnStartUpProducer::class);

        $output->writeln('Sync process started.');
        $syncProducer->run();
        $output->writeln('All data loaded to queue.');
    }
}
