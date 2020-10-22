<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create(
            'translations',
            function (Blueprint $table) {
                $table->id();
                $table->string('type')
                      ->index();
                $table->string('language')
                      ->index();
                $table->unique(['type', 'language']);
                $table->string('translation');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translations');
    }
}
