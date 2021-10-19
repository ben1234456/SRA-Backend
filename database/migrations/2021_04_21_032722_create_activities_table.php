<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->enum('activity_type',array('walking','running','hiking','cycling'));
            $table->integer('route_id')->nullable();
            $table->decimal('start_lat', 11, 8);
            $table->decimal('start_lng', 11, 8);
            $table->decimal('end_lat', 11, 8);
            $table->decimal('end_lng', 11, 8);
            $table->decimal('highest_altitude');
            $table->decimal('total_distance');
            $table->time('total_duration');
            $table->decimal('calories_burned');
            $table->datetime('start_dt');
            $table->datetime('end_dt');
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
        Schema::dropIfExists('activities');
    }
}
