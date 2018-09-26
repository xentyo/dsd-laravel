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
            $table->unsignedInteger('inventory_id');
            $table->unsignedInteger('item_id');
            $table->boolean('reversable')->default(true);
            $table->double('factor');
            $table->timestamps();

            $table->foreign('inventory_id')->references('id')->on('inventories');
            $table->foreign('item_id')->references('id')->on('items');
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
