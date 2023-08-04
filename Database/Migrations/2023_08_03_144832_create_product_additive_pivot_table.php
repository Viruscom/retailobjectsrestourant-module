<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAdditivePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_additive_pivot', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_additive_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('price', 10, 2);
            $table->decimal('quantity', 10, 2)->default(0.00);
            $table->boolean('in_without_list')->default(false);

            $table->foreign('product_additive_id')->references('id')->on('product_additives')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('product_additive_pivot');
    }
}
