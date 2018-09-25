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
            $table->unsignedInteger('dispenser');
            $table->unsignedInteger('kit');
            $table->double('quantity');
            $table->timestamps();

            $table->foreign('dispenser')->references('id')->on('dispensers');
            $table->foreign('kit')->references('id')->on('kits');
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
