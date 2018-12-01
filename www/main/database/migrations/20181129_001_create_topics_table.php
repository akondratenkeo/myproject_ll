<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Core\Database\Migration;

class CreateTopicsTable extends Migration
{
    public function up()
    {
        Capsule::schema()->create('topics', function ($table) {
            $table->increments('id');
            $table->string('title', 128);
            $table->timestamp('created_at')
                ->nullable();

            $table->index('title');
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('topics');
    }
}