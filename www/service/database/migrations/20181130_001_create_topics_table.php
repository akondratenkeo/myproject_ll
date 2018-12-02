<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Core\Database\Migration;

class CreateTopicsTable extends Migration
{
    public function up()
    {
        Capsule::schema()->create('articles_top_visited', function ($table) {
            $table->unsignedInteger('id');
            $table->string('title', 128);
            $table->unsignedInteger('topic_id');
            $table->unsignedInteger('visited');

            $table->index(['topic_id', 'visited'], 'topic_visited_idx');
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('articles_top_visited');
    }
}