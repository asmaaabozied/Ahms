<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoconsultationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videoconsultation_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('videoconsultation_id');
            $table->string('name');
            $table->string('locale')->index();
            $table->unique(['videoconsultation_id', 'locale']);
            $table->foreign('videoconsultation_id')->references('id')->on('videoconsultations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videoconsultation_translations');
    }
}
