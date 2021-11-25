<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTranslationExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_translation_extras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_translation_id')->index();
            $table->unsignedInteger('language_id')->index();
            $table->string('key');
            $table->text('value');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_translation_id')->references('id')->on('category_translations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_translation_extras');
    }
}
