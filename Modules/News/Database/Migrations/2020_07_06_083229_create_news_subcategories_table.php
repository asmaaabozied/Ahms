<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Geography\Entities\Geography;

class CreateNewsSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('news_subcategories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('active')->default(1);
            $table->string('main_image')->nullable();
            $table->text('images_slider')->nullable();
            $table->string('video_link')->nullable();
            $table->unsignedBigInteger('news_category_id');
            $table->timestamps();
            $table->foreign('news_category_id')->references('id')->on('news_categories')->onDelete('cascade');


        });

        Schema::create('news_subcategory_translations', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedBigInteger('news_sub_category_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->longText('content')->nullable();



            $table->unique(['news_sub_category_id','locale']);
            $table->foreign('news_sub_category_id')->references('id')->on('news_subcategories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('news_subcategories');
        Schema::dropIfExists('news_subcategory_translations');
    }
}
