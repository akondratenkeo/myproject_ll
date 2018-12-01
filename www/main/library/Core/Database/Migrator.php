<?php

namespace Core\Database;

use Core\Base\Application;

class Migrator
{
    /**
     * @var \Core\Base\Application
     */
    protected $container;

    /**
     * @var string
     */
    protected $path;

    /**
     * Migrator constructor.
     *
     * @param \Core\Base\Application $container
     */
    public function __construct(Application $container)
    {
        $this->container = $container;

        $this->path = $container->databasePath().DIRECTORY_SEPARATOR.'migrations';
    }

    /**
     *
     */
    public function run() : void
    {
        $migrations = $this->getMigrationFiles();

        $this->requireMigrationFiles($migrations);

        foreach ($migrations as $migration) {
            $this->runUp($migration);
        }
    }

    /**
     *
     */
    public function rollback() : void
    {
        $migrations = $this->getMigrationFiles();
        krsort($migrations);

        $this->requireMigrationFiles($migrations);

        foreach ($migrations as $migration) {
            $this->runDown($migration);
        }
    }

    /**
     * @param string $migration
     */
    protected function runUp(string $migration) : void
    {
        $migration = $this->resolve($migration);

        $this->runMigration($migration, 'up');
    }

    /**
     * @param string $migration
     */
    protected function runDown(string $migration) : void
    {
        $migration = $this->resolve($migration);

        $this->runMigration($migration, 'down');
    }

    /**
     * @param \Core\Database\Migration $migration
     * @param string $method
     */
    protected function runMigration(Migration $migration, string $method) : void
    {
        if (method_exists($migration, $method)) {
            $migration->{$method}();
        }
    }

    /**
     * @param string $migration
     * @return \Core\Database\Migration
     */
    protected function resolve(string $migration) : Migration
    {
        return new $migration;
    }

    /**
     * @return array
     */
    protected function getMigrationFiles() : array
    {
        $migrations = [];
        $iterator = new \DirectoryIterator($this->path);

        foreach ($iterator as $fileInfo) {
            if (! $fileInfo->isDot()) {
                $migrations[$fileInfo->getPathname()] = $this->prepareMigrationClassName($fileInfo->getFilename());
            }
        }

        ksort($migrations);

        return $migrations;
    }

    /**
     * @param array $migrations
     */
    protected function requireMigrationFiles(array $migrations) : void
    {
        foreach ($migrations as $path => $name) {
            require_once $path;
        }
    }

    /**
     * @param $filename
     * @return string
     */
    protected function prepareMigrationClassName(string $filename) : string
    {
        $parts = array_slice(explode('_', str_replace('.php' , '', $filename)), 2);

        array_walk($parts, function (&$item) {
            $item = ucfirst($item);
        });

        return implode('', $parts);
    }
}