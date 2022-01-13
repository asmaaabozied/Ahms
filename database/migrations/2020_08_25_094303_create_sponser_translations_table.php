<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponserTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponser_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sponser_id');
            $table->string('name');
            $table->string('description');
            $table->string('locale')->index();
            $table->unique(['sponser_id', 'locale']);
            $table->foreign('sponser_id')->references('id')->on('sponsers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sponser_translations');
    }
}
