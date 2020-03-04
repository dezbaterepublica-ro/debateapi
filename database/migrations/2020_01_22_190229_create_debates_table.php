<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 767)->index();
            $table->char('slug', 255)->unique();
            $table->char('type', 255)->index()->default('dezbatere-publica');
            $table->dateTime('start_date')->index()->nullable();
            $table->dateTime('end_date')->index()->nullable();
            $table->mediumText('description')->nullable();
            $table->text('url')->nullable();
            $table->bigInteger('interest')->default(1)->index();

            $table->unsignedBigInteger('authority_id')->nullable()->index();
            $table->foreign('authority_id')->references('id')->on('authorities');

            $table->timestamps();
            $table->index('created_at');
            $table->index('updated_at');
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
        Schema::dropIfExists('debates');
    }
}
