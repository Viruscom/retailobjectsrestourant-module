<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAdditiveTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_additive_translation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_additive_id');
            $table->string('locale')->index();
            $table->string('title');

            $table->unique(['product_additive_id', 'locale']);
            $table->foreign('product_additive_id')->references('id')->on('product_additives')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('product_additive_translation');
    }
}
