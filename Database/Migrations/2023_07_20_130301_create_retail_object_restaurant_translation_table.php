<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailObjectRestaurantTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retail_object_restaurant_translation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ro_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('announce')->nullable();
            $table->text('description')->nullable();
            $table->string('url');
            $table->string('address')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->text('map_iframe')->nullable()->default(null);
            $table->boolean('visible')->default(true);

            $table->unique(['ro_id', 'locale']);
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
        Schema::dropIfExists('retail_object_restaurant_translation');
    }
}
