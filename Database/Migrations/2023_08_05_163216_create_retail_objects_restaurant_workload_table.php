<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailObjectsRestaurantWorkloadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retail_objects_restaurant_workload', function (Blueprint $table) {
            $table->id();
            $table->integer('day_of_week')->unique();
            $table->integer('workload_status');
            $table->time('from_hour');
            $table->time('to_hour');
            $table->boolean('has_extraordinary_status')->default(false);
            $table->integer('extraordinary_status')->nullable()->default(null);
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
        Schema::dropIfExists('retail_objects_restaurant_workload');
    }
}
