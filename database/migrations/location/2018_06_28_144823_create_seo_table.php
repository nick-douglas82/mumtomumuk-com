<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.4.1)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateSeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumText('meta_title')->nullable();
            $table->mediumText('meta_description')->nullable();
            $table->mediumText('meta_keywords')->nullable();
            $table->mediumText('focus_keyword')->nullable();
            $table->string('canonical', 255)->nullable();
            $table->mediumText('opengraph_title')->nullable();
            $table->mediumText('opengraph_description')->nullable();
            $table->mediumText('opengraph_image')->nullable();
            $table->mediumText('twitter_title')->nullable();
            $table->mediumText('twitter_description')->nullable();
            $table->mediumText('twitter_image')->nullable();
            $table->tinyInteger('meta_robots_noindex')->nullable();
            $table->tinyInteger('meta_robots_nofollow')->nullable();
            $table->integer('subject_id')->nullable();
            $table->string('subject_type', 255)->nullable();
            $table->nullableTimestamps();

            

            

        });

        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo');
    }
}
