<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Core\Database\Migration;

class CreateImagesTable extends Migration
{
    public function up()
    {
        Capsule::schema()->create('images', function ($table) {
            $table->increments('id');
            $table->unsignedInteger('article_id');
            $table->string('filename', 255)->nullable();

            $table->foreign('article_id')->references('id')->on('articles')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('images');
    }
}