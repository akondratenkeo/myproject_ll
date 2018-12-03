<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Core\Database\Migration;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        Capsule::schema()->create('articles', function ($table) {
            $table->increments('id');
            $table->unsignedInteger('topic_id');
            $table->unsignedInteger('author_id');
            $table->string('title', 128);
            $table->string('description')->nullable();
            $table->text('body');
            $table->unsignedInteger('visited')->default(0);
            $table->timestamps();

            $table->foreign('topic_id')->references('id')->on('topics')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('author_id')->references('id')->on('authors')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->index('created_at', 'created_at_idx');
            $table->index('visited', 'visited_idx');
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('articles');
    }
}