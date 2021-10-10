<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsiteLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_languages', function (Blueprint $table) {
            $table->unsignedBigInteger('website_id');
            $table->unsignedBigInteger('language_id');
            $table->boolean('is_default')->default(0);

            $table->foreign('website_id')->references('id')->on('websites')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_languages');
    }
}
