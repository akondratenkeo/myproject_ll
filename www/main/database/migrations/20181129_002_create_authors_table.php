<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Core\Database\Migration;

class CreateAuthorsTable extends Migration
{
    public function up()
    {
        Capsule::schema()->create('authors', function ($table) {
            $table->increments('id');
            $table->string('name', 64);
            $table->timestamp('created_at')
                ->nullable();

            $table->index('name');
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('authors');
    }
}