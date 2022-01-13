<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLawerTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lawer_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lawer_id');
            $table->string('name');
            $table->string('description');
            $table->string('number');
            $table->string('locale')->index();
            $table->unique(['lawer_id', 'locale']);
            $table->foreign('lawer_id')->references('id')->on('lawers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lawer_translations');
    }
}
