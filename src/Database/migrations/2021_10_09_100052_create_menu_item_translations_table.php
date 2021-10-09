<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_item_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('menu_item_id')->index();
            $table->unsignedInteger('language_id')->index();
            $table->string('name');
            $table->unsignedInteger('url_id')->nullable()->index();
            $table->string('out_link')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('menu_item_id')->references('id')->on('menu_items')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_item_translations');
    }
}
