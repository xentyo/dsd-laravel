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
            $table->unsignedInteger('dispenser_id');
            $table->unsignedInteger('item_id');
            $table->string('type_id');
            $table->unsignedInteger('metric_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->double('quantity');
            $table->timestamps();

            $table->foreign('dispenser_id')->references('id')->on('dispensers');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('type_id')->references('name')->on('movement_types');
            $table->foreign('metric_id')->references('id')->on('metrics');
            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
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
