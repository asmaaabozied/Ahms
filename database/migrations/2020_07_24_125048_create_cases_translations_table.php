<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasesTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases_translations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cases_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('description');
            $table->string('number');

            $table->unique(['cases_id','locale']);
            $table->foreign('cases_id')->references('id')->on('cases')->onDelete('cascade');

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
        Schema::dropIfExists('case_translations');
    }
}
