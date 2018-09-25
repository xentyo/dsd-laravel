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
            $table->unsignedInteger("kit");
            $table->unsignedInteger("item");
            $table->unsignedInteger('metric');
            $table->double('quantity');
            $table->timestamps();

            $table->foreign("kit")->references('id')->on('kits');
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
        Schema::dropIfExists('kit_items');
    }
}
