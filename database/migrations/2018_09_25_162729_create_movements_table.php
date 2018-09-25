<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dispenser');
            $table->unsignedInteger('item');
            $table->string('type');
            $table->unsignedInteger('metric');
            $table->double('quantity');
            $table->timestamps();

            $table->foreign('dispenser')->references('id')->on('dispensers');
            $table->foreign('item')->references('id')->on('items');
            $table->foreign('type')->references('name')->on('movement_types');
            $table->foreign('metric')->references('id')->on('metrics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movements');
    }
}
