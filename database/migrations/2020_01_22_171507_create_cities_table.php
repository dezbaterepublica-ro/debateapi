<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->unsignedBigInteger('id')
                  ->primary();
            $table->string('name', 255)
                  ->index();
            $table->string('type', 255)
                  ->index();
            $table->string('coords', 255)
                  ->nullable();
            $table->unsignedBigInteger('county_id')
                  ->index();
            $table->foreign('county_id')
                  ->references('id')
                  ->on('counties');
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
        Schema::dropIfExists('cities');
    }
}
