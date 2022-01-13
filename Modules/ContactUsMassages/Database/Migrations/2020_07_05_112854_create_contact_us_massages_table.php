<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsMassagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us_massages', function (Blueprint $table) {
            $table->id();
            $table->string('user_type')->default('guest');
            $table->string('massage_type')->default('complaints');
            $table->integer('from_id')->nullable()->foreign('from_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('from_email');
            $table->string('from_name');
            $table->integer('to_id')->foreign('from_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('to_email');
            $table->string('to_name');
            $table->longText('massages');
            $table->softDeletes();
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
        Schema::dropIfExists('contact_us_massages');
    }
}
