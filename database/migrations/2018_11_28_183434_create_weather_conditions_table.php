<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_conditions', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('chill', 8, 1)->nullable();
            $table->decimal('pressure', 8, 1)->nullable();
            $table->integer('rv')->nullable();
            $table->string('station')->nullable();
            $table->decimal('temp', 8, 1)->nullable();
            $table->string('weather')->nullable();
            $table->integer('wind')->nullable();
            $table->string('wind_direction')->nullable();
            $table->integer('visibility')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather_conditions');
    }
}
