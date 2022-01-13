<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeconsultationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('typeconsultation_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('typeconsultation_id');
            $table->string('name');
            $table->string('locale')->index();
            $table->unique(['typeconsultation_id', 'locale']);
            $table->foreign('typeconsultation_id')->references('id')->on('typeconsultations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('typeconsultation_translations');
    }
}
