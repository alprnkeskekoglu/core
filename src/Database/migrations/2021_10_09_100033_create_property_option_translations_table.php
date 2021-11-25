<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyOptionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_option_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_option_id')->index();
            $table->unsignedInteger('language_id')->index();
            $table->boolean('status')->default(1);
            $table->string('name');
            $table->string('slug')->nullable();
            $table->text('detail')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('property_option_id')->references('id')->on('property_options')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_option_translations');
    }
}
