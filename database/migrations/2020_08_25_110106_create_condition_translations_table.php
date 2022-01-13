<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConditionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condition_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('condition_id');
            $table->string('title');
            $table->string('description');
            $table->string('locale')->index();
            $table->unique(['condition_id', 'locale']);
            $table->foreign('condition_id')->references('id')->on('conditions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('condition_translations');
    }
}
