<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.4.1)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wp_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('slug', 191);
            $table->string('title', 191);
            $table->text('body');
            $table->string('town', 191);
            $table->string('address', 191);
            $table->point('coordinates');
            $table->string('longitude', 191);
            $table->string('latitude', 191);
            $table->string('phone', 191);
            $table->string('website', 191);
            $table->nullableTimestamps();

            $table->unique('slug', 'places_slug_unique');



        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places');
    }
}
