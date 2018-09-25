<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDispenserItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispenser_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dispenser');
            $table->unsignedInteger('item');
            $table->unsignedInteger('metric');
            $table->double('quantity');
            $table->timestamps();

            
            $table->foreign('dispenser')->references('id')->on('dispensers');
            $table->foreign('item')->references('id')->on('items');
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
        Schema::dropIfExists('dispenser_items');
    }
}
