<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWorkingTimeColumnsToRetailObjectsRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retail_objects_restaurant', function (Blueprint $table) {
            $table->string('working_time_mon_fri')->nullable();
            $table->string('working_time_saturday')->nullable();
            $table->string('working_time_sunday')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('retail_objects_restaurant', function (Blueprint $table) {
            $table->dropColumn('working_time_mon_fri');
            $table->dropColumn('working_time_saturday');
            $table->dropColumn('working_time_sunday');
        });
    }
}
