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
            $table->unsignedInteger('dispenser_id');
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('metric_id');
            $table->double('quantity');
            $table->timestamps();


            $table->foreign('dispenser_id')->references('id')->on('dispensers');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('metric_id')->references('id')->on('metrics');

            $table->unque(['dispenser_id', 'item_id', 'metric_id']);
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
