<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateRetailObjectsRestaurantPrioritiesTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('retail_objects_restaurant_priorities', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('ro_id');
                $table->integer('workload_priority_status')->nullable()->default(null);
                $table->timestamps();
                $table->foreign('ro_id')->references('id')->on('retail_objects_restaurant')->onDelete('cascade')->onUpdate('cascade');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('retail_objects_restaurant_priorities');
        }
    }
