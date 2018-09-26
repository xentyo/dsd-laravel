<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDispenserKits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispenser_kits', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dispenser_id');
            $table->unsignedInteger('kit_id');
            $table->double('quantity');
            $table->timestamps();

            $table->foreign('dispenser_id')->references('id')->on('dispensers');
            $table->foreign('kit_id')->references('id')->on('kits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dispenser_kits');
    }
}
