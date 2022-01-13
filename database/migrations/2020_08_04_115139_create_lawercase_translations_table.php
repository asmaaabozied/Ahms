<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLawercaseTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lawercase_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lawercase_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('description');
            $table->string('number');

            $table->unique(['lawercase_id','locale']);
            $table->foreign('lawercase_id')->references('id')->on('lawercases')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lawercase_translations');
    }
}
