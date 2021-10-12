<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainerTranslationExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_translation_extras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('container_translation_id')->index();
            $table->unsignedInteger('language_id')->index();
            $table->string('key');
            $table->text('value');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('container_translation_id')->references('id')->on('container_translations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('container_translation_extras');
    }
}
