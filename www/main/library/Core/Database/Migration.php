<?php

namespace Core\Database;

abstract class Migration
{
    /**
     * Run method.
     */
    abstract public function up();

    /**
     * Rollback method.
     */
    abstract public function down();
}
