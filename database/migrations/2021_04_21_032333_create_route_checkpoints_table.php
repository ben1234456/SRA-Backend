<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteCheckpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_checkpoints', function (Blueprint $table) {
            $table->id();
            $table->integer('route_id');
            $table->integer('checkpoint1_lat');
            $table->integer('checkpoint1_lng');
            $table->integer('checkpoint2_lat')->nullable();
            $table->integer('checkpoint2_lng')->nullable();
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
        Schema::dropIfExists('route_checkpoints');
    }
}
