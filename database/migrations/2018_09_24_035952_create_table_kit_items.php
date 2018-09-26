<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableKitItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kit_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("kit_id");
            $table->unsignedInteger("item_id");
            $table->unsignedInteger('metric_id');
            $table->double('quantity');
            $table->timestamps();

            $table->foreign("kit_id")->references('id')->on('kits');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('metric_id')->references('id')->on('metrics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kit_items');
    }
}
