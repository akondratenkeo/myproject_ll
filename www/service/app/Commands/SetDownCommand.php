<?php

namespace App\Commands;

use Core\Base\Application;
use Core\Database\Migrator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetDownCommand extends Command
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
        $this->setName('app:set-down');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $migrator = $this->container->make(Migrator::class);
        $migrator->rollback();

        $output->writeln('Done.');
    }
}
