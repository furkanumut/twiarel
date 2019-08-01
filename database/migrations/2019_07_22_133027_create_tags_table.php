<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tag')->unique();
            $table->timestamps();
        });

        /* 
            buradaki tablonun adı article_tag olacak
            alfabetik olması gerekiyor ki laravel bunu kaydetsin sorguyu buna göre ayaralsın


            ******
            burası pivot table olarak alabiliyoruz

        */
        Schema::create('article_tag', function (Blueprint $table) {
            //$table->bigIncrements('id');
            $table->bigInteger('article_id')->unsigned();
            $table->bigInteger('tag_id')->unsigned();
            $table->unique(['article_id','tag_id']);

            $table->foreign('tag_id')->references('id')->on('tags');
            $table->foreign('article_id')->references('id')->on('articles');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_tag');
        Schema::dropIfExists('tags');
    }
}
