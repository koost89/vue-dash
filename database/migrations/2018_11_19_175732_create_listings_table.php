<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('type')->nullable();
            $table->integer('project_id')->unsigned()->nullable();
            $table->integer('customer_id')->unsigned()->nullable();
            $table->mediumText('description')->nullable();
            $table->mediumText('note')->nullable();
            $table->decimal('hourly_rate', 8,2)->nullable()->default('0.00');
            $table->decimal('estimate_hours', 8, 2)->nullable()->default('0.00');
            $table->decimal('worked_hours', 8, 2)->nullable()->default('0.00');
            $table->decimal('total_amount', 11, 2)->nullable()->default('0.00');

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('customer_id')->references('id')->on('customers');
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
        Schema::dropIfExists('listings');
    }
}
