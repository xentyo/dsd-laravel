<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConvertionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convertions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('metric_from');
            $table->unsignedInteger('metric_to');
            $table->boolean('reversable')->default(true);
            $table->timestamps();

            $table->foreign('metric_from')->references('id')->on('metrics');
            $table->foreign('metric_to')->references('id')->on('metrics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('convertions');
    }
}
