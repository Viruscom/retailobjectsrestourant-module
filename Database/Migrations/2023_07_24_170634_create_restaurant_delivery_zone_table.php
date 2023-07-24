<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantDeliveryZoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_delivery_zone', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ro_id');
            $table->text('polygon');

            $table->foreign('ro_id')->references('id')->on('retail_objects_restaurant')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_delivery_zone');
    }
}
