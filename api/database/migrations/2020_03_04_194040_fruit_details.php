<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FruitDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('fruit_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fruit_id');
            $table->enum('size', ['pequeño', 'mediano', 'grande']);
            $table->string('color')->nullable();
            $table->timestamps();

            $table->foreign('fruit_id')->references('id')->on('fruits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('fruit_details');
    }
}
