<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.4.1)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wp_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('title', 191);
            $table->string('slug', 191)->nullable()->default('');
            $table->text('body')->nullable();
            $table->text('address')->nullable();
            $table->string('town', 255)->nullable();
            $table->string('phone', 150)->nullable();
            $table->string('website', 255)->nullable();
            $table->point('coordinates')->nullable();
            $table->string('longitude', 100)->nullable();
            $table->string('latitude', 100)->nullable();
            $table->tinyInteger('featured')->nullable()->default(0);
            $table->timestamp('event_at')->nullable();
            $table->timestamp('event_end')->nullable();
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
        Schema::dropIfExists('events');
    }
}
