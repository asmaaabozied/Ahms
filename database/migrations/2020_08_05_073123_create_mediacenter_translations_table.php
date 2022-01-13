<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediacenterTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mediacenter_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mediacenter_id');
            $table->string('name');
            $table->string('description');
            $table->string('locale')->index();
            $table->unique(['mediacenter_id', 'locale']);
            $table->foreign('mediacenter_id')->references('id')->on('mediacenters')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mediacenter_translations');
    }
}
